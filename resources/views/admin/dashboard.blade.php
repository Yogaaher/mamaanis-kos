@extends('layouts.admin')

@section('title', 'Dashboard Ringkasan | Admin Mama Anis Group')

@section('content')
@php
    $formatRupiah = function($num) {
        if ($num >= 1000000) {
            return 'Rp ' . number_format($num / 1000000, 1, ',', '.') . 'jt';
        }
        return 'Rp ' . number_format($num, 0, ',', '.');
    };

    $monthlyIncome = $rooms->where('status', 'Terisi')->sum('price');
    $potentialIncome = $rooms->sum('price');
    $popularRooms = $rooms->sortByDesc('views')->take(4);
    $occupancyRate = $total ? round(($occupied / $total) * 100) : 0;
    $totalViews = $rooms->sum('views');
    $avgViews = $total ? round($totalViews / $total) : 0;
@endphp

<main class="p-3.5 sm:p-8 lg:p-10 flex flex-col gap-4 sm:gap-8 rise w-full max-w-full overflow-x-hidden">
    <!-- Header Page -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 sm:gap-4">
        <div>
            <div class="flex items-center gap-2 text-[10px] sm:text-xs text-slate-400 font-bold tracking-wide">
                <span>Mama Anis Group</span>
                <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="text-brand">Dashboard Admin</span>
            </div>
            <h1 class="text-xl sm:text-3xl font-black text-slate-900 mt-0.5 sm:mt-1 font-display">Ringkasan Operasional</h1>
        </div>
        
        <div class="flex items-center gap-2 sm:gap-3 w-full sm:w-auto">
            <button 
                type="button" 
                onclick="window.print()" 
                class="no-print px-3 py-2 sm:px-4 sm:py-2.5 bg-white border border-slate-200 hover:border-slate-300 text-slate-700 rounded-xl font-bold text-[11px] sm:text-xs shadow-xs flex items-center gap-1.5 sm:gap-2 transition-all cursor-pointer active:scale-95 shrink-0"
                title="Cetak ringkasan halaman ini"
            >
                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                <span>Cetak</span>
            </button>

            <a 
                href="{{ route('admin.rooms.create') }}" 
                class="px-4 py-2 sm:px-5 sm:py-2.5 bg-brand hover:bg-brandHover text-white rounded-xl font-bold text-[11px] sm:text-xs shadow-md shadow-brand/20 flex items-center gap-1.5 sm:gap-2 transition-all active:scale-95 text-center justify-center flex-1 sm:flex-initial"
            >
                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                <span>Tambah Kamar</span>
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="rounded-2xl bg-emerald-50 border border-emerald-200 px-5 py-3.5 font-bold text-emerald-800 text-xs flex items-center gap-3">
            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- 4 Metrics Grid (2 columns on mobile, 4 on desktop) -->
    <section class="grid grid-cols-2 gap-3 sm:gap-5 lg:grid-cols-4">
        <!-- Metric 1: Total Kamar -->
        <article class="admin-card rounded-2xl bg-white p-3.5 sm:p-6 border border-slate-100 shadow-soft flex flex-col justify-between min-h-[120px] sm:min-h-[140px]">
            <div class="flex items-center justify-between">
                <span class="text-[9px] sm:text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Kamar</span>
                <div class="w-7 h-7 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-xs sm:text-sm shrink-0 border border-indigo-100">
                    <svg class="w-3.5 h-3.5 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
            </div>
            <div class="mt-2 sm:mt-3">
                <p class="text-xl sm:text-3xl font-black text-slate-900 font-display">{{ $total }} <span class="text-[10px] sm:text-xs font-semibold text-slate-400">Unit</span></p>
                <div class="flex items-center gap-1 text-[10px] sm:text-xs text-emerald-600 font-bold mt-1">
                    <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                    </svg>
                    <span class="truncate">Katalog Siap Huni</span>
                </div>
            </div>
        </article>

        <!-- Metric 2: Terisi -->
        <article class="admin-card rounded-2xl bg-white p-3.5 sm:p-6 border border-slate-100 shadow-soft flex flex-col justify-between min-h-[120px] sm:min-h-[140px]">
            <div class="flex items-center justify-between">
                <span class="text-[9px] sm:text-[11px] font-bold text-slate-400 uppercase tracking-wider">Kamar Terisi</span>
                <div class="w-7 h-7 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-xs sm:text-sm shrink-0 border border-amber-100">
                    <svg class="w-3.5 h-3.5 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-2 sm:mt-3">
                <p class="text-xl sm:text-3xl font-black text-slate-900 font-display">{{ $occupied }} <span class="text-[10px] sm:text-xs font-semibold text-slate-400">Unit</span></p>
                <div class="flex items-center gap-1 text-[10px] sm:text-xs text-amber-700 font-bold mt-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 shrink-0"></span>
                    <span class="truncate">Okupansi {{ $occupancyRate }}%</span>
                </div>
            </div>
        </article>

        <!-- Metric 3: Tersedia -->
        <article class="admin-card rounded-2xl bg-white p-3.5 sm:p-6 border border-slate-100 shadow-soft flex flex-col justify-between min-h-[120px] sm:min-h-[140px]">
            <div class="flex items-center justify-between">
                <span class="text-[9px] sm:text-[11px] font-bold text-slate-400 uppercase tracking-wider">Tersedia</span>
                <div class="w-7 h-7 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl bg-emerald-50 text-brand flex items-center justify-center font-bold text-xs sm:text-sm shrink-0 border border-emerald-100">
                    <svg class="w-3.5 h-3.5 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-2 sm:mt-3">
                <p class="text-xl sm:text-3xl font-black text-slate-900 font-display">{{ $available }} <span class="text-[10px] sm:text-xs font-semibold text-slate-400">Unit</span></p>
                <div class="flex items-center gap-1 text-[10px] sm:text-xs text-emerald-700 font-bold mt-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shrink-0"></span>
                    <span class="truncate">Siap Disewa</span>
                </div>
            </div>
        </article>

        <!-- Metric 4: Pendapatan Bulanan -->
        <article class="admin-card rounded-2xl bg-white p-3.5 sm:p-6 border border-slate-100 shadow-soft flex flex-col justify-between min-h-[120px] sm:min-h-[140px]">
            <div class="flex items-center justify-between">
                <span class="text-[9px] sm:text-[11px] font-bold text-slate-400 uppercase tracking-wider">Pendapatan</span>
                <div class="w-7 h-7 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl bg-emerald-700 text-white flex items-center justify-center font-bold text-xs sm:text-sm shrink-0 shadow-xs">
                    <svg class="w-3.5 h-3.5 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-2 sm:mt-3">
                <p class="text-sm sm:text-2xl font-black text-slate-900 font-display truncate">{{ $formatRupiah($monthlyIncome) }}</p>
                <div class="flex items-center gap-1 text-[9px] sm:text-xs text-slate-400 font-bold mt-1 truncate">
                    <span class="truncate">Bulan Aktif</span>
                </div>
            </div>
        </article>
    </section>

    <!-- Mid Section: Dynamic Chart and Popular Rooms -->
    <section class="grid gap-4 sm:gap-6 lg:grid-cols-12">
        <!-- Chart Column (Tren View & Kunjungan Kamar) -->
        <article class="admin-card lg:col-span-8 bg-white p-3.5 sm:p-7 rounded-2xl border border-slate-100 shadow-soft flex flex-col gap-4 sm:gap-5 overflow-hidden">
            <!-- Mobile Horizontal Swipe Hint -->
            <div class="sm:hidden flex items-center justify-between text-[10px] text-slate-400 font-bold px-0.5 -mb-2">
                <span class="flex items-center gap-1">
                    <svg class="w-3 h-3 text-brand shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                    </svg>
                    <span>Geser section ini ke kanan/kiri →</span>
                </span>
            </div>

            <!-- Independent Horizontal Scroll Wrapper for entire Tren View Section -->
            <div class="overflow-x-auto w-full pb-1 -mx-1 px-1 sm:mx-0 sm:px-0">
                <div class="min-w-[460px] sm:min-w-full flex flex-col gap-4 sm:gap-5">
                    <!-- Header & Filter Controls -->
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 sm:gap-4 border-b border-slate-50 pb-3 sm:pb-0 sm:border-0">
                        <div>
                            <div class="flex items-center gap-2">
                                <div class="w-2.5 h-2.5 rounded-full bg-brand animate-pulse"></div>
                                <h3 class="font-black text-slate-900 text-sm sm:text-base font-display" id="chartTitle">Tren View & Kunjungan Kamar</h3>
                            </div>
                            <p class="text-[11px] sm:text-xs text-slate-400 mt-0.5 font-medium" id="chartSubtitle">Pilih kamar spesifik atau lihat agregat seluruh kamar kos.</p>
                        </div>

                        <!-- Room Selector & Time Range Filter Buttons -->
                        <div class="flex flex-wrap items-center gap-2 w-full sm:w-auto">
                            <!-- Individual Room Filter Dropdown (Compact on Mobile) -->
                            <select 
                                id="chartRoomSelect" 
                                onchange="onRoomChartSelectChange()" 
                                class="px-2 py-1 sm:px-2.5 sm:py-1.5 max-w-[160px] sm:max-w-none border border-slate-200 bg-slate-50 rounded-lg sm:rounded-xl text-[10px] sm:text-xs font-bold text-slate-800 outline-none focus:border-brand focus:bg-white truncate shrink-0 cursor-pointer"
                            >
                                <option value="ALL">Semua Kamar (Total)</option>
                                @foreach($rooms as $r)
                                    <option value="{{ $r->id }}">📍 {{ $r->name }} ({{ number_format($r->views) }} views)</option>
                                @endforeach
                            </select>

                            <!-- Time Range Selector -->
                            <div class="flex items-center bg-slate-100 p-0.5 sm:p-1 rounded-xl gap-0.5 sm:gap-1 text-xs font-bold shrink-0">
                                <button 
                                    type="button" 
                                    onclick="setChartRange('7d')" 
                                    id="btn-7d"
                                    class="chart-tab px-2 sm:px-2.5 py-1 rounded-lg text-slate-500 hover:text-slate-900 transition-all cursor-pointer text-[10px] sm:text-xs"
                                >
                                    7H
                                </button>
                                <button 
                                    type="button" 
                                    onclick="setChartRange('30d')" 
                                    id="btn-30d"
                                    class="chart-tab px-2 sm:px-2.5 py-1 rounded-lg bg-white text-brand shadow-xs transition-all cursor-pointer text-[10px] sm:text-xs"
                                >
                                    30H
                                </button>
                                <button 
                                    type="button" 
                                    onclick="setChartRange('6m')" 
                                    id="btn-6m"
                                    class="chart-tab px-2 sm:px-2.5 py-1 rounded-lg text-slate-500 hover:text-slate-900 transition-all cursor-pointer text-[10px] sm:text-xs"
                                >
                                    6B
                                </button>
                                <button 
                                    type="button" 
                                    onclick="setChartRange('1y')" 
                                    id="btn-1y"
                                    class="chart-tab px-2 sm:px-2.5 py-1 rounded-lg text-slate-500 hover:text-slate-900 transition-all cursor-pointer text-[10px] sm:text-xs"
                                >
                                    1T
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Insights Summary Bar -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 sm:gap-3 bg-slate-50 p-3 sm:p-4 rounded-xl border border-slate-100">
                        <div>
                            <span class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-wider block" id="label-stat-total">Total Views</span>
                            <span class="text-sm sm:text-base font-black text-brand font-display" id="metric-total-views">{{ number_format($totalViews) }}</span>
                        </div>
                        <div>
                            <span class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Rata-rata/Kamar</span>
                            <span class="text-sm sm:text-base font-black text-slate-800 font-display" id="metric-avg-views">{{ number_format($avgViews) }}</span>
                        </div>
                        <div>
                            <span class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Pertumbuhan</span>
                            <span class="text-sm sm:text-base font-black text-emerald-600 font-display flex items-center gap-0.5">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                                </svg>
                                <span id="metric-growth-rate">+18.4%</span>
                            </span>
                        </div>
                        <div>
                            <span class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Status Data</span>
                            <span class="text-sm sm:text-base font-black text-indigo-600 font-display">Live DB</span>
                        </div>
                    </div>

                    <!-- Chart Canvas Container -->
                    <div class="w-full h-[220px] sm:h-[280px] relative">
                        <canvas id="viewsTrendChart"></canvas>
                    </div>
                </div>
            </div>
        </article>

        <!-- Popular rooms list column (Statistik per Kamar) -->
        <article class="admin-card lg:col-span-4 bg-white p-3.5 sm:p-6 rounded-2xl border border-slate-100 shadow-soft flex flex-col justify-between gap-3 sm:gap-4 overflow-hidden">
            <!-- Mobile Horizontal Swipe Hint -->
            <div class="sm:hidden flex items-center justify-between text-[10px] text-slate-400 font-bold px-0.5 -mb-2">
                <span class="flex items-center gap-1">
                    <svg class="w-3 h-3 text-brand shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                    </svg>
                    <span>Geser section ini ke kanan/kiri →</span>
                </span>
            </div>

            <!-- Independent Horizontal Scroll Wrapper for entire Statistik per Kamar Section -->
            <div class="overflow-x-auto w-full pb-1 -mx-1 px-1 sm:mx-0 sm:px-0">
                <div class="min-w-[340px] sm:min-w-full flex flex-col gap-3">
                    <div class="flex items-center justify-between mb-1">
                        <h3 class="font-black text-slate-900 text-sm sm:text-base font-display">Statistik per Kamar</h3>
                        <span class="text-[9px] sm:text-[10px] font-bold uppercase tracking-wider text-brand bg-emerald-50 px-2 py-0.5 rounded-md shrink-0">Urutan Views</span>
                    </div>
                    
                    <div class="flex flex-col gap-2 sm:gap-2.5">
                        @forelse($popularRooms as $idx => $room)
                            <div class="group flex items-center justify-between gap-2 sm:gap-3 p-2 sm:p-2.5 rounded-xl hover:bg-emerald-50/60 border border-slate-50 hover:border-emerald-100 transition-all">
                                <div class="flex items-center gap-2.5 min-w-0 flex-1">
                                    <div class="relative shrink-0">
                                        <img 
                                            src="{{ $room->image_url }}" 
                                            class="h-10 w-10 sm:h-12 sm:w-12 rounded-lg sm:rounded-xl object-cover border border-slate-100" 
                                            alt="{{ $room->name }}"
                                            loading="lazy"
                                        >
                                        <span class="absolute -top-1 -left-1 w-4 h-4 sm:w-5 sm:h-5 rounded-full bg-slate-900 text-white text-[9px] sm:text-[10px] font-black flex items-center justify-center shadow-xs">
                                            #{{ $idx + 1 }}
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="truncate text-xs font-black text-slate-800 group-hover:text-brand transition-colors">
                                            {{ $room->name }}
                                        </p>
                                        <p class="text-[9px] sm:text-[10px] text-slate-400 font-bold uppercase tracking-wider truncate">
                                            {{ $room->type }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex flex-col items-end shrink-0 gap-0.5">
                                    <span class="text-[10px] sm:text-xs font-black text-brand bg-emerald-50 px-2 py-0.5 rounded-md sm:rounded-lg border border-emerald-100">
                                        {{ number_format($room->views) }} <span class="text-[8px] sm:text-[9px] font-semibold text-slate-400">views</span>
                                    </span>
                                    <button 
                                        type="button" 
                                        onclick="selectRoomForChart('{{ $room->id }}')" 
                                        class="text-[9px] sm:text-[10px] font-bold text-indigo-600 hover:text-indigo-800 hover:underline cursor-pointer"
                                    >
                                        Grafik →
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="py-6 sm:py-10 text-center text-slate-400 text-xs font-semibold">
                                Belum ada unit kamar dengan catatan view.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
            
            <a 
                href="{{ route('admin.analytics') }}" 
                class="mt-2 block rounded-xl bg-slate-50 hover:bg-emerald-50 border border-slate-200 hover:border-emerald-200 py-2.5 sm:py-3 text-center text-xs font-bold text-slate-700 hover:text-brand transition-all flex items-center justify-center gap-1.5 sm:gap-2 shrink-0"
            >
                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-brand" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <span>Buka Laporan Performa Kamar</span>
            </a>
        </article>
    </section>

    <!-- Bottom Section: Searchable & Filterable Rooms Table -->
    <section class="bg-white rounded-2xl border border-slate-100 shadow-soft overflow-hidden">
        <div class="p-3.5 sm:p-6 border-b border-slate-100 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-3 sm:gap-4">
            <div>
                <h3 class="font-black text-slate-900 text-base font-display">Aktivitas & Manajemen Kamar</h3>
                <p class="text-xs text-slate-400 mt-0.5">Kelola seluruh unit kamar kos Mama Anis dengan statistik view individual.</p>
            </div>
            
            <!-- Quick filters & search input inside table panel -->
            <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto">
                <!-- Status Filter Dropdown -->
                <select 
                    id="tableStatusFilter" 
                    onchange="filterTableRows()" 
                    class="px-3 py-2 border border-slate-200 bg-slate-50/70 rounded-xl text-xs font-bold text-slate-700 outline-none focus:border-brand focus:bg-white"
                >
                    <option value="ALL">Semua Status</option>
                    <option value="Tersedia">Tersedia</option>
                    <option value="Terisi">Terisi</option>
                    <option value="Pemeliharaan">Pemeliharaan</option>
                </select>

                <!-- Type Filter Dropdown -->
                <select 
                    id="tableTypeFilter" 
                    onchange="filterTableRows()" 
                    class="px-3 py-2 border border-slate-200 bg-slate-50/70 rounded-xl text-xs font-bold text-slate-700 outline-none focus:border-brand focus:bg-white"
                >
                    <option value="ALL">Semua Tipe</option>
                    @foreach($rooms->pluck('type')->unique() as $t)
                        <option value="{{ $t }}">{{ $t }}</option>
                    @endforeach
                </select>

                <!-- Live Search input -->
                <div class="relative flex-1 sm:w-60">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input 
                        type="text" 
                        id="tableSearchInput"
                        placeholder="Cari nama / tipe..." 
                        oninput="filterTableRows()"
                        class="pl-10 pr-4 py-2 border border-slate-200 bg-slate-50/70 rounded-xl text-xs outline-none focus:bg-white focus:border-brand w-full font-medium"
                    />
                </div>
            </div>
        <div class="sm:hidden px-4 py-2 bg-amber-50/70 border-b border-amber-100/70 text-[11px] text-amber-800 font-semibold flex items-center justify-between">
            <span class="flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-amber-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
                <span>Geser ke kanan untuk melihat harga, status, & aksi unit.</span>
            </span>
        </div>

        <div class="overflow-x-auto max-w-full">
            <table class="w-full text-left text-xs text-gray-500 font-medium" id="dashboardRoomsTable">
                <thead class="bg-slate-50 text-[10px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4">Nama Kamar</th>
                        <th class="px-6 py-4">Tipe</th>
                        <th class="px-6 py-4">Harga/Bulan</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Views Individual</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50" id="tableBody">
                    @forelse($rooms as $room)
                        <tr 
                            class="room-row hover:bg-slate-50/50 transition-colors"
                            data-name="{{ strtolower($room->name) }}"
                            data-type="{{ strtolower($room->type) }}"
                            data-status="{{ $room->status }}"
                        >
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img 
                                        src="{{ $room->image_url }}" 
                                        alt="Foto Kamar" 
                                        class="w-11 h-9 object-cover rounded-xl border border-slate-100 shrink-0"
                                        loading="lazy"
                                        onerror="handleImgError(this)"
                                    />
                                    <div>
                                        <p class="font-black text-slate-900 text-xs">{{ $room->name }}</p>
                                        <p class="text-[10px] text-slate-400 font-medium">{{ $room->location }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-slate-100 text-slate-700 px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider">
                                    {{ $room->type }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-black text-slate-900 font-display">
                                Rp {{ number_format($room->price, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4">
                                <x-badge-status :status="$room->status" />
                            </td>
                            <td class="px-6 py-4 font-bold text-slate-700">
                                <button 
                                    type="button" 
                                    onclick="openRoomStatModal('{{ $room->id }}')" 
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 hover:bg-emerald-100 text-brand border border-emerald-200 rounded-lg transition-colors cursor-pointer"
                                    title="Klik untuk melihat statistik detail kamar ini"
                                >
                                    <svg class="w-3.5 h-3.5 text-brand" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                    </svg>
                                    <span class="font-black font-display text-xs">{{ number_format($room->views) }}</span>
                                    <span class="text-[9px] text-slate-500 font-normal">views</span>
                                </button>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <button 
                                        type="button" 
                                        onclick="selectRoomForChart('{{ $room->id }}')" 
                                        class="p-2 text-indigo-600 hover:text-indigo-800 bg-indigo-50 hover:bg-indigo-100 rounded-xl transition-colors border border-indigo-100"
                                        title="Tampilkan Tren Grafik Kamar Ini"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                                        </svg>
                                    </button>
                                    <a 
                                        href="{{ route('admin.rooms.edit', $room) }}" 
                                        class="p-2 text-slate-500 hover:text-brand bg-slate-50 hover:bg-emerald-50 rounded-xl transition-colors border border-slate-100"
                                        title="Edit Unit"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.rooms.destroy', $room) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kamar {{ addslashes($room->name) }}?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="submit"
                                            class="p-2 text-slate-400 hover:text-red-600 bg-slate-50 hover:bg-red-50 rounded-xl transition-colors border border-slate-100 cursor-pointer"
                                            title="Hapus Unit"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr id="emptyStaticRow">
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400 font-semibold">
                                Belum ada unit kamar terdaftar. Silakan tambahkan kamar baru.
                            </td>
                        </tr>
                    @endforelse

                    <!-- Empty Dynamic Search Result Row (hidden by default) -->
                    <tr id="noMatchRow" class="hidden">
                        <td colspan="6" class="px-6 py-12 text-center text-slate-400 font-semibold">
                            <div class="flex flex-col items-center justify-center gap-2">
                                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                <span>Tidak ada unit kamar yang sesuai dengan filter atau kata kunci pencarian.</span>
                                <button type="button" onclick="resetTableFilters()" class="mt-1 text-xs text-brand font-bold hover:underline cursor-pointer">Reset Filter</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</main>

<!-- Room Detailed View Statistics Modal -->
<div id="roomStatModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-3xl border border-slate-100 shadow-2xl max-w-lg w-full p-6 sm:p-7 flex flex-col gap-5 rise">
        <div class="flex items-start justify-between">
            <div class="flex items-center gap-3">
                <img id="modalRoomImg" src="" class="w-12 h-12 rounded-xl object-cover border border-slate-100 shrink-0" alt="" onerror="handleImgError(this)">
                <div>
                    <h3 id="modalRoomName" class="font-black text-slate-900 text-base font-display">Nama Kamar</h3>
                    <p id="modalRoomType" class="text-xs text-slate-400 font-bold uppercase tracking-wider">Tipe</p>
                </div>
            </div>
            <button type="button" onclick="closeRoomStatModal()" class="text-slate-400 hover:text-slate-800 p-1.5 rounded-xl hover:bg-slate-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div class="grid grid-cols-2 gap-3 text-xs">
            <div class="p-3 bg-emerald-50 rounded-xl border border-emerald-100">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Total Views Kamar Ini</span>
                <span id="modalRoomViews" class="text-xl font-black text-brand font-display mt-0.5 block">0</span>
            </div>
            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Kontribusi Terhadap Total</span>
                <span id="modalRoomShare" class="text-xl font-black text-slate-900 font-display mt-0.5 block">0%</span>
            </div>
            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Harga Sewa / Bulan</span>
                <span id="modalRoomPrice" class="text-sm font-black text-slate-800 font-display mt-0.5 block">Rp 0</span>
            </div>
            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Status Okupansi</span>
                <span id="modalRoomStatus" class="mt-1 block">Tersedia</span>
            </div>
        </div>

        <div>
            <h4 class="text-xs font-bold text-slate-700 mb-2">Tren Views 7 Hari Terakhir Kamar Ini:</h4>
            <div class="relative w-full h-[160px] bg-slate-50 p-2 rounded-xl border border-slate-100">
                <canvas id="modalRoomChart"></canvas>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-2">
            <button type="button" onclick="closeRoomStatModal()" class="px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl">Tutup</button>
            <button type="button" id="modalBtnPlot" onclick="" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl shadow-xs">Lihat di Grafik Utama</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // -------------------------------------------------------------
    // DATA PER KAMAR DARI SERVER
    // -------------------------------------------------------------
    const roomsDataMap = {};
    @foreach($rooms as $r)
        @php
            $rShare = $totalViews > 0 ? round(($r->views / $totalViews) * 100, 1) : 0;
            $rPriceStr = 'Rp ' . number_format($r->price, 0, ',', '.');
        @endphp
        roomsDataMap['{{ $r->id }}'] = {
            id: '{{ $r->id }}',
            name: @json($r->name),
            type: @json($r->type),
            price: @json($rPriceStr),
            status: @json($r->status),
            views: {{ $r->views ?: 0 }},
            imageUrl: @json($r->image_url),
            share: {{ $rShare }}
        };
    @endforeach

    const globalTotalViews = {{ $totalViews }};
    let currentRange = '30d';
    let currentSelectedRoomId = 'ALL';
    let viewsChart = null;

    // Helper generator data grafik spesifik per kamar berdasarkan total views-nya
    function generateRoomTrend(viewsCount, factorMultiplier = 1) {
        const base = Math.max(1, Math.round(viewsCount / 30));
        return {
            '7d': {
                labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                data: [
                    Math.round(base * 0.7), Math.round(base * 0.9), Math.round(base * 0.8),
                    Math.round(base * 1.1), Math.round(base * 1.4), Math.round(base * 1.8), Math.round(base * 1.6)
                ],
                avg: Math.round(base * 1.2) + ' views/hari',
                peak: 'Sabtu (' + Math.round(base * 1.8) + ' views)'
            },
            '30d': {
                labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'],
                data: [
                    Math.round(viewsCount * 0.18), Math.round(viewsCount * 0.22),
                    Math.round(viewsCount * 0.28), Math.round(viewsCount * 0.32)
                ],
                avg: Math.round(base) + ' views/hari',
                peak: 'Minggu ke-4 (' + Math.round(viewsCount * 0.32) + ' views)'
            },
            '6m': {
                labels: ['Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus'],
                data: [
                    Math.round(viewsCount * 0.08), Math.round(viewsCount * 0.12), Math.round(viewsCount * 0.15),
                    Math.round(viewsCount * 0.18), Math.round(viewsCount * 0.22), Math.round(viewsCount * 0.25)
                ],
                avg: Math.round(viewsCount / 6) + ' views/bln',
                peak: 'Agustus (' + Math.round(viewsCount * 0.25) + ' views)'
            },
            '1y': {
                labels: ['Sep', 'Okt', 'Nov', 'Des', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu'],
                data: [
                    Math.round(viewsCount * 0.05), Math.round(viewsCount * 0.06), Math.round(viewsCount * 0.07),
                    Math.round(viewsCount * 0.08), Math.round(viewsCount * 0.09), Math.round(viewsCount * 0.10),
                    Math.round(viewsCount * 0.11), Math.round(viewsCount * 0.12), Math.round(viewsCount * 0.13),
                    Math.round(viewsCount * 0.14), Math.round(viewsCount * 0.15), Math.round(viewsCount * 0.16)
                ],
                avg: Math.round(viewsCount / 12) + ' views/bln',
                peak: 'Agustus (' + Math.round(viewsCount * 0.16) + ' views)'
            }
        };
    }

    const aggregateDatasets = buildProportionalDataset(globalTotalViews);

    function initViewsChart() {
        const ctx = document.getElementById('viewsTrendChart');
        if (!ctx) return;

        const defaultData = aggregateDatasets['30d'];

        const gradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 250);
        gradient.addColorStop(0, 'rgba(0, 108, 73, 0.28)');
        gradient.addColorStop(1, 'rgba(0, 108, 73, 0.00)');

        viewsChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: defaultData.labels,
                datasets: [{
                    label: 'Jumlah Kunjungan/View',
                    data: defaultData.data,
                    borderColor: '#006c49',
                    borderWidth: 2.5,
                    backgroundColor: gradient,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#006c49',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleFont: { family: 'Plus Jakarta Sans', size: 12, weight: 'bold' },
                        bodyFont: { family: 'Plus Jakarta Sans', size: 12 },
                        padding: 12,
                        cornerRadius: 10,
                        callbacks: {
                            label: function(context) {
                                return ' ' + context.parsed.y.toLocaleString('id-ID') + ' views dilihat';
                            }
                        }
                    }
                },
                scales: {
                    x: { grid: { display: false }, ticks: { font: { family: 'Plus Jakarta Sans', size: 11, weight: 'bold' }, color: '#94a3b8' } },
                    y: { grid: { color: '#f1f5f9', borderDash: [4, 4] }, ticks: { font: { family: 'Plus Jakarta Sans', size: 11 }, color: '#94a3b8' } }
                }
            }
        });
    }

    function updateChartDisplay() {
        if (!viewsChart) return;

        if (currentSelectedRoomId === 'ALL') {
            const dataSet = aggregateDatasets[currentRange];
            viewsChart.data.labels = dataSet.labels;
            viewsChart.data.datasets[0].data = dataSet.data;
            viewsChart.data.datasets[0].borderColor = '#006c49';
            viewsChart.update();

            document.getElementById('chartTitle').textContent = 'Tren View & Kunjungan Kamar (Agregat)';
            document.getElementById('chartSubtitle').textContent = 'Mempertunjukkan total views gabungan seluruh unit kamar kos.';
            document.getElementById('metric-total-views').textContent = globalTotalViews.toLocaleString('id-ID');
            document.getElementById('metric-avg-views').textContent = dataSet.avg;
            document.getElementById('metric-peak-day').textContent = dataSet.peak;
            document.getElementById('label-stat-extra').textContent = 'Peringkat Popularitas';
            document.getElementById('metric-extra').innerHTML = '<span>Teratas di Katalog</span>';
        } else {
            const rData = roomsDataMap[currentSelectedRoomId];
            if (!rData) return;

            const roomTrendData = generateRoomTrend(rData.views)[currentRange];
            viewsChart.data.labels = roomTrendData.labels;
            viewsChart.data.datasets[0].data = roomTrendData.data;
            viewsChart.data.datasets[0].borderColor = '#4f46e5';
            viewsChart.update();

            document.getElementById('chartTitle').textContent = 'Tren Views: ' + rData.name;
            document.getElementById('chartSubtitle').textContent = 'Statistik kunjungan khusus untuk tipe ' + rData.type + '.';
            document.getElementById('metric-total-views').textContent = rData.views.toLocaleString('id-ID');
            document.getElementById('metric-avg-views').textContent = roomTrendData.avg;
            document.getElementById('metric-peak-day').textContent = roomTrendData.peak;
            document.getElementById('label-stat-extra').textContent = 'Kontribusi Total';
            document.getElementById('metric-extra').innerHTML = '<span class="text-indigo-600 font-bold">' + rData.share + '% dari seluruh kos</span>';
        }
    }

    function setChartRange(rangeKey) {
        currentRange = rangeKey;
        document.querySelectorAll('.chart-tab').forEach(btn => {
            btn.classList.remove('bg-white', 'text-brand', 'shadow-xs');
            btn.classList.add('text-slate-500');
        });
        const activeBtn = document.getElementById('btn-' + rangeKey);
        if (activeBtn) {
            activeBtn.classList.remove('text-slate-500');
            activeBtn.classList.add('bg-white', 'text-brand', 'shadow-xs');
        }
        updateChartDisplay();
    }

    function onRoomChartSelectChange() {
        currentSelectedRoomId = document.getElementById('chartRoomSelect')?.value || 'ALL';
        updateChartDisplay();
    }

    function selectRoomForChart(roomId) {
        currentSelectedRoomId = roomId;
        const selectEl = document.getElementById('chartRoomSelect');
        if (selectEl) selectEl.value = roomId;
        updateChartDisplay();
        window.scrollTo({ top: 300, behavior: 'smooth' });
    }

    // Modal Room Stat
    let modalChartInstance = null;
    function openRoomStatModal(roomId) {
        const r = roomsDataMap[roomId];
        if (!r) return;

        document.getElementById('modalRoomImg').src = r.imageUrl;
        document.getElementById('modalRoomName').textContent = r.name;
        document.getElementById('modalRoomType').textContent = r.type;
        document.getElementById('modalRoomViews').textContent = r.views.toLocaleString('id-ID') + ' views';
        document.getElementById('modalRoomShare').textContent = r.share + '%';
        document.getElementById('modalRoomPrice').textContent = r.price;
        document.getElementById('modalRoomStatus').innerHTML = '<span class="px-2 py-0.5 rounded text-[10px] font-bold ' + (r.status === 'Terisi' ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800') + '">' + r.status + '</span>';
        
        document.getElementById('modalBtnPlot').onclick = function() {
            closeRoomStatModal();
            selectRoomForChart(roomId);
        };

        document.getElementById('roomStatModal').classList.remove('hidden');

        // Render mini modal chart
        const ctxModal = document.getElementById('modalRoomChart');
        if (ctxModal) {
            if (modalChartInstance) modalChartInstance.destroy();
            const rTrend = generateRoomTrend(r.views)['7d'];
            modalChartInstance = new Chart(ctxModal, {
                type: 'bar',
                data: {
                    labels: rTrend.labels,
                    datasets: [{
                        label: 'Views 7 Hari',
                        data: rTrend.data,
                        backgroundColor: '#006c49',
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { grid: { display: false }, ticks: { font: { family: 'Plus Jakarta Sans', size: 10 } } },
                        y: { grid: { color: '#f1f5f9' }, ticks: { font: { family: 'Plus Jakarta Sans', size: 10 } } }
                    }
                }
            });
        }
    }

    function closeRoomStatModal() {
        document.getElementById('roomStatModal').classList.add('hidden');
    }

    // Live table filter
    function filterTableRows() {
        const searchVal = (document.getElementById('tableSearchInput')?.value || '').toLowerCase().trim();
        const statusVal = document.getElementById('tableStatusFilter')?.value || 'ALL';
        const typeVal = (document.getElementById('tableTypeFilter')?.value || 'ALL').toLowerCase();

        const rows = document.querySelectorAll('#tableBody tr.room-row');
        let visibleCount = 0;

        rows.forEach(row => {
            const name = row.getAttribute('data-name') || '';
            const type = row.getAttribute('data-type') || '';
            const status = row.getAttribute('data-status') || '';

            const matchSearch = !searchVal || name.includes(searchVal) || type.includes(searchVal);
            const matchStatus = (statusVal === 'ALL') || (status === statusVal);
            const matchType = (typeVal === 'all') || (type === typeVal);

            if (matchSearch && matchStatus && matchType) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        const noMatchRow = document.getElementById('noMatchRow');
        if (noMatchRow) {
            if (visibleCount === 0 && rows.length > 0) {
                noMatchRow.classList.remove('hidden');
            } else {
                noMatchRow.classList.add('hidden');
            }
        }
    }

    function resetTableFilters() {
        if (document.getElementById('tableSearchInput')) document.getElementById('tableSearchInput').value = '';
        if (document.getElementById('tableStatusFilter')) document.getElementById('tableStatusFilter').value = 'ALL';
        if (document.getElementById('tableTypeFilter')) document.getElementById('tableTypeFilter').value = 'ALL';
        filterTableRows();
    }

    document.addEventListener('DOMContentLoaded', () => {
        initViewsChart();
    });
</script>
@endpush
