@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-4">Articles</h1>

    @if(isset($query) && $query)
        <p class="mb-4 text-gray-600">Search results for: <strong>{{ $query }}</strong></p>
    @endif

    @if($articles->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($articles as $article)
                <div class="p-4 border rounded shadow-sm hover:shadow-md transition">
                    <h2 class="font-semibold text-lg">{{ $article->title }}</h2>
                    <p class="text-gray-700 mt-2">{{ Str::limit($article->content, 100) }}</p>
                    <a href="{{ route('article.index', $article->id) }}" class="text-blue-600 mt-2 inline-block">Read more</a>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $articles->appends(request()->query())->links() }}
        </div>
    @else
        <p>No articles found.</p>
    @endif
</div>
@endsection
