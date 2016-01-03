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

Route::get('/test', 'TestController@test');
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
    Route::get('items/{itemCode}/files', 'ItemsController@itemFiles');
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

Route::group(['prefix' => 'inventory', 'namespace' => 'Modules\Inventory', 'middleware' => ['auth']], function () {
    Route::get('item-movements/datatable', 'ItemMovementController@datatable');
    Route::post('item-movements/post/{docNo}', 'ItemMovementController@postDocument');
    Route::resource('item-movements', 'ItemMovementController');
});

Route::group(['prefix' => 'production', 'namespace' => 'Modules\Production', 'middleware' => ['auth']], function () {
    Route::get('bom/datatable', 'BillOfMaterialsController@datatable');
    Route::resource('bom', 'BillOfMaterialsController');

    ///{BOMCode}/qty/{qty}    
    Route::get('production-orders/production-details', 'ProductionOrdersController@productionCostDetails');
    Route::get('production-orders/datatable', 'ProductionOrdersController@datatable');
    Route::resource('production-orders', 'ProductionOrdersController');    
});
