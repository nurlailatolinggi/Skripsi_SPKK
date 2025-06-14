<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndikatorIki extends Model
{
    protected $fillable = [
        'deskripsi_indikator','indikator_keberhasilan','parameter','unit_id'
    ];
    public function unit(){
        return $this->belongsTo(Unit::class,'unit_id');
    }
}
