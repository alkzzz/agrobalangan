<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    protected $fillable = [
        'path',
        'original_name',
        'mime',
        'size',
        'caption',
        'collection_name',
    ];

    public function model()
    {
        return $this->morphTo();
    }

    public function getUrlAttribute(): string
    {
        return asset('dokumentasi/' . $this->path);
    }
}
