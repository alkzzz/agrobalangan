<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lokasi_agropolitan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kecamatan_id')->constrained('kecamatan')->onDelete('cascade');
            $table->string('irigasi')->nullable();
            $table->string('kls_lereng')->nullable();
            $table->double('luas_ha');
            $table->geometry('geometri');

            $table->timestamps();
            $table->spatialIndex('geometri');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lokasi_agropolitan');
    }
};
