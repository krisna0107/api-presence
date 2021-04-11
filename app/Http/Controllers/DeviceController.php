<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;

class DeviceController extends Controller
{
    protected $imei, $user_id;
    public function __construct($user_id, $imei) {
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
}
