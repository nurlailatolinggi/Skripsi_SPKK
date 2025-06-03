<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Unit;
use App\Models\Jabatan;
use App\Models\IndikatorIku as Iku;
use App\Models\IndikatorIki as Iki;
use App\Models\UploadIku;
use App\Models\UploadIki;

class ValidatorController extends Controller
{
    public function index(){
        return view('validator.dashboard');
    }
    // iku
    public function masteriku(Request $request){
        $search = $request->query('search');
        $ikus = Iku::when($search, function($query, $search){
            return $query->where('deskripsi_indikator','LIKE',"%{$search}%")
                ->orWhere('indikator_keberhasilan','LIKE',"%{$search}%")
                ->orWhere('parameter','LIKE',"%{$search}%");
        })->paginate(20);
        return view('validator.iku_tabel', compact('search','ikus'));
    }
    public function ikucreate(){
        return view('validator.iku_create');
    }
    public function ikustore(Request $request){
        $request->validate([
            'deskripsi_indikator'=> 'required|string:deskripsi_indikator',
            'indikator_keberhasilan'=> 'required|string:indikator_keberhasilan',
            'parameter'=> 'required|string:parameter',
            'frekuensi_indikator'=> 'required|in:BULANAN,TAHUNAN',
        ]);
        try {
            DB::beginTransaction();
            Iku::create([
                'deskripsi_indikator'=> $request->deskripsi_indikator,
                'indikator_keberhasilan'=> $request->indikator_keberhasilan,
                'parameter'=> $request->parameter,
                'frekuensi_indikator'=> $request->frekuensi_indikator,
            ]);
            DB::commit();
            return redirect()->route('iku.list')->with([
                'notif' => true,
                'icon' =>'success',
                'title' =>'Tambah Data Berhasil',
                'message' =>'Berhasil menyimpan data iku baru'
            ])->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with([
                'notif' => true,
                'icon' =>'error',
                'title' =>'Tambah Data Gagal',
                'message' =>'Terjadi kesalahan saat menyimpan data iku baru'
            ])->withInput();
        }
    }
    public function ikuedit($id){
        $iku = Iku::findOrFail($id);
        return view('validator.iku_edit', compact('iku'));
    }
    public function ikuupdate(Request $request, $id){
        $request->validate([
            'deskripsi_indikator'=> 'required|string:deskripsi_indikator',
            'indikator_keberhasilan'=> 'required|string:indikator_keberhasilan',
            'parameter'=> 'required|string:parameter',
            'frekuensi_indikator'=> 'required|in:BULANAN,TAHUNAN',
        ]);
        $iku = Iku::findOrFail($id);
        try {
            DB::beginTransaction();
            $iku->update([
                'deskripsi_indikator'=> $request->deskripsi_indikator,
                'indikator_keberhasilan'=> $request->indikator_keberhasilan,
                'parameter'=> $request->parameter,
                'frekuensi_indikator'=> $request->frekuensi_indikator,
            ]);
            DB::commit();
            return back()->with([
                'notif' => true,
                'icon' =>'success',
                'title' =>'Edit data Berhasil',
                'message' =>'Berhasil memperbaharui data iku'
            ])->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with([
                'notif' => true,
                'icon' =>'error',
                'title' =>'Edit data Gagal',
                'message' =>'Terjadi kesalahan saat memperbaharui data iku'
            ])->withInput();
        }
    }
    public function ikudestroy($id){
        $iku = Iku::findOrFail($id);
        try {
            DB::beginTransaction();
            $iku->delete();
            DB::commit();
            return back()->with([
                'notif' => true,
                'icon' =>'success',
                'title' =>'Hapus data Berhasil',
                'message' =>'Berhasil memperbaharui data iku'
            ])->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with([
                'notif' => true,
                'icon' =>'error',
                'title' =>'Hapus data Gagal',
                'message' =>'Terjadi kesalahan saat memperbaharui data iku'
            ])->withInput();
        }
    }
    // IKI================================================================================================================
    public function masteriki(Request $request){
        $search = $request->query('search');
        $ikis = Iki::with(['unit'])->when($search, function($query, $search){
        $ikis = Iki::where('unit_id', auth()->user()->karyawan->unit_id);
            return $query->where('deskripsi_indikator','LIKE',"%{$search}%")
                ->orWhere('indikator_keberhasilan','LIKE',"%{$search}%")
                ->orWhere('parameter','LIKE',"%{$search}%");
        })->paginate(20);
        return view('validator.iki_tabel', compact('search','ikis'));
    } 
    public function ikicreate(){
        $units = Unit::all();
        return view('validator.iki_create', compact('units'));
    }
    public function ikistore(Request $request){
        $request->validate([
            'deskripsi_indikator'=> 'required|string:deskripsi_indikator',
            'indikator_keberhasilan'=> 'required|string:indikator_keberhasilan',
            'parameter'=> 'required|string:parameter',
            'unit_id'=> 'required|exists:units,id',
        ]);
        try {
            DB::beginTransaction();
            Iki::create([
                'deskripsi_indikator'=> $request->deskripsi_indikator,
                'indikator_keberhasilan'=> $request->indikator_keberhasilan,
                'parameter'=> $request->parameter,
                'unit_id'=> $request->unit_id,
            ]);
            DB::commit();
            return redirect()->route('iki.list')->with([
                'notif' => true,
                'icon' =>'success',
                'title' =>'Tambah Data Berhasil',
                'message' =>'Berhasil menyimpan data iki baru'
            ])->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with([
                'notif' => true,
                'icon' =>'error',
                'title' =>'Tambah Data Gagal',
                'message' =>'Terjadi kesalahan saat menyimpan data iki baru'
            ])->withInput();
        }
    }
    public function ikiedit($id){
        $iki = Iki::findOrFail($id);
        $units = Unit::all();
        return view('validator.iki_edit', compact('iki','units'));
    }
    public function ikiupdate(Request $request, $id){
        $request->validate([
            'deskripsi_indikator'=> 'required|string:deskripsi_indikator',
            'indikator_keberhasilan'=> 'required|string:indikator_keberhasilan',
            'parameter'=> 'required|string:parameter',
            'unit_id'=> 'required|exists:units,id',
        ]);
        $iki = Iki::findOrFail($id);
        try {
            DB::beginTransaction();
            $iki->update([
                'deskripsi_indikator'=> $request->deskripsi_indikator,
                'indikator_keberhasilan'=> $request->indikator_keberhasilan,
                'parameter'=> $request->parameter,
                'unit_id'=> $request->unit_id,
            ]);
            DB::commit();
            return back()->with([
                'notif' => true,
                'icon' =>'success',
                'title' =>'Edit data Berhasil',
                'message' =>'Berhasil memperbaharui data iki'
            ])->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with([
                'notif' => true,
                'icon' =>'error',
                'title' =>'Edit data Gagal',
                'message' =>'Terjadi kesalahan saat memperbaharui data iki'
            ])->withInput();
        }
    }
    public function ikidestroy($id){
        $iki = Iki::findOrFail($id);
        try {
            DB::beginTransaction();
            $iki->delete();
            DB::commit();
            return back()->with([
                'notif' => true,
                'icon' =>'success',
                'title' =>'Hapus data Berhasil',
                'message' =>'Berhasil memperbaharui data iki'
            ])->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with([
                'notif' => true,
                'icon' =>'error',
                'title' =>'Hapus data Gagal',
                'message' =>'Terjadi kesalahan saat memperbaharui data iki'
            ])->withInput();
        }
    }
    // validasi iku list==================================================================================
    public function validasiiku(Request $request){
        $search = $request->query('search');
        $periode = $request->query('periode');
        $unit_id = $request->query('unit_id');
        $jabatan_id = $request->query('jabatan_id');
        $units = Unit::all();
        $jabatans = Jabatan::all();
        $ikus = Iku::all();
        $users = User::with(['karyawan.unit', 'karyawan.jabatan'])
            ->where('role','KARYAWAN')
            ->when($search, function($query, $search){
                return $query->where('username','LIKE', "%{$search}%")
                    ->orWhereHas('karyawan', function($q) use ($search){
                        $q->where('nama_user','LIKE', "%{$search}%")
                            ->orWhere('nik_user','LIKE', "%{$search}%");
                    });
            })->when($unit_id, function($query, $unit_id){
                return $query->whereHas('karyawan', function($q) use ($unit_id){
                    $q->where('unit_id',$unit_id);
                });
            })->when($jabatan_id, function($query, $jabatan_id){
                return $query->whereHas('karyawan', function($q) use ($jabatan_id){
                    $q->where('jabatan_id',$jabatan_id);
                });
            })->paginate(10);
        return view('validator.validasiiku', compact(
            'search','periode','unit_id','jabatan_id','units','jabatans','ikus','users',
        ));
    }
    public function validasiikukaryawan($id, $periode){
        $periode = $periode;
        $ikus = Iku::all();
        $user = User::with(['karyawan.unit','karyawan.jabatan'])
            ->where('karyawan_id',$id)
            ->firstOrFail();
        return view('validator.validasiikukaryawan', compact('user', 'periode','ikus'));
    }
    public function validasiikuupdate(Request $request){
        $request->validate([
            'id'=> 'required',
            'status'=> 'required',
        ]);
        // dd($request);
        $upload = UploadIku::findOrFail($request->id);
        try {
            DB::beginTransaction();
            $upload->update([
                'status'=> $request->status,
            ]);
            DB::commit();
            return back()->with([
                'notif' => true,
                'icon' =>'success',
                'title' =>'Validasi Dokumen Berhasil',
                'message' =>'Berhasil melakukan validasi data iku'
            ])->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with([
                'notif' => true,
                'icon' =>'error',
                'title' =>'Validasi Dokumen Gagal',
                'message' =>'Terjadi kesalahan saat melakukan validasi data iku'
            ])->withInput();
        }
    }
    // validasi iki list==================================================
    public function validasiiki(Request $request){
        $search = $request->query('search');
        $periode = $request->query('periode');
        $unit_id = $request->query('unit_id');
        $jabatan_id = $request->query('jabatan_id');
        $units = Unit::all();
        $jabatans = Jabatan::all();
        $ikis = Iki::all();
        $users = User::with(['karyawan.unit', 'karyawan.jabatan'])
            ->where('role','KARYAWAN')
            ->when($search, function($query, $search){
                return $query->where('username','LIKE', "%{$search}%")
                    ->orWhereHas('karyawan', function($q) use ($search){
                        $q->where('nama_user','LIKE', "%{$search}%")
                            ->orWhere('nik_user','LIKE', "%{$search}%");
                    });
            })->when($unit_id, function($query, $unit_id){
                return $query->whereHas('karyawan', function($q) use ($unit_id){
                    $q->where('unit_id',$unit_id);
                });
            })->when($jabatan_id, function($query, $jabatan_id){
                return $query->whereHas('karyawan', function($q) use ($jabatan_id){
                    $q->where('jabatan_id',$jabatan_id);
                });
            })->paginate(10);
        return view('validator.validasiiki', compact(
            'search','periode','unit_id','jabatan_id','units','jabatans','users',
        ));
    }
    public function validasiikikaryawan($id){
        $ikis = Iki::all();
        $user = User::with(['karyawan.unit','karyawan.jabatan'])
            ->where('karyawan_id',$id)
            ->firstOrFail();
        $ikis = Iki::where('unit_id',$user->karyawan->unit_id)->get();
        return view('validator.validasiikikaryawan', compact('user',  'ikis'));
    }
    public function validasiikiupdate(Request $request){
        $request->validate([
            'id'=> 'required',
            'status'=> 'required',
        ]);
        // dd($request);
        $upload = UploadIki::findOrFail($request->id);
        try {
            DB::beginTransaction();
            $upload->update([
                'status'=> $request->status,
            ]);
            DB::commit();
            return back()->with([
                'notif' => true,
                'icon' =>'success',
                'title' =>'Validasi Dokumen Berhasil',
                'message' =>'Berhasil melakukan validasi data iki'
            ])->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with([
                'notif' => true,
                'icon' =>'error',
                'title' =>'Validasi Dokumen Gagal',
                'message' =>'Terjadi kesalahan saat melakukan validasi data iki'
            ])->withInput();
        }
    }
    // laporan kinerja
    public function laporankinerja(Request $request){
        $search = $request->query('search');
        $periode = $request->query('periode');
        $unit_id = $request->query('unit_id');
        $jabatan_id = $request->query('jabatan_id');
        $units = Unit::all();
        $jabatans = Jabatan::all();
        $users = User::with(['karyawan.unit', 'karyawan.jabatan'])
            ->where('role','KARYAWAN')
            ->when($search, function($query, $search){
                return $query->where('username','LIKE', "%{$search}%")
                    ->orWhereHas('karyawan', function($q) use ($search){
                        $q->where('nama_user','LIKE', "%{$search}%")
                            ->orWhere('nik_user','LIKE', "%{$search}%");
                    });
            })->when($unit_id, function($query, $unit_id){
                return $query->whereHas('karyawan', function($q) use ($unit_id){
                    $q->where('unit_id',$unit_id);
                });
            })->when($jabatan_id, function($query, $jabatan_id){
                return $query->whereHas('karyawan', function($q) use ($jabatan_id){
                    $q->where('jabatan_id',$jabatan_id);
                });
            })->paginate(10);
        return view('validator.laporankinerja_tabel', compact(
            'search','periode','unit_id','jabatan_id','units','jabatans','users',
        ));
    }
}
