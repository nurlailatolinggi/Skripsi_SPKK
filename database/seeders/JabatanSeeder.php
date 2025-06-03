<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jabatan;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $jabatans = [
            ['nama_jabatan'=>'DIREKTUR',],
            ['nama_jabatan'=>'KEPALA UNIT',],
            ['nama_jabatan'=>'STAFF UNIT',],
        ];

        foreach ($jabatans as $jabatan){
            Jabatan::create($jabatan);
        }
    }
}
