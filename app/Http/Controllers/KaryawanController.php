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

    public function getKarywanByUsers($users)
    {
        $uid = Karyawan::with('jenis')->where('uid', $users)->first();
        if (!$uid) {
            $getUsers = new AuthFirebase;
            $email = Karyawan::with('jenis')->where('email', $users)->first();
            if (!$email) {
                return response()->json([
                    'status' => 'K404-2',
                    'message' => 'Tidak Ditemukan',
                ], 404);
            }
            return $getUsers->getUsersData();
        }
        return $uid;
    }

    public function getKarywanByEmail($email)
    {
        $karyawan = Karyawan::with('jenis')->where('email', $email)->first();
        if (!$karyawan) {
            return response()->json([
                'status' => 'K404-3',
                'message' => 'Tidak Ditemukan',
            ], 404);
        }
        return $karyawan;
    }
}
