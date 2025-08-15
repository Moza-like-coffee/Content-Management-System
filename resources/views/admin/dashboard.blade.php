@extends('layouts.admin')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
<div class="space-y-6">
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
                        <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">Aktif</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
