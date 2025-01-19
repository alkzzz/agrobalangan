<?php

namespace App\Http\Controllers;

use App\Models\PotentialArea;
use Illuminate\Http\Request;
use DB;

class PotentialAreaController extends Controller
{

    public function index()
    {
        $data = PotentialArea::whereNotNull('geometry')
            ->orderBy('kecamatan')
            ->get();

        return view('potential_area.index', compact('data'));
    }

    public function geojson()
    {
        $data = PotentialArea::whereNotNull('geometry')
            ->orderBy('kecamatan')
            ->get()
            ->map(function ($item) {
                if ($item->geometry instanceof \MatanYadaev\EloquentSpatial\Objects\Polygon) {
                    $geometry = json_decode($item->geometry->toJson());
                } elseif ($item->geometry instanceof \MatanYadaev\EloquentSpatial\Objects\MultiPolygon) {
                    $geometry = json_decode($item->geometry->toJson());

                    // Flatten MultiPolygon to get the first polygon's first coordinate for map clicks
                    if (isset($geometry->coordinates[0][0][0])) {
                        $geometry->center = $geometry->coordinates[0][0][0];
                    }
                } else {
                    \Log::error('Unsupported geometry type found.', [
                        'id' => $item->id,
                        'type' => get_class($item->geometry),
                    ]);
                    return null;
                }

                return [
                    'type' => 'Feature',
                    'geometry' => $geometry,
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
                        'center' => $geometry->center ?? null, // Add center for easier click handling
                    ],
                ];
            })->filter();

        $geojson = [
            'type' => 'FeatureCollection',
            'features' => $data->values()->toArray(),
        ];

        return response()->json($geojson, 200, [], JSON_UNESCAPED_UNICODE);
    }


    public function show($id)
    {
        $area = PotentialArea::findOrFail($id);
        return view('potential_area.show', compact('area'));
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'desa' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kls_lereng' => 'nullable|string|max:255',
            'irigasi' => 'nullable|string|max:255',
            'luas' => 'nullable|numeric',
            'jenis_tanah' => 'nullable|string|max:255',
            'tanaman_potensial' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
            'rekomendasi' => 'nullable|string',
        ]);

        $potentialArea = PotentialArea::create($validatedData);

        return response()->json(['pesan' => 'Data berhasil ditambahkan!', 'data' => $potentialArea], 201);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'desa' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kls_lereng' => 'nullable|string|max:255',
            'irigasi' => 'nullable|string|max:255',
            'luas' => 'nullable|numeric',
            'jenis_tanah' => 'nullable|string|max:255',
            'tanaman_potensial' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
            'rekomendasi' => 'nullable|string',
        ]);

        $potentialArea = PotentialArea::findOrFail($id);
        $potentialArea->update($validatedData);

        return response()->json(['pesan' => 'Data berhasil diperbarui!', 'data' => $potentialArea], 200);
    }

    public function destroy($id)
    {
        $potentialArea = PotentialArea::findOrFail($id);
        $potentialArea->delete();

        return response()->json(['pesan' => 'Data berhasil dihapus!'], 200);
    }

    public function generate_data_from_db()
    {
        $data = DB::table('potential_area')
            ->select([
                'id',
                'objectid',
                'desa',
                'kecamatan',
                'kls_lereng',
                'irigasi',
                'shape_length',
                'shape_area',
                DB::raw('ST_AsText(geometry) AS geometry_text'),
                'luas',
                'jenis_tanah',
                'kesesuaian_lahan',
                'tanaman_potensial',
                'keterangan',
                'rekomendasi',
            ])
            ->get();

        $formattedData = $data->map(function ($item) {
            // Debug: Log each item

            // Parse geometry_text and convert to WKT
            $geometryText = $item->geometry_text;
            if ($geometryText) {
                $geometryText = preg_replace_callback(
                    '/\(([^()]+)\)/',
                    function ($matches) {
                        $coords = explode(',', $matches[1]);
                        $fixedCoords = array_map(function ($coord) {
                            $points = explode(' ', trim($coord));
                            if (count($points) === 2) {
                                list($lat, $lng) = $points; // Latitude and Longitude
                                return "{$lng} {$lat}"; // Switch to WKT format
                            }
                            return $coord; // Fallback
                        }, $coords);
                        return implode(', ', $fixedCoords);
                    },
                    $geometryText
                );
            }

            return [
                'id' => $item->id ?? 'null',
                'objectid' => $item->objectid ?? 'null',
                'desa' => $item->desa ? "'{$item->desa}'" : "''",
                'kecamatan' => $item->kecamatan ? "'{$item->kecamatan}'" : "''",
                'kls_lereng' => $item->kls_lereng ? "'{$item->kls_lereng}'" : "''",
                'irigasi' => $item->irigasi ? "'{$item->irigasi}'" : "''",
                'shape_length' => $item->shape_length ?? 'null',
                'shape_area' => $item->shape_area ?? 'null',
                'geometry' => $geometryText
                    ? "DB::raw(\"ST_GeomFromText('POLYGON(({$geometryText}))')\")"
                    : 'null',
                'luas' => $item->luas ?? 'null',
                'jenis_tanah' => "''",
                'kesesuaian_lahan' => "''",
                'tanaman_potensial' => "''",
                'keterangan' => "''",
                'rekomendasi' => "''",
            ];
        });

        $result = $formattedData->map(function ($item) {
            $formattedString = "            [\n";
            foreach ($item as $key => $value) {
                $formattedString .= "                '{$key}' => {$value},\n";
            }
            $formattedString .= "            ],";
            return $formattedString;
        });

        $finalOutput = "[\n" . implode("\n", $result->toArray()) . "\n];";

        // Save to a .txt file
        $filePath = storage_path('exports/potential_area_data.txt');
        file_put_contents($filePath, $finalOutput);

        return "Data saved to {$filePath}";
    }
}
