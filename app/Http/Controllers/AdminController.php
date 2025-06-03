<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\Jabatan;
use App\Models\Unit;
use App\Models\User;
use App\Models\Karyawan;
use App\Models\IndikatorIku as Iku;
use App\Models\IndikatorIki as Iki;
use App\Models\UploadIku;
use App\Models\UploadIki;


class AdminController extends Controller
{
    public function index(){
        return view('admin.dashboard');
    }
    // jabatan=======================================================================================================
    public function masterjabatan(Request $request){
        $search = $request->query('search'); //klau bagian search msh kosong dia menampilkan paginate
        $jabatans = Jabatan::when($search, function($query, $search){
            return $query->where('nama_jabatan','LIKE',"%{$search}%");
        })->paginate(20);
        return view('admin.jabatan_tabel', compact('search','jabatans'));
    }
    public function jabatancreate(){
        return view('admin.jabatan_create');
    }
    public function jabatanstore(Request $request){
        $request->validate([
            'nama_jabatan'=> 'required|string:nama_jabatan'
        ]);
        try {
            DB::beginTransaction();
            Jabatan::create([
                'nama_jabatan'=> $request->nama_jabatan
            ]);
            DB::commit();
            return redirect()->route('jabatan.list')->with([
                'notif' => true,
                'icon' =>'success',
                'title' =>'Tambah Data Berhasil',
                'message' =>'Berhasil menyimpan data jabatan baru'
            ])->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with([
                'notif' => true,
                'icon' =>'error',
                'title' =>'Tambah Data Gagal',
                'message' =>'Terjadi kesalahan saat menyimpan data jabatan baru'
            ])->withInput();
        }
    }
    public function jabatanedit($id){
        $jabatan = Jabatan::findOrFail($id);
        return view('admin.jabatan_edit', compact('jabatan')); //->mengirim data ke view
    }
    public function jabatanupdate(Request $request, $id){
        $request->validate([
            'nama_jabatan'=> 'required|string:nama_jabatan'
        ]);
        $jabatan = Jabatan::findOrFail($id);
        try {
            DB::beginTransaction();
            $jabatan->update([
                'nama_jabatan'=> $request->nama_jabatan
            ]);
            DB::commit();
            return back()->with([
                'notif' => true,
                'icon' =>'success',
                'title' =>'Edit data Berhasil',
                'message' =>'Berhasil memperbaharui data jabatan'
            ])->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with([
                'notif' => true,
                'icon' =>'error',
                'title' =>'Edit data Gagal',
                'message' =>'Terjadi kesalahan saat memperbaharui data jabatan'
            ])->withInput();
        }
    }
    public function jabatandestroy($id){
        $jabatan = Jabatan::findOrFail($id);
        try {
            DB::beginTransaction();
            $jabatan->delete();
            DB::commit();
            return back()->with([
                'notif' => true,
                'icon' =>'success',
                'title' =>'Hapus data Berhasil',
                'message' =>'Berhasil memperbaharui data jabatan'
            ])->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with([
                'notif' => true,
                'icon' =>'error',
                'title' =>'Hapus data Gagal',
                'message' =>'Terjadi kesalahan saat memperbaharui data jabatan'
            ])->withInput();
        }
    }
    // UNIT================================================================================================================
    public function masterunit(Request $request){
        $search = $request->query('search');
        $units = Unit::when($search, function($query, $search){
            return $query->where('nama_unit','LIKE',"%{$search}%");
        })->paginate(20);
        return view('admin.unit_tabel', compact('search','units'));
    }
    public function unitcreate(){
        return view('admin.unit_create'); //menampilkan form tambah unit
    }
    public function unitstore(Request $request){
        $request->validate([
            'nama_unit'=> 'required|string:nama_unit'
        ]);
        try {
            DB::beginTransaction();
            Unit::create([
                'nama_unit'=> $request->nama_unit
            ]);
            DB::commit();
            return redirect()->route('unit.list')->with([
                'notif' => true,
                'icon' =>'success',
                'title' =>'Tambah Data Berhasil',
                'message' =>'Berhasil menyimpan data unit baru'
            ])->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with([
                'notif' => true,
                'icon' =>'error',
                'title' =>'Tambah Data Gagal',
                'message' =>'Terjadi kesalahan saat menyimpan data unit baru'
            ])->withInput();
        }
    }
    public function unitedit($id){
        $unit = Unit::findOrFail($id);
        return view('admin.unit_edit', compact('unit'));
    }
    public function unitupdate(Request $request, $id){
        $request->validate([
            'nama_unit'=> 'required|string:nama_unit'
        ]);
        $unit = Unit::findOrFail($id);
        try {
            DB::beginTransaction();
            $unit->update([
                'nama_unit'=> $request->nama_unit
            ]);
            DB::commit();
            return back()->with([
                'notif' => true,
                'icon' =>'success',
                'title' =>'Edit data Berhasil',
                'message' =>'Berhasil memperbaharui data unit'
            ])->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with([
                'notif' => true,
                'icon' =>'error',
                'title' =>'Edit data Gagal',
                'message' =>'Terjadi kesalahan saat memperbaharui data unit'
            ])->withInput();
        }
    }
    public function unitdestroy($id){
        $unit = Unit::findOrFail($id);
        try {
            DB::beginTransaction();
            $unit->delete();
            DB::commit();
            return back()->with([
                'notif' => true,
                'icon' =>'success',
                'title' =>'Hapus data Berhasil',
                'message' =>'Berhasil memperbaharui data unit'
            ])->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with([
                'notif' => true,
                'icon' =>'error',
                'title' =>'Hapus data Gagal',
                'message' =>'Terjadi kesalahan saat memperbaharui data unit'
            ])->withInput();
        }
    }
    // USER===========================================================================================================================
    public function masteruser(Request $request){
        $search = $request->query('search');
        $users = User::with(['karyawan.unit', 'karyawan.jabatan'])
            ->when($search, function($query, $search){
                return $query->where('username','LIKE', "%{$search}%")
                    ->orWhereHas('karyawan', function($q) use ($search){
                        $q->where('nama_user','LIKE', "%{$search}%")
                            ->orWhere('nik_user','LIKE', "%{$search}%");
                    });
            })->paginate(50);
        return view('admin.user_tabel', compact('search','users'));
    }
    public function usercreate(){
        $units = Unit::all();
        $jabatans = Jabatan::all();
        return view('admin.user_create', compact('units','jabatans'));
    }
    public function userstore(Request $request){
        $request->validate([
            'nik_user'=> 'required|string:nik_user|max:16|min:16|unique:karyawans,nik_user',
            'nama_user'=> 'required|string:nama_user',
            'username'=> 'required|string:username|unique:users,username',
            'password'=> 'required|string:password|min:6',
            'role'=> 'required|string:role',
            'jabatan_id'=> 'required|exists:jabatans,id',
            'unit_id'=> 'required|exists:units,id',
        ]);
        try {
            DB::beginTransaction();
            $karyawan = Karyawan::create([
                'nik_user'=> $request->nik_user,
                'nama_user'=> $request->nama_user,
                'jabatan_id'=> $request->jabatan_id,
                'unit_id'=> $request->unit_id,
            ]);
            User::create([
                'username'=> $request->username,
                'password'=> Hash::make($request->password),
                'karyawan_id'=> $karyawan->id,
                'role'=> $request->role,
            ]);
            DB::commit();
            return redirect()->route('user.list')->with([
                'notif' => true,
                'icon' =>'success',
                'title' =>'Tambah Data Berhasil',
                'message' =>'Berhasil menyimpan data user baru'
            ])->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with([
                'notif' => true,
                'icon' =>'error',
                'title' =>'Tambah Data Gagal',
                'message' =>'Terjadi kesalahan saat menyimpan data user baru'
            ])->withInput();
        }
    }
    public function useredit($id){
        $user = User::findOrFail($id);
        $units = Unit::all();
        $jabatans = Jabatan::all();
        return view('admin.user_edit', compact('user','units','jabatans'));
    }
    public function userupdate(Request $request, $id){
        $user = User::findOrFail($id);
        $request->validate([
            'nik_user'=> [
                'required','string:nik_user','max:16','min:16',
                Rule::unique('karyawans','nik_user')->ignore($user->karyawan_id,'id'),
            ],
            'nama_user'=> 'required|string:nama_user',
            'username'=> [
                'required','string:username',
                Rule::unique('users','username')->ignore($id,'id')
            ],
            'password'=> 'nullable|string:password|min:6',
            'role'=> 'required|string:role',
            'jabatan_id'=> 'required|exists:jabatans,id',
            'unit_id'=> 'required|exists:units,id',
        ]);
        $newpassword = $user->password;
        if($request->password){
            $newpassword = Hash::make($request->password);
        } 
        try {
            DB::beginTransaction();
            $user->username = $request->username;
            $user->password = $newpassword;
            $user->role = $request->role;
            $user->save();
            $user->karyawan->nik_user = $request->nik_user;
            $user->karyawan->nama_user = $request->nama_user;
            $user->karyawan->jabatan_id = $request->jabatan_id;
            $user->karyawan->unit_id = $request->unit_id;
            $user->karyawan->save();
            DB::commit();
            return back()->with([
                'notif' => true,
                'icon' =>'success',
                'title' =>'Edit data Berhasil',
                'message' =>'Berhasil memperbaharui data user'
            ])->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with([
                'notif' => true,
                'icon' =>'error',
                'title' =>'Edit data Gagal',
                'message' =>'Terjadi kesalahan saat memperbaharui data user'
            ])->withInput();
        }
    }
    public function userdestroy($id){
        $user = User::findOrFail($id);
        try {
            DB::beginTransaction();
            if($user->karyawan){
                $user->karyawan->delete();
            }
            $user->delete();
            DB::commit();
            return back()->with([
                'notif' => true,
                'icon' =>'success',
                'title' =>'Hapus data Berhasil',
                'message' =>'Berhasil memperbaharui data user'
            ])->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with([
                'notif' => true,
                'icon' =>'error',
                'title' =>'Hapus data Gagal',
                'message' =>'Terjadi kesalahan saat memperbaharui data user'
            ])->withInput();
        }
    }
    // KARYAWAN====================================================================================================================
    public function masterkaryawan(Request $request){
        $search = $request->query('search');
        $periode = $request->query('periode');
        $unit_id = $request->query('unit_id');
        $jabatan_id = $request->query('jabatan_id');
        $units = Unit::all();//mengambil semua data
        $jabatans = Jabatan::all();
        $users = User::with(['karyawan.unit', 'karyawan.jabatan'])
            ->where('role','KARYAWAN')
            ->when($search, function($query, $search){
                return $query->where('username','LIKE', "%{$search}%") //mengelompokkan pencarian agar tdk bentrok
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
        return view('admin.karyawan_tabel', compact(
            'search','periode','unit_id','jabatan_id','units','jabatans','users',
        ));
    }

      public function laporankinerja(Request $request){
        $search = $request->query('search');
        $periode = $request->query('periode');
        $unit_id = $request->query('unit_id');
        $jabatan_id = $request->query('jabatan_id');
        $units = Unit::all();
        $jabatans = Jabatan::all();
        $users = User::with(['karyawan.unit', 'karyawan.jabatan'])
            ->where('role','ADMIN')
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
        return view('admin.laporankinerja_tabel', compact(
            'search','periode','unit_id','jabatan_id','units','jabatans','users',
        ));
    }
}
