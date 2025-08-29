<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LokasiAgropolitan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use App\Models\SaluranIrigasi;
use App\Models\BangunanAir;

class LokasiAgropolitanController extends Controller
{
    public function geojson()
    {
        $lokasiAgropolitan = LokasiAgropolitan::with('kecamatan')->get();

        $features = $lokasiAgropolitan->map(function ($lokasi) {
            return [
                'type' => 'Feature',
                'geometry' => $lokasi->geometri,
                'properties' => [
                    'id' => $lokasi->id,
                    'kecamatan' => $lokasi->kecamatan->name,
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
        $lokasiAgropolitan = LokasiAgropolitan::with('kecamatan')
            ->join('kecamatan', 'lokasi_agropolitan.kecamatan_id', '=', 'kecamatan.id')
            ->orderBy('kecamatan.name', 'asc')
            ->select('lokasi_agropolitan.*') // penting supaya hasilnya tetap model LokasiAgropolitan
            ->get();

        return view('lokasi_agropolitan.index', compact('lokasiAgropolitan'));
    }

    public function detail($id)
    {
        $lokasi = LokasiAgropolitan::with(['kecamatan', 'kepemilikanLahan', 'analisisTanah', 'saluranIrigasi', 'bangunanAir'])->findOrFail($id);

        $feature = [
            'type' => 'Feature',
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

        $kepemilikanFeatures = $lokasi->kepemilikanLahan->map(function ($k) {
            return [
                'type' => 'Feature',
                'geometry' => $k->geometri?->toArray(),
                'properties' => [
                    'id'           => $k->id,
                    'nama_pemilik' => $k->nama_pemilik,
                ],
            ];
        })->values()->all();

        $kepemilikanGeoJson = [
            'type' => 'FeatureCollection',
            'features' => $kepemilikanFeatures,
        ];

        $kepemilikanList = $lokasi->kepemilikanLahan->map(fn($k) => [
            'id' => $k->id,
            'nama_pemilik' => $k->nama_pemilik,
            'keterangan' => $k->keterangan,
        ])->values();

        $saluranFeatures = $lokasi->saluranIrigasi->map(function ($saluran) {
            return [
                'type' => 'Feature',
                'geometry' => $saluran->geometri->toArray(),
                'properties' => [
                    'id' => $saluran->id,
                    'desa' => $saluran->desa,
                    'kondisi' => $saluran->kondisi,
                    'masalah' => $saluran->masalah,
                ],
            ];
        })->values()->all();

        $saluranGeoJson = [
            'type' => 'FeatureCollection',
            'features' => $saluranFeatures,
        ];

        $bangunanAirFeatures = $lokasi->bangunanAir->map(function ($bangunan) {
            return [
                'type' => 'Feature',
                'geometry' => $bangunan->geometri->toArray(),
                'properties' => [
                    'id' => $bangunan->id,
                    'desa' => $bangunan->desa,
                    'jenis_bangunan' => $bangunan->jenis_bangunan,
                    'kondisi' => $bangunan->kondisi,
                ],
            ];
        })->values()->all();

        $bangunanAirGeoJson = [
            'type' => 'FeatureCollection',
            'features' => $bangunanAirFeatures,
        ];

        $namaKecamatan = $lokasi->kecamatan->name;

        // Rencana Bendung
        $pathBendung = public_path('geojson/Rencana_bendung_perkecamatan.geojson');
        $rencanaBendungGeoJson = json_encode(['type' => 'FeatureCollection', 'features' => []]); // Default: GeoJSON kosong

        if (File::exists($pathBendung)) {
            $geojsonBendungAsli = json_decode(File::get($pathBendung));
            $fiturBendungFiltered = [];

            if (isset($geojsonBendungAsli->features)) {
                foreach ($geojsonBendungAsli->features as $feature) {
                    if (isset($feature->properties->KECAMATAN) && strcasecmp($feature->properties->KECAMATAN, $namaKecamatan) == 0) {
                        $fiturBendungFiltered[] = $feature;
                    }
                }
            }

            $rencanaBendungGeoJson = json_encode(['type' => 'FeatureCollection', 'features' => $fiturBendungFiltered]);
        }

        // Rencana Sumur Bor
        $pathSumurBor = public_path('geojson/Rencana_sumur_bor_perkecamatan.geojson');
        $rencanaSumurBorGeoJson = json_encode(['type' => 'FeatureCollection', 'features' => []]); // Default: GeoJSON kosong

        if (File::exists($pathSumurBor)) {
            $geojsonSumurBorAsli = json_decode(File::get($pathSumurBor));
            $fiturSumurBorFiltered = [];

            if (isset($geojsonSumurBorAsli->features)) {
                foreach ($geojsonSumurBorAsli->features as $feature) {
                    if (isset($feature->properties->KECAMATAN) && strcasecmp($feature->properties->KECAMATAN, $namaKecamatan) == 0) {
                        $fiturSumurBorFiltered[] = $feature;
                    }
                }
            }

            $rencanaSumurBorGeoJson = json_encode(['type' => 'FeatureCollection', 'features' => $fiturSumurBorFiltered]);
        }

        return view('lokasi_agropolitan.detail', [
            'lokasi'             => $lokasi,
            'geoJsonData'        => $geoJsonData,
            'kepemilikanGeoJson' => $kepemilikanGeoJson,
            'kepemilikanList'    => $kepemilikanList,
            'analisisTanah'      => $lokasi->analisisTanah,
            'saluranList'        => $lokasi->saluranIrigasi,
            'saluranGeoJson'     => $saluranGeoJson,
            'bangunanAirList'    => $lokasi->bangunanAir,
            'bangunanAirGeoJson' => $bangunanAirGeoJson,
            'rencanaBendungGeoJson'  => $rencanaBendungGeoJson,
            'rencanaSumurBorGeoJson' => $rencanaSumurBorGeoJson,
        ]);
    }


    public function showKepemilikanDokumentasi(LokasiAgropolitan $lokasi)
    {
        $mediaList = $lokasi->media()->where('collection_name', 'kepemilikan_lahan')->get();
        $data = [
            'title'          => 'Dokumentasi Kepemilikan Lahan',
            'headerTitle'    => 'Dokumentasi Kepemilikan Lahan',
            'collectionName' => 'kepemilikan_lahan',
            'lokasi'         => $lokasi,
            'mediaList'      => $mediaList
        ];

        return view('lokasi_agropolitan.dokumentasi', $data);
    }

    public function showTanahDokumentasi(LokasiAgropolitan $lokasi)
    {
        $mediaList = $lokasi->media()->where('collection_name', 'analisis_tanah')->get(); // Load analisis lokasi untuk data
        $data = [
            'title'          => 'Dokumentasi Analisis Tanah',
            'headerTitle'    => 'Dokumentasi Analisis Tanah',
            'collectionName' => 'analisis_tanah',
            'lokasi'         => $lokasi,
            'mediaList'      => $mediaList
        ];

        return view('lokasi_agropolitan.dokumentasi', $data);
    }

    public function showIrigasiDokumentasi(LokasiAgropolitan $lokasi)
    {
        $mediaList = $lokasi->media()->where('collection_name', 'data_irigasi')->get(); // Load data irigasi untuk dokumentasi
        $data = [
            'title'          => 'Dokumentasi Jaringan Irigasi',
            'headerTitle'    => 'Dokumentasi Jaringan Irigasi',
            'collectionName' => 'data_irigasi',
            'lokasi'         => $lokasi,
            'mediaList'      => $mediaList
        ];

        return view('lokasi_agropolitan.dokumentasi', $data);
    }

    public function showJalanDokumentasi(LokasiAgropolitan $lokasi)
    {
        $mediaList = $lokasi->media()->where('collection_name', 'dokumentasi_jalan')->get(); // Load dokumentasi jalan
        $data = [
            'title'          => 'Dokumentasi Jalan',
            'headerTitle'    => 'Dokumentasi Jalan',
            'collectionName' => 'dokumentasi_jalan',
            'lokasi'         => $lokasi,
            'mediaList'      => $mediaList
        ];

        return view('lokasi_agropolitan.dokumentasi', $data);
    }

    public function storeDokumentasi(Request $request, LokasiAgropolitan $lokasi)
    {
        $request->validate([
            'files'      => 'required|array',
            'files.*'    => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'collection' => 'required|string',
        ]);

        $collectionName = $request->collection;

        $lokasiSlug = Str::slug($lokasi->kecamatan->name, '_');

        $folderPath = $lokasiSlug . '/' . $collectionName;

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store($folderPath, 'cp_public');

                $lokasi->media()->create([
                    'collection_name' => $collectionName,
                    'path'            => $path,
                    'original_name'   => $file->getClientOriginalName(),
                    'mime'            => $file->getClientMimeType(),
                    'size'            => $file->getSize(),
                    'caption'         => null,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Dokumentasi berhasil diunggah.');
    }

    public function updateSaluran(Request $request, SaluranIrigasi $saluran_irigasi)
    {
        $validated = $request->validate([
            'desa' => 'required|string|max:255',
            'hirarki' => 'nullable|string|max:255',
            'tipe_saluran' => 'nullable|string|max:255',
            'kondisi' => 'nullable|string|max:255',
            'panjang_m' => 'nullable|numeric',
            'lebar_m' => 'nullable|numeric',
            'kedalaman_m' => 'nullable|numeric',
            'masalah' => 'nullable|string',
            'link_dokumentasi' => 'nullable|url',
        ]);

        $saluran_irigasi->update($validated);

        return redirect()
            ->back()
            ->with('success', 'Data Saluran Irigasi berhasil diperbarui.');
    }

    public function updateBangunan(Request $request, BangunanAir $bangunan_air)
    {
        $validated = $request->validate([
            'desa' => 'required|string|max:255',
            'jenis_bangunan' => 'nullable|string|max:255',
            'tipe_ukur_debit' => 'nullable|string|max:255',
            'kondisi' => 'nullable|string|max:255',
            'lebar_m' => 'nullable|numeric',
            'kedalaman_m' => 'nullable|numeric',
            'jumlah_pintu' => 'nullable|integer',
            'masalah' => 'nullable|string',
        ]);

        $bangunan_air->update($validated);

        return redirect()
            ->back()
            ->with('success', 'Data Bangunan Air berhasil diperbarui.');
    }
}
