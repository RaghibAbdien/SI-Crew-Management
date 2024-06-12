<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LokasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('lokasi')->insert([
            ['nama_lokasi' => 'Surabaya'],
            ['nama_lokasi' => 'Riau'],
            ['nama_lokasi' => 'Maluku'],
            ['nama_lokasi' => 'Aceh'],
            ['nama_lokasi' => 'Bekasi'],
        ]);
    }
}
