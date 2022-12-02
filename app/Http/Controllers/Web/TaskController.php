<?php

namespace App\Http\Controllers\Web;

use App\Enums\DriverPrefix;
use App\Http\Controllers\Controller;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Phattarachai\ThaiIdCardValidation\ThaiIdCardRule;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TaskController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $parameters = $request->all();

        $validator = $this->validator($request);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();
            $data = [
                'task_date' => Carbon::CreateFromFormat('d/m/Y', Arr::get($parameters, 'task_date'))->format('Y-m-d'),
                'vehicle_registration' => Arr::get($parameters, 'vehicle_registration'),
                'trailer_registration' => Arr::get($parameters, 'trailer_registration'),
                'job_type_id' => Arr::get($parameters, 'job_type'),
                'partner_id' => optional(auth()->user())->partner->id,
                'product_id' => Arr::get($parameters, 'product'),
                'department_id' => Arr::get($parameters, 'department'),
                'id_card' => Arr::get($parameters, 'id_card'),
                'prefix' => Arr::get($parameters, 'prefix'),
                'first_name' => Arr::get($parameters, 'first_name'),
                'last_name' => Arr::get($parameters, 'last_name'),
            ];

            $task = Task::create($data);

            $task->qr_code = $this->generateQrCode($task);

            $task->save();

            DB::commit();

            return redirect()->back()->with(['qr' => $task->qr_code, 'id' => $task->id ])->withInput();

        } catch (Exception $e) {
            session()->flash('error', $e->getMessage());

            return redirect()->back();
        }

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    private function validator(Request $request)
    {
        $rules = [
            'task_date' => 'required',
            'vehicle_registration' => 'required',
            'job_type' => 'required',
            'product' => 'required',
            'department' => 'required',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
//            'id_card' => new ThaiIdCardRule
        ];

        $customMessages = [
            'task_date.required' => 'วันที่ไม่ควรเป็นค่าว่าง',
            'vehicle_registration.required' => 'ทะเบียนรถไม่ควรเป็นค่าว่าง',
            'job_type.required' => 'ประเภทชั่งไม่ควรเป็นค่าว่าง',
            'product.required' => 'สินค้าไม่ควรเป็นค่าว่าง',
            'department.required' => 'แผนกไม่ควรเป็นค่าว่าง',
            'first_name.required' => 'ชื่อไม่ควรเป็นค่าว่าง',
            'last_name.required' => 'นามสกุลไม่ควรเป็นค่าว่าง',
            'id_card.required' => 'เลขบัตรประชาชนไม่ควรเป็นค่าว่าง',
        ];

        return Validator::make($request->all(), $rules, $customMessages);
    }

    /**
     * @param Task $task
     * @return mixed
     */
    private function generateQrCode(Task $task)
    {
        $payload = [
            Arr::get($task, 'vehicle_registration'),
            Arr::get($task, 'trailer_registration'),
            optional($task)->partner->code,
            optional($task)->product->code,
            optional($task)->department->code,
            Arr::get($task, 'id_card'),
            DriverPrefix::asArray()[Arr::get($task, 'prefix')],
            Arr::get($task, 'first_name'),
            Arr::get($task, 'last_name'),
        ];

        $encode = base64_encode(implode(' ', $payload));

        return (new \chillerlan\QRCode\QRCode)->render($encode);
    }

    public function export($id, Request $request)
    {
        $parameters = $request->all();

        $task = Task::query()->find($id);
        $type = Arr::get($parameters, 'type', 'preview');

        $pdf = \PDF::loadView(
            'web.export.task',
            ['item' => $task]
        )->setPaper('a4');

        $fileName = Carbon::now()->getTimestampMs() . '-' . $task->vehicle_registration . '.pdf';

        if ($type == 'preview') {
            return $pdf->stream($fileName);
        }

        return $pdf->download($fileName);
    }
}
