<?php

use Illuminate\Support\Facades\Route;
use SimpleSoftwareIO\QrCode\Generator;
use App\Http\Controllers\QRCodeController;

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
    // $qrcode = new Generator;
    // $qr = $qrcode->size(500)->generate(QRCodeController::GenerateQR());

    // return view('welcome', [
    //     'qr' => $qr
    // ]);
    return response()->json([
        'status' => '404',
        'message' => 'Not Found',
    ], 404);
});
