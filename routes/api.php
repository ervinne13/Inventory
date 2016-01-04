<?php

use Illuminate\Http\Request;

/*
  |--------------------------------------------------------------------------
  | API Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register API routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | is assigned the "api" middleware group. Enjoy building your API!
  |
 */

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'master-files', 'namespace' => 'Modules\MasterFiles'], function () {
    Route::get('items', 'ItemsController@searchableItemsByNameJsonAPI');
    Route::get('itemUOMList', 'ItemsController@searchableUOMByItemCodeJSONAPI');
});


Route::post('login', 'Modules\MasterFiles\UsersController@apiLogin');
Route::get('inventory/{locationCode}', 'Modules\MasterFiles\ItemsController@stocksByLocation');
