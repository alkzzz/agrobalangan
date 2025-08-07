<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnalisisLokasi extends Model
{
    use HasFactory;

    protected $table = 'analisis_lokasi';

    protected $fillable = [
        'lokasi_agropolitan_id',
        'tekstur',
        'ph',
        'c_organik',
        'n_total',
        'p_potensial',
        'k_potensial',
        'ktk',
        'kejenuhan_basa',
        'kesesuaian_aktual',
        'faktor_pembatas',
        'kesesuaian_potensial',
    ];

    public function lokasiAgropolitan()
    {
        return $this->belongsTo(LokasiAgropolitan::class);
    }
}
