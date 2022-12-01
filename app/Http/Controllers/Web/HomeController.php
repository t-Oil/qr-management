<?php

namespace App\Http\Controllers\Web;

use App\Enums\DriverPrefix;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\JobType;
use App\Models\Product;

class HomeController extends Controller
{
    public function index(){
        if (!auth()->user()) {
            return view('auth.login');
        }

        $data['products'] = Product::query()->where('is_active', 1)->get();
        $data['departments'] = Department::query()->where('is_active', 1)->get();
        $data['jobTypes'] = JobType::query()->where('is_active', 1)->get();
        $data['prefixes'] = DriverPrefix::asArray();

        return view('web.welcome', $data);
    }

}
