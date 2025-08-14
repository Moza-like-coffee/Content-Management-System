@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-4">{{ $gallery->title }}</h1>
<p class="mb-6">{{ $gallery->description }}</p>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
  @foreach($gallery->images as $img)
    <div>
      <button type="button" data-modal-toggle="image-modal-{{ $img->id }}">
        <img src="{{ Storage::url($img->thumb_path ?? $img->path) }}" alt="" class="w-full h-36 object-cover rounded">
      </button>

      <!-- Flowbite modal -->
      <div id="image-modal-{{ $img->id }}" tabindex="-1" class="hidden overflow-y-auto fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-4xl h-full md:h-auto">
          <div class="relative bg-white rounded-lg shadow">
            <button type="button" class="absolute top-3 right-2.5 text-gray-400" data-modal-toggle="image-modal-{{ $img->id }}">
              ✕
            </button>
            <div class="p-6">
              <img src="{{ Storage::url($img->path) }}" alt="{{ $img->caption }}" class="w-full h-auto rounded">
              @if($img->caption)
                <p class="mt-2 text-sm text-gray-600">{{ $img->caption }}</p>
              @endif
            </div>
          </div>
        </div>
      </div>
      <!-- end modal -->
    </div>
  @endforeach
</div>
@endsection
