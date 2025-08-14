@extends('layouts.app')
@section('title','Galleries')
@section('content')
<h1 class="text-2xl font-bold mb-4">Galleries</h1>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
  @foreach($galleries as $gallery)
    <div class="bg-white rounded shadow overflow-hidden">
      @if($gallery->images->first())
        <a href="{{ route('galleries.show', $gallery->slug) }}">
          <img src="{{ Storage::url($gallery->images->first()->thumb_path ?? $gallery->images->first()->path) }}" alt="{{ $gallery->title }}" class="w-full h-40 object-cover">
        </a>
      @endif
      <div class="p-3">
        <h3 class="font-semibold"><a href="{{ route('galleries.show', $gallery->slug) }}">{{ $gallery->title }}</a></h3>
        <p class="text-sm text-gray-600">{{ Str::limit($gallery->description, 80) }}</p>
      </div>
    </div>
  @endforeach
</div>

<div class="mt-6">
  {{ $galleries->links() }}
</div>
@endsection
