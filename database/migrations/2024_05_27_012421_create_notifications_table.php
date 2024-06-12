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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('id_crew'); 
            $table->string('title');
            $table->text('message');
            $table->enum('jenis_notif', ['kontrak', 'mcu']);
            $table->boolean('is_read')->default(false);
            $table->boolean('is_notif')->default(true);
            $table->timestamp('duration')->nullable();
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
        Schema::dropIfExists('notifications');
    }
};
