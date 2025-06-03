<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Unit;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
            ['nama_unit'=>'CO',],
            ['nama_unit'=>'LABORATORIUM',],
            ['nama_unit'=>'ANAK',],
            ['nama_unit'=>'BIDAN',],
            ['nama_unit'=>'SECURITY',],
            ['nama_unit'=>'CS',],
            ['nama_unit'=>'VK',],
            ['nama_unit'=>'IGD',],
        ];

        foreach ($units as $unit){
            Unit::create($unit);
        }
    }
}
