@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Hero Section -->
    <section class="mb-12">
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl p-8 text-white">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Selamat Datang </h1>
            <p class="text-xl mb-6">Temukan koleksi galeri dan artikel terbaru kami</p>
            <div class="flex space-x-4">
                <a href="#galleries" class="bg-white text-blue-600 px-6 py-2 rounded-lg font-medium hover:bg-blue-50 transition">Lihat Galeri</a>
                <a href="#articles" class="border-2 border-white px-6 py-2 rounded-lg font-medium hover:bg-white hover:bg-opacity-20 transition">Baca Artikel</a>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section id="galleries" class="mb-16">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-gray-800">Galeri Terbaru</h2>
            <a href="#" class="text-blue-600 hover:underline flex items-center">
                Lihat Semua <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($galleries as $gallery)
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <a href="{{ route('gallery.show', $gallery->id) }}" class="block">
                    @if($gallery->images->first())
                    <div class="relative h-48 overflow-hidden">
                        <img src="{{ asset('storage/' . $gallery->images->first()->image_path) }}" 
                             class="w-full h-full object-cover transition-transform duration-500 hover:scale-110"
                             alt="{{ $gallery->title }}">
                        <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent opacity-0 hover:opacity-70 transition-opacity duration-300 flex items-end p-4">
                            <span class="text-white font-medium">Lihat Detail</span>
                        </div>
                    </div>
                    @else
                    <div class="h-48 bg-gray-100 flex items-center justify-center text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    @endif
                    <div class="p-4">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $gallery->title }}</h3>
                        <p class="text-gray-600 text-sm">{{ $gallery->created_at->diffForHumans() }}</p>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Articles Section -->
    <section id="articles" class="mb-12">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-gray-800">Artikel Terbaru</h2>
            <a href="#" class="text-blue-600 hover:underline flex items-center">
                Lihat Semua <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @foreach($articles as $article)
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-xl font-bold text-gray-800">
                            <a href="{{ route('article.show', $article->id) }}" class="hover:text-blue-600 transition">
                                {{ $article->title }}
                            </a>
                        </h3>
                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">{{ $article->category->name ?? 'Umum' }}</span>
                    </div>
                    <p class="text-gray-600 mb-4 line-clamp-2">{{ Str::limit(strip_tags($article->content), 150) }}</p>
                    <div class="flex justify-between items-center text-sm text-gray-500">
                        <span>Oleh: {{ $article->user->name }}</span>
                        <span>{{ $article->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-gray-50 rounded-2xl p-8 text-center">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Ingin melihat lebih banyak konten?</h2>
        <p class="text-gray-600 mb-6 max-w-2xl mx-auto">Jelajahi koleksi lengkap galeri foto dan artikel menarik kami.</p>
        <a href="#" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition mr-4">Lihat Semua Galeri</a>
        <a href="#" class="inline-block border-2 border-blue-600 text-blue-600 px-6 py-3 rounded-lg font-medium hover:bg-blue-50 transition">Baca Semua Artikel</a>
    </section>
</div>
@endsection