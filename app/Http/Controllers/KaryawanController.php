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

class KaryawanController extends Controller
{
    protected $karyawan_id;
    public function __construct(){
        $this->karyawan_id = auth()->user()->karyawan_id;
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
        $search = $request->query('search');
        $periode = $request->query('periode');
        $ikis = Iki::where('unit_id', auth()->user()->karyawan->unit_id)
            ->when($search, function($query, $search){
                return $query->where('deskripsi_indikator','LIKE',"%{$search}%")
                    ->orWhere('indikator_keberhasilan','LIKE',"%{$search}%")
                    ->orWhere('parameter','LIKE',"%{$search}%");
            })->paginate(20);
        return view('karyawan.iki_tabel', compact('search', 'periode','ikis'));
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
        $user = auth()->user();
        $iku = Iku::count();
        $iki = getikiunit(auth()->user()->karyawan->unit_id);
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
}
