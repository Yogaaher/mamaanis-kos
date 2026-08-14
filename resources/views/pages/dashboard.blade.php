@extends('layouts.admin')

@section('title', 'Admin Dashboard - Mama Anis Group')

@php
    $formatRupiah = function($num) {
        return 'Rp ' . number_format($num, 0, ',', '.');
    };

    // Calculate dynamic analytics from collection
    $totalRooms = count($rooms);
    $filledRooms = collect($rooms)->filter(fn($r) => ($r['status'] ?? '') === 'Terisi')->count();
    $availableRooms = collect($rooms)->filter(fn($r) => ($r['status'] ?? '') === 'Tersedia')->count();
    $maintenanceRooms = $totalRooms - $filledRooms - $availableRooms;

    $occupancyRate = $totalRooms > 0 ? round(($filledRooms / $totalRooms) * 100) : 0;
    
    // Total monthly potential revenue
    $totalRevenue = collect($rooms)->filter(fn($r) => ($r['status'] ?? '') === 'Terisi')->sum('price');
@endphp

@section('content')
<!-- Page Heading -->
<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Ringkasan Analitik</h1>
        <p class="text-sm text-gray-500 mt-1">
            Status operasional terkini dan performa sewa Mama Anis Group.
        </p>
    </div>
    
    <!-- Action buttons -->
    <div class="flex gap-3">
        <button
            type="button"
            onclick="alert('Fitur Cetak Laporan akan terhubung dengan PDF Generator Laravel')"
            class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 rounded-xl font-semibold text-xs hover:bg-gray-50 active:scale-95 transition-all cursor-pointer shadow-xs"
        >
            Cetak Laporan
        </button>
        <button
            type="button"
            onclick="document.getElementById('add-room-modal').classList.remove('hidden')"
            class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-semibold text-xs active:scale-95 transition-all cursor-pointer shadow-sm flex items-center gap-1.5"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path>
            </svg>
            <span>Tambah Kamar Baru</span>
        </button>
    </div>
</div>

<!-- Key Performance Indicators (Metrics Grid) -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Total Rooms -->
    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-xs flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
        </div>
        <div>
            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Total Kamar</p>
            <h3 class="text-2xl font-black text-slate-900 mt-1">{{ $totalRooms }} Unit</h3>
        </div>
    </div>

    <!-- Occupied Rooms -->
    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-xs flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
        </div>
        <div>
            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Kamar Terisi</p>
            <h3 class="text-2xl font-black text-slate-900 mt-1">{{ $filledRooms }} Unit</h3>
        </div>
    </div>

    <!-- Available Rooms -->
    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-xs flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div>
            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Kamar Kosong</p>
            <h3 class="text-2xl font-black text-slate-900 mt-1">{{ $availableRooms }} Unit</h3>
        </div>
    </div>

    <!-- Total Income -->
    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-xs flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div>
            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Pendapatan Bulanan</p>
            <h3 class="text-xl font-black text-slate-900 mt-1">{{ $formatRupiah($totalRevenue) }}</h3>
        </div>
    </div>
</div>

<!-- Analytics Charts & Statistics Area -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    
    <!-- Left Column: Occupancy & Visitors SVG Trend graph -->
    <div class="lg:col-span-8 bg-white p-6 rounded-3xl border border-gray-100 shadow-xs flex flex-col gap-6">
        <div>
            <h3 class="font-extrabold text-gray-950 text-base">Tren Pengunjung Portal (Mingguan)</h3>
            <p class="text-xs text-gray-400 mt-1">Statistik total kunjungan calon penyewa Mama Anis Group.</p>
        </div>

        <!-- Custom Line Chart simulated with inline responsive SVG vectors -->
        <div class="relative w-full h-64 bg-slate-50 rounded-2xl border border-gray-100 p-4 overflow-hidden">
            <svg class="w-full h-full text-emerald-500" viewBox="0 0 600 200" preserveAspectRatio="none">
                <!-- Grid Lines -->
                <line x1="0" y1="50" x2="600" y2="50" stroke="#f1f5f9" stroke-width="1.5" />
                <line x1="0" y1="100" x2="600" y2="100" stroke="#f1f5f9" stroke-width="1.5" />
                <line x1="0" y1="150" x2="600" y2="150" stroke="#f1f5f9" stroke-width="1.5" />
                
                <!-- Area path below trend line -->
                <path d="M 0 160 Q 100 120 200 140 T 400 60 T 600 80 L 600 200 L 0 200 Z" fill="rgba(16, 185, 129, 0.08)" />
                
                <!-- Main Trend Line path -->
                <path d="M 0 160 Q 100 120 200 140 T 400 60 T 600 80" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" />
                
                <!-- Chart markers (dots) -->
                <circle cx="100" cy="140" r="5" fill="#10b981" stroke="white" stroke-width="1.5" />
                <circle cx="300" cy="90" r="5" fill="#10b981" stroke="white" stroke-width="1.5" />
                <circle cx="500" cy="70" r="5" fill="#10b981" stroke="white" stroke-width="1.5" />
            </svg>
            
            <!-- X Axis Labels -->
            <div class="absolute bottom-1 left-4 right-4 flex justify-between font-mono text-[9px] text-gray-400 uppercase font-bold tracking-wider">
                <span>Senin</span>
                <span>Selasa</span>
                <span>Rabu</span>
                <span>Kamis</span>
                <span>Jumat</span>
                <span>Sabtu</span>
                <span>Minggu</span>
            </div>
        </div>
    </div>

    <!-- Right Column: Occupancy Pie Distribution Simulated -->
    <div class="lg:col-span-4 bg-white p-6 rounded-3xl border border-gray-100 shadow-xs flex flex-col gap-6 justify-between">
        <div>
            <h3 class="font-extrabold text-gray-950 text-base">Tingkat Okupansi</h3>
            <p class="text-xs text-gray-400 mt-1">Perbandingan kamar terisi dan kosong.</p>
        </div>

        <div class="flex justify-center py-4 relative">
            <!-- Custom Circular progress circle layout -->
            <div class="relative w-36 h-36 flex items-center justify-center">
                <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                    <!-- Base ring -->
                    <path class="text-slate-100" stroke-width="4" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                    <!-- Green fill based on occupancyRate percentage -->
                    <path class="text-emerald-500" stroke-dasharray="{{ $occupancyRate }}, 100" stroke-width="4" stroke-linecap="round" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                </svg>
                <div class="absolute flex flex-col items-center">
                    <span class="text-2xl font-black text-slate-800">{{ $occupancyRate }}%</span>
                    <span class="text-[9px] text-gray-400 font-bold uppercase tracking-wider">Terisi</span>
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-2 pt-2 border-t border-gray-50 text-xs font-semibold text-gray-600">
            <div class="flex justify-between">
                <span class="flex items-center gap-1.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                    <span>Terisi</span>
                </span>
                <span>{{ $filledRooms }} Unit</span>
            </div>
            <div class="flex justify-between">
                <span class="flex items-center gap-1.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-slate-200"></span>
                    <span>Kosong</span>
                </span>
                <span>{{ $availableRooms }} Unit</span>
            </div>
        </div>
    </div>
</div>

<!-- Rooms Database Datatable List -->
<div class="bg-white rounded-3xl border border-gray-100 shadow-xs overflow-hidden">
    <div class="p-6 border-b border-gray-50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h3 class="font-extrabold text-gray-950 text-base">Daftar Pengelolaan Kamar</h3>
            <p class="text-xs text-gray-400 mt-1">Daftar lengkap unit kamar kost terdaftar.</p>
        </div>
    </div>

    <!-- Table content wrapper -->
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-600">
            <thead class="text-xs font-bold text-gray-400 bg-slate-50 uppercase tracking-wider border-b border-gray-100">
                <tr>
                    <th scope="col" class="px-6 py-4">Foto & Nama Kamar</th>
                    <th scope="col" class="px-6 py-4">Tipe</th>
                    <th scope="col" class="px-6 py-4">Lokasi</th>
                    <th scope="col" class="px-6 py-4">Tarif Bulanan</th>
                    <th scope="col" class="px-6 py-4">Status</th>
                    <th scope="col" class="px-6 py-4">Rating / Views</th>
                    <th scope="col" class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($rooms as $room)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 flex items-center gap-3">
                            <img
                                src="{{ $room['image'] ?? 'https://images.unsplash.com/photo-1505691938895-1758d7feb511?auto=format&fit=crop&w=800&q=80' }}"
                                alt="Fasilitas Kamar"
                                class="w-12 h-10 object-cover rounded-lg border border-gray-200"
                            />
                            <div>
                                <p class="font-bold text-slate-800 text-sm leading-tight">{{ $room['name'] }}</p>
                                <p class="text-[10px] text-gray-400 mt-0.5">ID: {{ $room['id'] }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="bg-gray-100 text-gray-600 px-2.5 py-1 rounded-lg text-xs font-semibold uppercase">
                                {{ $room['type'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-xs font-medium text-gray-500">
                            {{ $room['location'] }}
                        </td>
                        <td class="px-6 py-4 font-bold text-slate-900 text-sm">
                            {{ $formatRupiah($room['price']) }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider @if($room['status'] === 'Tersedia') bg-emerald-50 text-emerald-700 @elseif($room['status'] === 'Terisi') bg-gray-100 text-gray-500 @else bg-amber-50 text-amber-500 @endif">
                                {{ $room['status'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 font-mono text-xs text-gray-500">
                            ★ {{ number_format($room['rating'], 1) }} / {{ $room['views'] }} views
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <button
                                    type="button"
                                    onclick="alert('Kelola / Edit detail kamar terhubung dengan Controller update database Laravel.')"
                                    class="p-2 text-slate-400 hover:text-[#006c49] bg-gray-100 hover:bg-[#006c49]/10 rounded-lg transition-colors cursor-pointer"
                                    title="Edit Unit"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                                <button
                                    type="button"
                                    onclick="alert('Hapus unit kamar terhubung dengan Controller destroy database Laravel.')"
                                    class="p-2 text-slate-400 hover:text-red-600 bg-gray-100 hover:bg-red-50 rounded-lg transition-colors cursor-pointer"
                                    title="Hapus Unit"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Absolute Pop Modal: Add Room Mock Layout (Alpine or Vanilla JS hidden by default) -->
<div id="add-room-modal" class="hidden fixed inset-0 bg-slate-950/40 backdrop-blur-xs z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl border border-gray-100 max-w-lg w-full p-6 shadow-2xl flex flex-col gap-6 animate-in fade-in zoom-in duration-150">
        <div class="flex justify-between items-center pb-4 border-b border-gray-100">
            <h4 class="font-extrabold text-slate-900 text-lg">Tambah Kamar Baru</h4>
            <button
                type="button"
                onclick="document.getElementById('add-room-modal').classList.add('hidden')"
                class="text-gray-400 hover:text-gray-600 p-1 rounded-lg cursor-pointer"
            >
                ✕
            </button>
        </div>

        <form action="#" method="POST" class="flex flex-col gap-4 text-sm" onsubmit="event.preventDefault(); alert('Kamar berhasil dibuat! Data terhubung dengan form POST controller Laravel.'); document.getElementById('add-room-modal').classList.add('hidden');">
            <div>
                <label class="block font-bold text-gray-700 mb-1">Nama Kamar / Unit</label>
                <input required type="text" placeholder="Contoh: Mama Anis Central Room 104" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-100 rounded-xl focus:bg-white focus:border-emerald-600 outline-none" />
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-gray-700 mb-1">Tipe Kamar</label>
                    <select class="w-full px-4 py-2.5 bg-gray-50 border border-gray-100 rounded-xl focus:bg-white focus:border-emerald-600 outline-none cursor-pointer">
                        <option>Executive</option>
                        <option>Penthouse</option>
                        <option>Deluxe</option>
                        <option>Standard</option>
                    </select>
                </div>
                <div>
                    <label class="block font-bold text-gray-700 mb-1">Lokasi Kampus</label>
                    <input required type="text" placeholder="Contoh: Alam Sutera, Tangerang" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-100 rounded-xl focus:bg-white focus:border-emerald-600 outline-none" />
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-gray-700 mb-1">Biaya Bulanan (Rp)</label>
                    <input required type="number" placeholder="Contoh: 3500000" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-100 rounded-xl focus:bg-white focus:border-emerald-600 outline-none" />
                </div>
                <div>
                    <label class="block font-bold text-gray-700 mb-1">Status Ketersediaan</label>
                    <select class="w-full px-4 py-2.5 bg-gray-50 border border-gray-100 rounded-xl focus:bg-white focus:border-emerald-600 outline-none cursor-pointer">
                        <option>Tersedia</option>
                        <option>Terisi</option>
                        <option>Pemeliharaan</option>
                    </select>
                </div>
            </div>

            <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
                <button
                    type="button"
                    onclick="document.getElementById('add-room-modal').classList.add('hidden')"
                    class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 rounded-xl font-bold cursor-pointer hover:bg-gray-50"
                >
                    Batalkan
                </button>
                <button
                    type="submit"
                    class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold cursor-pointer active:scale-95 transition-all"
                >
                    Simpan Unit
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
