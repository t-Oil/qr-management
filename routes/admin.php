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

                Route::post('/status', [
                    'uses' => 'PartnerController@updateStatus'
                ])->name('partner.update.status');

                Route::delete('/delete/{id}', [
                    'uses' => 'PartnerController@destroy'
                ])->name('partner.destroy');
            }
        );
    }
);

