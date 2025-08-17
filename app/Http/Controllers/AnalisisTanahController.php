<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnalisisTanah;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AnalisisTanahController extends Controller
{

    public function update(Request $request, AnalisisTanah $analisisTanah)
    {
        $validatedData = $request->validate([
            'tekstur'               => 'nullable|string|max:100',
            'ph'                    => 'nullable|numeric',
            'c_organik'             => 'nullable|numeric',
            'n_total'               => 'nullable|numeric',
            'p_potensial'           => 'nullable|numeric',
            'k_potensial'           => 'nullable|numeric',
            'ktk'                   => 'nullable|numeric',
            'kejenuhan_basa'        => 'nullable|numeric',
            'kesesuaian_aktual'     => 'nullable|string|max:100',
            'faktor_pembatas'       => 'nullable|string',
            'kesesuaian_potensial'  => 'nullable|string|max:100',
        ]);

        $analisisTanah->update($validatedData);

        return redirect()->route('lokasi-agropolitan.detail', $analisisTanah->lokasi_agropolitan_id)
            ->with('success', 'Data Analisis Tanah berhasil diperbarui.');
    }

    public function storeMedia(Request $request, AnalisisTanah $analisis)
    {
        $request->validate([
            'images.*'   => ['required', 'image', 'max:5120'],
            'captions.*' => ['nullable', 'string', 'max:255'],
        ]);

        foreach ($request->file('images', []) as $i => $file) {
            $dir = "analisis_tanah/{$analisis->id}";
            $filename = Str::uuid() . '.' . $file->extension();

            $path = $file->storeAs($dir, $filename, 'cp_public');

            $analisis->media()->create([
                'path'          => $path,
                'original_name' => $file->getClientOriginalName(),
                'mime'          => $file->getClientMimeType(),
                'size'          => $file->getSize(),
                'caption'       => $request->captions[$i] ?? null,
            ]);
        }

        return back()->with('status', 'Gambar disimpan');
    }

    public function destroyMedia(AnalisisTanah $analisis, Media $media)
    {
        abort_unless($media->model()->is($analisis), 404);

        Storage::disk('cp_public')->delete($media->path);
        $media->delete();

        return back()->with('status', 'Gambar dihapus');
    }
}
