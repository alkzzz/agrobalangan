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

    public function analisisTanah()
    {
        return $this->hasOne(AnalisisTanah::class);
    }

    public function kepemilikanLahan()
    {
        return $this->hasMany(KepemilikanLahan::class, 'lokasi_agropolitan_id');
    }

    public function saluranIrigasi()
    {
        return $this->hasMany(SaluranIrigasi::class, 'lokasi_agropolitan_id');
    }

    public function media()
    {
        return $this->morphMany(\App\Models\Media::class, 'model');
    }

    public function kepemilikanMedia()
    {
        return $this->media();
    }
}
