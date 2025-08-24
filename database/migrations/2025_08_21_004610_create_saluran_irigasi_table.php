<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('saluran_irigasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lokasi_agropolitan_id')->constrained('lokasi_agropolitan')->onDelete('cascade');
            $table->string('desa');
            $table->string('hirarki')->nullable();
            $table->string('tipe_saluran')->nullable();
            $table->string('jenis_saluran')->nullable();
            $table->string('bentuk_saluran')->nullable();
            $table->double('panjang_m')->nullable();
            $table->double('lebar_m')->nullable();
            $table->double('kedalaman_m')->nullable();
            $table->string('kondisi')->nullable();
            $table->text('masalah')->nullable();
            $table->geometry('geometri');
            $table->string('link_dokumentasi')->nullable();
            $table->timestamps();
            $table->spatialIndex('geometri');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saluran_irigasi');
    }
};
