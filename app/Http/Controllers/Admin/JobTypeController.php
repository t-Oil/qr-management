<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobType;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class JobTypeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->module = new \stdClass();
        $this->module->contentHeader = 'ข้อมูลประเภทชั่ง';
        $this->module->preFixUrl = 'job-types';

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

        return view('admin.job-type.index', $this->data);
    }

    /**
     * @param $parameters
     * @return mixed
     */
    public function items($parameters)
    {
        $search = Arr::get($parameters, 'search');
        $paginate = Arr::get($parameters, 'total', config('project.limit_rows'));
        $query = new JobType;

        if ($search) {
            $query = $query->where('code', 'LIKE', '%' . $search . '%')
                ->orWhere('name', 'LIKE', '%' . $search . '%');
        }

        return $query->paginate($paginate);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        $data = JobType::query()->select(['code', 'name'])->find($id);

        return response()->json(array(
            'data' => $data,
            'success' => true,
        ), 200);
    }

    /**
     * @param Request $request
     * @param JobType $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(Request $request, JobType $data)
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
            $data = JobType::query()->find($id);

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
            'code' => 'required|unique:job_types,code,' . $id,
            'name' => 'required'
        ], [
            'name.required' => 'ชื่อประเภทชั่งไม่ควรเป็นค่าว่าง',
            'code.required' => 'รหัสประเภทชั่งไม่ควรเป็นค่าว่าง',
            'code.unique' => 'รหัสประเภทชั่งซ้ำ',
        ]);

        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'message' => $validator->errors()
            ), 200);
        }

        if (!empty($id)) {
            $data = JobType::query()->find($id);

            if (!$data) {
                return response()->json(array(
                    'success' => false,
                    'message' => 'ไม่พบข้อมูล'
                ), 404);
            }
        }

        try {
            DB::beginTransaction();

            JobType::updateOrCreate([
                'id' => $id
            ], [
                'code' => Arr::get($parameters, 'code'),
                'name' => Arr::get($parameters, 'name')
            ]);

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
