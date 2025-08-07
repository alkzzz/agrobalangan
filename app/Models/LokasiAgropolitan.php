<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use MatanYadaev\EloquentSpatial\Objects\MultiPolygon;
use MatanYadaev\EloquentSpatial\Traits\HasSpatial;

class LokasiAgropolitan extends Model
{
    use HasFactory, HasSpatial;

    protected $table = 'lokasi_agropolitan';

    protected $fillable = [
        'kecamatan_id',
        'irigasi',
        'kls_lereng',
        'luas_ha',
        'geometri',
    ];

    protected $casts = [
        'geometri' => MultiPolygon::class,
    ];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function analisis()
    {
        return $this->hasOne(AnalisisLokasi::class);
    }
}
