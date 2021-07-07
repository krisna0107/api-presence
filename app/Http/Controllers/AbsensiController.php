<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Http\Controllers\QRCodeController;
use App\Http\Controllers\DeviceController;
use Carbon\Carbon;

class AbsensiController extends Controller
{

    public static function getKaryawanAbsensi($user_id, $imei)
    {
        $getDevice = new DeviceController($user_id, $imei);
        $getDeviceByImei = $getDevice->verifyDevice();
        $absen = Absensi::where('device_id', $getDeviceByImei)->whereDate('jam_masuk', Carbon::now()->isoFormat('Y-MM-D'))->first();
        if (!$absen) {
            return false;
        }
        return true;
    }

    public function getNowAbsensi(Request $request, $user_id, $imei)
    {
        $getDevice = new DeviceController($user_id, $imei);
        $getDeviceByImei = $getDevice->verifyDevice($request->bearerToken());
        $absen = Absensi::where('device_id', $getDeviceByImei)->whereDate('jam_masuk', Carbon::now()->isoFormat('Y-MM-D'))->first();
        if (!$absen) {
            return response()->json([
                'status' => 'A404-3',
                'message' => 'Tidak ditemukan',
            ], 404);
        }
        return $absen;
    }

    public function getAllAbsensi(Request $request, $user_id, $imei, $limit)
    {
        $getDevice = new DeviceController($user_id, $imei);
        $getDeviceByImei = $getDevice->verifyDevice($request->bearerToken());
        $absen = Absensi::where('device_id', $getDeviceByImei)->orderByDesc('jam_masuk')->paginate($limit);
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
        $getDevice = new DeviceController($user_id, $imei);
        if (!$getDevice->verifyDevice()) {
            return response()->json([
                'status' => 'A404-2',
                'message' => 'Device tidak terdaftar',
            ], 404);
        }
        $qrcode = new QRCodeController($ssid, date('Y-m-d H:i:s'));
        if (!$qrcode->verifyQR()) {
            return response()->json([
                'status' => 'A404-1',
                'message' => 'Gagal absen! '.date('Y-m-d H:i:s'),
            ], 404);
        }
        if ($opsi == 'masuk') {
            $absen = new Absensi;
            $getAbsen = $this->getKaryawanAbsensi($user_id, $imei);
            if ($getAbsen) {
                return response()->json([
                    'status' => 'A404-4',
                    'message' => 'Telah melakukan absen masuk hari ini',
                ], 409);
            }
            $absen->device_id = $getDevice->verifyDevice();
            $absen->jam_masuk = Carbon::now();
            $absen->qrcode_id = $qrcode->verifyQR();
            $absen->save();
            return $absen;
        } else {
            $deviceAbsen = Absensi::where('device_id', $getDevice->verifyDevice());
            $absenKeluar = $deviceAbsen->where('qrcode_id', $qrcode->verifyQR())->whereDate('jam_masuk', Carbon::now()->isoFormat('Y-MM-D'))->first();
            if (!$absenKeluar) {
                return response()->json([
                    'status' => 'A404-1',
                    'message' => 'Gagal absen! '.Carbon::now()->isoFormat('Y-MM-D'),
                ], 404);
            }
            $getAbsen = $deviceAbsen->whereDate('jam_keluar', Carbon::now()->isoFormat('Y-MM-D'))->first();
            if ($getAbsen) {
                return response()->json([
                    'status' => 'A404-4',
                    'message' => 'Telah melakukan absen keluar hari ini',
                ], 409);
            }
            $absenKeluar->jam_keluar = Carbon::now();
            $absenKeluar->save();
            return $absenKeluar;
        }
    }
}
