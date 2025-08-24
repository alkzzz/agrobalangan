<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LokasiAgropolitan;
use Illuminate\Support\Str;

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
        $lokasi = LokasiAgropolitan::with(['kecamatan', 'kepemilikanLahan', 'analisisTanah', 'saluranIrigasi'])->findOrFail($id);

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

        return view('lokasi_agropolitan.detail', [
            'lokasi'             => $lokasi,
            'geoJsonData'        => $geoJsonData,
            'kepemilikanGeoJson' => $kepemilikanGeoJson,
            'kepemilikanList'    => $kepemilikanList,
            'analisisTanah'      => $lokasi->analisisTanah,
            'saluranList'        => $lokasi->saluranIrigasi,
            'saluranGeoJson'     => $saluranGeoJson,
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
}
