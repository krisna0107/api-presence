<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Http\Controllers\ValidasiController;

class KaryawanController extends Controller
{
    //
    public function index($limit)
    {
        $karyawan = Karyawan::with('jenis')->orderby('nama')->paginate($limit);
        return $karyawan;
    }

    public function getKarywanById(Request $request, $id)
    {
        $validasi = new ValidasiController($request->bearerToken());
        $karyawan = Karyawan::with('jenis')->find($id);
        if (!$karyawan) {
            return response()->json([
                'status' => 'K404-1',
                'message' => 'Tidak Ditemukan',
            ], 404);
        }
        if ($validasi->validasi() != $karyawan->uid) {
            return response()->json([
                'status' => 'K404-5',
                'message' => 'Unauthorized',
            ], 401);
        }
        return $karyawan;
    }

    public function getKarywanByUsers(Request $request, $users)
    {
        $validasi = new ValidasiController($request->bearerToken());
        $uid = Karyawan::with('jenis')->with('devices')->where('uid', $users)->first();
        if (!$uid) {
            $email = Karyawan::with('jenis')->with('devices')->where('email', $users)->first();
            if (!$email) {
                return response()->json([
                    'status' => 'K404-2',
                    'message' => 'Tidak Ditemukan',
                ], 404);
            }
            if ($validasi->validasi() != $email->uid) {
                return response()->json([
                    'status' => 'K404-5',
                    'message' => 'Unauthorized',
                ], 401);
            }
            return $email;
        }
        if ($validasi->validasi() != $uid->uid) {
            return response()->json([
                'status' => 'K404-5',
                'message' => 'Unauthorized',
            ], 401);
        }
        return $uid;
    }

    public function getKarywanByEmail(Request $request, $email)
    {
        $validasi = new ValidasiController($request->bearerToken());
        $karyawan = Karyawan::with('jenis')->where('email', $email)->first();
        if (!$karyawan) {
            return response()->json([
                'status' => 'K404-3',
                'message' => 'Tidak Ditemukan',
            ], 404);
        }
        if ($validasi->validasi() != $karyawan->uid) {
            return response()->json([
                'status' => 'K404-5',
                'message' => 'Unauthorized',
            ], 401);
        }
        return $karyawan;
    }

}
