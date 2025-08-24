<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\Traits\HasSpatial;

class SaluranIrigasi extends Model
{
    use HasFactory, HasSpatial;

    protected $table = 'saluran_irigasi';

    protected $fillable = [
        'lokasi_agropolitan_id',
        'desa',
        'hirarki',
        'tipe_saluran',
        'jenis_saluran',
        'bentuk_saluran',
        'panjang_m',
        'lebar_m',
        'kedalaman_m',
        'kondisi',
        'masalah',
        'geometri',
        'link_dokumentasi',
    ];

    protected $casts = [
        'geometri' => Point::class,
    ];

    public function lokasiAgropolitan(): BelongsTo
    {
        return $this->belongsTo(LokasiAgropolitan::class, 'lokasi_agropolitan_id');
    }
}
