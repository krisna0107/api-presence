<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;

class KaryawanController extends Controller
{
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
