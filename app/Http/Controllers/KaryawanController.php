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
                'status' => 'K404',
                'message' => 'Tidak Ditemukan',
            ], 404);
        }
        return $karyawan;
    }
}
