<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QRCode;

class QRCodeController extends Controller
{
    protected $ssid, $date;
    public function __construct($ssid, $date) {
        $this->ssid = $ssid;
        $this->date = $date;
    }
    //
    public static function GenerateQR()
    {
        return QRCode::first();
    }

    public function verifyQR()
    {
        $qrcode = QRCode::where('ssid', $this->ssid)->whereDate('tanggal', $this->date)->first();
        if ($qrcode) {
            return $qrcode->id;
        }
        return false;
    }
}
