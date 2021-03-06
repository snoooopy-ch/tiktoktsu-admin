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
Route::get('/rank/{key}/{period}', 'DashboardController@ranking')->name('dashboard.subrank');
Route::get('/rank/{key}', 'DashboardController@ranking')->name('dashboard.rank');
Route::get('/category/{category}', 'DashboardController@category')->name('dashboard.category');
Route::get('/user/{user}', 'DashboardController@index')->name('user');

Route::post('api/front/getusers', 'DashboardController@getUsersInFrontPage');

Route::get('/tiktok/{id}', 'DetailController@index')->name('tiktok.user');
Route::post('api/front/userdetail/{id}', 'DetailController@getUserDetailHistory');

Route::get('/posts', 'NewsViewController@index')->name('posts');
Route::get('/posts/{id}', 'NewsViewController@view')->name('posts.view');

Route::get('api/rest/getusers', 'RestApiController@users')->name('rest.users');
Route::post('api/rest/saveuser', 'RestApiController@saveUser')->name('rest.saveuser');
Route::post('api/rest/savetrending', 'RestApiController@saveTrending')->name('rest.savetrending');

Route::get('/publish', 'PublishController@index')->name('publish');
Route::post('/publish/send', 'PublishController@send')->name('publish.send');

Route::get('/trend', 'TrendController@index')->name('trend.index');
Route::post('/trend/recent', 'TrendController@recent')->name('trend.recent');

Route::get('/contact', 'ContactController@index')->name('contact.index');
Route::post('/contact/send', 'ContactController@send')->name('contact.send');

Route::get('/about', 'SupportController@about')->name('about');
Route::get('/media', 'SupportController@media')->name('media');
Route::get('/terms', 'SupportController@term')->name('term');
Route::get('/privacy', 'SupportController@privacy')->name('privacy');
Route::get('/company', 'SupportController@company')->name('company');

Route::get('/logout', function() {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    
    Route::get('/admin/news/view', 'NewsController@index')->name('news.view');
    Route::get('/admin/news/post', 'NewsController@post')->name('news.post');
    Route::post('/admin/news/upload', 'NewsController@upload')->name('news.upload');
    Route::post('/admin/news/save', 'NewsController@save')->name('news.save');
    Route::post('/admin/news/update', 'NewsController@update')->name('news.update');
    Route::get('/admin/news/edit/{id}', 'NewsController@edit')->name('news.edit');
    Route::post('api/newslist', 'NewsController@newslist');
    Route::get('api/deletenews/{id}', 'NewsController@deletetiktok');

    Route::get('/admin/news/category', 'NewsController@category')->name('news.category');
    Route::post('/admin/news/category/add', 'NewsController@addCagegory')->name('news.category.add');
    Route::post('api/news/getcategories', 'NewsController@getcategories');
    Route::get('api/deletenewscategory/{id}', 'NewsController@deleteCategory');
    Route::post('api/modifynewscategory/{id}', 'NewsController@modifyCategory');

    Route::get('/password', 'AdminController@index')->name('password');
    Route::post('/admin/passwordupdate', 'AdminController@passwordupdate')->name('admin.passwordupdate');

});

Route::group(['middleware' => ['auth', 'admin.role']], function () {
    Route::get('/admin/tiktok/list', 'HomeController@index')->name('tiktok.list');
    Route::get('/admin/tiktok/category', 'HomeController@category')->name('tiktok.category');
    Route::post('/admin/tiktok/category/add', 'HomeController@addCagegory')->name('tiktok.category.add');
    Route::post('api/tiktok/getcategories', 'HomeController@getcategories');
    Route::get('api/deletetiktokcategory/{id}', 'HomeController@deleteCategory');
    Route::post('api/modifytiktokcategory/{id}', 'HomeController@modifyCategory');
    Route::post('api/modifyusercategory/{id}', 'HomeController@modifyUserCategory');

    Route::get('/home', 'HomeController@index')->name('home');
    Route::post('api/tiktokusers', 'HomeController@tiktokusers');
    Route::get('api/deletetiktok/{id}', 'HomeController@deletetiktok');

    Route::get('/admin/staff', 'StaffController@index')->name('staff');
    Route::get('/admin/staff/add', 'StaffController@add')->name('staff.add');
    Route::get('/admin/staff/edit', 'StaffController@edit')->name('staff.edit');
    Route::post('/admin/staff/add', 'StaffController@post_add')->name('staff.post.add');
    Route::post('/admin/staff/edit', 'StaffController@post_edit')->name('staff.post.edit');
    Route::post('ajax/staff/search', 'StaffController@ajax_search');
    Route::post('ajax/staff/createToken', 'StaffController@ajax_createToken');
    Route::post('ajax/staff/delete', 'StaffController@ajax_delete');

    Route::get('/admin/setting', 'SettingController@index')->name('setting.index');
    Route::post('/admin/setitng/save', 'SettingController@save')->name('setting.save');
});
