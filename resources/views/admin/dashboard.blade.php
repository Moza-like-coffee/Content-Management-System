@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('header', 'Article Dashboard')

@section('content')
    <div class="space-y-6">
        <!-- Stats Cards - Modern Glassmorphism Style -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Articles -->
            <div
                class="bg-white rounded-xl p-5 shadow-md hover:shadow-lg transition-all duration-200 border-l-4 border-blue-500">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Total Articles</h3>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalArticles }}</p>
                    </div>
                    <div class="p-2 rounded-lg bg-blue-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Published Articles -->
            <div
                class="bg-white rounded-xl p-5 shadow-md hover:shadow-lg transition-all duration-200 border-l-4 border-green-500">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Published</h3>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $publishedArticles }}</p>
                    </div>
                    <div class="p-2 rounded-lg bg-green-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Draft Articles -->
            <div
                class="bg-white rounded-xl p-5 shadow-md hover:shadow-lg transition-all duration-200 border-l-4 border-yellow-500">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Drafts</h3>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $draftArticles }}</p>
                    </div>
                    <div class="p-2 rounded-lg bg-yellow-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Archived Articles -->
            <div
                class="bg-white rounded-xl p-5 shadow-md hover:shadow-lg transition-all duration-200 border-l-4 border-gray-500">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Archived</h3>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $archivedArticles }}</p>
                    </div>
                    <div class="p-2 rounded-lg bg-gray-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>


        <!-- Filters - Modern Card with Gradient -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-5 rounded-2xl shadow-lg border border-white/30">
            <form method="GET" action="{{ route('admin.dashboard') }}"
                class="grid grid-cols-1 sm:grid-cols-4 gap-4 items-end">
                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Status</label>
                    <div class="relative">
                        <select name="status"
                            class="appearance-none block w-full px-4 py-2.5 text-sm bg-white/90 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                            <option value="">All Status</option>
                            <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published
                            </option>
                            <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="archived" {{ request('status') === 'archived' ? 'selected' : '' }}>Archived
                            </option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Date From -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">From Date</label>
                    <div class="relative">
                        <input type="date" name="date_from" value="{{ request('date_from') }}"
                            class="block w-full px-4 py-2.5 text-sm bg-white/90 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                    </div>
                </div>

                <!-- Date To -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">To Date</label>
                    <div class="relative">
                        <input type="date" name="date_to" value="{{ request('date_to') }}"
                            class="block w-full px-4 py-2.5 text-sm bg-white/90 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                    </div>
                </div>

                <!-- Submit -->
                <div>
                    <button type="submit"
                        class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-4 py-2.5 rounded-xl shadow-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Apply Filters
                    </button>
                </div>
            </form>
        </div>

        <!-- Recent Articles - Modern Table Design -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-white/30">
            <div
                class="px-6 py-4 border-b border-gray-200/50 flex justify-between items-center bg-gradient-to-r from-blue-50 to-indigo-50">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Recent Articles</h3>
                    <p class="text-sm text-gray-500 mt-1">Latest articles from your collection</p>
                </div>
                <a href="{{ route('admin.article.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-xl shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                    View All
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
            <div class="divide-y divide-gray-200/30">
                @forelse($recentArticles as $article)
                    <div class="px-6 py-4 hover:bg-gray-50/50 transition duration-150 ease-in-out">
                        <div class="flex items-start justify-between">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('admin.article.edit', $article) }}"
                                        class="text-lg font-semibold text-gray-900 hover:text-blue-600 truncate">
                                        {{ $article->title }}
                                    </a>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                @if ($article->status === 'published') bg-green-100 text-green-800
                                @elseif($article->status === 'draft') bg-yellow-100 text-yellow-800
                                @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($article->status) }}
                                    </span>
                                </div>
                                <p class="mt-1 text-sm text-gray-500">
                                    {{ Str::limit(strip_tags($article->excerpt), 120) }}
                                </p>
                                <div class="mt-2 flex items-center text-sm text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="flex-shrink-0 mr-1.5 h-4 w-4 text-gray-400" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span>
                                        {{ $article->created_at->format('M d, Y') }} •
                                        {{ $article->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                            <div class="ml-4 flex-shrink-0">
                                <a href="{{ route('admin.article.edit', $article) }}"
                                    class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                                    Edit
                                    <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 -mr-0.5 h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-12 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No articles found</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by creating a new article.</p>
                        <div class="mt-6">
                            <a href="{{ route('admin.article.create') }}"
                                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-xl text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                New Article
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
