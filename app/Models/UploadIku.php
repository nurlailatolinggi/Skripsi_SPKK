<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UploadIku extends Model
{
    protected $fillable = ['path_file_iku', 'karyawan_id', 'indikator_iku_id', 'tahun', 'bulan', 'status'];
    // public function karyawan(){
    //     return $this->hasOne(Karyawan::class, 'karyawan_id');
    // }
    public function karyawan(){
        return $this->belongsTo(Karyawan::class, 'karyawan_id', 'id');
    }
    public function indikator_iku(){
        return $this->belongsTo(IndikatorIku::class, 'indikator_iku_id', 'id');
    }
}
