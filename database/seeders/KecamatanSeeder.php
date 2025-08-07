<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use MatanYadaev\EloquentSpatial\Objects\LineString;
use MatanYadaev\EloquentSpatial\Objects\MultiLineString;
use MatanYadaev\EloquentSpatial\Objects\Point;

class KecamatanSeeder extends Seeder
{
    public function run(): void
    {
        Kecamatan::query()->delete();

        $jsonPath = public_path('geojson/batas_kecamatan.geojson');

        if (!File::exists($jsonPath)) {
            $this->command->error("File GeoJSON batas kecamatan tidak ditemukan.");
            return;
        }

        $data = json_decode(File::get($jsonPath));
        $kecamatanLines = [];

        foreach ($data->features as $feature) {
            if ($feature->geometry->type === 'LineString') {
                $kecamatanName = trim($feature->properties->KECAMATAN);
                if (!isset($kecamatanLines[$kecamatanName])) {
                    $kecamatanLines[$kecamatanName] = [];
                }
                $kecamatanLines[$kecamatanName][] = $feature->geometry->coordinates;
            }
        }

        foreach ($kecamatanLines as $kecamatanName => $lines) {
            $lineStrings = [];
            foreach ($lines as $line) {
                $points = array_map(function ($coordinate) {
                    return new Point($coordinate[1], $coordinate[0]);
                }, $line);
                $lineStrings[] = new LineString($points);
            }

            $multiLineString = new MultiLineString($lineStrings);

            Kecamatan::create([
                'name' => $kecamatanName,
                'batas_wilayah' => $multiLineString,
            ]);

            $this->command->info("Data Kecamatan {$kecamatanName} berhasil dibuat.");
        }
    }
}
