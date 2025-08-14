<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }}</title>
    
    {{-- Tailwind CSS --}}
    @vite('resources/css/app.css')


</head>
<body class="h-full antialiased text-gray-900">

   

    <!-- Main Content -->
    <main>
        {{ $slot }}
    </main>

    <!-- Footer -->
   
</body>
</html>
