<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QRCode;
use Carbon\Carbon;

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
        return QRCode::where('tanggal', Carbon::now()->isoFormat('Y-MM-D'))->first();
    }

    public function verifyQR()
    {
        $qrcode = QRCode::where('ssid', $this->ssid)->where('tanggal', '>=' , $this->date)->first();
        if ($qrcode) {
            return $qrcode->id;
        }
        return false;
    }
}
