<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
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

    protected function getFilteredArticles()
    {
        return Article::with(['categories', 'author'])
            ->when(request('search'), function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('content', 'like', "%{$search}%");
                });
            })
            ->when(request('status'), function ($query, $status) {
                if (in_array($status, $this->statuses)) {
                    $query->where('status', $status);
                }
            })
            ->when(request('category'), function ($query, $categorySlug) {
                $query->whereHas('categories', function ($q) use ($categorySlug) {
                    $q->where('slug', $categorySlug);
                });
            })
            ->when(request('author'), function ($query, $username) {
                $query->whereHas('author', function ($q) use ($username) {
                    $q->where('username', $username);
                });
            })
            ->latest()
            ->paginate($this->perPage)
            ->withQueryString();
    }

    protected function getCurrentFilters()
    {
        return [
            'search' => request('search'),
            'status' => request('status'),
            'category' => request('category'),
            'author' => request('author')
        ];
    }

    public function create()
    {
        return view('admin.article.create', [
            'categories' => Category::all(),
            'tags' => Tag::all(),
            'statuses' => $this->statuses
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateArticleRequest($request);
        $imagePath = $this->handleImageUpload($request);

        $article = $this->createArticle($validated, $imagePath);
        $this->syncRelationships($article, $validated);

        return $this->redirectAfterStore($article, $validated['status']);
    }

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

    public function update(Request $request, Article $article)
    {
        $validated = $this->validateArticleRequest($request, $article);
        $imagePath = $this->handleImageUpload($request, $article);

        $this->updateArticle($article, $validated, $imagePath);
        $this->syncRelationships($article, $validated);

        return redirect()->route('admin.article.edit', $article)
            ->with('success', 'Article updated successfully');
    }

    public function destroy(Article $article)
    {
        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }
        $article->delete();

        return redirect()->route('admin.article.index')
            ->with('success', 'Article deleted successfully');
    }

    // ==========================
    // Validation & Helpers
    // ==========================

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

    protected function storeImage($image)
    {
        $filename = 'article_' . time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
        return $image->storeAs('articles', $filename, 'public');
    }

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

    protected function syncRelationships(Article $article, array $data)
    {
        if (isset($data['categories'])) {
            $article->categories()->sync($data['categories']);
        }

        if (isset($data['tags'])) {
            $article->tags()->sync($data['tags']);
        }
    }

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

    public function generateSlug(Request $request)
    {
        $request->validate(['title' => 'required|string']);
        $slug = Str::slug($request->title);
        $count = Article::where('slug', 'like', "{$slug}%")->count();

        return response()->json(['slug' => $count ? "{$slug}-{$count}" : $slug]);
    }

    public function uploadImage(Request $request)
    {
        $request->validate(['image' => 'required|image|max:2048|mimes:jpeg,png,jpg,gif'] );
        $path = $this->storeImage($request->file('image'));

        return response()->json(['url' => Storage::disk('public')->url($path)]);
    }

    public function bulkActions(Request $request)
    {
        $validated = $request->validate([
            'action' => 'required|in:delete,publish,archive',
            'ids' => 'required|array',
            'ids.*' => 'exists:articles,id'
        ]);

        $count = $this->processBulkAction($validated['action'], $validated['ids']);

        return redirect()->back()
            ->with('success', $this->getBulkActionMessage($validated['action'], $count));
    }

    protected function processBulkAction($action, $ids)
    {
        switch ($action) {
            case 'delete': return $this->deleteArticles($ids);
            case 'publish': return $this->publishArticles($ids);
            case 'archive': return $this->archiveArticles($ids);
        }
    }

    protected function deleteArticles($ids)
    {
        $articles = Article::whereIn('id', $ids)->get();
        $articles->each(function ($article) {
            if ($article->image) Storage::disk('public')->delete($article->image);
            $article->delete();
        });
        return count($ids);
    }

    protected function publishArticles($ids)
    {
        return Article::whereIn('id', $ids)->update(['status' => 'published', 'published_at' => now()]);
    }

    protected function archiveArticles($ids)
    {
        return Article::whereIn('id', $ids)->update(['status' => 'archived']);
    }

    protected function getBulkActionMessage($action, $count)
    {
        $messages = [
            'delete' => "$count articles deleted successfully",
            'publish' => "$count articles published successfully",
            'archive' => "$count articles archived successfully"
        ];
        return $messages[$action] ?? 'Action completed successfully';
    }

    // ==========================
    // Dashboard for Admin
    // ==========================
    public function dashboard(Request $request)
    {
        $query = Article::query();

        if ($request->filled('status') && in_array($request->status, $this->statuses)) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $totalArticles     = Article::count();
        $publishedArticles = Article::where('status', 'published')->count();
        $draftArticles     = Article::where('status', 'draft')->count();
        $archivedArticles  = Article::where('status', 'archived')->count();

        $recentArticles = $query->latest()->take(10)->get();

        return view('admin.dashboard', compact(
            'totalArticles',
            'publishedArticles',
            'draftArticles',
            'archivedArticles',
            'recentArticles'
        ));
    }
}
