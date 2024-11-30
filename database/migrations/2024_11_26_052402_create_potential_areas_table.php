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
        Schema::create('potential_area', function (Blueprint $table) {
            $table->id();
            $table->integer('objectid')->nullable();
            $table->string('desa')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kls_lereng')->nullable();
            $table->string('irigasi')->nullable();
            $table->float('shape_length')->nullable();
            $table->float('shape_area')->nullable();
            $table->geometry('geometry')->nullable();
            $table->float('luas')->nullable();
            $table->string('jenis_tanah')->nullable();
            $table->string('kesesuaian_lahan')->nullable();
            $table->string('tanaman_potensial')->nullable();
            $table->text('keterangan')->nullable();
            $table->text('rekomendasi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('potential_areas');
    }
};
