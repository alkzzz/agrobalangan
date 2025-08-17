<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('analisis_tanah', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lokasi_agropolitan_id')->constrained('lokasi_agropolitan')->onDelete('cascade');
            $table->string('tekstur', 100)->nullable();
            $table->double('ph')->nullable();
            $table->double('c_organik')->nullable();
            $table->double('n_total')->nullable();
            $table->double('p_potensial')->nullable();
            $table->double('k_potensial')->nullable();
            $table->double('ktk')->nullable();
            $table->double('kejenuhan_basa')->nullable();
            $table->string('kesesuaian_aktual', 100)->nullable();
            $table->text('faktor_pembatas')->nullable();
            $table->string('kesesuaian_potensial', 100)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('analisis_tanah');
    }
};
