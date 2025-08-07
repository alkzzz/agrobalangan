<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LokasiAgropolitan;

class LokasiAgropolitanController extends Controller
{
    public function geojson()
    {
        $lokasiAgropolitan = LokasiAgropolitan::with('kecamatan')->get();

        $features = $lokasiAgropolitan->map(function ($lokasi) {
            return [
                'type' => 'Feature',
                'geometry' => $lokasi->geometri, // Otomatis di-cast menjadi GeoJSON oleh paket
                'properties' => [
                    'id' => $lokasi->id,
                    'kecamatan' => $lokasi->kecamatan->name, // Ambil nama dari relasi
                    'luas_ha' => $lokasi->luas_ha,
                    'irigasi' => $lokasi->irigasi,
                    'kls_lereng' => $lokasi->kls_lereng,
                ]
            ];
        });

        $featureCollection = [
            'type' => 'FeatureCollection',
            'features' => $features
        ];

        return response()->json($featureCollection);
    }

    public function index()
    {
        $lokasiAgropolitan = LokasiAgropolitan::with('kecamatan')->get();
        return view('lokasi_agropolitan.index', compact('lokasiAgropolitan'));
    }

    public function detail($id)
    {
        $lokasi = LokasiAgropolitan::with('kecamatan')->findOrFail($id);

        $feature = [
            'type' => 'Feature',
            // UBAH BARIS INI: Konversi objek Geometri menjadi array
            'geometry' => $lokasi->geometri->toArray(),
            'properties' => [
                'id' => $lokasi->id,
                'kecamatan' => $lokasi->kecamatan->name ?? 'N/A',
                'luas_ha' => $lokasi->luas_ha,
            ]
        ];

        $geoJsonData = [
            'type' => 'FeatureCollection',
            'features' => [$feature]
        ];

        // dd($geoJsonData); // Debugging: Tampilkan GeoJSON

        return view('lokasi_agropolitan.detail', [
            'lokasi' => $lokasi,
            'geoJsonData' => $geoJsonData
        ]);
    }
}
