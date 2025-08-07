<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use App\Models\LokasiAgropolitan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\Objects\LineString;
use MatanYadaev\EloquentSpatial\Objects\MultiPolygon;
use MatanYadaev\EloquentSpatial\Objects\Polygon;

class LokasiAgropolitanSeeder extends Seeder
{
    public function run(): void
    {
        LokasiAgropolitan::query()->delete();
        $jsonPath = public_path('geojson/Agro_balangan_kec.geojson');

        if (!File::exists($jsonPath)) {
            $this->command->error("File GeoJSON tidak ditemukan di: " . $jsonPath);
            return;
        }

        $data = json_decode(File::get($jsonPath));

        foreach ($data->features as $feature) {
            $properties = $feature->properties;
            $geometryData = $feature->geometry;
            $kecamatan = Kecamatan::where('name', trim($properties->Kecamatan))->first();

            if ($kecamatan) {
                $polygons = [];
                $allPolygonCoordinates = [];

                if ($geometryData->type === 'MultiPolygon') {
                    $allPolygonCoordinates = $geometryData->coordinates;
                } elseif ($geometryData->type === 'Polygon') {
                    $allPolygonCoordinates = [$geometryData->coordinates];
                }

                if (empty($allPolygonCoordinates)) {
                    $this->command->warn('Tidak ada koordinat untuk Kecamatan ' . trim($properties->Kecamatan));
                    continue;
                }

                foreach ($allPolygonCoordinates as $polygonCoordinates) {
                    $lineStrings = [];
                    foreach ($polygonCoordinates as $ring) {
                        $points = array_map(function ($coordinate) {
                            if (is_array($coordinate)) {
                                return new Point($coordinate[1], $coordinate[0]);
                            }
                            return null;
                        }, $ring);

                        $points = array_filter($points);

                        if (!empty($points)) {
                            $lineStrings[] = new LineString($points);
                        }
                    }
                    if (!empty($lineStrings)) {
                        $polygons[] = new Polygon($lineStrings);
                    }
                }

                if (empty($polygons)) {
                    $this->command->warn('Gagal membuat poligon untuk Kecamatan ' . trim($properties->Kecamatan));
                    continue;
                }

                $multiPolygon = new MultiPolygon($polygons);

                LokasiAgropolitan::create([
                    'kecamatan_id' => $kecamatan->id,
                    'irigasi'      => $properties->Irigasi,
                    'kls_lereng'   => $properties->Kls_lereng,
                    'luas_ha'      => $properties->Luas_Ha,
                    'geometri'     => $multiPolygon,
                ]);

                $this->command->info('Data untuk Kecamatan ' . trim($properties->Kecamatan) . ' berhasil di-seed.');
            } else {
                $this->command->warn('Kecamatan tidak ditemukan di database: ' . trim($properties->Kecamatan));
            }
        }
    }
}
