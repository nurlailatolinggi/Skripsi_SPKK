<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    protected $fillable = ['nik_user','nama_user','jabatan_id','unit_id'];
    
    public function user(){
        return $this->hasOne(User::class, 'karyawan_id', 'id');
    }
    // public function user(){
    //     return $this->belongsTo(User::class, 'karyawan_id');
    // }
    public function unit(){
        return $this->belongsTo(Unit::class, 'unit_id');
    }
    public function jabatan(){
        return $this->belongsTo(Jabatan::class, 'jabatan_id');
    }
    public function uploadIku(){
        return $this->hasMany(UploadIku::class, 'karyawan_id', 'id');
    }
    public function uploadIki(){
        return $this->hasMany(UploadIki::class, 'karyawan_id', 'id');
    }
    public function rekapKinerjaBulanan()
    {
        return $this->hasMany(RekapKinerjaPerbulan::class);
    }
}
