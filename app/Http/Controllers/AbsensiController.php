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
        $absen->qrcode_id = $request->qrcode_id;
        $getDevice = new DeviceController($request->user_id, $request->imei);
        if (!$getDevice->verifyDevice()) {
            return response()->json([
                'status' => 'A404-2',
                'message' => 'Device tidak terdaftar',
            ], 404);
        }
        $absen->device_id = $getDevice->verifyDevice();
        $absen->jam_masuk = Carbon::now();

        $qrcode = new QRCodeController($request->ssid, $request->qrcode_id, Carbon::now()->isoFormat('Y-MM-D'));
        if (!$qrcode->verifyQR()) {
            return response()->json([
                'status' => 'A404-1',
                'message' => 'Gagal absen!'.Carbon::now()->isoFormat('Y-MM-D'),
            ], 404);
        }
        $absen->save();
        return $absen;
    }

    public function absenKeluar(Request $request)
    {
        $absen->qrcode_id = $request->qrcode_id;
        $getDevice = new DeviceController($request->user_id, $request->imei);
        if (!$getDevice->verifyDevice()) {
            return response()->json([
                'status' => 'A404-2',
                'message' => 'Device tidak terdaftar',
            ], 404);
        }
        $absen->jam_keluar = Carbon::now();

        $qrcode = new QRCodeController($request->ssid, $request->qrcode_id, Carbon::now()->isoFormat('Y-MM-D'));
        if (!$qrcode->verifyQR()) {
            return response()->json([
                'status' => 'A404-1',
                'message' => 'Gagal absen!'.Carbon::now()->isoFormat('Y-MM-D'),
            ], 404);
        }
        $absen->save();
        return $absen;
    }
}
