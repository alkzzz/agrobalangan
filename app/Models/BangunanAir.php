<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\Traits\HasSpatial;

class BangunanAir extends Model
{
    use HasFactory, HasSpatial;

    protected $table = 'bangunan_air';

    protected $fillable = [
        'lokasi_agropolitan_id',
        'desa',
        'jenis_bangunan',
        'tipe_ukur_debit',
        'lebar_m',
        'kedalaman_m',
        'kondisi',
        'jumlah_pintu',
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
