<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    protected $fillable = ['nik_user','nama_user','jabatan_id','unit_id'];
    
    public function user(){
        return $this->hasOne(User::class, 'karyawan_id');
    }
    public function unit(){
        return $this->belongsTo(Unit::class, 'unit_id');
    }
    public function jabatan(){
        return $this->belongsTo(Jabatan::class, 'jabatan_id');
    }
}
