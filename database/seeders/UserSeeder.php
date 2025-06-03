<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Karyawan;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // buat karyawan
        $karyawans = [
            [
                'nik_user'=> '1234567890123456',
                'nama_user'=> 'admin',
                'jabatan_id'=> 1,
                'unit_id'=> 1,
            ],
            [
                'nik_user'=> '1234567890123455',
                'nama_user'=> 'validator',
                'jabatan_id'=> 2,
                'unit_id'=> 1,
            ],
            [
                'nik_user'=> '1234567890123454',
                'nama_user'=> 'karyawan',
                'jabatan_id'=> 3,
                'unit_id'=> 1,
            ],
        ];
        foreach($karyawans as $karyawan){
            Karyawan::create($karyawan);
        }
        $roles = ['ADMIN', 'VALIDATOR', 'KARYAWAN'];
        // buat user berdasarkan karyawan
        foreach(Karyawan::all() as $key=>$val){
            User::create([
                'username'=> strtolower($val->nama_user),
                'password'=> Hash::make('123456'),
                'role'=> $roles[$key % count($roles)],
                'karyawan_id'=> $val->id
            ]);
        }
    }
}
