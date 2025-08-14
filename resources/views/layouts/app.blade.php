<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title','CMS')</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800">
  <nav class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4">
      <div class="flex justify-between items-center h-16">
        <div class="flex items-center">
          <a href="{{ route('home') }}" class="text-xl font-bold">MyCMS</a>
        </div>
        <div class="flex items-center space-x-4">
          <a href="{{ route('galleries.index') }}" class="hover:underline">Gallery</a>
          <a href="#" class="hover:underline">Articles</a>
          @auth
            @if(auth()->user()->is_admin)
              <a href="{{ route('admin.galleries.index') }}" class="px-3 py-1 bg-blue-600 text-white rounded">Admin</a>
            @endif
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="ml-2">Logout</button>
            </form>
          @else
            <a href="{{ route('login') }}" class="ml-2">Login</a>
          @endauth
        </div>
      </div>
    </div>
  </nav>

  <main class="max-w-7xl mx-auto p-4">
    @if(session('success'))
      <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif
    @yield('content')
  </main>
</body>
</html>
