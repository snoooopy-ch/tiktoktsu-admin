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
Route::get('/', 'DashboardController@index')->name('dashboard');
Route::post('api/front/getusers', 'DashboardController@getUsersInFrontPage');

Route::get('/posts', 'NewsViewController@index')->name('posts');
Route::get('/posts/{id}', 'NewsViewController@view')->name('posts.view');

Route::get('api/rest/getusers', 'RestApiController@users')->name('rest.users');
Route::post('api/rest/saveuser', 'RestApiController@saveUser')->name('rest.saveuser');

Route::get('/publish', 'PublishController@index')->name('publish');
Route::post('/publish/send', 'PublishController@send')->name('publish.send');

Route::get('/logout', function() {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/tiktok/list', 'HomeController@index')->name('tiktok.list');
    Route::get('/tiktok/category', 'HomeController@category')->name('tiktok.category');
    Route::post('/tiktok/category/add', 'HomeController@addCagegory')->name('tiktok.category.add');
    Route::post('api/tiktok/getcategories', 'HomeController@getcategories');
    Route::get('api/deletetiktokcategory/{id}', 'HomeController@deleteCategory');
    Route::post('api/modifytiktokcategory/{id}', 'HomeController@modifyCategory');
    Route::post('api/modifyusercategory/{id}', 'HomeController@modifyUserCategory');

    Route::get('/home', 'HomeController@index')->name('home');
    Route::post('api/tiktokusers', 'HomeController@tiktokusers');
    Route::get('api/deletetiktok/{id}', 'HomeController@deletetiktok');

    Route::get('/news/view', 'NewsController@index')->name('news.view');
    Route::get('/news/post', 'NewsController@post')->name('news.post');
    Route::post('/news/upload', 'NewsController@upload')->name('news.upload');
    Route::post('/news/save', 'NewsController@save')->name('news.save');
    Route::post('api/newslist', 'NewsController@newslist');
    Route::get('api/deletenews/{id}', 'NewsController@deletetiktok');

    Route::get('/news/category', 'NewsController@category')->name('news.category');
    Route::post('/news/category/add', 'NewsController@addCagegory')->name('news.category.add');
    Route::post('api/news/getcategories', 'NewsController@getcategories');
    Route::get('api/deletenewscategory/{id}', 'NewsController@deleteCategory');
    Route::post('api/modifynewscategory/{id}', 'NewsController@modifyCategory');

    Route::get('/password', 'AdminController@index')->name('password');
    Route::post('/admin/passwordupdate', 'AdminController@passwordupdate')->name('admin.passwordupdate');

    Route::get('/staff', 'StaffController@index')->name('staff');
    Route::get('/staff/add', 'StaffController@add')->name('staff.add');
    Route::get('/staff/edit', 'StaffController@edit')->name('staff.edit');
    Route::post('/staff/add', 'StaffController@post_add')->name('staff.post.add');
    Route::post('/staff/edit', 'StaffController@post_edit')->name('staff.post.edit');
    Route::post('ajax/staff/search', 'StaffController@ajax_search');
    Route::post('ajax/staff/createToken', 'StaffController@ajax_createToken');
    Route::post('ajax/staff/delete', 'StaffController@ajax_delete');
});
