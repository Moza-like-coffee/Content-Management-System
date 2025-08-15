@php
    $theme = $theme ?? 'light';
    $user = $user ?? (object) [
        'name' => auth()->user()->name ?? 'Admin',
        'email' => auth()->user()->email ?? 'admin@example.com',
        'avatar' => 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name ?? 'Admin').'&background=0D8ABC&color=fff',
    ];
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    @vite('resources/css/app.css')
</head>
<body class="flex min-h-screen bg-gray-100 text-gray-900">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-lg min-h-screen p-4">
        <h1 class="text-2xl font-bold mb-8 ml-3 mt-3">Admin Panel</h1>
        <nav class="space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-lg hover:bg-gray-200 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-200' : '' }}">Dashboard</a>
            <a href="{{ route('admin.article.index') }}" class="block px-3 py-2 rounded-lg hover:bg-gray-200 {{ request()->routeIs('admin.article.*') ? 'bg-gray-200' : '' }}">Artikel</a>
            <a href="#" class="block px-3 py-2 rounded-lg hover:bg-gray-200">Users</a>
            <a href="#" class="block px-3 py-2 rounded-lg hover:bg-gray-200">Reports</a>
            <a href="#" class="block px-3 py-2 rounded-lg hover:bg-gray-200">Settings</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full text-left block px-3 py-2 rounded-lg hover:bg-gray-200">Logout</button>
            </form>
        </nav>
    </aside>

    <!-- Main content -->
    <main class="flex-1 p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold mb-3">@yield('header', 'Welcome, Admin')</h2>

            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-3 bg-gray-200 px-3 py-2 rounded-lg">
                    <img src="{{ $user->avatar }}" alt="Avatar" class="w-8 h-8 rounded-full border-2 border-white">
                    <div class="hidden sm:block">
                        <p class="text-sm font-medium">{{ $user->name }}</p>
                        <p class="text-xs text-gray-500">{{ $user->email }}</p>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>

</body>
</html>
