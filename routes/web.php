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

Route::get('/', 'HomeController@index');

Route::get("/logout", "Auth\LoginController@logout");
Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::post('files/upload', 'FilesController@upload');
    Route::post('files/remove', 'FilesController@remove');
});

Route::group(['prefix' => 'master-files', 'namespace' => 'Modules\MasterFiles', 'middleware' => ['auth']], function () {
    Route::get('users/datatable', 'UsersController@datatable');
    Route::resource('users', 'UsersController');

    Route::get('number-series/datatable', 'NumberSeriesController@datatable');
    Route::resource('number-series', 'NumberSeriesController');

    Route::get('locations/datatable', 'LocationsController@datatable');
    Route::resource('locations', 'LocationsController');

    Route::get('items/datatable', 'ItemsController@datatable');
    Route::resource('items', 'ItemsController');

    Route::get('uom/datatable', 'UOMController@datatable');
    Route::resource('uom', 'UOMController');
});

Route::group(['prefix' => 'security', 'namespace' => 'Modules\Security', 'middleware' => ['auth']], function () {
    Route::get('roles/datatable', 'RolesController@datatable');
    Route::resource('roles', 'RolesController');

    Route::get('acl/datatable', 'ACLController@datatable');
    Route::resource('acl', 'ACLController');
});
