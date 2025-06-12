<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Unit;
use App\Models\Jabatan;
use App\Models\IndikatorIku as Iku;
use App\Models\IndikatorIki as Iki;
use App\Models\UploadIku;
use App\Models\UploadIki;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\RekapKinerjaPerbulan;

class KaryawanController extends Controller
{
    protected $karyawan_id;
    public function __construct(){
        $this->karyawan_id = Auth::user()->karyawan_id;
    }

    public function index(){
        $user = Auth::user();

        $karyawanId = $user->karyawan_id;

        //hitung total iku
        $totalIku = UploadIku::where('karyawan_id', $karyawanId)->count();

        //hitung baru iku
        $totalBaruIku = UploadIku::where('karyawan_id', $karyawanId)
            ->where('status', 'BARU')
            ->count();

        //hitung valid iku
        $totalValidIku = UploadIku::where('karyawan_id', $karyawanId)
            ->where('status', 'VALID')
            ->count();

        //hitung tidak valid iku
        $totalTidakValidIku = UploadIku::where('karyawan_id', $karyawanId)
            ->where('status', 'TIDAK VALID')
            ->count();

        //hitung total iki
        $totalIki = UploadIki::where('karyawan_id', $karyawanId)->count();

        //hitung baru iki
        $totalBaruIki = UploadIki::where('karyawan_id', $karyawanId)
            ->where('status', 'BARU')
            ->count();

        //hitung valid iki
        $totalValidIki = UploadIki::where('karyawan_id', $karyawanId)
            ->where('status', 'VALID')
            ->count();

        //hitung tidak valid iki
        $totalTidakValidIki = UploadIki::where('karyawan_id', $karyawanId)
            ->where('status', 'TIDAK VALID')
            ->count();

        // dd($totalIku, $totalBaruIku, $totalValidIku, $totalTidakValidIku, $totalIki, $totalBaruIki, $totalValidIki, $totalTidakValidIki);

        return view('karyawan.dashboard', compact('totalIku', 'totalBaruIku', 'totalValidIku', 'totalTidakValidIku', 'totalIki', 'totalBaruIki', 'totalValidIki', 'totalTidakValidIki'));
    }
    
    // IKU===================================================================================================================================
    public function uploadiku(Request $request){
        $search = $request->query('search');
        $periode = $request->query('periode');
        $ikus = Iku::when($search, function($query, $search){
            return $query->where('deskripsi_indikator','LIKE',"%{$search}%")
                ->orWhere('indikator_keberhasilan','LIKE',"%{$search}%")
                ->orWhere('parameter','LIKE',"%{$search}%");
        })->paginate(20);
        return view('karyawan.iku_tabel', compact('search', 'periode','ikus'));
    }
    public function uploadikustore(Request $request){
        $request->validate([
            'file'=> 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'indikator_iku_id'=> 'required',
            'bulan'=> 'required',
            'tahun'=> 'required',
        ]);
        try {
            $file = $request->file('file');
            $path = $file->store('files_iku','public');
            DB::beginTransaction();
            UploadIku::create([
                'path_file_iku'=> $path,
                'karyawan_id'=> $this->karyawan_id,
                'indikator_iku_id'=> $request->indikator_iku_id,
                'tahun'=> (int) $request->tahun,
                'bulan'=> (int) $request->bulan,
            ]);
            DB::commit();
            return back()->with([
                'notif' => true,
                'icon' =>'success',
                'title' =>'Upload Dokumen Berhasil',
                'message' =>'Berhasil menyimpan dokumen iku baru'
            ])->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with([
                'notif' => true,
                'icon' =>'error',
                'title' =>'Upload Dokumen Gagal',
                'message' =>'Terjadi kesalahan saat menyimpan dokumen iku baru'
            ])->withInput();
        }
    }
    public function uploadikudestroy($id){
        $uploadiku = UploadIku::findOrFail($id);
        try {
            DB::beginTransaction();
            if(Storage::disk('public')->exists($uploadiku->path_file_iku)){
                Storage::disk('public')->delete($uploadiku->path_file_iku);
            }
            $uploadiku->delete();
            DB::commit();
            return back()->with([
                'notif' => true,
                'icon' =>'success',
                'title' =>'Hapus Dokumen Berhasil',
                'message' =>'Berhasil menghapus dokumen iku baru'
            ])->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with([
                'notif' => true,
                'icon' =>'error',
                'title' =>'Hapus Dokumen Gagal',
                'message' =>'Terjadi kesalahan saat menghapus dokumen iku baru'
            ])->withInput();
        }
    }
    // IKI=================================================================================================
    public function uploadiki(Request $request){
        // $search = $request->query('search');
        // $periode = $request->query('periode');
        // $ikis = Iki::where('unit_id', Auth::user()->karyawan->unit_id)
        //     ->when($search, function($query, $search){
        //         return $query->where('deskripsi_indikator','LIKE',"%{$search}%")
        //             ->orWhere('indikator_keberhasilan','LIKE',"%{$search}%")
        //             ->orWhere('parameter','LIKE',"%{$search}%");
        //     })->paginate(20);
        // return view('karyawan.iki_tabel', compact('search', 'periode','ikis'));
        $search = $request->query('search');
        $periode = $request->query('periode') ?? now()->format('Y-m');
        [$tahun, $bulan] = explode('-', $periode);

        // Data IKI (indikator)
        $ikis = Iki::where('unit_id', Auth::user()->karyawan->unit_id)
            ->when($search, function($query, $search) {
                return $query->where('deskripsi_indikator', 'LIKE', "%{$search}%")
                    ->orWhere('indikator_keberhasilan', 'LIKE', "%{$search}%")
                    ->orWhere('parameter', 'LIKE', "%{$search}%");
            })
            ->paginate(20);

        // Upload-an user karyawan saat ini untuk bulan & tahun yang dipilih
        $uploads = UploadIki::where('karyawan_id', Auth::user()->karyawan_id)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->get()
            ->keyBy('indikator_iki_id'); // agar bisa akses per indikator di view


        // dd([
        //     'periode' => $periode,
        //     'tahun' => $tahun,
        //     'bulan' => $bulan,
        //     'uploads_found' => UploadIki::where('karyawan_id', Auth::user()->karyawan_id)
        //         ->where('bulan', $bulan)
        //         ->where('tahun', $tahun)
        //         ->count(),
        // ]);

        return view('karyawan.iki_tabel', compact('ikis', 'search', 'periode', 'uploads', 'bulan', 'tahun'));
    }
    public function uploadikistore(Request $request){
        $request->validate([
            'file'=> 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'indikator_iki_id'=> 'required',
            'bulan'=> 'required',
            'tahun'=> 'required',
        ]);
        try {
            $file = $request->file('file');
            $path = $file->store('files_iki','public');
            DB::beginTransaction();
            UploadIki::create([
                'path_file_iki'=> $path,
                'karyawan_id'=> $this->karyawan_id,
                'indikator_iki_id'=> $request->indikator_iki_id,
                'tahun'=> (int) $request->tahun,
                'bulan'=> (int) $request->bulan,
            ]);
            DB::commit();
            return back()->with([
                'notif' => true,
                'icon' =>'success',
                'title' =>'Upload Dokumen Berhasil',
                'message' =>'Berhasil menyimpan dokumen iki baru'
            ])->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with([
                'notif' => true,
                'icon' =>'error',
                'title' =>'Upload Dokumen Gagal',
                'message' =>'Terjadi kesalahan saat menyimpan dokumen iki baru'
            ])->withInput();
        }
    }
    public function uploadikidestroy($id){
        $uploadiki = UploadIki::findOrFail($id);
        try {
            DB::beginTransaction();
            if(Storage::disk('public')->exists($uploadiki->path_file_iki)){
                Storage::disk('public')->delete($uploadiki->path_file_iki);
            }
            $uploadiki->delete();
            DB::commit();
            return back()->with([
                'notif' => true,
                'icon' =>'success',
                'title' =>'Hapus Dokumen Berhasil',
                'message' =>'Berhasil menghapus dokumen iku baru'
            ])->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with([
                'notif' => true,
                'icon' =>'error',
                'title' =>'Hapus Dokumen Gagal',
                'message' =>'Terjadi kesalahan saat menghapus dokumen iku baru'
            ])->withInput();
        }
    }
    // laporan kinerja
    public function laporankinerja(Request $request){
        $periode = $request->query('periode');
        $user = Auth::user();
        $iku = Iku::count();
        $iki = getikiunit(Auth::user()->karyawan->unit_id);
        // $users = User::with(['karyawan.unit', 'karyawan.jabatan'])
        //     ->where('role','KARYAWAN')
        //     ->when($search, function($query, $search){
        //         return $query->where('username','LIKE', "%{$search}%")
        //             ->orWhereHas('karyawan', function($q) use ($search){
        //                 $q->where('nama_user','LIKE', "%{$search}%")
        //                     ->orWhere('nik_user','LIKE', "%{$search}%");
        //             });
        //     })->when($unit_id, function($query, $unit_id){
        //         return $query->whereHas('karyawan', function($q) use ($unit_id){
        //             $q->where('unit_id',$unit_id);
        //         });
        //     })->when($jabatan_id, function($query, $jabatan_id){
        //         return $query->whereHas('karyawan', function($q) use ($jabatan_id){
        //             $q->where('jabatan_id',$jabatan_id);
        //         });
        //     })->paginate(10);
        return view('karyawan.laporankinerja_tabel', compact(
            'periode','user','iku','iki',
        ));
    }

    // public function laporankinerjakaryawan(Request $request, $karyawan_id){
    //     $periode = $request->query('periode');
    //     $user = User::with(['karyawan.unit', 'karyawan.jabatan'])
    //         ->findOrFail($karyawan_id);
    //     $iku = getuploadiku([
    //         'karyawan_id' => $karyawan_id,
    //         'tahun' => Carbon::parse($periode)->year,
    //         'bulan' => Carbon::parse($periode)->month,
    //     ]);
    //     $iki = getuploadiki([
    //         'karyawan_id' => $karyawan_id,
    //     ]);
    //     return view('karyawan.laporankinerja_karyawan', compact(
    //         'periode','user','iku','iki',
    //     ));
    // }

    public function laporankinerjakaryawan()
    {
        $user = Auth::user();
        $tahunIni = date('Y');
        $bulanIni = date('m');

        // // if ($user->role === 'admin' || $user->role === 'validator') {
        //     // Ambil semua data bulan & tahun ini, dengan relasi ke unit
        //     $rekap = RekapKinerjaPerbulan::with('karyawan.unit')
        //                 ->where('tahun', $tahunIni)
        //                 ->where('bulan', $bulanIni)
        //                 ->get()
        //                 ->groupBy(function ($item) {
        //                     return $item->karyawan->unit->nama_unit ?? 'Tanpa Unit';
        //                 });

        // } elseif ($user->role === 'karyawan') {
            // Hanya data milik user yang sedang login
            $rekap = RekapKinerjaPerbulan::with('karyawan.unit')
                        ->where('karyawan_id', $user->karyawan_id)
                        ->where('tahun', $tahunIni)
                        ->orderBy('bulan')
                        ->get();
        // }

        return view('karyawan.laporankinerja_karyawan', compact('rekap'));
    }
}
