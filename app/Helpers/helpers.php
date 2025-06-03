<?php

use App\Models\IndikatorIku as Iku;
use App\Models\IndikatorIki as Iki;
use App\Models\UploadIku;
use App\Models\UploadIki;

// umum
function getbulandantahun($bulan, $tahun){
  $daftarBulan = [ 1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember', ];
  $bulan = (int) $bulan;
  $tahun = (int) $tahun;
  return ($daftarBulan[$bulan] ?? 'Bulan Tidak Valid') . ' ' . $tahun;
}
// khusus
function getuploadikubulanandetail($where=[],$status=NULL){
  return UploadIku::with(['indikator_iku'])
    ->where([
      'karyawan_id'=>$where['karyawan_id'],
      'tahun'=>$where['tahun'],
      'bulan'=>$where['bulan'],
    ])->whereHas('indikator_iku', function($query){
      $query->where('frekuensi_indikator','BULANAN');
    })->when($status, function($query, $status){
      return $query->where('status', $status);
    })
    ->count();
}
function getuploadikutahunandetail($where=[],$status=NULL){
  return UploadIku::with(['indikator_iku'])
    ->where([
      'karyawan_id'=>$where['karyawan_id'],
      'tahun'=>$where['tahun'],
    ])->whereHas('indikator_iku', function($query){
      $query->where('frekuensi_indikator','TAHUNAN');
    })->when($status, function($query, $status){
      return $query->where('status', $status);
    })
    ->count();
}
function getuploadiku($where){
  return (Object) [
    'baru' => getuploadikubulanandetail($where, 'BARU')+getuploadikutahunandetail($where, 'BARU'),
    'valid' => getuploadikubulanandetail($where, 'VALID')+getuploadikutahunandetail($where, 'VALID'),
    'tidak_valid' => getuploadikubulanandetail($where, 'TIDAK VALID')+getuploadikutahunandetail($where, 'TIDAK VALID'),
    'total' => getuploadikubulanandetail($where)+getuploadikutahunandetail($where),
  ];
}
function getuploadikidetail($where=[],$status=NULL){
  return UploadIki::with(['indikator_iki'])
    ->where([
      'karyawan_id'=>$where['karyawan_id'],
    ])->when($status, function($query, $status){
      return $query->where('status', $status);
    })
    ->count();
}
function getuploadiki($where){
  return (Object) [
    'baru' => getuploadikidetail($where, 'BARU'),
    'valid' => getuploadikidetail($where, 'VALID'),
    'tidak_valid' => getuploadikidetail($where, 'TIDAK VALID'),
    'total' => getuploadikidetail($where),
  ];
}
function getikiunit($unit_id){
  return Iki::where('unit_id',$unit_id)
    ->count();
}
function tdstatusdokumen($status){
  $td = "";
  switch ($status) {
    case 'VALID':
      $td.="<td class='bg-success text-white'>";
    break;
    case 'TIDAK VALID':
      $td.="<td class='bg-danger text-white'>";
    break;
    default:
      $td.="<td>";
    break;
  }
  $td .=$status;
  $td .= "</td>";
  return $td;
}
function hitungpersentasekinerja($iku=0, $ikuvalid=0, $iki=0, $ikivalid=0){
  $bobotIku = 20;
  $bobotIki = 80;
  $persenIku = ($iku > 0)?($ikuvalid/$iku)*$bobotIku:0;
  $persenIki = ($iki > 0)?($ikivalid/$iki)*$bobotIki:0;
  return number_format(($persenIku+$persenIki),2);
}