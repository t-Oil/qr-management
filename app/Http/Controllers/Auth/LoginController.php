<?php

namespace App\Http\Controllers\Auth;

use App\Events\ClearHistoryTask;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $input = $request->all();

        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ], [
            'username.required' => 'ชื่อผู้ใช้งานต้องไม่เป็นค่าว่าง',
            'password.required' => 'รหัสผ่านต้องไม่เป็นค่าว่าง'
        ]);

        if(auth()->attempt(array('username' => $input['username'], 'password' => $input['password'])))
        {
            if (auth()->user()->is_admin == 1) {
                event(new ClearHistoryTask());
                return redirect()->route('admin.task.index');
            }

            return redirect()->route('web.index');
        }

        return redirect()->back()
            ->with('error','ชื่อผู้ใช้งานหรือรหัสผ่านไม่ถูกต้อง');

    }
}
