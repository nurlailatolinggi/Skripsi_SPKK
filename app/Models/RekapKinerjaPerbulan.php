<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekapKinerjaPerbulan extends Model
{
    protected $fillable = ['karyawan_id', 'bulan', 'tahun', 'persentase_kinerja'];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }
}
