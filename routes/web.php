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

Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/logout', function() {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', function() {
        return redirect()->route('home.view');
    })->name('home');

    Route::get('/home/view', 'HomeController@index')->name('home.view');
    Route::get('/home/register', 'HomeController@register')->name('home.register');
    Route::post('/api/addorders', 'HomeController@addOrders');
    Route::post('/api/getorders', 'HomeController@ajax_getOrderList');
    Route::get('/api/getorder/{id}', 'HomeController@getorder');
    Route::get('/api/deleteorder/{id}', 'HomeController@deleteorder');
    Route::get('/api/modifyorder/{id}', 'HomeController@modifyorder');
    Route::get('/api/deleteorders', 'HomeController@deleteorders');
    

    Route::get('/goods/view', 'GoodsController@index')->name('goods.view');
    Route::get('/goods/register', 'GoodsController@register')->name('goods.register');
    Route::post('/api/addgoods', 'GoodsController@addGoods');
    Route::post('/api/getgoods', 'GoodsController@ajax_getGoodList');
    Route::get('/api/getgood/{id}', 'GoodsController@getgood');
    Route::get('/api/deletegood/{id}', 'GoodsController@deletegood');
    Route::get('/api/modifygood/{id}', 'GoodsController@modifygood');
    Route::get('/api/deletegoods', 'GoodsController@deletegoods');

    Route::get('/sales', 'SalesController@index')->name('sales');
    Route::post('/api/addsales', 'SalesController@addSales');
    Route::post('/api/getsales', 'SalesController@ajax_getSalesList');
    Route::get('/sales/csvdownload', 'SalesController@csv_download')->name('sales.csvdownload');
    Route::get('/sales/pdfdownload', 'SalesController@pdf_download')->name('sales.pdfdownload');
    

    Route::get('/users/view', 'CustomersController@index')->name('users.view');
    Route::get('/users/register', 'CustomersController@register')->name('users.register');
    Route::post('/api/addusers', 'CustomersController@addUsers');
    Route::post('/api/getusers', 'CustomersController@ajax_getUserList');
    Route::get('/api/getuser/{id}', 'CustomersController@getuser');
    Route::get('/api/deleteuser/{id}', 'CustomersController@deleteuser');
    Route::get('/api/modifyuser/{id}', 'CustomersController@modifyuser');
    Route::get('/api/deleteusers', 'CustomersController@deleteusers');


    # Staff
    Route::get('/staff', 'StaffController@index')->name('staff');
    Route::get('/staff/add', 'StaffController@add')->name('staff.add');
    Route::get('/staff/edit', 'StaffController@edit')->name('staff.edit');
    Route::post('/staff/add', 'StaffController@post_add')->name('staff.post.add');
    Route::post('/staff/edit', 'StaffController@post_edit')->name('staff.post.edit');
    Route::post('ajax/staff/search', 'StaffController@ajax_search');
    Route::post('ajax/staff/createToken', 'StaffController@ajax_createToken');
    Route::post('ajax/staff/delete', 'StaffController@ajax_delete');

    Route::get('/staff/sale/{id}', 'CustomersController@staffSales')->name('staff.sale');
    Route::post('/staff/sale/getsales/{id}', 'CustomersController@ajax_getSaleList')->name('staff.getsales');

    # DB
    Route::get('/db', 'DBController@index')->name('db');
    Route::get('/db/download', 'DBController@download')->name('db.download');
    Route::post('/db/upload', 'DBController@upload')->name('db.upload');

    Route::get('/admin', 'AdminController@index')->name('admin');
    Route::post('/admin/passwordupdate', 'AdminController@passwordupdate')->name('admin.passwordupdate');
});
