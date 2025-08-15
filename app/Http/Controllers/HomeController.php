<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;
use App\Models\Article;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil data gallery terbaru
        $galleries = Gallery::with('images')->latest()->take(6)->get();

        // Ambil artikel terbaru
        $articles = Article::latest()->take(5)->get();

        return view('home', compact('galleries', 'articles'));
    }

    public function showArticle($id)
    {
        $article = Article::findOrFail($id);
        return view('article.show', compact('article'));
    }

    public function showGallery($id)
    {
        $gallery = Gallery::with('images')->findOrFail($id);
        return view('gallery.show', compact('gallery'));
    }

    public function article(Request $request)
    {
        $query = $request->input('query');

        $articles = \App\Models\Article::query()
            ->when($query, function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                    ->orWhere('content', 'like', "%{$query}%");
            })
            ->latest()
            ->paginate(10);

        return view('article.index', compact('articles', 'query'));
    }
}
