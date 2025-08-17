<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function update(Request $request, Media $media)
    {
        $request->validate([
            'caption' => 'nullable|string|max:255',
        ]);

        $media->update([
            'caption' => $request->caption,
        ]);

        return redirect()->back()->with('success', 'Keterangan gambar berhasil diperbarui.');
    }

    public function destroy(Media $media)
    {
        Storage::disk('cp_public')->delete($media->path);

        $media->delete();

        return redirect()->back()->with('success', 'Dokumentasi berhasil dihapus.');
    }
}
