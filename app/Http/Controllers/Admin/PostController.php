<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'is_admin']);
    }

    public function index()
    {
        $posts = Post::latest()->paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'body' => 'nullable|string',
            'featured_image' => 'nullable|image|max:5120'
        ]);

        $path = null;
        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('posts', 'public');
        }

        Post::create([
            'title' => $data['title'],
            'slug' => Str::slug($data['title']) . '-' . Str::random(6),
            'excerpt' => $data['excerpt'] ?? null,
            'body' => $data['body'] ?? null,
            'featured_image' => $path,
            'user_id' => auth()->id(),
            'published_at' => now()
        ]);

        return redirect()->route('admin.posts.index')->with('success', 'Post berhasil dibuat.');
    }

    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'body' => 'nullable|string',
            'featured_image' => 'nullable|image|max:5120'
        ]);

        if ($request->hasFile('featured_image')) {
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')->store('posts', 'public');
        }

        $data['slug'] = Str::slug($data['title']) . '-' . Str::random(6);

        $post->update($data);

        return redirect()->route('admin.posts.index')->with('success', 'Post berhasil diperbarui.');
    }

    public function destroy(Post $post)
    {
        if ($post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
        }
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Post berhasil dihapus.');
    }
}
