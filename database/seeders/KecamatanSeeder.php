<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use MatanYadaev\EloquentSpatial\Objects\LineString;
use MatanYadaev\EloquentSpatial\Objects\MultiPolygon;
use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\Objects\Polygon;

class KecamatanSeeder extends Seeder
{
    public function run(): void
    {
        Kecamatan::query()->delete();

        $jsonPath = public_path('geojson/batas_kecamatan_balangan.geojson');

        if (!File::exists($jsonPath)) {
            $this->command->error("File GeoJSON tidak ditemukan di path: " . $jsonPath);
            return;
        }

        $geoJsonData = json_decode(File::get($jsonPath));

        if (json_last_error() !== JSON_ERROR_NONE || !isset($geoJsonData->features)) {
            $this->command->error("Format file GeoJSON tidak valid atau tidak memiliki 'features'.");
            return;
        }

        foreach ($geoJsonData->features as $feature) {
            if (!isset($feature->properties->NAME_3) || !isset($feature->geometry->type)) {
                $this->command->warn("Skipping feature due to missing properties or geometry type.");
                continue;
            }

            if ($feature->geometry->type === 'MultiPolygon') {
                $kecamatanName = trim($feature->properties->NAME_3);
                $polygons = [];

                foreach ($feature->geometry->coordinates as $polygonCoordinates) {
                    $lineStrings = [];

                    foreach ($polygonCoordinates as $ringCoordinates) {
                        $points = array_map(function ($coordinate) {
                            return new Point($coordinate[1], $coordinate[0]);
                        }, $ringCoordinates);

                        $lineStrings[] = new LineString($points);
                    }

                    $polygons[] = new Polygon($lineStrings);
                }

                $multiPolygon = new MultiPolygon($polygons);

                Kecamatan::create([
                    'name' => $kecamatanName,
                    'batas_wilayah' => $multiPolygon,
                ]);

                $this->command->info("Data Kecamatan '{$kecamatanName}' berhasil dibuat.");
            }
        }
    }
}
