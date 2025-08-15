<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title', 'Medical Service')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-grey-50 text-grey-900 font-sans">
    <!-- Modern Navbar -->
    <div x-data="{ open: false, searchOpen: false, openUser: false }">
        <div class="fixed top-0 left-0 w-full bg-[#B2C6D5] px-0 md:px-0 py-4 z-50 shadow-md shadow-black/10">
            <div class="w-full mx-auto flex items-center justify-between px-4 md:px-8 max-w-none">
                <!-- Logo dengan animasi hover -->
                <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center space-x-2 group">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="MedicalCare Logo"
                        class="h-12 w-auto transition-transform duration-300 group-hover:scale-105">
                    <span
                        class="px-3 py-1 bg-white border-2 border-blue-500 rounded-full text-blue-600 font-normal text-sm uppercase tracking-wider shadow-sm transition-all duration-300 group-hover:bg-blue-50 group-hover:border-blue-600 group-hover:text-blue-700 group-hover:shadow-md">
                        Medical Service
                    </span>
                </a>

                <!-- Navigation -->
                <div class="flex items-center gap-4">
                    <!-- Desktop Navigation -->
                    <div class="hidden md:flex items-center gap-6 text-neutral-700">
                        <a href="{{ route('home') }}" class="relative text-lg font-normal py-2 px-1 group">
                            <span class="relative z-10">Home</span>
                            <span
                                class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                        </a>
                        <a href="{{ route('galleries.index') }}" class="relative text-lg font-normal py-2 px-1 group">
                            <span class="relative z-10">Gallery</span>
                            <span
                                class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                        </a>
                        <a href="#" class="relative text-lg font-normal py-2 px-1 group">
                            <span class="relative z-10">Articles</span>
                            <span
                                class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                        </a>
                    </div>

                    <!-- Search Bar (Desktop) -->
                    <div class="hidden md:block" x-show="searchOpen"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
                        <form action="#" method="GET">
                            <div class="flex items-center h-10 bg-[#B2C6D5]">
                                <input type="text" name="query"
                                    class="w-64 h-10 text-sm px-4 border-r-0 rounded-l-full focus:border-blue-600 focus:ring-0 transition-all duration-300 focus:ring-2 focus:ring-blue-200"
                                    placeholder="Search articles...">
                                <button aria-label="Search"
                                    class="px-4 bg-blue-600 hover:bg-blue-700 rounded-r-full text-white duration-300 h-10 transition-all hover:shadow-md hover:shadow-blue-200 active:scale-95">
                                    <svg aria-hidden="true" viewBox="0 0 512 512" width="18" height="18"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill="currentColor"
                                            d="M505 442.7L405.3 343c29.6-34.9 47.7-79.6 47.7-128C453 96.5 352.5-4 229.5-4S6 96.5 6 215.5 106.5 435 229.5 435c48.4 0 93.1-18.1 128-47.7l99.7 99.7c9.4 9.4 24.6 9.4 34 0l14.8-14.8c9.4-9.4 9.4-24.6 0-34zM229.5 369c-84.6 0-153.5-68.9-153.5-153.5S144.9 62 229.5 62 383 130.9 383 215.5 314.1 369 229.5 369z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Search Icon (Desktop) -->
                    <button @click="searchOpen = !searchOpen"
                        class="hidden md:flex items-center justify-center w-10 h-10 text-neutral-500 hover:text-blue-600 duration-300 group"
                        aria-label="Search">
                        <svg aria-hidden="true" viewBox="0 0 512 512" width="20" height="20"
                            xmlns="http://www.w3.org/2000/svg"
                            class="transition-transform duration-300 group-hover:scale-110">
                            <path fill="currentColor"
                                d="M505 442.7L405.3 343c29.6-34.9 47.7-79.6 47.7-128C453 96.5 352.5-4 229.5-4S6 96.5 6 215.5 106.5 435 229.5 435c48.4 0 93.1-18.1 128-47.7l99.7 99.7c9.4 9.4 24.6 9.4 34 0l14.8-14.8c9.4-9.4 9.4-24.6 0-34zM229.5 369c-84.6 0-153.5-68.9-153.5-153.5S144.9 62 229.5 62 383 130.9 383 215.5 314.1 369 229.5 369z">
                            </path>
                        </svg>
                    </button>

                    <!-- User Actions -->
                    <div class="flex items-center space-x-4">
                        @auth
                            <div class="relative">
                                <button @click="openUser = !openUser"
                                    class="flex items-center space-x-1  group transition-all duration-200 hover:scale-105">
                                    <div
                                        class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold transition-all duration-300 group-hover:bg-blue-600 group-hover:shadow-md">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-4 w-4 text-grey-500 group-hover:text-grey-700 transition-[transform,colors] duration-300 ease-[cubic-bezier(0.68,-0.6,0.32,1.6)]"
                                        :class="{ 'transform rotate-180': openUser }" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <div x-show="openUser" @click.away="openUser = false"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 scale-95"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100 scale-100"
                                    x-transition:leave-end="opacity-0 scale-95"
                                    class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-grey-100">
                                    <a href="#"
                                        class="block px-4 py-2 text-sm text-grey-700 hover:bg-grey-100 transition-all duration-200 hover:pl-6">My
                                        Profile</a>
                                    <a href="#"
                                        class="block px-4 py-2 text-sm text-grey-700 hover:bg-grey-100 transition-all duration-200 hover:pl-6">Settings</a>
                                    @if (auth()->user()->is_admin)
                                        <a href="{{ route('admin.dashboard') }}"
                                            class="block px-4 py-2 text-sm text-grey-700 hover:bg-grey-100 transition-all duration-200 hover:pl-6">Admin
                                            Panel</a>
                                    @endif
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="block w-full text-left px-4 py-2 text-sm text-grey-700 hover:bg-grey-100 transition-all duration-200 hover:pl-6">Logout</button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}"
                                class="hidden md:inline-flex items-center px-4 py-2 border border-blue-600 text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition-all duration-300 hover:shadow-md hover:scale-[1.02] active:scale-95">
                                <span class="relative z-10">Login</span>
                            </a>
                        @endauth
                    </div>

                    <!-- Mobile Menu Button -->
                    <button @click="open = !open" :class="{ 'text-blue-600': open, 'text-neutral-500': !open }"
                        aria-label="Menu" class="flex md:hidden gap-2 items-center duration-300 group">
                        <div class="w-6 h-6 relative">
                            <span :class="{ 'rotate-45 translate-y-[5px]': open, '': !open }"
                                class="block absolute w-full h-0.5 bg-current transform transition duration-300 ease-in-out"></span>
                            <span :class="{ 'opacity-0': open, 'opacity-100': !open }"
                                class="block absolute w-full h-0.5 bg-current transform transition duration-300 ease-in-out mt-2"></span>
                            <span :class="{ '-rotate-45 -translate-y-[5px]': open, '': !open }"
                                class="block absolute w-full h-0.5 bg-current transform transition duration-300 ease-in-out mt-4"></span>
                        </div>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div :class="{ 'top-[70px] sm:top-20 opacity-100': open, '-translate-y-full opacity-0 top-0': !open }"
            class="fixed flex md:hidden flex-col bg-white w-full left-0 justify-center gap-4 font-normal text-neutral-700 pt-2 px-4 pb-4 transition-all duration-300 z-40 shadow-lg">
            <a href="{{ route('home') }}"
                class="relative text-lg font-normal py-2 px-1 group transition-all duration-200 hover:pl-3">
                <span class="relative z-10">Home</span>
                <span
                    class="absolute left-0 top-1/2 w-1 h-6 bg-blue-600 transform -translate-y-1/2 opacity-0 group-hover:opacity-100 transition-all duration-300"></span>
            </a>
            <a href="{{ route('galleries.index') }}"
                class="relative text-lg font-normal py-2 px-1 group transition-all duration-200 hover:pl-3">
                <span class="relative z-10">Gallery</span>
                <span
                    class="absolute left-0 top-1/2 w-1 h-6 bg-blue-600 transform -translate-y-1/2 opacity-0 group-hover:opacity-100 transition-all duration-300"></span>
            </a>
            <a href="#"
                class="relative text-lg font-normal py-2 px-1 group transition-all duration-200 hover:pl-3">
                <span class="relative z-10">Articles</span>
                <span
                    class="absolute left-0 top-1/2 w-1 h-6 bg-blue-600 transform -translate-y-1/2 opacity-0 group-hover:opacity-100 transition-all duration-300"></span>
            </a>

            @auth
                @if (auth()->user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}"
                        class="relative text-lg font-normal py-2 px-1 group transition-all duration-200 hover:pl-3">
                        <span class="relative z-10">Admin Panel</span>
                    </a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="relative text-lg font-normal py-2 px-1 group transition-all duration-200 hover:pl-3 text-left">
                        <span class="relative z-10">Logout</span>
                    </button>
                </form>
                <!-- Mobile Search Bar -->
                <form action="#" method="GET" class="mt-2 transition-all duration-300 hover:scale-[1.01]">
                    <div
                        class="flex items-center h-10 bg-white border border-gray-200 rounded-full overflow-hidden focus-within:ring-2 focus-within:ring-blue-200 focus-within:border-blue-500">
                        <input type="text" name="query" class="flex-1 h-10 text-sm px-4 border-none focus:ring-0"
                            placeholder="Search articles...">
                        <button aria-label="Search"
                            class="px-4 bg-blue-600 hover:bg-blue-700 text-white duration-300 h-10 transition-all active:scale-95">
                            <svg aria-hidden="true" viewBox="0 0 512 512" width="18" height="18"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill="currentColor"
                                    d="M505 442.7L405.3 343c29.6-34.9 47.7-79.6 47.7-128C453 96.5 352.5-4 229.5-4S6 96.5 6 215.5 106.5 435 229.5 435c48.4 0 93.1-18.1 128-47.7l99.7 99.7c9.4 9.4 24.6 9.4 34 0l14.8-14.8c9.4-9.4 9.4-24.6 0-34zM229.5 369c-84.6 0-153.5-68.9-153.5-153.5S144.9 62 229.5 62 383 130.9 383 215.5 314.1 369 229.5 369z">
                                </path>
                            </svg>
                        </button>
                    </div>
                </form>
            @else
                <a href="{{ route('login') }}"
                    class="relative text-lg font-normal py-2 px-1 group transition-all duration-200 hover:pl-3">
                    <span class="relative z-10">Login</span>
                </a>
            @endauth
        </div>
    </div>



    <main class="max-w-7xl mx-auto p-4 sm:p-6">
        @if (session('success'))
            <div class="mb-4 p-3 bg-green-50 text-green-800 rounded-lg border border-green-200 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                {{ session('success') }}
            </div>
        @endif
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-[#B2C6D5] border-t border-grey-200 mt-14">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Logo and Description -->
                <div class="md:col-span-1">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2">
                        <img src="{{ asset('assets/img/logo.png') }}" alt="MedicalCare Logo"
                            class="h-16 md:h-20 w-auto">
                        <span
                            class="px-3 py-1 bg-white border-2 border-blue-500 rounded-full 
              text-blue-600 font-bold text-sm uppercase tracking-wider shadow-sm">
                            Medical Service
                        </span>
                    </a>
                    <p class="mt-4 text-grey-500 text-sm">
                        Menyediakan layanan dan informasi perawatan kesehatan berkualitas untuk membantu Anda menjalani
                        hidup yang lebih sehat.
                    </p>
                    <div class="mt-4 flex space-x-4">
                        <a href="#" class="text-grey-400 hover:text-blue-500 transition-colors">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" class="text-grey-400 hover:text-blue-500 transition-colors">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                            </svg>
                        </a>
                        <a href="https://www.instagram.com/rohyoonseo/?hl=id"
                            class="text-grey-400 hover:text-blue-500 transition-colors">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-sm font-semibold text-grey-900 uppercase tracking-wider">Quick Links</h3>
                    <ul class="mt-4 space-y-2">
                        <li>
                            <a href="{{ route('home') }}"
                                class="text-grey-500 hover:text-blue-600 text-sm transition-colors">Home</a>
                        </li>
                        <li>
                            <a href="{{ route('galleries.index') }}"
                                class="text-grey-500 hover:text-blue-600 text-sm transition-colors">Gallery</a>
                        </li>
                        <li>
                            <a href="#"
                                class="text-grey-500 hover:text-blue-600 text-sm transition-colors">Articles</a>
                        </li>
                        <li>
                            <a href="#"
                                class="text-grey-500 hover:text-blue-600 text-sm transition-colors">About Us</a>
                        </li>
                        <li>
                            <a href="#"
                                class="text-grey-500 hover:text-blue-600 text-sm transition-colors">Contact</a>
                        </li>
                    </ul>
                </div>

                <!-- Services -->
                <div>
                    <h3 class="text-sm font-semibold text-grey-900 uppercase tracking-wider">Services</h3>
                    <ul class="mt-4 space-y-2">
                        <li>
                            <a href="#"
                                class="text-grey-500 hover:text-blue-600 text-sm transition-colors">Medical
                                Checkup</a>
                        </li>
                        <li>
                            <a href="#"
                                class="text-grey-500 hover:text-blue-600 text-sm transition-colors">Emergency Care</a>
                        </li>
                        <li>
                            <a href="#"
                                class="text-grey-500 hover:text-blue-600 text-sm transition-colors">Online
                                Consultation</a>
                        </li>
                        <li>
                            <a href="#"
                                class="text-grey-500 hover:text-blue-600 text-sm transition-colors">Health Tips</a>
                        </li>
                        <li>
                            <a href="#"
                                class="text-grey-500 hover:text-blue-600 text-sm transition-colors">Vaccination</a>
                        </li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h3 class="text-sm font-semibold text-grey-900 uppercase tracking-wider">Contact Us</h3>
                    <ul class="mt-4 space-y-3">
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-grey-400 mt-0.5 mr-2"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="text-grey-500 text-sm">123 Medical Street, Health City, HC 12345</span>
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-grey-400 mt-0.5 mr-2"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span class="text-grey-500 text-sm">(123) 456-7890</span>
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-grey-400 mt-0.5 mr-2"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span class="text-grey-500 text-sm">info@medicalservice.com</span>
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-grey-400 mt-0.5 mr-2"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-grey-500 text-sm">Mon-Fri: 8:00 AM - 5:00 PM</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Copyright -->
            <div class="mt-12 pt-4 border-t border-gray-500">
                <p class="text-grey-500 text-sm text-center">
                    &copy; {{ date('Y') }} Medical Service. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }

            // User dropdown toggle
            const userDropdownButton = document.getElementById('user-dropdown-button');
            const userDropdownMenu = document.getElementById('user-dropdown-menu');

            if (userDropdownButton && userDropdownMenu) {
                userDropdownButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    userDropdownMenu.classList.toggle('hidden');
                });
            }

            // Close dropdowns when clicking outside
            document.addEventListener('click', function() {
                if (userDropdownMenu && !userDropdownMenu.classList.contains('hidden')) {
                    userDropdownMenu.classList.add('hidden');
                }
            });

            // Prevent dropdown from closing when clicking inside it
            if (userDropdownMenu) {
                userDropdownMenu.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }
        });
    </script>
</body>

</html>
