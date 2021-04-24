<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;

class DeviceController extends Controller
{
    protected $imei, $user_id;
    public function __construct($user_id = null, $imei = null) {
        $this->user_id = $user_id;
        $this->imei = $imei;
    }

    public function verifyDevice()
    {
        $device = Device::where('karyawan_id', $this->user_id)->where('no_device', $this->imei)->first();
        if ($device) {
            return $device->id;
        }
        return false;
    }

    public function getDeviceByImei($karyawan, $imei)
    {
        $device = Device::where('karyawan_id', $karyawan)->where('no_device', $imei)->first();
        if (!$device) {
            return response()->json([
                'status' => 'D404-1',
                'message' => 'Tidak Ditemukan',
            ], 404);
        }
        return $device;
    }
}
