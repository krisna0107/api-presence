<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;
    public function jenis()
    {
        return $this->belongsTo(Jenis::class, 'jenis_id', 'id');
    }
    
    public function devices()
    {
        return $this->hasMany(Device::class, 'karyawan_id', 'id');
    }
}
