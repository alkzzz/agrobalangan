<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KepemilikanLahan;

class KepemilikanLahanController extends Controller
{
    public function geojson()
    {
        $kepemilikanLahan = KepemilikanLahan::with('kecamatan', 'lokasiAgropolitan')->get();

        $features = $kepemilikanLahan->map(function ($lahan) {
            return [
                'type' => 'Feature',
                'geometry' => $lahan->geometri, // Otomatis di-cast menjadi GeoJSON oleh paket
                'properties' => [
                    'id' => $lahan->id,
                    'nama_pemilik' => $lahan->nama_pemilik,
                    'kecamatan' => $lahan->kecamatan->name ?? 'N/A',
                    'lokasi_agropolitan' => $lahan->lokasiAgropolitan->name ?? 'N/A',
                ]
            ];
        });

        $featureCollection = [
            'type' => 'FeatureCollection',
            'features' => $features
        ];

        return response()->json($featureCollection);
    }
}
