<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ArticleController extends Controller
{
    protected $perPage = 15;
    protected $statuses = ['draft', 'published', 'archived'];

    public function __construct()
    {
        $this->middleware(['auth', 'is_admin']);
    }

    // ==========================
    // CRUD + Filter Methods
    // ==========================
    /**
     * Display a listing of articles with filters
     */
    public function index()
    {
        $articles = $this->getFilteredArticles();

        return view('admin.article.index', [
            'articles' => $articles,
            'categories' => Category::all(),
            'statuses' => $this->statuses,
            'filters' => $this->getCurrentFilters()
        ]);
    }

    /**
     * Get filtered articles based on request parameters
     */
    protected function getFilteredArticles()
    {
        $query = Article::with(['categories', 'author'])
            ->when(request('search'), function ($q, $search) {
                $q->where(function ($q2) use ($search) {
                    $q2->where('title', 'like', "%{$search}%")
                       ->orWhere('content', 'like', "%{$search}%");
        return Article::with(['categories', 'author'])
            ->when(request('search'), function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('content', 'like', "%{$search}%");
                });
            })
            ->when(request('status'), function ($q, $status) {
                if (in_array($status, $this->statuses)) {
                    $q->where('status', $status);
                }
            })
            ->when(request('category'), function ($q, $slug) {
                $q->whereHas('categories', function ($q2) use ($slug) {
                    $q2->where('slug', $slug);
                });
            })
            ->when(request('author'), function ($q, $username) {
                $q->whereHas('author', function ($q2) use ($username) {
                    $q2->where('username', $username);
                });
            })
            ->latest();

        // Safe for all Laravel versions
        return $query->paginate($this->perPage)->appends(request()->query());
    }

    /**
     * Get current filter values from request
     */
    protected function getCurrentFilters()
    {
        return [
            'search' => request('search'),
            'status' => request('status'),
            'category' => request('category'),
            'author' => request('author')
        ];
    }

    /**
     * Show the form for creating a new article
     */
    public function create()
    {
        return view('admin.article.create', [
            'categories' => Category::all(),
            'tags' => Tag::all(),
            'statuses' => $this->statuses
        ]);
    }

    /**
     * Store a newly created article
     */
    public function store(Request $request)
    {
        $validated = $this->validateArticleRequest($request);
        $imagePath = $this->handleImageUpload($request);

        $article = $this->createArticle($validated, $imagePath);
        $this->syncRelationships($article, $validated);

        return $this->redirectAfterStore($article, $validated['status']);
    }

    /**
     * Show the form for editing an article
     */
    public function edit(Article $article)
    {
        return view('admin.article.edit', [
            'article' => $article,
            'categories' => Category::all(),
            'tags' => Tag::all(),
            'statuses' => $this->statuses,
            'selectedCategories' => $article->categories->pluck('id')->toArray(),
            'selectedTags' => $article->tags->pluck('id')->toArray()
        ]);
    }

    /**
     * Update an existing article
     */
    public function update(Request $request, Article $article)
    {
        $validated = $this->validateArticleRequest($request, $article);
        $imagePath = $this->handleImageUpload($request, $article);

        $this->updateArticle($article, $validated, $imagePath);
        $this->syncRelationships($article, $validated);

        return redirect()->route('admin.article.edit', $article)
            ->with('success', 'Article updated successfully');
    }

    /**
     * Delete an article
     */
    public function destroy(Article $article)
    {
        Storage::disk('public')->delete($article->image);
        $article->delete();

        return redirect()->route('admin.article.index')
            ->with('success', 'Article deleted successfully');
    }

    // ==========================
    // Validation & Helpers
    // ==========================
    /**
     * Validate article request data
     */
    protected function validateArticleRequest(Request $request, Article $article = null)
    {
        $rules = [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'excerpt' => ['nullable', 'string', 'max:300'],
            'status' => ['required', 'in:draft,published,archived'],
            'image' => ['nullable', 'image', 'max:5120', 'mimes:jpeg,png,jpg,gif,webp'],
            'image_alt' => ['nullable', 'string', 'max:255'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:300'],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['exists:categories,id'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['exists:tags,id'],
        ];

        if ($article) {
            $rules['title'][] = Rule::unique('articles')->ignore($article->id);
            $rules['slug'][] = Rule::unique('articles')->ignore($article->id);
        } else {
            $rules['title'][] = 'unique:articles';
            $rules['slug'][] = 'unique:articles';
        }

        return $request->validate($rules);
    }

    /**
     * Handle image upload
     */
    protected function handleImageUpload(Request $request, Article $article = null)
    {
        if (!$request->hasFile('image')) {
            return $article->image ?? null;
        }

        if ($article && $article->image) {
            Storage::disk('public')->delete($article->image);
        }

        return $this->storeImage($request->file('image'));
    }

    /**
     * Store image file
     */
    protected function storeImage($image)
    {
        $filename = 'article_' . time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
        return $image->storeAs('articles', $filename, 'public');
    }

    /**
     * Create new article record
     */
    protected function createArticle(array $data, $imagePath)
    {
        return Article::create([
            'title' => $data['title'],
            'slug' => $data['slug'] ?? Str::slug($data['title']),
            'content' => $data['content'],
            'excerpt' => $data['excerpt'] ?? Str::limit(strip_tags($data['content']), 200),
            'status' => $data['status'],
            'image' => $imagePath,
            'image_alt' => $data['image_alt'] ?? null,
            'meta_title' => $data['meta_title'] ?? $data['title'],
            'meta_description' => $data['meta_description'] ?? Str::limit(strip_tags($data['content']), 160),
            'user_id' => auth()->id(),
            'published_at' => $data['status'] === 'published' ? now() : null,
        ]);
    }

    /**
     * Update existing article
     */
    protected function updateArticle(Article $article, array $data, $imagePath)
    {
        $updateData = [
            'title' => $data['title'],
            'slug' => $data['slug'] ?? $article->slug,
            'content' => $data['content'],
            'excerpt' => $data['excerpt'] ?? Str::limit(strip_tags($data['content']), 200),
            'status' => $data['status'],
            'image' => $imagePath,
            'image_alt' => $data['image_alt'] ?? $article->image_alt,
            'meta_title' => $data['meta_title'] ?? $article->meta_title,
            'meta_description' => $data['meta_description'] ?? $article->meta_description,
        ];

        if ($article->status !== 'published' && $data['status'] === 'published') {
            $updateData['published_at'] = now();
        }

        $article->update($updateData);
    }

    /**
     * Sync article relationships
     */
    protected function syncRelationships(Article $article, array $data)
    {
        if (isset($data['categories'])) {
            $article->categories()->sync($data['categories']);
        }

        if (isset($data['tags'])) {
            $article->tags()->sync($data['tags']);
        }
    }

    /**
     * Determine redirect after store
     */
    protected function redirectAfterStore(Article $article, $status)
    {
        $route = $status === 'published' ? 'admin.article.index' : 'admin.article.edit';
        $message = $status === 'published' ? 'Article published successfully' : 'Article saved as draft';

        return redirect()->route($route, $article)
            ->with('success', $message);
    }

    // ==========================
    // Extra Features
    // ==========================
    /**
     * Generate slug from title
     */
    public function generateSlug(Request $request)
    {
        $request->validate(['title' => 'required|string']);

        $slug = Str::slug($request->title);
        $count = Article::where('slug', 'like', "{$slug}%")->count();

        return response()->json([
            'slug' => $count ? "{$slug}-{$count}" : $slug
        ]);
    }

    /**
     * Handle image upload from editor
     */
    public function uploadImage(Request $request)
    {
        $request->validate(['image' => 'required|image|max:2048|mimes:jpeg,png,jpg,gif']);
        $request->validate([
            'image' => 'required|image|max:2048|mimes:jpeg,png,jpg,gif'
        ]);

        $path = $this->storeImage($request->file('image'));

        return response()->json([
            'url' => Storage::disk('public')->url($path)
        ]);
    }

    /**
     * Handle bulk actions
     */
    public function bulkActions(Request $request)
    {
        $validated = $request->validate([
            'action' => 'required|in:delete,publish,archive',
            'ids' => 'required|array',
            'ids.*' => 'exists:articles,id'
        ]);

        $count = $this->processBulkAction(
            $validated['action'],
            $validated['ids']
        );

        return redirect()->back()
            ->with('success', $this->getBulkActionMessage($validated['action'], $count));
    }

    /**
     * Process bulk action
     */
    protected function processBulkAction($action, $ids)
    {
        switch ($action) {
            case 'delete':
                return $this->deleteArticles($ids);
            case 'publish':
                return $this->publishArticles($ids);
            case 'archive':
                return $this->archiveArticles($ids);
        }
    }

    /**
     * Delete multiple articles
     */
    protected function deleteArticles($ids)
    {
        $articles = Article::whereIn('id', $ids)->get();

        $articles->each(function ($article) {
            if ($article->image) {
                Storage::disk('public')->delete($article->image);
            }
            $article->delete();
        });

        return count($ids);
    }

    /**
     * Publish multiple articles
     */
    protected function publishArticles($ids)
    {
        return Article::whereIn('id', $ids)
            ->update([
                'status' => 'published',
                'published_at' => now()
            ]);
    }

    /**
     * Archive multiple articles
     */
    protected function archiveArticles($ids)
    {
        return Article::whereIn('id', $ids)
            ->update(['status' => 'archived']);
    }

    /**
     * Get bulk action success message
     */
    protected function getBulkActionMessage($action, $count)
    {
        $messages = [
            'delete' => "$count articles deleted successfully",
            'publish' => "$count articles published successfully",
            'archive' => "$count articles archived successfully"
        ];

        return $messages[$action] ?? 'Action completed successfully';
    }

    public function dashboard(Request $request)
{
    // Query dasar untuk filter
    $query = Article::query();

    // Filter status
    if ($request->filled('status') && in_array($request->status, ['published', 'draft', 'archived'])) {
        $query->where('status', $request->status);
    }

    // Filter tanggal dari
    if ($request->filled('date_from')) {
        $query->whereDate('created_at', '>=', $request->date_from);
    }

    // Filter tanggal sampai
    if ($request->filled('date_to')) {
        $query->whereDate('created_at', '<=', $request->date_to);
    }

        $articles = $query->latest()->paginate($this->perPage)->appends($request->query());
    // Statistik (tidak terfilter)
    $totalArticles     = Article::count();
    $publishedArticles = Article::where('status', 'published')->count();
    $draftArticles     = Article::where('status', 'draft')->count();
    $archivedArticles  = Article::where('status', 'archived')->count();

    // Artikel terbaru sesuai filter
    $recentArticles = $query->latest()->take(10)->get();

        return view('admin.dashboard', [
            'articles' => $articles,
            'statuses' => $this->statuses,
            'filters' => $request->only(['status', 'date_from', 'date_to'])
        ]);
    }
    return view('admin.dashboard', compact(
        'totalArticles',
        'publishedArticles',
        'draftArticles',
        'archivedArticles',
        'recentArticles'
    ));
}

}
