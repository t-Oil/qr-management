<?php

use Illuminate\Support\Facades\Route;
use App\Mail\WelcomeMailable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['verify' => true]);

Route::group(
    [
        'namespace' => 'App\Http\Controllers\Web',
    ],
    function () {
        Route::get('/', [
            'uses' => 'HomeController@index'
        ])->name('web.index');

        Route::get('/task', [
            'uses' => 'TaskController@index'
        ])->name('task.index');

        Route::post('/task/store', [
            'uses' => 'TaskController@store'
        ])->name('task.store');
    }
);

Route::get('/logout', [
    'App\Http\Controllers\Auth\LogoutController', 'logout'
])->name('auth.logout');

Route::get('/register', [
    'App\Http\Controllers\Auth\RegisterController', 'register'
])->name('auth.register');

