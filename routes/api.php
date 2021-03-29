<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::group(['prefix' => 'v1', 'middleware' => 'authfirebase'], function(){
    Route::prefix('karyawans')->group(function () {
        Route::get('/{id}', 'App\Http\Controllers\KaryawanController@getKarywanById');
        Route::get('/uid/{uid}', 'App\Http\Controllers\KaryawanController@getKarywanByUID');
        Route::get('/email/{email}', 'App\Http\Controllers\KaryawanController@getKarywanByEmail');
        Route::get('/paginate/{limit}', 'App\Http\Controllers\KaryawanController@index');
    });
});