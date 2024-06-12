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
        Schema::create('crews', function (Blueprint $table) {
            $table->id();
            $table->string('id_crew')->unique();
            $table->string('nama_crew');
            $table->text('alamat_crew');
            $table->string('email_crew')->unique();
            $table->string('nohp_crew')->unique();
            $table->unsignedBigInteger('lokasi_crew_id');
            $table->unsignedBigInteger('proyek_crew_id');
            $table->unsignedBigInteger('id_bank');
            $table->string('no_rekening')->unique();
            $table->boolean('status_crew')->default(true);
            $table->timestamps();

            
            $table->foreign('lokasi_crew_id')->references('id')->on('lokasi');
            $table->foreign('id_bank')->references('id')->on('bank');
            $table->foreign('proyek_crew_id')->references('id')->on('proyeks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crews');
    }
};
