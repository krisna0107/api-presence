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
Route::middleware('authfirebase')->group(function () {
    Route::prefix('karyawans')->group(function () {
        Route::get('/{id}', 'App\Http\Controllers\KaryawanController@getKarywanById');
        Route::get('/barcode/{uid}', 'App\Http\Controllers\KaryawanController@getBarcode');
        Route::get('/users/{users}', 'App\Http\Controllers\KaryawanController@getKarywanByUsers');
        Route::get('/email/{email}', 'App\Http\Controllers\KaryawanController@getKarywanByEmail');
        Route::get('/paginate/{limit}', 'App\Http\Controllers\KaryawanController@index');
    });
    
    Route::prefix('devices')->group(function () {
        Route::get('/users/{users}/no-device/{imei}', 'App\Http\Controllers\DeviceController@getDeviceByImei');
    });

    Route::prefix('absensis')->group(function () {
        Route::get('/user/{user_id}/device/{imei}', 'App\Http\Controllers\AbsensiController@getNowAbsensi');
        Route::get('/user/{user_id}/device/{imei}/limit/{limit}', 'App\Http\Controllers\AbsensiController@getAllAbsensi');
    });
});

Route::prefix('absensis')->group(function () {
    Route::get('/user/{user_id}/device/{imei}', 'App\Http\Controllers\AbsensiController@getNowAbsensi');
    Route::get('/user/{user_id}/device/{imei}/limit/{limit}', 'App\Http\Controllers\AbsensiController@getAllAbsensi');
    Route::post('/user/{user_id}/device/{imei}/id/{ssid}/kode/{opsi}', 'App\Http\Controllers\AbsensiController@absenMasukKeluar');
});

// $user_id, $imei, $ssid, $opsi
Route::prefix('qrcode')->group(function () {
    Route::get('', 'App\Http\Controllers\QRCodeController@GenerateQR');
});