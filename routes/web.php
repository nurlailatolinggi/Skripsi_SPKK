<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ValidatorController;
use App\Http\Controllers\KaryawanController;
use App\Http\Middleware\RoleMiddleWare;


Route::middleware(['guest'])->group(function(){
    Route::get('/', [AuthController::class, 'index'])->name('login');
    Route::post('/', [AuthController::class, 'login'])->name('loginact');
});

    Route::middleware(['auth'])->group(function(){
    //ADMIN =================================================================
    Route::get('/admin/index',[AdminController::class, 'index'])
        ->middleware(RoleMiddleWare::class . ":ADMIN")
        ->name('admin.index');
    // USER VIEW
    Route::get('/admin/user', [AdminController::class, 'masteruser'])
        ->middleware(RoleMiddleWare::class.":ADMIN")
        ->name('user.list');
    Route::get('/admin/usercreate', [AdminController::class, 'usercreate'])
        ->middleware(RoleMiddleWare::class.":ADMIN")
        ->name('user.create');
    Route::get('/admin/useredit/{id}', [AdminController::class, 'useredit'])
        ->middleware(RoleMiddleWare::class.":ADMIN")
        ->name('user.edit');
    // SER ACTION
    Route::post('/admin/userstore', [AdminController::class, 'userstore'])
        ->middleware(RoleMiddleWare::class.":ADMIN")
        ->name('user.store');
    Route::put('/admin/userupdate/{id}', [AdminController::class, 'userupdate'])
        ->middleware(RoleMiddleWare::class.":ADMIN")
        ->name('user.update');
    Route::delete('/admin/user/{id}', [AdminController::class, 'userdestroy'])
        ->middleware(RoleMiddleWare::class.":ADMIN")
        ->name('user.destroy');
    // JABATAN VIEW
    Route::get('/admin/jabatan', [AdminController::class, 'masterjabatan'])
        ->middleware(RoleMiddleWare::class.":ADMIN")
        ->name('jabatan.list');
    Route::get('/admin/jabatancreate', [AdminController::class, 'jabatancreate'])
        ->middleware(RoleMiddleWare::class.":ADMIN")
        ->name('jabatan.create');
    Route::get('/admin/jabatanedit/{id}', [AdminController::class, 'jabatanedit'])
        ->middleware(RoleMiddleWare::class.":ADMIN")
        ->name('jabatan.edit');
    //JABATAN ACTION
    Route::post('/admin/jabatanstore', [AdminController::class, 'jabatanstore'])
        ->middleware(RoleMiddleWare::class.":ADMIN")
        ->name('jabatan.store');
    Route::put('/admin/jabatanupdate/{id}', [AdminController::class, 'jabatanupdate'])
        ->middleware(RoleMiddleWare::class.":ADMIN")
        ->name('jabatan.update');
    Route::delete('/admin/jabatan/{id}', [AdminController::class, 'jabatandestroy'])
        ->middleware(RoleMiddleWare::class.":ADMIN")
        ->name('jabatan.destroy');
    //UNIT VIEW
    Route::get('/admin/unit', [AdminController::class, 'masterunit'])
        ->middleware(RoleMiddleWare::class.":ADMIN")
        ->name('unit.list');
    Route::get('/admin/unitcreate', [AdminController::class, 'unitcreate'])
        ->middleware(RoleMiddleWare::class.":ADMIN")
        ->name('unit.create');
    Route::get('/admin/unitedit/{id}', [AdminController::class, 'unitedit'])
        ->middleware(RoleMiddleWare::class.":ADMIN")
        ->name('unit.edit');
    //UNIT ACTION
    Route::post('/admin/unitstore', [AdminController::class, 'unitstore'])
        ->middleware(RoleMiddleWare::class.":ADMIN")
        ->name('unit.store');
    Route::put('/admin/unitupdate/{id}', [AdminController::class, 'unitupdate'])
        ->middleware(RoleMiddleWare::class.":ADMIN")
        ->name('unit.update');
    Route::delete('/admin/unit/{id}', [AdminController::class, 'unitdestroy'])
        ->middleware(RoleMiddleWare::class.":ADMIN")
        ->name('unit.destroy');
    //KARYAWAN VIEW
    Route::get('/admin/karyawan', [AdminController::class, 'masterkaryawan'])
    ->middleware(RoleMiddleWare::class.":ADMIN")
    ->name('karyawan.list');
    //LAPORAN KINERJA
    Route::get('/admin/laporankinerja', [AdminController::class, 'laporankinerja'])
    ->middleware(RoleMiddleWare::class.":ADMIN")
    ->name('admin.laporankinerja');

    //LAPORAN KINERJA ADMIN
    Route::get('/admin/laporankinerjadmin', [AdminController::class, 'laporankinerjaadmin'])
    ->middleware(RoleMiddleWare::class.":ADMIN")
    ->name('admin.laporankinerjaadmin');
  
    
    
    // VALIDATOR=================================================================================
    Route::get('/validator/index',[ValidatorController::class, 'index'])
        ->middleware(RoleMiddleWare::class . ":VALIDATOR")
        ->name('validator.index');
    // IKU VIEW
    Route::get('/validator/iku', [ValidatorController::class, 'masteriku'])
        ->middleware(RoleMiddleWare::class.":VALIDATOR")
        ->name('iku.list');
    Route::get('/validator/ikucreate', [ValidatorController::class, 'ikucreate'])
        ->middleware(RoleMiddleWare::class.":VALIDATOR")
        ->name('iku.create');
    Route::get('/validator/ikuedit/{id}', [ValidatorController::class, 'ikuedit'])
        ->middleware(RoleMiddleWare::class.":VALIDATOR")
        ->name('iku.edit');
    //IKU ACTION
    Route::post('/validator/ikustore', [ValidatorController::class, 'ikustore'])
        ->middleware(RoleMiddleWare::class.":VALIDATOR")
        ->name('iku.store');
    Route::put('/validator/ikuupdate/{id}', [ValidatorController::class, 'ikuupdate'])
        ->middleware(RoleMiddleWare::class.":VALIDATOR")
        ->name('iku.update');
    Route::delete('/validator/iku/{id}', [ValidatorController::class, 'ikudestroy'])
        ->middleware(RoleMiddleWare::class.":VALIDATOR")
        ->name('iku.destroy');
    //IKI VIEW
    Route::get('/validator/iki', [ValidatorController::class, 'masteriki'])
        ->middleware(RoleMiddleWare::class.":VALIDATOR")
        ->name('iki.list');
    Route::get('/validator/ikicreate', [ValidatorController::class, 'ikicreate'])
        ->middleware(RoleMiddleWare::class.":VALIDATOR")
        ->name('iki.create');
    Route::get('/validator/ikiedit/{id}', [ValidatorController::class, 'ikiedit'])
        ->middleware(RoleMiddleWare::class.":VALIDATOR")
        ->name('iki.edit');
    //IKI ACTION
    Route::post('/validator/ikistore', [ValidatorController::class, 'ikistore'])
        ->middleware(RoleMiddleWare::class.":VALIDATOR")
        ->name('iki.store');
    Route::put('/validator/ikiupdate/{id}', [ValidatorController::class, 'ikiupdate'])
        ->middleware(RoleMiddleWare::class.":VALIDATOR")
        ->name('iki.update');
    Route::delete('/validator/iki/{id}', [ValidatorController::class, 'ikidestroy'])
        ->middleware(RoleMiddleWare::class.":VALIDATOR")
        ->name('iki.destroy');
    //VALIDASI IKU VIEW
    Route::get('/validator/validasiiku', [ValidatorController::class, 'validasiiku'])
        ->middleware(RoleMiddleWare::class.":VALIDATOR")
        ->name('validasiiku.list');
    Route::get('/validator/validasiikukaryawan/{id}/{periode}', [ValidatorController::class, 'validasiikukaryawan'])
        ->middleware(RoleMiddleWare::class.":VALIDATOR")
        ->name('validasiikukaryawan.list');
    //VALIDASI IKU ACTION
    Route::put('/validator/validasiikuupdate', [ValidatorController::class, 'validasiikuupdate'])
        ->middleware(RoleMiddleWare::class.":VALIDATOR")
        ->name('validasiiku.update');
    //VALIDASI IKI VIEW
    Route::get('/validator/validasiiki', [ValidatorController::class, 'validasiiki'])
        ->middleware(RoleMiddleWare::class.":VALIDATOR")
        ->name('validasiiki.list');
    Route::get('/validator/validasiikikaryawan/{id}', [ValidatorController::class, 'validasiikikaryawan'])
        ->middleware(RoleMiddleWare::class.":VALIDATOR")
        ->name('validasiikikaryawan.list');
    //VALIDASI IKI ACTION
    Route::put('/validator/validasiikiupdate', [ValidatorController::class, 'validasiikiupdate'])
        ->middleware(RoleMiddleWare::class.":VALIDATOR")
        ->name('validasiiki.update');
    //LAPORAN KINERJA
    Route::get('/validator/laporankinerja', [ValidatorController::class, 'laporankinerja'])
        ->middleware(RoleMiddleWare::class.":VALIDATOR")
        ->name('validator.laporankinerja');

    //LAPORAN KINERJA VALIDATOR
    Route::get('/validator/laporankinerjavalidator', [ValidatorController::class, 'laporankinerjavalidator'])
        ->middleware(RoleMiddleWare::class.":VALIDATOR")
        ->name('validator.laporankinerjavalidator');
    
    Route::get('/validator/laporan-kinerja/pdf', [ValidatorController::class, 'exportPdf'])->name('laporan.kinerja.pdf');
        
    // KARYAWAN ==================================================================================
    Route::get('/karyawan/index',[KaryawanController::class, 'index'])
        ->middleware(RoleMiddleWare::class . ":KARYAWAN")
        ->name('karyawan.index');
    //UPLOAD IKU VIEW
    Route::get('/karyawan/uploadiku', [KaryawanController::class, 'uploadiku'])
        ->middleware(RoleMiddleWare::class.":KARYAWAN")
        ->name('uploadiku.list');
    //UPLOAD IKU ACTION
    Route::post('/karyawan/uploadikustore', [KaryawanController::class, 'uploadikustore'])
        ->middleware(RoleMiddleWare::class.":KARYAWAN")
        ->name('uploadiku.store');
    Route::delete('/karyawan/uploadiku/{id}', [KaryawanController::class, 'uploadikudestroy'])
        ->middleware(RoleMiddleWare::class.":KARYAWAN")
        ->name('uploadiku.destroy');
    //UPLOAD IKI VIEW
    Route::get('/karyawan/uploadiki', [KaryawanController::class, 'uploadiki'])
        ->middleware(RoleMiddleWare::class.":KARYAWAN")
        ->name('uploadiki.list');
    //UPLOAD IKI ACTION
    Route::post('/karyawan/uploadikistore', [KaryawanController::class, 'uploadikistore'])
        ->middleware(RoleMiddleWare::class.":KARYAWAN")
        ->name('uploadiki.store');
    Route::delete('/karyawan/uploadiki/{id}', [KaryawanController::class, 'uploadikidestroy'])
        ->middleware(RoleMiddleWare::class.":KARYAWAN")
        ->name('uploadiki.destroy');
    //LAPORAN KINERJA
    Route::get('/karyawan/laporankinerja', [KaryawanController::class, 'laporankinerja'])
    ->middleware(RoleMiddleWare::class.":KARYAWAN")
    ->name('karyawan.laporankinerja');

    // LAPORAN KINERJA KARYAWAB
    Route::get('/karyawan/laporankinerjakaryawan', [KaryawanController::class, 'laporankinerjakaryawan'])
    ->middleware(RoleMiddleWare::class.":KARYAWAN")
    ->name('karyawan.laporankinerjakaryawan');
    
    // logout =================================================================
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
