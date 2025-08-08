<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use MatanYadaev\EloquentSpatial\Objects\MultiPolygon;
use MatanYadaev\EloquentSpatial\Traits\HasSpatial;

class KepemilikanLahan extends Model
{
    use HasFactory, HasSpatial;


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kepemilikan_lahan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_pemilik',
        'kecamatan_id',
        'lokasi_agropolitan_id',
        'geometri',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'geometri' => MultiPolygon::class,
    ];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function lokasiAgropolitan()
    {
        return $this->belongsTo(LokasiAgropolitan::class, 'lokasi_agropolitan_id');
    }
}
