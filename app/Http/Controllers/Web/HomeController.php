<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        if (!auth()->user()) {
            return view('auth.login');
        }

        $data['products'] = Product::query()->where('is_active', 1)->get();
        $data['departments'] = Department::query()->where('is_active', 1)->get();

        return view('web.welcome', $data);
    }

}
