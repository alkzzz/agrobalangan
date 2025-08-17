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
        Schema::create('kepemilikan_lahan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kecamatan_id')
                ->constrained('kecamatan')
                ->onDelete('cascade');
            $table->foreignId('lokasi_agropolitan_id')
                ->constrained('lokasi_agropolitan')
                ->onDelete('cascade');
            $table->string('nama_pemilik');
            $table->string('keterangan')->nullable();
            $table->geometry('geometri');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kepemilikan_lahans');
    }
};
