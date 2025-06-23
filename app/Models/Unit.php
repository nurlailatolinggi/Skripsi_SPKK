<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = ['nama_unit'];
    public function karyawans()
    {
        return $this->hasMany(Karyawan::class, 'unit_id');
    }
}
