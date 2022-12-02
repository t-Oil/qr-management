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

        Route::post('/task/store', [
            'uses' => 'TaskController@store'
        ])->name('task.store');

        Route::get('/task/{id}/export', [
            'uses' => 'TaskController@export'
        ])->name('task.export');
    }
);

Route::group(
    [
        'namespace' => 'App\Http\Controllers\Auth',
    ],
    function () {
        Route::get('/logout', [
            'LogoutController@logout'
        ])->name('auth.logout');

        Route::get('/register', [
            'RegisterController@register'
        ])->name('auth.register');
    }
);


