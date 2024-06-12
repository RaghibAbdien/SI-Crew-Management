<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dokumens', function (Blueprint $table) {
            $table->id();
            $table->string('id_crew')->unique();
            $table->string('cv_path');
            $table->string('ktp_path');
            $table->json('vaksin_path');
            $table->string('pkwt_path');
            $table->json('sertifikat_path');
            $table->string('ijazah_path');
            $table->string('fotocrew_path');
            $table->string('npwp_path');
            $table->string('skck_path');
            $table->json('mcu_path');
            $table->date('tgl_mcu');
            $table->date('expired_mcu');
            $table->date('warn_mcu');
            $table->date('awal_kontrak');
            $table->date('berakhir_kontrak');
            $table->date('warn_kontrak');
            $table->boolean('is_notif_kontrak')->default(false);
            $table->boolean('is_notif_mcu')->default(false); 
            $table->timestamps();

            // Menambahkan foreign key constraint
            $table->foreign('id_crew')->references('id_crew')->on('crews')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Dokumen');
    }
};
