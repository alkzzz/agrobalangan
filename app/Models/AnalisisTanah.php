<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnalisisTanah extends Model
{
    use HasFactory;

    protected $table = 'analisis_tanah';

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

    public function media()
    {
        return $this->morphMany(Media::class, 'model')->orderBy('caption');
    }
}
