<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->module = new \stdClass();
        $this->module->contentHeader = 'ข้อมูลสินค้า';
        $this->module->preFixUrl = 'products';

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

        return view('admin.product.index', $this->data);
    }

    /**
     * @param $parameters
     * @return mixed
     */
    public function items($parameters)
    {
        $search = Arr::get($parameters, 'search');
        $paginate = Arr::get($parameters, 'total', config('project.limit_rows'));
        $query = new Product;

        if ($search) {
            $query = $query->where('code', 'LIKE', '%' . $search . '%')
                ->orWhere('name', 'LIKE', '%' . $search . '%');
        }

        return $query->paginate($paginate);
    }

    /**
     * @param Request $request
     * @param Product $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(Request $request, Product $data)
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
            $data = Product::query()->find($id);

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
}
