@php
    $theme = 'light';
    $user = (object) [
        'name' => 'Justin',
        'email' => 'justin@example.com',
        'avatar' => 'https://ui-avatars.com/api/?name=Justin&background=0D8ABC&color=fff',
    ];
@endphp

<x-layout :theme="$theme">
    <div class="flex min-h-screen bg-gray-100 text-gray-900">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-lg min-h-screen p-4">
            <h1 class="text-2xl font-bold mb-8 ml-3 mt-3">Admin Panel</h1>
            <nav class="space-y-2">
                <a href="/dashboard" class="block px-3 py-2 rounded-lg hover:bg-gray-200">Dashboard</a>
                <a href="#" class="block px-3 py-2 rounded-lg hover:bg-gray-200">Users</a>
                <a href="#" class="block px-3 py-2 rounded-lg hover:bg-gray-200">Reports</a>
                <a href="#" class="block px-3 py-2 rounded-lg hover:bg-gray-200">Settings</a>
                <form action="Logout" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full text-left block px-3 py-2 rounded-lg hover:bg-gray-200">Logout</button>
                </form>
            </nav>
        </aside>

        <!-- Main content -->
        <main class="flex-1 p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold mb-3">Welcome, Admin</h2>

                <div class="flex items-center space-x-4">
                    <!-- Theme toggle dihapus karena mode selalu terang -->

                    <!-- User profile -->
                    <div class="flex items-center space-x-3 bg-gray-200 px-3 py-2 rounded-lg">
                        <img src="{{ $user->avatar }}" alt="Avatar"
                            class="w-8 h-8 rounded-full border-2 border-white">
                        <div class="hidden sm:block">
                            <p class="text-sm font-medium">{{ $user->name }}</p>
                            <p class="text-xs text-gray-500">{{ $user->email }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cards -->
            <!-- Wrapper -->
            <div class="space-y-6">

                <!-- Judul -->
                <div>
                    <h2 class="text-xl font-bold text-blue-600">Informasi Outlet</h2>
                    <p class="text-gray-500 text-sm">Ringkasan data outlet yang terdaftar</p>
                </div>

                <!-- Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-white rounded-lg p-4 shadow border-l-4 border-blue-500">
                        <h3 class="text-sm font-medium text-gray-600">Total Outlet</h3>
                        <p class="text-3xl font-bold text-blue-600 mt-1">1</p>
                    </div>

                    <div class="bg-white rounded-lg p-4 shadow border-l-4 border-blue-500">
                        <h3 class="text-sm font-medium text-gray-600">Outlet Aktif</h3>
                        <p class="text-3xl font-bold text-blue-600 mt-1">1</p>
                    </div>

                    <div class="bg-white rounded-lg p-4 shadow border-l-4 border-blue-500">
                        <h3 class="text-sm font-medium text-gray-600">Terakhir Diupdate</h3>
                        <p class="text-lg font-semibold text-blue-600 mt-1">14 Aug 2025</p>
                    </div>
                </div>



                <!-- Table -->
                <div class="bg-white rounded-lg shadow overflow-hidden border">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-3 text-sm font-semibold text-gray-700">Nama Outlet</th>
                                <th class="px-4 py-3 text-sm font-semibold text-gray-700">Lokasi</th>
                                <th class="px-4 py-3 text-sm font-semibold text-gray-700">Kontak</th>
                                <th class="px-4 py-3 text-sm font-semibold text-gray-700">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-t hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <span class="font-semibold text-blue-700">Sumedang Kilat</span>
                                    <span class="text-xs text-gray-500 block">ID: 1</span>
                                </td>
                                <td class="px-4 py-3 text-gray-700">Jalan Cadas Pangeran</td>
                                <td class="px-4 py-3 text-gray-700">
                                    <div class="flex items-center space-x-2">
                                        <span>0812312312</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <span
                                        class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">Aktif</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

</x-layout>
