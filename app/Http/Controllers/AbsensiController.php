<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Http\Controllers\QRCodeController;
use App\Http\Controllers\DeviceController;
use Carbon\Carbon;

class AbsensiController extends Controller
{

    public function absenMasuk(Request $request)
    {
        $absen = new Absensi;
        $getDevice = new DeviceController($request->user_id, $request->imei);
        if (!$getDevice->verifyDevice()) {
            return response()->json([
                'status' => 'A404-2',
                'message' => 'Device tidak terdaftar',
            ], 404);
        }
        $absen->device_id = $getDevice->verifyDevice();
        $absen->jam_masuk = Carbon::now();

        $qrcode = new QRCodeController($request->ssid, Carbon::now()->isoFormat('Y-MM-D'));
        if (!$qrcode->verifyQR()) {
            return response()->json([
                'status' => 'A404-1',
                'message' => 'Gagal absen!'.Carbon::now()->isoFormat('Y-MM-D'),
            ], 404);
        }
        $absen->qrcode_id = $qrcode->verifyQR();
        $absen->save();
        return $absen;
    }
}
