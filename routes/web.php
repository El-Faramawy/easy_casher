<?php

use Illuminate\Support\Facades\Route;

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


//Route::get('/', 'Admin\AdminLoginController@showLoginForm');


//Route::view('/', 'welcome');
Route::view('/', 'Site/index');
Route::view('add-page', 'Site/add-page');
Route::view('sale-invoice', 'Site/sale-invoice');
Route::view('receipt', 'Site/receipt');
Route::view('add-sections', 'Site/add-sections');
Route::view('add-products', 'Site/add-products');
Route::view('add-offer', 'Site/add-offer');
Route::view('login', 'Site/login');
Route::post('post_login', 'Site\AuthController@post_login')->name('post_login');
Route::get('logout', 'Site\AuthController@logout')->name('logout');
Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});
//Route::post('PayBill', 'Api\Sales\PayBillApi@index');


//Route::post('PayBill', 'Api\Sales\PayBillApi@index');
//Route::group(['middleware' => 'auth:auth'], function () {

//  ======================add_sction=========================
    Route::get('add-sections', 'Site\AddSectionController@index')->name('add-sections');
    Route::post('create-sections', 'Site\AddSectionController@create')->name('create-sections');
    Route::post('update-sections', 'Site\AddSectionController@update')->name('update-sections');


//  ======================add_products=========================
    Route::get('add-products', 'Site\AddProductCategory@index')->name('add-products');
    Route::post('create-products', 'Site\AddProductCategory@create')->name('create-products');
    Route::post('update-products', 'Site\AddProductCategory@update')->name('update-products');

//  ======================add_offer=========================
    Route::get('add-offer', 'Site\AddCouponsController@index')->name('add-offer');
    Route::post('create-offer', 'Site\AddCouponsController@create')->name('create-offer');
    Route::post('update-offer', 'Site\AddCouponsController@update')->name('update-offer');

//});
