<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = ['username','password','role','karyawan_id'];
    protected $hidden = ['password'];

    // public function karyawan(){
    //     return $this->hasOne(Karyawan::class, 'user_id', 'id');
    // }
    public function karyawan(){
        return $this->belongsTo(Karyawan::class, 'karyawan_id', 'id');
    }
}
