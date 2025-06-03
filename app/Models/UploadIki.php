<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UploadIki extends Model
{
    protected $fillable = ['path_file_iki','karyawan_id','indikator_iki_id', 'status'];
    public function karyawan(){
        return $this->hasOne(Karyawan::class, 'karyawan_id');
    }
    public function indikator_iki(){
        return $this->belongsTo(IndikatorIki::class, 'indikator_iki_id', 'id');
    }
}
