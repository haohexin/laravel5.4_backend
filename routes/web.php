<?php

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
    return view('welcome');
});

/*
 *  backend pages
 */
Route::group(["prefix" => "admin", "namespace" => "Admin"], function () {
    //  login
    Route::get('login', 'AuthController@showLogin');
    Route::post('login', 'AuthController@login');

    //  login success
    Route::group(['middleware' => 'auth:admin'], function () {
        //  first page
        Route::get('index', 'AuthController@index');
        //  logout
        Route::get('/logout', 'AuthController@logout');

        //  nav
        Route::get('nav/delete', 'NavController@delete');
        Route::get('nav/findLists', 'NavController@findLists');
        Route::resource('nav', 'NavController');

        //  admin
        Route::get('admins/delete', 'AdminController@delete');
        Route::resource('admins', 'AdminController');

        //  permission and role
        Route::get('permissions/delete', 'PermissionController@delete');
        Route::resource('permissions', 'PermissionController');
        Route::get('roles/permissionEdit', 'RoleController@permissionEdit');
        Route::post('roles/permissionEditPost', 'RoleController@permissionEditPost');
        Route::get('roles/delete', 'RoleController@delete');
        Route::resource('roles', 'RoleController');

        //  category
        Route::get('category/delete','CategoryController@delete');
        Route::get ( 'category/findLists', 'CategoryController@findLists' );
        Route::resource('category','CategoryController');
    });
});