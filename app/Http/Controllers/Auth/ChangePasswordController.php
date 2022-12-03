<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ChangePasswordController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function update(Request $request)
    {
        $parameters = $request->all();
        $validator = $this->validator($request);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::query()->find(auth()->user()->id);

        try {
            DB::beginTransaction();

            $user->password = Hash::make(Arr::get($parameters, 'password'));
            $user->save();

            DB::commit();

            return redirect()->back()->with(['changePassword' => 'success']);

        } catch (Exception $e) {
            session()->flash('error', $e->getMessage());

            return redirect()->back();
        }
    }

    private function validator(Request $request)
    {
        $rules = [
            'old_password' => [
                'required', function ($attribute, $value, $fail) {
                    if (!Hash::check($value, auth()->user()->password)) {
                        $fail('รหัสผ่านเก่าไม่ถูกต้อง');
                    }
                },
            ],
            'password' => [
                'required',
                'confirmed',
                'min:6'
            ],
            'password_confirmation' => 'required',
        ];

        $customMessages = [
            'old_password.required' => 'รหัสผ่านเก่าไม่ควรเป็นค่าว่าง',
            'password.required' => 'รหัสผ่านใหม่ไม่ควรเป็นค่าว่าง',
            'password.confirmed' => 'รหัสผ่านใหม่และยืนยันรหัสผ่านใหม่ต้องตรงกัน',
            'password.min' => 'รหัสผ่านใหม่ต้องมีอย่างน้อย 6 ตัวอักษร',
            'password_confirmation.required' => 'ยืนยันรหัสผ่านใหม่ไม่ควรเป็นค่าว่าง',
        ];

        return Validator::make($request->all(), $rules, $customMessages);
    }
}
