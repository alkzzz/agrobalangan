<?php

namespace App\Http\Controllers;

use App\Models\PotentialArea;

class PotentialAreaController extends Controller
{
    public function index()
    {
        $data = PotentialArea::where('id', '!=', 17)->get();
        return $data;
        // return view('potential_area.index', compact('data'));
    }

    public function geojson()
    {
        $data = PotentialArea::where('id', '!=', 17)
            ->whereNotNull('geometry')
            ->orderBy('kecamatan')
            ->get()
            ->map(function ($item) {
                if (!$item->geometry instanceof \MatanYadaev\EloquentSpatial\Objects\Polygon) {
                    return null;
                }

                return [
                    'type' => 'Feature',
                    'geometry' => json_decode($item->geometry->toJson()),
                    'properties' => [
                        'objectid' => $item->objectid,
                        'desa' => $item->desa,
                        'kecamatan' => $item->kecamatan,
                        'kls_lereng' => $item->kls_lereng,
                        'irigasi' => $item->irigasi,
                        'shape_length' => $item->shape_length,
                        'shape_area' => $item->shape_area,
                        'luas' => $item->luas,
                        'jenis_tanah' => $item->jenis_tanah,
                        'kesesuaian_lahan' => $item->kesesuaian_lahan,
                        'tanaman_potensial' => $item->tanaman_potensial,
                        'keterangan' => $item->keterangan,
                        'rekomendasi' => $item->rekomendasi,
                    ],
                ];
            })->filter();

        $geojson = [
            'type' => 'FeatureCollection',
            'features' => $data->toArray(),
        ];

        return response()->json($geojson, 200, [], JSON_UNESCAPED_UNICODE);
    }
}
