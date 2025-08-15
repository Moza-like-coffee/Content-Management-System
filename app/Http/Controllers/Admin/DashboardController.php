<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalArticles' => Article::count(),
            'publishedArticles' => Article::where('status', 'published')->count(),
            'draftArticles' => Article::where('status', 'draft')->count(),
            'archivedArticles' => Article::where('status', 'archived')->count(),
            'recentArticles' => Article::with('author')
                ->latest()
                ->take(5)
                ->get()
        ]);
    }
}