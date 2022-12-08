<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->module = new \stdClass();
        $this->module->contentHeader = 'ข้อมูลผู้ใช้งาน';
        $this->module->preFixUrl = 'users';

        $this->data['data'] = $this->module;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $this->items = $this->items($request->all());
        $this->items->pages = new \stdClass();
        $this->items->pages->start = ($this->items->perPage() * $this->items->currentPage()) - $this->items->perPage();
        $this->data['items'] = $this->items;

        $this->data['partners'] = Partner::query()->where('is_active', 1)->get();

        return view('admin.user.index', $this->data);
    }

    /**
     * @param $parameters
     * @return mixed
     */
    public function items($parameters)
    {
        $search = Arr::get($parameters, 'search');
        $paginate = Arr::get($parameters, 'total', config('project.limit_rows'));
        $query = new User;

        if ($search) {
            $query = $query->where('username', 'LIKE', '%' . $search . '%');
        }

        return $query->paginate($paginate);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        $data = User::query()->select(['username', 'partner_id', 'is_admin'])->find($id);

        return response()->json(array(
            'data' => $data,
            'success' => true,
        ), 200);
    }

    /**
     * @param Request $request
     * @param User $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(Request $request, User $data)
    {
        $id = Arr::get($request->all(), 'id');
        $typeField = Arr::get($request->all(), 'typeField');
        $value = Arr::get($request->all(), 'value');

        try {
            $data = $data->find($id);

            if ($data) {
                $data->update([$typeField => !$value]);
            }
        } catch (Exception $e) {

            return response()->json(array(
                'success' => false,
                'error' => $e->getMessage(),
            ), 400);
        }

        return response()->json(array(
            'success' => true,
        ), 200);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $data = User::query()->find($id);

            if ($data) {
                $data->delete();
            }
        } catch (Exception $e) {

            return response()->json(array(
                'success' => false,
                'error' => $e->getMessage(),
            ), 400);
        }

        return response()->json(array(
            'success' => true,
        ), 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $parameters = $request->all();
        $id = Arr::get($parameters, 'id');

        $validator = Validator::make($parameters, [
            'username' => 'required|unique:users,username,' . $id,
            'password' => [
                'required_if:action,==,create',
                'confirmed',
                'min:6'
            ],
            'password_confirmation' => 'required_if:action,==,create',
            'partner' => 'required',
            'user_type' => 'required',
            'action' => 'required'
        ], [
            'password.required_if' => 'รหัสผ่านไม่ควรเป็นค่าว่าง',
            'password.confirmed' => 'รหัสผ่านและยืนยันรหัสผ่านต้องตรงกัน',
            'password.min' => 'รหัสผ่านต้องมีอย่างน้อย 6 ตัวอักษร',
            'password_confirmation.required_if' => 'ยืนยันรหัสผ่านไม่ควรเป็นค่าว่าง',
            'partner.required' => 'คู่ค้าไม่ควรเป็นค่าว่าง',
            'username.required' => 'ชื่อผู้ใช้งานไม่ควรเป็นค่าว่าง',
            'username.unique' => 'ชื่อผู้ใช้งานซ้ำ',
            'user_type.required' => 'ประเภทผู้ใช้งานไม่ควรเป็นค่าว่าง',
        ]);

        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'message' => $validator->errors()
            ), 200);
        }

        if (!empty($id)) {
            $data = User::query()->find($id);

            if (!$data) {
                return response()->json(array(
                    'success' => false,
                    'message' => 'ไม่พบข้อมูล'
                ), 404);
            }

            Arr::set($parameters, 'username', $data->username);
        }

        try {
            DB::beginTransaction();

            $data = [
                'email' => Arr::get($parameters, 'username'),
                'username' => Arr::get($parameters, 'username'),
                'partner_id' => Arr::get($parameters, 'partner'),
                'is_admin' => Arr::get($parameters, 'user_type'),
                'email_verified_at' => Carbon::now()
            ];

            if (!empty(Arr::get($parameters, 'password'))){
                $data['password'] = Hash::make(Arr::get($parameters, 'password'));
            }

            User::updateOrCreate([
                'id' => $id
            ], $data);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();

            return response()->json(array(
                'success' => false,
                'message' => $e->getMessage()
            ), 400);
        }

        return response()->json(array(
            'success' => true,
        ), 200);
    }
}
