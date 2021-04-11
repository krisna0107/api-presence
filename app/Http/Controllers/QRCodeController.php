<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QRCode;

class QRCodeController extends Controller
{
    protected $ssid, $qr, $date;
    public function __construct($ssid, $qr, $date) {
        $this->ssid = $ssid;
        $this->qr = $qr;
        $this->date = $date;
    }
    //
    public static function GenerateQR()
    {
        return QRCode::first();
    }

    public function verifyQR()
    {
        $qrcode = QRCode::find($this->qr);
        if ($qrcode->ssid == $this->ssid && $qrcode->tanggal == $this->date) {
            return true;
        }
        return false;
    }
}
