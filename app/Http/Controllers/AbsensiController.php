<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Http\Controllers\QRCodeController;
use App\Http\Controllers\DeviceController;
use Carbon\Carbon;

class AbsensiController extends Controller
{

    public function getNowAbsensi($user_id, $imei)
    {
        $getDevice = new DeviceController;
        $getDeviceByImei = $getDevice->getDeviceByImei($user_id, $imei);
        $absen = Absensi::where('device_id', $getDeviceByImei->id)->whereDate('jam_masuk', Carbon::now()->isoFormat('Y-MM-D'))->first();
        if (!$absen) {
            return response()->json([
                'status' => 'A404-3',
                'message' => 'Tidak ditemukan',
            ], 404);
        }
        return $absen;
    }

    public function getAllAbsensi($user_id, $imei, $limit)
    {
        $getDevice = new DeviceController;
        $getDeviceByImei = $getDevice->getDeviceByImei($user_id, $imei);
        $absen = Absensi::where('device_id', $getDeviceByImei->id)->orderByDesc('jam_masuk')->paginate($limit);
        if (!$absen) {
            return response()->json([
                'status' => 'A404-3',
                'message' => 'Tidak ditemukan',
            ], 404);
        }
        return $absen;
    }
    
    public function absenMasukKeluar($user_id, $imei, $ssid, $opsi)
    {
        if ($opsi == 'masuk') {
            $absen = new Absensi;
            $getDevice = new DeviceController($user_id, $imei);
            if (!$getDevice->verifyDevice()) {
                return response()->json([
                    'status' => 'A404-2',
                    'message' => 'Device tidak terdaftar',
                ], 404);
            }
            $absen->device_id = $getDevice->verifyDevice();
            $absen->jam_masuk = Carbon::now();

            $qrcode = new QRCodeController($ssid, Carbon::now()->isoFormat('Y-MM-D'));
            if (!$qrcode->verifyQR()) {
                return response()->json([
                    'status' => 'A404-1',
                    'message' => 'Gagal absen!'.Carbon::now()->isoFormat('Y-MM-D'),
                ], 404);
            }
            $absen->qrcode_id = $qrcode->verifyQR();
            $absen->save();
            return $absen;
        }else {
            $getDevice = new DeviceController($user_id, $imei);
            if (!$getDevice->verifyDevice()) {
                return response()->json([
                    'status' => 'A404-2',
                    'message' => 'Device tidak terdaftar',
                ], 404);
            }

            $qrcode = new QRCodeController($ssid, Carbon::now()->isoFormat('Y-MM-D'));
            if (!$qrcode->verifyQR()) {
                return response()->json([
                    'status' => 'A404-1',
                    'message' => 'Gagal absen!'.Carbon::now()->isoFormat('Y-MM-D'),
                ], 404);
            }
            $absen = Absensi::where('device_id', $getDevice->verifyDevice())->where('qrcode_id', $qrcode->verifyQR())->first();
            $absen->jam_keluar = Carbon::now();
            $absen->save();
            return $absen;
        }
    }
}
