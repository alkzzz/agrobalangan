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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
