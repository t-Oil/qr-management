<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/
Route::group(
    [
        'namespace' => 'App\Http\Controllers\Admin',
        'as' => 'admin.'
    ],
    function () {
        Route::get('/', [
            'uses' => 'DashboardController@index'
        ])->name('index');

        Route::group(
            [
                'prefix' => 'departments',
            ],
            function () {
                Route::get('/', [
                    'uses' => 'DepartmentController@index'
                ])->name('department.index');

                Route::get('/{id}', [
                    'uses' => 'DepartmentController@show'
                ])->name('department.show');

                Route::post('/store', [
                    'uses' => 'DepartmentController@store'
                ])->name('department.store');

                Route::post('/status', [
                    'uses' => 'DepartmentController@updateStatus'
                ])->name('department.update.status');

                Route::delete('/delete/{id}', [
                    'uses' => 'DepartmentController@destroy'
                ])->name('department.destroy');
            }
        );

        Route::group(
            [
                'prefix' => 'products',
            ],
            function () {
                Route::get('/', [
                    'uses' => 'ProductController@index'
                ])->name('product.index');

                Route::get('/{id}', [
                    'uses' => 'ProductController@show'
                ])->name('product.show');

                Route::post('/store', [
                    'uses' => 'ProductController@store'
                ])->name('product.store');

                Route::post('/status', [
                    'uses' => 'ProductController@updateStatus'
                ])->name('product.update.status');

                Route::delete('/delete/{id}', [
                    'uses' => 'ProductController@destroy'
                ])->name('product.destroy');
            }
        );

        Route::group(
            [
                'prefix' => 'partners',
            ],
            function () {
                Route::get('/', [
                    'uses' => 'PartnerController@index'
                ])->name('partner.index');

                Route::get('/{id}', [
                    'uses' => 'PartnerController@show'
                ])->name('partner.show');

                Route::post('/store', [
                    'uses' => 'PartnerController@store'
                ])->name('partner.store');

                Route::post('/status', [
                    'uses' => 'PartnerController@updateStatus'
                ])->name('partner.update.status');

                Route::delete('/delete/{id}', [
                    'uses' => 'PartnerController@destroy'
                ])->name('partner.destroy');
            }
        );

        Route::group(
            [
                'prefix' => 'users',
            ],
            function () {
                Route::get('/', [
                    'uses' => 'UserController@index'
                ])->name('user.index');

                Route::get('/{id}', [
                    'uses' => 'UserController@show'
                ])->name('user.show');

                Route::post('/store', [
                    'uses' => 'UserController@store'
                ])->name('user.store');

                Route::post('/status', [
                    'uses' => 'UserController@updateStatus'
                ])->name('user.update.status');

                Route::delete('/delete/{id}', [
                    'uses' => 'UserController@destroy'
                ])->name('user.destroy');
            }
        );
    }
);

