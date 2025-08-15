@extends('layouts.admin')

@section('title', 'Daftar Artikel')
@section('header', 'Daftar Artikel')

@section('content')
<div class="bg-white p-6 rounded shadow">
    <a href="{{ route('admin.article.create') }}" class="mb-4 inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Buat Artikel Baru</a>

    <table class="min-w-full border border-gray-200">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 border">#</th>
                <th class="p-2 border">Judul</th>
                <th class="p-2 border">Penulis</th>
                <th class="p-2 border">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($articles as $article)
            <tr>
                <td class="p-2 border">{{ $loop->iteration }}</td>
                <td class="p-2 border">{{ $article->title }}</td>
                <td class="p-2 border">{{ $article->user->name }}</td>
                <td class="p-2 border flex gap-2">
                    <a href="{{ route('admin.article.edit', $article) }}" class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">Edit</a>
                    <form action="{{ route('admin.article.destroy', $article) }}" method="POST" onsubmit="return confirm('Yakin ingin dihapus?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $articles->links() }}
    </div>
</div>
@endsection
