@extends('layouts.admin')

@section('title', 'Buat Artikel Baru')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Buat Artikel Baru</h1>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.article.store') }}" method="POST" enctype="multipart/form-data" x-data="articleForm()">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Judul Artikel</label>
                    <input type="text" id="title" name="title" x-model="title" @input.debounce.500="generateSlug" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Masukkan judul artikel" required>
                </div>

                <!-- Slug -->
                <div>
                    <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
                    <input type="text" id="slug" name="slug" x-model="slug" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Slug akan otomatis dibuat" required>
                </div>

                <!-- Content Editor -->
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700">Konten</label>
                    <textarea id="content" name="content" rows="12" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Tulis konten artikel..." required></textarea>
                </div>

                <!-- Excerpt -->
                <div>
                    <label for="excerpt" class="block text-sm font-medium text-gray-700">Ringkasan (Excerpt)</label>
                    <textarea id="excerpt" name="excerpt" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Ringkasan artikel untuk SEO"></textarea>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-6">
                <!-- Image Upload -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Gambar Artikel</label>
                    <div class="mt-1 flex items-center">
                        <input type="file" name="image" @change="previewImage" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                    <template x-if="imagePreview">
                        <img :src="imagePreview" class="mt-3 rounded border max-h-64 object-cover">
                    </template>
                </div>

                <!-- Image Alt -->
                <div>
                    <label for="image_alt" class="block text-sm font-medium text-gray-700">Alt Text Gambar</label>
                    <input type="text" id="image_alt" name="image_alt" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Deskripsi gambar">
                </div>

                <!-- Categories -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Kategori</label>
                    <select name="categories[]" multiple class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-400 mt-1">Tekan Ctrl / Cmd untuk memilih lebih dari satu</p>
                </div>

                <!-- Tags -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tags</label>
                    <select name="tags[]" multiple class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @foreach($tags as $tag)
                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-400 mt-1">Tekan Ctrl / Cmd untuk memilih lebih dari satu</p>
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status Artikel</label>
                    <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="draft">Draft</option>
                        <option value="published">Published</option>
                        <option value="archived">Archived</option>
                    </select>
                </div>

                <!-- SEO Meta -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">SEO Meta</label>
                    <input type="text" name="meta_title" placeholder="Meta Title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <textarea name="meta_description" rows="3" placeholder="Meta Description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Simpan Artikel
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function articleForm() {
    return {
        title: '',
        slug: '',
        imagePreview: null,
        generateSlug() {
            if(this.title.length > 0){
                fetch("{{ route('admin.article.generate-slug') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({title: this.title})
                })
                .then(res => res.json())
                .then(data => {
                    this.slug = data.slug;
                });
            }
        },
        previewImage(event) {
            const file = event.target.files[0];
            if(file){
                const reader = new FileReader();
                reader.onload = e => this.imagePreview = e.target.result;
                reader.readAsDataURL(file);
            }
        }
    }
}
</script>
@endsection
