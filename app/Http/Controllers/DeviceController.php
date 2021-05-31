<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Http\Controllers\ValidasiController;

class DeviceController extends Controller
{
    protected $imei, $user_id;
    public function __construct($user_id = null, $imei = null) {
        $this->user_id = $user_id;
        $this->imei = $imei;
    }

    public function verifyDevice($token = null)
    {
        $device = Device::with('karyawan')->where('karyawan_id', $this->user_id)->where('no_device', $this->imei)->first();
        if ($token!=null && $device) {
            $validasi = new ValidasiController($token);
            if ($validasi->validasi() != $device->karyawan->uid) {
                return false;
            }
        }
        if ($device) {
            return $device->id;
        }
        return false;
    }

    public function getDeviceByImei(Request $request, $karyawan, $imei)
    {
        $validasi = new ValidasiController($request->bearerToken());
        $device = Device::with('karyawan')->where('karyawan_id', $karyawan)->where('no_device', $imei)->first();
        if (!$device) {
            return response()->json([
                'status' => 'D404-1',
                'message' => 'Tidak Ditemukan',
            ], 404);
        }
        if ($validasi->validasi() != $device->karyawan->uid) {
            return response()->json([
                'status' => 'D404-2',
                'message' => 'Unauthorized',
            ], 401);
        }
        return $device;
    }
}
