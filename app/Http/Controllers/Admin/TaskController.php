<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class TaskController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->module = new \stdClass();
        $this->module->contentHeader = 'ข้อมูลลงทะเบียน QR Code';
        $this->module->preFixUrl = 'tasks';

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

        return view('admin.task.index', $this->data);
    }

    /**
     * @param $parameters
     * @return mixed
     */
    public function items($parameters)
    {
        $startDate = Arr::get($parameters, 'start_date');
        $endDate = Arr::get($parameters, 'end_date');
        $paginate = Arr::get($parameters, 'total', config('project.limit_rows'));
        $query = new Task;

        if ($startDate && $endDate) {
            $query = $query->whereBetween('task_date', [$startDate, $endDate]);
        }

        return $query->paginate($paginate);
    }
}
