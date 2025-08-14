<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class GalleryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'is_admin']);
    }

    public function index()
    {
        $galleries = Gallery::latest()->paginate(10);
        return view('admin.galleries.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.galleries.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:5120'
        ]);

        $gallery = Gallery::create([
            'title' => $data['title'],
            'slug' => Str::slug($data['title']) . '-' . Str::random(6),
            'description' => $data['description'] ?? null,
            'user_id' => auth()->id()
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('galleries', 'public');

                $img = Image::make($file->getRealPath());
                $img->fit(1200, 800, function ($constraint) {
                    $constraint->upsize();
                });
                Storage::disk('public')->put($path, (string) $img->encode());

                $thumbName = 'galleries/thumbs/' . basename($path);
                $thumb = Image::make($file->getRealPath())->resize(400, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                Storage::disk('public')->put($thumbName, (string) $thumb->encode());

                $gallery->images()->create([
                    'path' => $path,
                    'thumb_path' => $thumbName
                ]);
            }
        }

        return redirect()->route('admin.galleries.index')->with('success', 'Gallery berhasil dibuat.');
    }

    public function show(Gallery $gallery)
    {
        $gallery->load('images');
        return view('admin.galleries.show', compact('gallery'));
    }

    public function edit(Gallery $gallery)
    {
        $gallery->load('images');
        return view('admin.galleries.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:5120'
        ]);

        $gallery->update([
            'title' => $data['title'],
            'slug' => Str::slug($data['title']) . '-' . Str::random(6),
            'description' => $data['description'] ?? null
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('galleries', 'public');

                $img = Image::make($file->getRealPath());
                $img->fit(1200, 800, function ($constraint) {
                    $constraint->upsize();
                });
                Storage::disk('public')->put($path, (string) $img->encode());

                $thumbName = 'galleries/thumbs/' . basename($path);
                $thumb = Image::make($file->getRealPath())->resize(400, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                Storage::disk('public')->put($thumbName, (string) $thumb->encode());

                $gallery->images()->create([
                    'path' => $path,
                    'thumb_path' => $thumbName
                ]);
            }
        }

        return redirect()->route('admin.galleries.index')->with('success', 'Gallery berhasil diperbarui.');
    }

    public function destroy(Gallery $gallery)
    {
        foreach ($gallery->images as $img) {
            Storage::disk('public')->delete([$img->path, $img->thumb_path]);
        }
        $gallery->delete();

        return redirect()->route('admin.galleries.index')->with('success', 'Gallery berhasil dihapus.');
    }

    public function deleteImage(GalleryImage $image)
    {
        Storage::disk('public')->delete([$image->path, $image->thumb_path]);
        $image->delete();

        return back()->with('success', 'Gambar berhasil dihapus.');
    }
}
