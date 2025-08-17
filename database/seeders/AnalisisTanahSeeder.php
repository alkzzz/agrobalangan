<?php

namespace Database\Seeders;

use App\Models\AnalisisTanah;
use App\Models\LokasiAgropolitan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnalisisTanahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('analisis_tanah')->delete();

        $dataAnalisis = [
            'Paringin' => [
                'tekstur' => 'Clay',
                'ph' => 5.07,
                'c_organik' => 3.67,
                'n_total' => 0.32,
                'p_potensial' => 42.20,
                'k_potensial' => 3.64,
                'ktk' => 29.08,
                'kejenuhan_basa' => 8.14,
                'kesesuaian_aktual' => 'S3nf (sesuai marginal)',
                'faktor_pembatas' => 'Hara (n), Retensi Hara (pH)',
                'kesesuaian_potensial' => 'S1 (Sangat Sesuai)',
            ],
            'Paringin Selatan' => [
                'tekstur' => 'Clay Loam',
                'ph' => 4.94,
                'c_organik' => 0.46,
                'n_total' => 0.09,
                'p_potensial' => 19.53,
                'k_potensial' => 3.46,
                'ktk' => 11.43,
                'kejenuhan_basa' => 29.74,
                'kesesuaian_aktual' => 'S3rnf (sesuai marginal)',
                'faktor_pembatas' => 'Media Perakaran, Hara (n), Retensi Hara (pH)',
                'kesesuaian_potensial' => 'S2t (Cukup Sesuai)',
            ],
            'Lampihong' => [
                'tekstur' => 'Clay Loam',
                'ph' => 5.03,
                'c_organik' => 1.08,
                'n_total' => 0.15,
                'p_potensial' => 46.61,
                'k_potensial' => 7.25,
                'ktk' => 26.26,
                'kejenuhan_basa' => 56.27,
                'kesesuaian_aktual' => 'S3nf (sesuai marginal)',
                'faktor_pembatas' => 'Hara (n), Retensi Hara (pH)',
                'kesesuaian_potensial' => 'S1 (Sangat Sesuai)',
            ],
            'Batu Mandi' => [
                'tekstur' => 'Clay',
                'ph' => 5.67,
                'c_organik' => 1.06,
                'n_total' => 0.15,
                'p_potensial' => 26.21,
                'k_potensial' => 4.69,
                'ktk' => 11.60,
                'kejenuhan_basa' => 60.60,
                'kesesuaian_aktual' => 'S3nf (sesuai marginal)',
                'faktor_pembatas' => 'Hara (n)',
                'kesesuaian_potensial' => 'S1 (Sangat Sesuai)',
            ],
            'Awayan' => [
                'tekstur' => 'Clay Loam',
                'ph' => 5.19,
                'c_organik' => 0.82,
                'n_total' => 0.10,
                'p_potensial' => 32.10,
                'k_potensial' => 4.26,
                'ktk' => 8.24,
                'kejenuhan_basa' => 98.32,
                'kesesuaian_aktual' => 'S3nf (sesuai marginal)',
                'faktor_pembatas' => 'Hara (n)',
                'kesesuaian_potensial' => 'S1 (Sangat Sesuai)',
            ],
            'Halong' => [
                'tekstur' => 'Clay',
                'ph' => 4.83,
                'c_organik' => 0.85,
                'n_total' => 0.12,
                'p_potensial' => 11.26,
                'k_potensial' => 3.48,
                'ktk' => 26.26,
                'kejenuhan_basa' => 39.14,
                'kesesuaian_aktual' => 'S3nf (sesuai marginal)',
                'faktor_pembatas' => 'Hara (n, P, K), Retensi Hara (pH)',
                'kesesuaian_potensial' => 'S1 (Sangat Sesuai)',
            ],
            'Juai' => [
                'tekstur' => 'Clay Loam',
                'ph' => 5.12,
                'c_organik' => 0.76,
                'n_total' => 0.09,
                'p_potensial' => 1.03,
                'k_potensial' => 2.87,
                'ktk' => 11.64,
                'kejenuhan_basa' => 11.77,
                'kesesuaian_aktual' => 'S3nf (sesuai marginal)',
                'faktor_pembatas' => 'Hara (n, P, K), Retensi Hara',
                'kesesuaian_potensial' => 'S1 (Sangat Sesuai)',
            ],
        ];

        $lokasiAgropolitanList = LokasiAgropolitan::with('kecamatan')->get();

        if ($lokasiAgropolitanList->isEmpty()) {
            $this->command->warn('Tidak ada data Lokasi Agropolitan. Seeder Analisis Tanah dilewati.');
            return;
        }

        foreach ($lokasiAgropolitanList as $lokasi) {
            $namaKecamatan = $lokasi->kecamatan->name;

            if (isset($dataAnalisis[$namaKecamatan])) {
                $data = $dataAnalisis[$namaKecamatan];
                $data['lokasi_agropolitan_id'] = $lokasi->id;

                AnalisisTanah::create($data);
            }
        }

        $this->command->info('Seeder Analisis Tanah dari data laporan berhasil dijalankan.');
    }
}
