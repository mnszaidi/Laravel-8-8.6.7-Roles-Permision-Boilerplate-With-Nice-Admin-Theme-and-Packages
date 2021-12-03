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

Route::get('/', function () { return view('welcome'); })->name('welcome');

Auth::routes(['verify' => true]);

Route::group(['middleware' => ['auth']], function() {

    Route::group(['middleware' => ['verified']], function() {

        Route::group(['middleware' => ['role:User']], function() {
            
            /**************************** Route Customer ****************************/
            Route::get('/home', 'HomeController@index')->name('home');
            /**************************** Route Customer ****************************/
        });


        Route::group(['middleware' => ['role:Teacher']], function() {
            /**************************** Route SalesMarketing ****************************/
            Route::get('teacher',       'Dashboard\TeacherDashboardController@index')->name('teacher');
            /**************************** Route SalesMarketing ****************************/
        });

        Route::group(['middleware' => ['role:Admin']], function() {
            /**************************** Route Admin ****************************/
            Route::get('dashboard',    'Dashboard\AdminDashboardController@index')->name('dashboard');
            /**************************** Route Admin ****************************/
            /**************************** Route Users ****************************/
            Route::resource('users','User\UserController');
            Route::get('/users_upload_page','User\UserController@upload_page')->name('users.upload_page');
            Route::post('/users_csv_upload','User\UserController@upload_process')->name('users.upload_process');
            Route::get('/users_deleted_show','User\UserController@show_deleted')->name('users.show_deleted');
            Route::get('/users_restore/{id}','User\UserController@restore_single')->name('users.restore_single');
            Route::get('/users_bulk_restore','User\UserController@restore_bulk')->name('users.restore_bulk');
            Route::post('/users_bulk_delete','User\UserController@bulk_delet')->name('users.bulk_delet');
            Route::post('/users_permDelete/{id}','User\UserController@perm_Delete');
            Route::post('/users_check','User\UserController@check_users')->name('check.users');
            /**************************** Route Users ****************************/
            /**************************** Route Roles ****************************/
            Route::resource('roles','Role\RoleController');
            Route::get('/roles_deleted_show','Role\RoleController@show_deleted')->name('roles.show_deleted');
            Route::post('/roles_bulk_delete','Role\RoleController@bulk_delet')->name('roles.bulk_delet');
            Route::post('/roles_get','CommonFunctionController@get_Roles')->name('get.roles');
            /**************************** Route Roles ****************************/
            /**************************** Route Users ****************************/
            Route::resource('activities','Activity\ActivityController');
            Route::post('/activities_permDelete/{id}','Activity\ActivityController@perm_Delete');
            Route::get('/activities_clearlog','Activity\ActivityController@clearlog')->name('activities.clearlog');
            /**************************** Route Users ****************************/
        });



    });
});