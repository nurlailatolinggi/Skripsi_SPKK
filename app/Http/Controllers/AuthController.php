<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function index(){
        return view('login');
    }
    public function login(Request $request){
        $request->validate([
            'username'=>'required',
            'password'=>'required',
        ],[
            'username.required' =>'username wajib di isi',
            'password.required'=>'password wajib di isi',
        ]);
        $userlogin = User::where('username', $request->username)->first();
        if(!$userlogin){
            return back()->with([
                'notif' => true,
                'icon' =>'error',
                'title' =>'Login Gagal',
                'message' =>'Username atau password salah'
            ])->withInput();
        }
        if(!(Hash::check($request->password, $userlogin->password))){
            return back()->with([
                'notif' => true,
                'icon' =>'error',
                'title' =>'Login Gagal',
                'message' =>'Username atau password salah'
            ])->withInput();
        }
        Auth::login($userlogin);
        switch ($userlogin->role) {
            case 'ADMIN':
                return redirect('/admin/index');
            break;
            case 'VALIDATOR':
                return redirect('/validator/index');
            break;
            case 'KARYAWAN':
                return redirect('/karyawan/index');
            break;
        }
    }
    public function logout(){
        Auth::logout();
        return redirect('/');
    }
}
