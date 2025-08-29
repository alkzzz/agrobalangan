<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BangunanAir;
use App\Models\Kecamatan;
use App\Models\LokasiAgropolitan;
use MatanYadaev\EloquentSpatial\Objects\Point;

class BangunanAirSeeder extends Seeder
{
    private function convertDmsToPoint($dmsString): ?Point
    {
        if (!$dmsString) {
            return null;
        }

        $pattern = '/(\d+)\°\s*(\d+)\'\s*([\d,]+)"([NSEW])/';
        preg_match_all($pattern, $dmsString, $matches, PREG_SET_ORDER);

        if (count($matches) !== 2) {
            return null;
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

    public function run(): void
    {
        BangunanAir::query()->delete();

        $bangunanData = [
            [
                'kecamatan' => 'Awayan',
                'desa' => 'Pulantan',
                'jenis_bangunan' => 'Pintu sorong',
                'tipe_ukur_debit' => 'Tipe Pintu Sorong',
                'kondisi' => 'Masih berfungsi Baik',
                'kedalaman_m' => 0.58,
                'lebar_m' => 0.7,
                'jumlah_pintu' => 1,
                'masalah' => 'tidak ada bangunan penghubung antara saluran sekunder dengan saluran tersier',
                'koordinat' => '2° 25\'19,458"S 115°32\'0,42"E',
                'link_dokumentasi' => 'https://drive.google.com/drive/folders/1Nam-XzgCk4m--9Y-pwLW1lGZXmSSL8W3?usp=drive_link'
            ],
            // Data untuk Kecamatan Batu Mandi
            [
                'kecamatan' => 'Batu Mandi',
                'desa' => 'Bungur',
                'jenis_bangunan' => 'Pintu sorong',
                'tipe_ukur_debit' => 'Tipe Pintu Sorong',
                'kondisi' => 'Masih berfungsi Baik',
                'kedalaman_m' => 0.8,
                'lebar_m' => 0.5,
                'jumlah_pintu' => 1,
                'masalah' => null,
                'koordinat' => '2° 25\'19,404"S 115°25\'32,256"E',
                'link_dokumentasi' => 'https://drive.google.com/drive/folders/1C-Ucv-e7zOgTIj-09vS30ctvRR_MlCeg?usp=drive_link'
            ],
            [
                'kecamatan' => 'Batu Mandi',
                'desa' => 'Bungur',
                'jenis_bangunan' => 'Pintu sorong',
                'tipe_ukur_debit' => 'Tipe Pintu Sorong',
                'kondisi' => 'Masih berfungsi Baik',
                'kedalaman_m' => 0.8,
                'lebar_m' => 0.5,
                'jumlah_pintu' => 1,
                'masalah' => null,
                'koordinat' => '2° 25\'19,608"S 115°25\'31,884"E',
                'link_dokumentasi' => null
            ],
            [
                'kecamatan' => 'Batu Mandi',
                'desa' => 'Bungur',
                'jenis_bangunan' => 'Pintu sorong',
                'tipe_ukur_debit' => 'Tipe Pintu Sorong',
                'kondisi' => 'Masih berfungsi Baik',
                'kedalaman_m' => 0.8,
                'lebar_m' => 0.5,
                'jumlah_pintu' => 1,
                'masalah' => null,
                'koordinat' => '2° 25\'19,548"S 115°25\'30,684"E',
                'link_dokumentasi' => null
            ],
            [
                'kecamatan' => 'Batu Mandi',
                'desa' => 'Bungur',
                'jenis_bangunan' => 'Pintu sorong',
                'tipe_ukur_debit' => 'Tipe Pintu Sorong',
                'kondisi' => 'rusak perlu perbaikan',
                'kedalaman_m' => 0.8,
                'lebar_m' => 0.5,
                'jumlah_pintu' => 1,
                'masalah' => 'saat ini petani menggunakan batu untuk menahan pintu',
                'koordinat' => '2° 25\'19,44"S 115°25\'29,046"E',
                'link_dokumentasi' => null
            ],
            [
                'kecamatan' => 'Batu Mandi',
                'desa' => 'Bungur',
                'jenis_bangunan' => 'Pintu sorong',
                'tipe_ukur_debit' => 'Tipe Pintu Sorong',
                'kondisi' => 'Masih berfungsi Baik',
                'kedalaman_m' => 1.1,
                'lebar_m' => 0.5,
                'jumlah_pintu' => 1,
                'masalah' => null,
                'koordinat' => '2° 25\'9,966"S 115°25\'15,918"E',
                'link_dokumentasi' => null
            ],
            [
                'kecamatan' => 'Batu Mandi',
                'desa' => 'Bungur',
                'jenis_bangunan' => 'Pintu sorong',
                'tipe_ukur_debit' => 'Tipe Pintu Sorong',
                'kondisi' => 'Masih berfungsi Baik',
                'kedalaman_m' => 1.1,
                'lebar_m' => 0.5,
                'jumlah_pintu' => 1,
                'masalah' => null,
                'koordinat' => '2° 25\'9,558"S 115°25\'8,94"E',
                'link_dokumentasi' => null
            ],
            [
                'kecamatan' => 'Batu Mandi',
                'desa' => 'Bungur',
                'jenis_bangunan' => 'Pintu sorong',
                'tipe_ukur_debit' => 'Tipe Pintu Sorong',
                'kondisi' => 'Rusak perlu ganti baru',
                'kedalaman_m' => 1,
                'lebar_m' => 0.65,
                'jumlah_pintu' => 1,
                'masalah' => 'Pintu air rusak parah dan berkarat, tuas pemutar juga sudah berkarat, bangunannya juga sudah runtuh, petani menahannya dengan tumpukan batu',
                'koordinat' => '2° 25\'12,846"S 115°25\'4,56"E',
                'link_dokumentasi' => null
            ],
            // Data untuk Kecamatan Halong
            [
                'kecamatan' => 'Halong',
                'desa' => 'Binju',
                'jenis_bangunan' => 'Pintu sorong',
                'tipe_ukur_debit' => 'Tipe Pintu Sorong',
                'kondisi' => 'Masih berfungsi Baik',
                'kedalaman_m' => 0.68,
                'lebar_m' => 0.69,
                'jumlah_pintu' => 1,
                'masalah' => null,
                'koordinat' => '2° 15\'33,912"S 115°37\'23,61"E',
                'link_dokumentasi' => 'https://drive.google.com/drive/folders/17Pih8mEBQlOOJKBpAnI49fwd0x_0hiux?usp=drive_link'
            ],
            [
                'kecamatan' => 'Halong',
                'desa' => 'Binju',
                'jenis_bangunan' => 'Pintu sorong',
                'tipe_ukur_debit' => 'Tipe Pintu Sorong',
                'kondisi' => 'Masih berfungsi Baik',
                'kedalaman_m' => 0.68,
                'lebar_m' => 0.69,
                'jumlah_pintu' => 1,
                'masalah' => null,
                'koordinat' => '2° 15\'46,74"S 115°37\'21,642"E',
                'link_dokumentasi' => null
            ],
            [
                'kecamatan' => 'Halong',
                'desa' => 'Binju',
                'jenis_bangunan' => 'Pintu sorong',
                'tipe_ukur_debit' => 'Tipe Pintu Sorong',
                'kondisi' => 'Masih berfungsi Baik',
                'kedalaman_m' => 1.23,
                'lebar_m' => 0.9,
                'jumlah_pintu' => 1,
                'masalah' => null,
                'koordinat' => '2° 15\'55,188"S 115°37\'29,106"E',
                'link_dokumentasi' => null
            ],
            [
                'kecamatan' => 'Halong',
                'desa' => 'Binju',
                'jenis_bangunan' => 'Pintu sorong',
                'tipe_ukur_debit' => 'Tipe Pintu Sorong',
                'kondisi' => 'Masih berfungsi Baik',
                'kedalaman_m' => 1.2,
                'lebar_m' => 0.61,
                'jumlah_pintu' => 1,
                'masalah' => null,
                'koordinat' => '2° 15\'55,332"S 115°37\'29,106"E',
                'link_dokumentasi' => null
            ],
            // Data untuk Kecamatan Lampihong
            [
                'kecamatan' => 'Lampihong',
                'desa' => 'Kandang Jaya',
                'jenis_bangunan' => 'Pintu sorong',
                'tipe_ukur_debit' => 'Tipe Pintu Sorong',
                'kondisi' => 'rusak perlu perbaikan',
                'kedalaman_m' => 3,
                'lebar_m' => 1.5,
                'jumlah_pintu' => 2,
                'masalah' => 'dari 5 pintu, 3 pintu rusak',
                'koordinat' => '2° 22\'34,02"S 115°20\'32,226"E',
                'link_dokumentasi' => 'https://drive.google.com/drive/folders/1tjrp588fzqAepYYlbLkHyWukZfZ42uh4?usp=drive_link'
            ],
            [
                'kecamatan' => 'Lampihong',
                'desa' => 'Kandang Jaya',
                'jenis_bangunan' => 'Pintu sorong',
                'tipe_ukur_debit' => 'Tipe Pintu Sorong',
                'kondisi' => 'rusak perlu perbaikan',
                'kedalaman_m' => 2.4,
                'lebar_m' => 1.1,
                'jumlah_pintu' => 2,
                'masalah' => 'Tanah disamping tembok pangkal longsor, sehingga air melewati samping saluran',
                'koordinat' => '2° 22\'53,58"S 115°20\'54,444"E',
                'link_dokumentasi' => null
            ],
            [
                'kecamatan' => 'Lampihong',
                'desa' => 'Kandang Jaya',
                'jenis_bangunan' => 'Pintu sorong',
                'tipe_ukur_debit' => 'Tipe Pintu Sorong',
                'kondisi' => 'Masih berfungsi Baik',
                'kedalaman_m' => 2,
                'lebar_m' => 1,
                'jumlah_pintu' => 1,
                'masalah' => null,
                'koordinat' => '2° 22\'52,41"S 115°20\'54,816"E',
                'link_dokumentasi' => null
            ],
            [
                'kecamatan' => 'Lampihong',
                'desa' => 'Kandang Jaya',
                'jenis_bangunan' => 'Pintu sorong',
                'tipe_ukur_debit' => 'Tipe Pintu Sorong',
                'kondisi' => 'Masih berfungsi Baik',
                'kedalaman_m' => 1.5,
                'lebar_m' => 1.2,
                'jumlah_pintu' => 1,
                'masalah' => null,
                'koordinat' => '2° 23\'21,93"S 115°20\'42,348"E',
                'link_dokumentasi' => null
            ],
            [
                'kecamatan' => 'Lampihong',
                'desa' => 'Tanah Habang Kanan',
                'jenis_bangunan' => 'Pintu sorong',
                'tipe_ukur_debit' => 'Tipe Pintu Sorong',
                'kondisi' => 'Masih berfungsi Baik',
                'kedalaman_m' => 3,
                'lebar_m' => 1,
                'jumlah_pintu' => 4,
                'masalah' => null,
                'koordinat' => '2° 23\'21,6"S 115°19\'55,77"E',
                'link_dokumentasi' => 'https://drive.google.com/drive/folders/1CFDc84DQWKiRIFMUYSJycG6i4vJCXvHH?usp=drive_link'
            ],
            [
                'kecamatan' => 'Lampihong',
                'desa' => 'Tanah Habang Kanan',
                'jenis_bangunan' => 'Pintu sorong',
                'tipe_ukur_debit' => 'Tipe Pintu Sorong',
                'kondisi' => 'Ada kerusakan tapi masih berfungsi',
                'kedalaman_m' => 2.1,
                'lebar_m' => 2.2,
                'jumlah_pintu' => 2,
                'masalah' => 'Bangunan samping retak, tebing longsor',
                'koordinat' => '2° 23\'23,37"S 115°19\'56,73"E',
                'link_dokumentasi' => null
            ],
            [
                'kecamatan' => 'Lampihong',
                'desa' => 'Tanah Habang Kanan',
                'jenis_bangunan' => 'Pintu sorong',
                'tipe_ukur_debit' => 'Tipe Pintu Sorong',
                'kondisi' => 'Masih berfungsi Baik',
                'kedalaman_m' => 2,
                'lebar_m' => 1.2,
                'jumlah_pintu' => 1,
                'masalah' => null,
                'koordinat' => '2° 23\'44,412"S 115°20\'10,269"E',
                'link_dokumentasi' => null
            ],
            // Data untuk Kecamatan Paringin
            [
                'kecamatan' => 'Paringin',
                'desa' => 'Kalahiang',
                'jenis_bangunan' => null,
                'tipe_ukur_debit' => null,
                'kondisi' => 'Rusak perlu ganti baru, pintu airnya hilang',
                'kedalaman_m' => null,
                'lebar_m' => null,
                'jumlah_pintu' => 0,
                'masalah' => null,
                'koordinat' => '2° 19\'30,792"S 115°25\'59,394"E',
                'link_dokumentasi' => 'https://drive.google.com/drive/folders/1ueSiZaIXToM_VuCisoJ3vaiuQH2eduH_?usp=drive_link'
            ],
            // Data untuk Kecamatan Paringin Selatan
            [
                'kecamatan' => 'Paringin Selatan',
                'desa' => 'Bungin',
                'jenis_bangunan' => 'Pintu sorong',
                'tipe_ukur_debit' => 'Tipe Pintu Sorong',
                'kondisi' => 'rusak perlu perbaikan',
                'kedalaman_m' => 0.95,
                'lebar_m' => 0.53,
                'jumlah_pintu' => 1,
                'masalah' => 'tuas pemutar pintu air sudah tidak dapat diputar lagi',
                'koordinat' => '2° 20\'55,578"S 115°27\'2,154"E',
                'link_dokumentasi' => 'https://drive.google.com/drive/folders/1I0kUZXTAG1BJppE3Xe93sWgJkC2q5zEL?usp=drive_link'
            ],
        ];

        foreach ($bangunanData as $data) {
            $geometri = $this->convertDmsToPoint($data['koordinat']);
            if (!$geometri) {
                $this->command->warn("Skipping '{$data['desa']}' due to missing coordinates.");
                continue;
            }

            $kecamatan = Kecamatan::where('name', $data['kecamatan'])->first();
            if ($kecamatan) {
                $lokasi = LokasiAgropolitan::where('kecamatan_id', $kecamatan->id)->first();
                if ($lokasi) {
                    BangunanAir::create([
                        'lokasi_agropolitan_id' => $lokasi->id,
                        'desa' => $data['desa'],
                        'jenis_bangunan' => $data['jenis_bangunan'],
                        'tipe_ukur_debit' => $data['tipe_ukur_debit'],
                        'lebar_m' => $data['lebar_m'],
                        'kedalaman_m' => $data['kedalaman_m'],
                        'kondisi' => $data['kondisi'],
                        'jumlah_pintu' => $data['jumlah_pintu'],
                        'masalah' => $data['masalah'],
                        'geometri' => $geometri,
                        'link_dokumentasi' => $data['link_dokumentasi'],
                    ]);
                }
            }
        }
    }
}
