<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login Panel</title>
  @vite('resources/css/app.css')
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-[#0e0e1f] min-h-screen flex items-center justify-center font-poppins text-gray-100">

  <!-- Floating subtle elements -->
  <div class="absolute top-0 left-1/2 -translate-x-1/2 w-64 h-64 rounded-full bg-indigo-700/20 blur-3xl animate-pulse-slow pointer-events-none"></div>
  <div class="absolute bottom-0 right-1/3 w-72 h-72 rounded-full bg-purple-600/20 blur-3xl animate-pulse-slow pointer-events-none"></div>

  <div class="relative z-10 w-full max-w-sm p-8 bg-[#1c1c38]/80 border border-gray-700 rounded-2xl shadow-xl backdrop-blur-md">
    <div class="text-center mb-6">
      <h1 class="text-3xl font-bold text-white">Sign In</h1>
      <p class="text-gray-400 text-sm mt-1">Login to access your account</p>
    </div>

    @error('email')
      <div class="mb-4 p-3 bg-red-900/50 border border-red-600 rounded-md text-red-200 text-sm">
        {{ $message }}
      </div>
    @enderror

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
      @csrf
      <div>
        <label for="email" class="block text-sm mb-1">Email</label>
        <input
          type="email"
          id="email"
          name="email"
          placeholder="Enter Your Email"
          required
          class="w-full px-4 py-3 rounded-lg bg-[#2a2a4d]/70 border border-gray-600 text-gray-100 placeholder-gray-400 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none transition"
        >
      </div>

      <div>
        <label for="password" class="block text-sm mb-1">Password</label>
        <input
          type="password"
          id="password"
          name="password"
          placeholder="********"
          required
          class="w-full px-4 py-3 rounded-lg bg-[#2a2a4d]/70 border border-gray-600 text-gray-100 placeholder-gray-400 focus:border-indigo-400 focus:ring-1 focus:ring-indigo-400 outline-none transition"
        >
      </div>

      <div class="flex items-center text-gray-400 text-sm">
        <input type="checkbox" id="remember" name="remember" class="h-4 w-4 rounded border-gray-600 bg-gray-800 focus:ring-indigo-400">
        <label for="remember" class="ml-2">Remember me</label>
      </div>

      <button type="submit" class="w-full py-3 mt-3 rounded-lg font-bold text-[#0e0e1f] bg-gradient-to-r from-purple-500 to-indigo-500 hover:scale-105 transform transition duration-300">
        Login
      </button>
    </form>
{{-- 
    <p class="text-xs text-gray-400 text-center mt-4">
      Forgot password? <a href="#" class="text-indigo-400 hover:underline">Reset here</a>
    </p> --}}
  </div>

</body>
</html>
