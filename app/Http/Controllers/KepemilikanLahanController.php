<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KepemilikanLahan;

class KepemilikanLahanController extends Controller
{
    public function geojson()
    {
        $kepemilikanLahan = KepemilikanLahan::with('kecamatan', 'lokasiAgropolitan')->get();

        $features = $kepemilikanLahan->map(function ($lahan) {
            return [
                'type' => 'Feature',
                'geometry' => $lahan->geometri,
                'properties' => [
                    'id' => $lahan->id,
                    'nama_pemilik' => $lahan->nama_pemilik,
                    'kecamatan' => $lahan->kecamatan->name ?? 'N/A',
                    'lokasi_agropolitan' => $lahan->lokasiAgropolitan->name ?? 'N/A',
                ]
            ];
        });

        $featureCollection = [
            'type' => 'FeatureCollection',
            'features' => $features
        ];

        return response()->json($featureCollection);
    }

    public function update(Request $request, $id)
    {
        $lahan = KepemilikanLahan::findOrFail($id);
        $lahan->update($request->only(['nama_pemilik', 'keterangan']));

        return redirect()->route('lokasi-agropolitan.detail', $lahan->lokasi_agropolitan_id)
            ->with('success', 'Data kepemilikan lahan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $lahan = KepemilikanLahan::findOrFail($id);
        $lahan->delete();

        return redirect()->route('lokasi-agropolitan.detail', $lahan->lokasi_agropolitan_id)
            ->with('success', 'Data kepemilikan lahan berhasil dihapus.');
    }
}
