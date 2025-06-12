<?php

namespace App\Http\Controllers;
use App\Models\RekapKinerjaPerbulan;
use App\Models\UploadIku;
use App\Models\UploadIki;

use Illuminate\Http\Request;

class ValidasiController extends Controller
{
    public function hitungKinerjaDanSimpan($karyawanId, $bulan, $tahun)
    {
        $totalIku = UploadIku::where('karyawan_id', $karyawanId)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->count();

        $validIku = UploadIku::where('karyawan_id', $karyawanId)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->where('status', 'VALID')
            ->count();

        $totalIki = UploadIki::where('karyawan_id', $karyawanId)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->count();

        $validIki = UploadIki::where('karyawan_id', $karyawanId)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->where('status', 'VALID')
            ->count();

        // Hitung persentase berdasarkan bobot
        $persentaseIku = $totalIku > 0 ? ($validIku / $totalIku) * 20 : 0;
        $persentaseIki = $totalIki > 0 ? ($validIki / $totalIki) * 80 : 0;
        $persentaseKinerja = round($persentaseIku + $persentaseIki, 2);

        // Simpan atau update ke tabel rekap
        RekapKinerjaPerbulan::updateOrCreate(
            [
                'karyawan_id' => $karyawanId,
                'bulan' => $bulan,
                'tahun' => $tahun,
            ],
            [
                'persentase_kinerja' => $persentaseKinerja,
            ]
        );
    }
}
