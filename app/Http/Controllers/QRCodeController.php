<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QRCode;

class QRCodeController extends Controller
{
    //
    public static function GenerateQR()
    {
        return QRCode::first();
    }
}
