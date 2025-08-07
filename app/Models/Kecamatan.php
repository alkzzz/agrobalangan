<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use MatanYadaev\EloquentSpatial\Objects\MultiLineString;
use MatanYadaev\EloquentSpatial\Traits\HasSpatial;

class Kecamatan extends Model
{
    use HasFactory, HasSpatial;

    protected $table = 'kecamatan';

    protected $fillable = [
        'name',
        'batas_wilayah',
    ];

    protected $casts = [
        'batas_wilayah' => MultiLineString::class,
    ];
}
