<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MediaController extends Controller
{
    // GET /api/media
    public function index(): JsonResponse
    {
        return response()->json(Media::orderBy('created_at', 'desc')->get());
    }

    // POST /api/media/upload
    public function upload(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $file     = $request->file('file');
        $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();

        // Save to storage/app/public/media
        $file->storeAs('media', $filename, 'public');

        $media = Media::create([
            'filename'      => $filename,
            'original_name' => $file->getClientOriginalName(),
            'url'           => asset('storage/media/' . $filename),
            'mime_type'     => $file->getMimeType(),
            'size'          => $file->getSize(),
        ]);

        return response()->json($media, 201);
    }

    // DELETE /api/media/{id}
    public function destroy(Media $media): JsonResponse
    {
        // Delete file from disk
        $path = storage_path('app/public/media/' . $media->filename);
        if (file_exists($path)) unlink($path);

        $media->delete();
        return response()->json(['message' => 'deleted']);
    }
}
