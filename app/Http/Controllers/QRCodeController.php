<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;

class QRCodeController extends Controller
{
    //
    public static function GenerateQR()
    {
        return Karyawan::first();
    }
}
