<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use Kreait\Firebase\Auth;
use Firebase\Auth\Token\Exception\InvalidToken;

class KaryawanController extends Controller
{
    private $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    //
    public function index($limit)
    {
        $karyawan = Karyawan::with('jenis')->orderby('nama')->paginate($limit);
        return $karyawan;
    }

    public function getKarywanById($id)
    {
        $karyawan = Karyawan::with('jenis')->find($id);
        if (!$karyawan) {
            return response()->json([
                'status' => 'K404-1',
                'message' => 'Tidak Ditemukan',
            ], 404);
        }
        return $karyawan;
    }

    public function getKarywanByUID($uid)
    {
        $karyawan = Karyawan::with('jenis')->where('uid', $uid)->fist();
        if (!$karyawan) {
            return response()->json([
                'status' => 'K404-2',
                'message' => 'Tidak Ditemukan',
            ], 404);
        }
        return $karyawan;
    }

    public function getKarywanByEmail($email)
    {
        $karyawan = Karyawan::with('jenis')->where('email', $email)->fist();
        if (!$karyawan) {
            return response()->json([
                'status' => 'K404-3',
                'message' => 'Tidak Ditemukan',
            ], 404);
        }
        return $karyawan;
    }
}
