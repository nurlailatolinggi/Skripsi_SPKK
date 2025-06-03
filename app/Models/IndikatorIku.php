<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndikatorIku extends Model
{
    protected $fillable = [
        'deskripsi_indikator','indikator_keberhasilan','parameter','frekuensi_indikator'
    ];
    public function upload_iku(){
        return $this->hasOne(UploadIku::class, 'indikator_iku_id');
    }
}
