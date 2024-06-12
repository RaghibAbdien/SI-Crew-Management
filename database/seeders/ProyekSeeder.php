<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProyekSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('proyeks')->insert([
            [
                'nama_proyek' => 'Proyek A',
                'lokasi_proyek_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_proyek' => 'Proyek B',
                'lokasi_proyek_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_proyek' => 'Proyek C',
                'lokasi_proyek_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
