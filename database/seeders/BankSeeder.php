<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('bank')->insert([
            ['nama_bank' => 'BRI'],
            ['nama_bank' => 'Mandiri'],
            ['nama_bank' => 'BNI'],
            ['nama_bank' => 'BTN'],
            ['nama_bank' => 'BNI'],
            ['nama_bank' => 'Danamon'],
            ['nama_bank' => 'Permata'],
            ['nama_bank' => 'BCA'],
            ['nama_bank' => 'Bank Indonesia'],
            ['nama_bank' => 'Panin'],
            ['nama_bank' => 'CIMB Niaga'],
            ['nama_bank' => 'UOB Indonesia'],
            ['nama_bank' => 'OCBC NISP'],
            ['nama_bank' => 'Artha Graha'],
            ['nama_bank' => 'Bumi Arta'],
            ['nama_bank' => 'Ekonomi Raharja'],
            ['nama_bank' => 'Antar Daerah'],
            ['nama_bank' => 'Mutiara'],
            ['nama_bank' => 'Mayapada Inernational'],
            ['nama_bank' => 'Nusantara Parahyangan'],
            ['nama_bank' => 'India Indonesia'],
            ['nama_bank' => 'Muamalat'],
            ['nama_bank' => 'Mestika Dharma'],
            ['nama_bank' => 'Metro Express'],
            ['nama_bank' => 'Sinarmas'],
            ['nama_bank' => 'Maspion Indonesia'],
            ['nama_bank' => 'Ganesha'],
            ['nama_bank' => 'ICBC Indonesia'],
            ['nama_bank' => 'QNB Indonesia'],
            ['nama_bank' => 'Himpunan Saudara 1906'],
            ['nama_bank' => 'Mega'],
            ['nama_bank' => 'BNI Syariah'],
            ['nama_bank' => 'BUKOPIN'],
            ['nama_bank' => 'Syariah Mandiri'],
            ['nama_bank' => 'KEB Hana Indonesia'],
            ['nama_bank' => 'MNC Internasional'],
            ['nama_bank' => 'Rakyat Indonesia Agroniaga'],
            ['nama_bank' => 'SBI Indonesia'],
            ['nama_bank' => 'MEGA Syariah'],
            ['nama_bank' => 'Index Selindo'],
            ['nama_bank' => 'Mayora'],
            ['nama_bank' => 'Windu Kentjana International'],
            ['nama_bank' => 'Sumitomo Mitsui Indonesia'],
            ['nama_bank' => 'DBS Indonesia'],
        ]);
    }
}
