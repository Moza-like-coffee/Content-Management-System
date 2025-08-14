<?php

namespace App\Http\Controllers;

use App\Models\Gallery;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::with('images')->latest()->paginate(12);
        return view('galleries.index', compact('galleries'));
    }

    public function show(Gallery $gallery)
    {
        $gallery->load('images');
        return view('galleries.show', compact('gallery'));
    }
}
