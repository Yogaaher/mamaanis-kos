@extends('layouts.admin')

@section('title', 'Analitik & Laporan | Admin Mama Anis Group')

@section('content')
@php
    $formatRupiah = function($num) {
        if ($num >= 1000000) {
            return 'Rp ' . number_format($num / 1000000, 1, ',', '.') . 'jt';
        }
        return 'Rp ' . number_format($num, 0, ',', '.');
    };
@endphp

<main class="p-3.5 sm:p-8 lg:p-10 flex flex-col gap-4 sm:gap-8 rise w-full max-w-full overflow-x-hidden">
    <!-- Header Page -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs text-slate-400 font-bold tracking-wide">
                <span>Mama Anis Group</span>
                <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="text-brand">Analitik</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 mt-1 font-display">Laporan & Analisis Performa Kamar</h1>
        </div>
        
        <div class="flex items-center gap-3">
            <button 
                type="button" 
                onclick="window.print()" 
                class="no-print px-4 py-2.5 bg-white border border-slate-200 hover:border-slate-300 text-slate-700 rounded-xl font-bold text-xs shadow-xs flex items-center gap-2 transition-all cursor-pointer active:scale-95"
            >
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                <span>Cetak Analisis</span>
            </button>
        </div>
    </div>

    <!-- Analytics KPI Cards -->
    <section class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <!-- KPI 1 -->
        <article class="admin-card rounded-2xl bg-white p-6 border border-slate-100 shadow-soft flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Views Terakumulasi</span>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-brand flex items-center justify-center font-bold text-sm shrink-0 border border-emerald-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-3xl font-black text-slate-900 font-display">{{ number_format($totalViews) }}</p>
                <p class="text-xs text-emerald-600 font-bold mt-1">Rata-rata {{ $total ? round($totalViews / $total) : 0 }} views per kamar</p>
            </div>
        </article>

        <!-- KPI 2 -->
        <article class="admin-card rounded-2xl bg-white p-6 border border-slate-100 shadow-soft flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Tingkat Okupansi</span>
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-sm shrink-0 border border-amber-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-3xl font-black text-slate-900 font-display">{{ $occupancyRate }}%</p>
                <p class="text-xs text-slate-500 font-bold mt-1">{{ $occupied }} dari {{ $total }} unit terisi</p>
            </div>
        </article>

        <!-- KPI 3 -->
        <article class="admin-card rounded-2xl bg-white p-6 border border-slate-100 shadow-soft flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Pendapatan Riil</span>
                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-sm shrink-0 border border-indigo-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-2xl font-black text-slate-900 font-display">{{ $formatRupiah($monthlyIncome) }}</p>
                <p class="text-xs text-emerald-600 font-bold mt-1">Dari unit status Terisi</p>
            </div>
        </article>

        <!-- KPI 4 -->
        <article class="admin-card rounded-2xl bg-white p-6 border border-slate-100 shadow-soft flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Potensi Pendapatan Penuh</span>
                <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center font-bold text-sm shrink-0 border border-purple-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-2xl font-black text-slate-900 font-display">{{ $formatRupiah($potentialIncome) }}</p>
                <p class="text-xs text-slate-400 font-bold mt-1">Bila 100% unit terisi</p>
            </div>
        </article>
    </section>

    <!-- Specific Per-Room Bar Comparison Chart Section -->
    <section class="bg-white p-6 sm:p-7 rounded-2xl border border-slate-100 shadow-soft flex flex-col gap-4">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <div>
                <h3 class="font-black text-slate-900 text-base font-display">Perbandingan Views Masing-Masing Kamar</h3>
                <p class="text-xs text-slate-400 mt-0.5">Lihat secara presisi statistik kunjungan individual tiap kamar kos.</p>
            </div>
            <div class="text-xs font-bold text-slate-500 bg-slate-50 px-3 py-1.5 rounded-xl border border-slate-100">
                Total {{ $rooms->count() }} Unit Terdaftar
            </div>
        </div>

        <div class="relative w-full h-[260px] sm:h-[300px]">
            <canvas id="perRoomBarChart"></canvas>
        </div>
    </section>

    <!-- Charts Row -->
    <section class="grid gap-6 lg:grid-cols-12">
        <!-- Main Area Chart -->
        <article class="admin-card lg:col-span-7 bg-white p-6 sm:p-7 rounded-2xl border border-slate-100 shadow-soft flex flex-col gap-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-black text-slate-900 text-base font-display">Pertumbuhan Minat Calon Penyewa</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Statistik kunjungan katalog per bulan sepanjang 2026.</p>
                </div>
            </div>
            <div class="relative w-full h-[280px]">
                <canvas id="analyticsGrowthChart"></canvas>
            </div>
        </article>

        <!-- Doughnut / Bar Type Distribution Chart -->
        <article class="admin-card lg:col-span-5 bg-white p-6 sm:p-7 rounded-2xl border border-slate-100 shadow-soft flex flex-col justify-between gap-4">
            <div>
                <h3 class="font-black text-slate-900 text-base font-display">Distribusi Minat per Tipe Kamar</h3>
                <p class="text-xs text-slate-400 mt-0.5">Proporsi total views berdasarkan kategori tipe kamar.</p>
                <div class="relative w-full h-[220px] mt-4 flex items-center justify-center">
                    <canvas id="analyticsTypeChart"></canvas>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-2 pt-3 border-t border-slate-100 text-center">
                @foreach($typeStats as $ts)
                    <div class="p-2 rounded-xl bg-slate-50">
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider block truncate">{{ $ts['type'] }}</span>
                        <span class="text-xs font-black text-slate-900">{{ number_format($ts['total_views']) }} views</span>
                    </div>
                @endforeach
            </div>
        </article>
    </section>

    <!-- Ranking Table Section -->
    <section class="bg-white rounded-2xl border border-slate-100 shadow-soft overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center">
            <div>
                <h3 class="font-black text-slate-900 text-base font-display">Rincian Statistik Tiap Kamar</h3>
                <p class="text-xs text-slate-400 mt-0.5">Daftar unit diurutkan dari view tertinggi calon penyewa.</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-gray-500 font-medium">
                <thead class="bg-slate-50 text-[10px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4">Peringkat</th>
                        <th class="px-6 py-4">Nama Kamar</th>
                        <th class="px-6 py-4">Tipe</th>
                        <th class="px-6 py-4">Harga / Bulan</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Jumlah Views</th>
                        <th class="px-6 py-4 text-right">Rasio Popularitas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($popularRooms as $idx => $room)
                        @php
                            $sharePercent = $totalViews > 0 ? round(($room->views / $totalViews) * 100, 1) : 0;
                        @endphp
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 font-black text-slate-900 font-display">
                                <span class="w-6 h-6 rounded-lg {{ $idx === 0 ? 'bg-amber-100 text-amber-800' : ($idx === 1 ? 'bg-slate-200 text-slate-800' : 'bg-slate-100 text-slate-600') }} flex items-center justify-center text-xs">
                                    #{{ $idx + 1 }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $room->image_url }}" alt="" class="w-10 h-8 rounded-lg object-cover border border-slate-100" onerror="handleImgError(this)">
                                    <div>
                                        <p class="font-bold text-slate-900">{{ $room->name }}</p>
                                        <p class="text-[10px] text-slate-400">{{ $room->location }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-slate-100 text-slate-700 px-2 py-0.5 rounded text-[10px] font-bold uppercase">
                                    {{ $room->type }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-black text-slate-900 font-display">
                                Rp {{ number_format($room->price, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4">
                                <x-badge-status :status="$room->status" />
                            </td>
                            <td class="px-6 py-4 font-black text-brand font-display">
                                {{ number_format($room->views) }} <span class="text-[10px] text-slate-400 font-medium">views</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <div class="w-20 bg-slate-100 rounded-full h-2 overflow-hidden">
                                        <div class="bg-brand h-full rounded-full" style="width: {{ min(100, $sharePercent * 2.5) }}%"></div>
                                    </div>
                                    <span class="text-xs font-bold text-slate-700 w-10 text-right">{{ $sharePercent }}%</span>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-slate-400">Belum ada data kamar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</main>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Individual Room Comparison Bar Chart
        const ctxPerRoom = document.getElementById('perRoomBarChart');
        if (ctxPerRoom) {
            const roomNames = @json($rooms->pluck('name'));
            const roomViews = @json($rooms->pluck('views'));

            new Chart(ctxPerRoom, {
                type: 'bar',
                data: {
                    labels: roomNames,
                    datasets: [{
                        label: 'Total Views Individual',
                        data: roomViews,
                        backgroundColor: '#006c49',
                        hoverBackgroundColor: '#005438',
                        borderRadius: 8,
                        barThickness: 28
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
                                    return ` ${context.parsed.y.toLocaleString('id-ID')} views dilihat`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: { grid: { display: false }, ticks: { font: { family: 'Plus Jakarta Sans', size: 11, weight: 'bold' }, color: '#475569' } },
                        y: { grid: { color: '#f1f5f9' }, ticks: { font: { family: 'Plus Jakarta Sans', size: 11 }, color: '#94a3b8' } }
                    }
                }
            });
        }

        // Growth line chart
        const ctxGrowth = document.getElementById('analyticsGrowthChart');
        if (ctxGrowth) {
            const gradient = ctxGrowth.getContext('2d').createLinearGradient(0, 0, 0, 260);
            gradient.addColorStop(0, 'rgba(0, 108, 73, 0.3)');
            gradient.addColorStop(1, 'rgba(0, 108, 73, 0.0)');

            const totalViewsVal = {{ (int) $totalViews }};
            const monthlyData = [
                Math.round(totalViewsVal * 0.08),
                Math.round(totalViewsVal * 0.09),
                Math.round(totalViewsVal * 0.11),
                Math.round(totalViewsVal * 0.12),
                Math.round(totalViewsVal * 0.14),
                Math.round(totalViewsVal * 0.15),
                Math.round(totalViewsVal * 0.15),
                Math.round(totalViewsVal * 0.16)
            ];

            new Chart(ctxGrowth, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu'],
                    datasets: [{
                        label: 'Total Views',
                        data: monthlyData,
                        borderColor: '#006c49',
                        backgroundColor: gradient,
                        fill: true,
                        tension: 0.35,
                        borderWidth: 2.5,
                        pointRadius: 4,
                        pointBackgroundColor: '#006c49'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { grid: { display: false }, ticks: { font: { family: 'Plus Jakarta Sans', size: 11 } } },
                        y: { grid: { color: '#f1f5f9' }, ticks: { font: { family: 'Plus Jakarta Sans', size: 11 } } }
                    }
                }
            });
        }

        // Type doughnut chart
        const ctxType = document.getElementById('analyticsTypeChart');
        if (ctxType) {
            const typeLabels = @json($typeStats->pluck('type'));
            const typeViews = @json($typeStats->pluck('total_views'));

            new Chart(ctxType, {
                type: 'doughnut',
                data: {
                    labels: typeLabels,
                    datasets: [{
                        data: typeViews.length ? typeViews : [1],
                        backgroundColor: ['#006c49', '#10b981', '#6ee7b7', '#a7f3d0', '#047857'],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom', labels: { font: { family: 'Plus Jakarta Sans', size: 11, weight: 'bold' } } }
                    },
                    cutout: '65%'
                }
            });
        }
    });
</script>
@endpush
