<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use MatanYadaev\EloquentSpatial\Traits\HasSpatial;
use MatanYadaev\EloquentSpatial\Objects\Geometry;

class PotentialArea extends Model
{
    use HasSpatial;

    protected $table = 'potential_area';

    protected $fillable = [
        'objectid',
        'desa',
        'kecamatan',
        'kls_lereng',
        'irigasi',
        'shape_length',
        'shape_area',
        'geometry',
        'luas',
        'jenis_tanah',
        'kesesuaian_lahan',
        'tanaman_potensial',
        'keterangan',
        'rekomendasi'
    ];

    protected $casts = [
        'geometry' => Geometry::class,
    ];
}
