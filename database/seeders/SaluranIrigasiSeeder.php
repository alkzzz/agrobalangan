<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SaluranIrigasi;
use App\Models\Kecamatan;
use App\Models\LokasiAgropolitan;
use MatanYadaev\EloquentSpatial\Objects\Point;

class SaluranIrigasiSeeder extends Seeder
{
    /**
     * Konversi string koordinat DMS (Degree, Minute, Second) ke objek Point.
     *
     * @param string|null $dmsString
     * @return Point|null
     */
    private function convertDmsToPoint($dmsString): ?Point
    {
        if (!$dmsString) {
            return null;
        }

        // Pola regex yang lebih fleksibel untuk menangani koma atau titik sebagai desimal
        $pattern = '/(\d+)\°\s*(\d+)\'\s*([\d,.]+)"([NSEW])/';
        preg_match_all($pattern, $dmsString, $matches, PREG_SET_ORDER);

        if (count($matches) !== 2) {
            // Coba format alternatif tanpa spasi antar komponen
            $pattern_alt = '/(\d+)°(\d+)\'([\d,.]+)"([NSEW])\s*(\d+)°(\d+)\'([\d,.]+)"([NSEW])/';
            if (preg_match($pattern_alt, $dmsString, $matches_alt)) {
                $matches = [
                    // Latitude
                    [$matches_alt[0], $matches_alt[1], $matches_alt[2], $matches_alt[3], $matches_alt[4]],
                    // Longitude
                    [$matches_alt[0], $matches_alt[5], $matches_alt[6], $matches_alt[7], $matches_alt[8]],
                ];
            } else {
                return null;
            }
        }


        $latDeg = (float)$matches[0][1];
        $latMin = (float)$matches[0][2];
        $latSec = (float)str_replace(',', '.', $matches[0][3]);
        $latDir = $matches[0][4];

        $lonDeg = (float)$matches[1][1];
        $lonMin = (float)$matches[1][2];
        $lonSec = (float)str_replace(',', '.', $matches[1][3]);
        $lonDir = $matches[1][4];

        $latitude = $latDeg + ($latMin / 60) + ($latSec / 3600);
        if ($latDir === 'S') {
            $latitude *= -1;
        }

        $longitude = $lonDeg + ($lonMin / 60) + ($lonSec / 3600);
        if ($lonDir === 'W') {
            $longitude *= -1;
        }

        return new Point($latitude, $longitude);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Mengosongkan tabel sebelum seeding
        SaluranIrigasi::query()->delete();

        $saluranData = [
            // Data untuk Kecamatan Awayan
            [
                'kecamatan' => 'Awayan',
                'desa' => 'Pulantan',
                'hirarki' => 'Sekunder',
                'tipe_saluran' => 'Pasangan beton',
                'jenis_saluran' => 'Terbuka',
                'bentuk_saluran' => 'Segiempat',
                'panjang_m' => 4377.24,
                'lebar_m' => 2,
                'kedalaman_m' => 1.35,
                'kondisi' => 'Bagus',
                'masalah' => 'Air bersumber dari bendung pitap, tidak ada bangunan air yang menghubungkan saluran sekunder dengan saluran tersier, saluran tersier dibangun secara swadaya sumbangan masyarakat.',
                'koordinat' => '2° 25\'19,608"S 115°32\'0,582"E',
                'link_dokumentasi' => 'https://drive.google.com/drive/folders/18AEYkm9RkM8x13Qk2Q9Fc4JNESPwG-nB?usp=drive_link'
            ],
            [
                'kecamatan' => 'Awayan',
                'desa' => 'Pulantan',
                'hirarki' => 'Tersier',
                'tipe_saluran' => 'Pasangan beton',
                'jenis_saluran' => 'Terbuka',
                'bentuk_saluran' => 'Trapesium',
                'panjang_m' => 400.21,
                'lebar_m' => 0.6,
                'kedalaman_m' => 0.55,
                'kondisi' => 'Bagus',
                'masalah' => 'Air bersumber dari bendung pitap, tidak ada bangunan air yang menghubungkan saluran sekunder dengan saluran tersier, saluran tersier dibangun secara swadaya sumbangan masyarakat.',
                'koordinat' => '2° 25\'2,793"S 115°31\'48,604"E',
                'link_dokumentasi' => 'https://drive.google.com/drive/folders/1yyCDbk8PhjcSnRLItqQIQ7Umon2nSwXk?usp=drive_link'
            ],
            [
                'kecamatan' => 'Awayan',
                'desa' => 'Pulantan',
                'hirarki' => 'Tersier Kiri',
                'tipe_saluran' => 'Pasangan beton',
                'jenis_saluran' => 'Terbuka',
                'bentuk_saluran' => 'Trapesium',
                'panjang_m' => 239,
                'lebar_m' => 0.6,
                'kedalaman_m' => 0.55,
                'kondisi' => 'Bagus',
                'masalah' => 'Dikarenakan muka air yang tinggi menyebabkan air meluap keluar saluran.',
                'koordinat' => '2° 25\'2,793"S 115°31\'48,604"E',
                'link_dokumentasi' => 'https://drive.google.com/drive/folders/1yyCDbk8PhjcSnRLItqQIQ7Umon2nSwXk?usp=drive_link'
            ],
            // Data untuk Kecamatan Batu Mandi
            [
                'kecamatan' => 'Batu Mandi',
                'desa' => 'Bungur',
                'hirarki' => 'Primer',
                'tipe_saluran' => 'Pasangan beton',
                'jenis_saluran' => 'Terbuka',
                'bentuk_saluran' => 'Trapesium',
                'panjang_m' => 294,
                'lebar_m' => 1.1,
                'kedalaman_m' => 2.1,
                'kondisi' => 'Bagus',
                'masalah' => 'Terdapat banyak tumpukan sedimen dan juga sampah.',
                'koordinat' => '2° 25\'20,97"S 115°25\'35,688"E',
                'link_dokumentasi' => 'https://drive.google.com/drive/folders/1VfkqzIU0OMQwzR2Yvlz81Z5DjRzRl555?usp=drive_link'
            ],
            [
                'kecamatan' => 'Batu Mandi',
                'desa' => 'Bungur',
                'hirarki' => 'Tersier 1 Kiri',
                'tipe_saluran' => 'Pasangan beton',
                'jenis_saluran' => 'Terbuka',
                'bentuk_saluran' => 'Trapesium',
                'panjang_m' => 102,
                'lebar_m' => 0.6,
                'kedalaman_m' => 0.6,
                'kondisi' => 'Bagus',
                'masalah' => null,
                'koordinat' => '2° 25\'18,78888"S 115°25\'36,78168"E',
                'link_dokumentasi' => null
            ],
            [
                'kecamatan' => 'Batu Mandi',
                'desa' => 'Bungur',
                'hirarki' => 'Tersier 3 Kanan',
                'tipe_saluran' => 'Pasangan beton',
                'jenis_saluran' => 'Terbuka',
                'bentuk_saluran' => 'Trapesium',
                'panjang_m' => 196.49,
                'lebar_m' => 0.7,
                'kedalaman_m' => 0.6,
                'kondisi' => 'Bagus',
                'masalah' => null,
                'koordinat' => '2° 25\'19,266"S 115°25\'29,028"E',
                'link_dokumentasi' => null
            ],
            [
                'kecamatan' => 'Batu Mandi',
                'desa' => 'Bungur',
                'hirarki' => 'Tersier 2 Kiri',
                'tipe_saluran' => 'Pasangan beton',
                'jenis_saluran' => 'Terbuka',
                'bentuk_saluran' => 'Trapesium',
                'panjang_m' => 85.8,
                'lebar_m' => 0.7,
                'kedalaman_m' => 0.6,
                'kondisi' => 'Bagus',
                'masalah' => 'Sebagian saluran masih ada yang berupa saluran tanah urugan.',
                'koordinat' => '2° 25\'19,208"S 115°25\'29,034"E',
                'link_dokumentasi' => null
            ],
            [
                'kecamatan' => 'Batu Mandi',
                'desa' => 'Bungur',
                'hirarki' => 'Sekunder',
                'tipe_saluran' => 'Pasangan beton',
                'jenis_saluran' => 'Terbuka',
                'bentuk_saluran' => 'Trapesium',
                'panjang_m' => 1146,
                'lebar_m' => 1.35,
                'kedalaman_m' => 0.6,
                'kondisi' => 'Bagus',
                'masalah' => 'Air cuman berasal dari air hujan (sungai kecil).',
                'koordinat' => '2° 25\'19,572"S 115°25\'31,494"E',
                'link_dokumentasi' => null
            ],
            // Data untuk Kecamatan Halong
            [
                'kecamatan' => 'Halong',
                'desa' => 'Binju',
                'hirarki' => 'Tersier',
                'tipe_saluran' => 'Pasangan beton',
                'jenis_saluran' => 'Terbuka',
                'bentuk_saluran' => 'Trapesium',
                'panjang_m' => 1002.81,
                'lebar_m' => 1.35,
                'kedalaman_m' => 0.7,
                'kondisi' => 'Ringan',
                'masalah' => 'Air di saluran bersumber dari sungai, tetapi hanya pada musim hujan air sampai ke ujung saluran.',
                'koordinat' => '2° 15\'34,098"S 115°37\'23,508"E',
                'link_dokumentasi' => 'https://drive.google.com/drive/folders/1IZRYr4-myfU-GpwQhABc-63plIsk5-3a?usp=drive_link'
            ],
            // Data untuk Kecamatan Lampihong
            [
                'kecamatan' => 'Lampihong',
                'desa' => 'Kandang Jaya',
                'hirarki' => 'Primer',
                'tipe_saluran' => 'Saluran irigasi tanpa pasangan (tanah)',
                'jenis_saluran' => 'Terbuka',
                'bentuk_saluran' => 'Trapesium',
                'panjang_m' => 1692,
                'lebar_m' => 8.8,
                'kedalaman_m' => 3,
                'kondisi' => 'Ringan',
                'masalah' => 'Pasangan batu bronjong hanya ada di bagian yang ada hulu bangunan air nya, sebagian tertutup longsor.',
                'koordinat' => '2° 22\'53,202"S 115°20\'54,528"E',
                'link_dokumentasi' => 'https://drive.google.com/drive/folders/1B8ePs7EsQ_5-NxlLSDTd3XEuD4RP7KNx?usp=drive_link'
            ],
            [
                'kecamatan' => 'Lampihong',
                'desa' => 'Kandang Jaya',
                'hirarki' => 'Sekunder 1 kiri',
                'tipe_saluran' => 'Pasangan beton',
                'jenis_saluran' => 'Terbuka',
                'bentuk_saluran' => 'Trapesium',
                'panjang_m' => 258,
                'lebar_m' => 2.4,
                'kedalaman_m' => 1.5,
                'kondisi' => 'Bagus',
                'masalah' => 'Saluran berfungsi dengan baik, namun tidak sepenuhnya menggunakan pasangan beton.',
                'koordinat' => '2° 22\'53,982"S 115°20\'54,288"E',
                'link_dokumentasi' => 'https://drive.google.com/drive/folders/1iK_QGkJ7XW5g3pQViC73jbFjvjf2E9fh?usp=drive_link'
            ],
            [
                'kecamatan' => 'Lampihong',
                'desa' => 'Kandang Jaya',
                'hirarki' => 'Sekunder 2 kanan',
                'tipe_saluran' => 'Saluran irigasi tanpa pasangan (tanah)',
                'jenis_saluran' => 'Terbuka',
                'bentuk_saluran' => 'Trapesium',
                'panjang_m' => 944,
                'lebar_m' => 4.6,
                'kedalaman_m' => 1.8,
                'kondisi' => 'Ringan',
                'masalah' => 'Terdapat keruntuhan sedikit dibeberapa bagian.',
                'koordinat' => '2° 22\'53,868"S 115°20\'54,222"E',
                'link_dokumentasi' => 'https://drive.google.com/drive/folders/1SNxHRq4ZyaX1dykyH3RerrRtVkFpldtB?usp=drive_link'
            ],
            [
                'kecamatan' => 'Lampihong',
                'desa' => 'Kandang Jaya',
                'hirarki' => 'Sekunder 3 kiri',
                'tipe_saluran' => 'Saluran irigasi tanpa pasangan (tanah)',
                'jenis_saluran' => 'Terbuka',
                'bentuk_saluran' => 'Trapesium',
                'panjang_m' => 508,
                'lebar_m' => 5,
                'kedalaman_m' => 0.54,
                'kondisi' => 'Bagus',
                'masalah' => null,
                'koordinat' => '2° 23\'4,633"S 115°20\'0,874"E',
                'link_dokumentasi' => 'https://drive.google.com/drive/folders/1SrlT6a8rP7tFzgk0f2ZF0Uv14h096Bcw?usp=drive_link'
            ],
            [
                'kecamatan' => 'Lampihong',
                'desa' => 'Kandang Jaya',
                'hirarki' => 'Sekunder 4 kanan',
                'tipe_saluran' => 'Saluran irigasi tanpa pasangan (tanah)',
                'jenis_saluran' => 'Terbuka',
                'bentuk_saluran' => 'Trapesium',
                'panjang_m' => 494,
                'lebar_m' => 4.5,
                'kedalaman_m' => 0.5,
                'kondisi' => 'Bagus',
                'masalah' => null,
                'koordinat' => '2° 23\'12,654"S 115°20\'57,798"E',
                'link_dokumentasi' => 'https://drive.google.com/drive/folders/1T-lxqKgkAjZYqIJGgPWMeEQ9JzCl9NF3?usp=drive_link'
            ],
            [
                'kecamatan' => 'Lampihong',
                'desa' => 'Tanah Habang Kanan',
                'hirarki' => 'Primer',
                'tipe_saluran' => 'Saluran irigasi tanpa pasangan (tanah)',
                'jenis_saluran' => 'Terbuka',
                'bentuk_saluran' => 'Trapesium',
                'panjang_m' => 1240.27,
                'lebar_m' => 8,
                'kedalaman_m' => 3,
                'kondisi' => 'Ringan',
                'masalah' => 'Pasangan beton hanya ada di bagian yang ada bangunan air nya.',
                'koordinat' => '2° 23\'44,526"S 115°20\'10,248"E',
                'link_dokumentasi' => 'https://drive.google.com/drive/folders/1huIBUDdVP96038iToIGdnoJJhFP2ppJg?usp=drive_link'
            ],
            [
                'kecamatan' => 'Lampihong',
                'desa' => 'Tanah Habang Kanan',
                'hirarki' => 'Sekunder',
                'tipe_saluran' => 'Pasangan beton',
                'jenis_saluran' => 'Terbuka',
                'bentuk_saluran' => 'Trapesium',
                'panjang_m' => 146,
                'lebar_m' => 0.6,
                'kedalaman_m' => 0.5,
                'kondisi' => 'Tidak Berfungsi',
                'masalah' => 'Saluran primer tidak terhubung dengan saluran sekunder, saluran sekunder elevasinya lebih tinggi 3 meter dari dasar saluran primer.',
                'koordinat' => '2° 23\'44,748"S 115°20\'10,17"E',
                'link_dokumentasi' => 'https://drive.google.com/drive/folders/1QpJShpnUrPwZqXqQnDo66ky0yJQtdUUN?usp=drive_link'
            ],
            // Data untuk Kecamatan Paringin
            [
                'kecamatan' => 'Paringin',
                'desa' => 'Kalahiang',
                'hirarki' => 'Tersier',
                'tipe_saluran' => 'Pasangan beton',
                'jenis_saluran' => 'Terbuka',
                'bentuk_saluran' => 'Trapesium',
                'panjang_m' => 781.93,
                'lebar_m' => 1,
                'kedalaman_m' => 0.9,
                'kondisi' => 'Ringan',
                'masalah' => 'Air bersumber dari sungai balangan, sebagian pasangan batu bronjong usak pada muara saluran, saluran tertutup batang kayu, Tidak ada pintu air.',
                'koordinat' => '2° 19\'24,75"S 115°26\'5,22"E',
                'link_dokumentasi' => 'https://drive.google.com/drive/folders/1Cf8dE55Eei22BTMsutu4XUnLhkOMLc_9?usp=drive_link'
            ],
            // Data untuk Kecamatan Paringin Selatan
            [
                'kecamatan' => 'Paringin Selatan',
                'desa' => 'Bungin',
                'hirarki' => 'Tersier Kiri',
                'tipe_saluran' => 'Pasangan beton',
                'jenis_saluran' => 'Terbuka',
                'bentuk_saluran' => 'Trapesium',
                'panjang_m' => 413,
                'lebar_m' => 0.9,
                'kedalaman_m' => 0.8,
                'kondisi' => 'Parah',
                'masalah' => 'Ada di beberapa titik saluran kondisinya patah dan sebagian hancur parah dan dipenuhi banyak rumput liar.',
                'koordinat' => '2° 20\'56,7"S 115°27\'2,454"E',
                'link_dokumentasi' => 'https://drive.google.com/drive/folders/1avf4GiIoG6LEOXvlwEDfB3O60mpnlcOp?usp=drive_link'
            ],
            [
                'kecamatan' => 'Paringin Selatan',
                'desa' => 'Bungin',
                'hirarki' => 'Tersier',
                'tipe_saluran' => 'Pasangan beton',
                'jenis_saluran' => 'Terbuka',
                'bentuk_saluran' => 'Trapesium',
                'panjang_m' => 310,
                'lebar_m' => 0.7,
                'kedalaman_m' => 0.85,
                'kondisi' => 'Parah',
                'masalah' => 'Saluran patah, Tidak ada pintu air.',
                'koordinat' => '2° 20\'48,108"S 115°26\'55,296"E',
                'link_dokumentasi' => 'https://drive.google.com/drive/folders/1xRw-wMsb4KDRmO3tOpuytp4mKZt_GLe9?usp=drive_link'
            ],
            [
                'kecamatan' => 'Paringin Selatan',
                'desa' => 'Bungin',
                'hirarki' => 'Tersier',
                'tipe_saluran' => 'Saluran irigasi tanpa pasangan (tanah)',
                'jenis_saluran' => 'Terbuka',
                'bentuk_saluran' => 'Trapesium',
                'panjang_m' => 963,
                'lebar_m' => 2.5,
                'kedalaman_m' => 0.9,
                'kondisi' => 'Ringan',
                'masalah' => 'Saluran Tertutup tanaman.',
                'koordinat' => '2° 20\'51,24"S 115°26\'30,936"E',
                'link_dokumentasi' => 'https://drive.google.com/drive/folders/1-imO7LtfpnIai9z5VT4EvyTEpqVtW6b8?usp=drive_link'
            ],
        ];

        foreach ($saluranData as $data) {
            // Mengabaikan entri tanpa data penting seperti 'hirarki'
            if (empty($data['hirarki']) || $data['hirarki'] === '-') {
                $this->command->info("Skipping '{$data['desa']}' karena tidak ada data saluran.");
                continue;
            }

            $geometri = $this->convertDmsToPoint($data['koordinat']);

            if (!$geometri) {
                $this->command->warn("Gagal memproses koordinat untuk '{$data['desa']}'. Data dilewati.");
                continue;
            }

            // Mencari kecamatan berdasarkan nama
            $kecamatan = Kecamatan::where('name', $data['kecamatan'])->first();
            if (!$kecamatan) {
                $this->command->error("Kecamatan '{$data['kecamatan']}' tidak ditemukan. Data untuk '{$data['desa']}' dilewati.");
                continue;
            }

            // Mencari lokasi agropolitan berdasarkan ID kecamatan
            $lokasi = LokasiAgropolitan::where('kecamatan_id', $kecamatan->id)->first();
            if (!$lokasi) {
                $this->command->warn("Lokasi Agropolitan untuk Kecamatan '{$data['kecamatan']}' tidak ditemukan. Data untuk '{$data['desa']}' dilewati.");
                continue;
            }

            // Membuat record baru di tabel SaluranIrigasi
            SaluranIrigasi::create([
                'lokasi_agropolitan_id' => $lokasi->id,
                'desa' => $data['desa'],
                'hirarki' => $data['hirarki'],
                'tipe_saluran' => $data['tipe_saluran'],
                'jenis_saluran' => $data['jenis_saluran'],
                'bentuk_saluran' => $data['bentuk_saluran'],
                'panjang_m' => $data['panjang_m'],
                'lebar_m' => $data['lebar_m'],
                'kedalaman_m' => $data['kedalaman_m'],
                'kondisi' => $data['kondisi'],
                'masalah' => $data['masalah'],
                'geometri' => $geometri,
                'link_dokumentasi' => $data['link_dokumentasi'],
            ]);
        }
    }
}
