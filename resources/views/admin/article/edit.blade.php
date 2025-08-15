@extends('layouts.admin')

@section('title', 'Edit Artikel')
@section('header', 'Edit Artikel')

@section('content')
<div class="bg-white p-6 rounded shadow max-w-3xl">
    <form action="{{ route('admin.article.update', $article) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block mb-1 font-semibold">Judul</label>
            <input type="text" name="title" value="{{ old('title', $article->title) }}" class="w-full p-2 border rounded" required>
        </div>

        <div>
            <label class="block mb-1 font-semibold">Konten</label>
            <textarea name="content" class="w-full p-2 border rounded h-40" required>{{ old('content', $article->content) }}</textarea>
        </div>

        <div>
            <label class="block mb-1 font-semibold">Gambar</label>
            <input type="file" name="image" class="w-full p-2 border rounded">
            @if($article->image)
                <img src="{{ asset('storage/'.$article->image) }}" class="mt-2 w-32 h-32 object-cover rounded">
            @endif
        </div>

        <div class="flex justify-between">
            <a href="{{ route('admin.article.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Kembali</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update</button>
        </div>
    </form>
</div>
@endsection
