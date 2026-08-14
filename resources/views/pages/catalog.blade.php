@extends('layouts.app')

@section('title', 'Katalog Kamar | Mama Anis Kos')

@section('content')
@php
    $formatRupiah = function($num) {
        return 'Rp ' . number_format($num, 0, ',', '.');
    };

    $rooms = isset($rooms) ? collect($rooms) : \App\Models\Room::query()->latest()->get();

    // 1. Get query parameters for filtering & sorting
    $search = request('search', '');
    $selectedStatus = request('status', 'Semua');
    $sortBy = request('sort', 'rekomendasi');
    $currentPage = (int)request('page', 1);
    $itemsPerPage = 3;

    // 2. Perform filtering & sorting in PHP (Removed room type query validation)
    $filteredRooms = collect($rooms)->filter(function($room) use ($search, $selectedStatus) {
        $roomData = is_array($room) ? $room : $room->toArray();
        // Search filter
        $matchesSearch = empty($search) || 
            (str_contains(strtolower($roomData['name'] ?? ''), strtolower($search)) || 
             str_contains(strtolower($roomData['type'] ?? ''), strtolower($search)));

        // Status filter
        $matchesStatus = $selectedStatus === 'Semua' || ($roomData['status'] ?? '') === $selectedStatus;

        return $matchesSearch && $matchesStatus;
    });

    // Sort collection (Removed rating sorting option)
    if ($sortBy === 'lowest') {
        $filteredRooms = $filteredRooms->sortBy('price');
    } elseif ($sortBy === 'highest') {
        $filteredRooms = $filteredRooms->sortByDesc('price');
    } else {
        // Rekomendasi (Sort by Views count)
        $filteredRooms = $filteredRooms->sortByDesc('views');
    }

    // 3. Paginate results
    $totalItems = $filteredRooms->count();
    $totalPages = max(1, (int)ceil($totalItems / $itemsPerPage));
    $currentPage = min($totalPages, max(1, $currentPage));
    $startIndex = ($currentPage - 1) * $itemsPerPage;
    $paginatedRooms = $filteredRooms->slice($startIndex, $itemsPerPage);
@endphp

<div class="pt-4 sm:pt-8 pb-16 sm:pb-20 font-sans bg-[#f8f9fb] min-h-screen">
    <!-- Aligned to max-w-7xl px-4 sm:px-8 for perfect desktop alignment -->
    <div class="max-w-7xl mx-auto px-4 sm:px-8">
        <!-- Header Section -->
        <div class="mb-6 sm:mb-8 text-center flex flex-col gap-1.5 sm:gap-2">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight font-display">
                Katalog Kamar
            </h1>
            <p class="text-gray-500 text-xs sm:text-sm md:text-base max-w-2xl mx-auto leading-relaxed px-2">
                Pilihan kamar kos yang bersih, nyaman, dan terjangkau di kawasan Tangerang.
            </p>
        </div>

        <!-- Anti-Fraud Security Notice Banner in Catalog -->
        <div class="mb-6 sm:mb-8 p-3.5 sm:p-4 rounded-xl sm:rounded-2xl bg-amber-50 border border-amber-200/80 shadow-2xs flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 text-xs">
            <div class="flex items-center gap-2.5 sm:gap-3">
                <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg sm:rounded-xl bg-amber-500 text-white flex items-center justify-center shrink-0">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div class="text-[11px] sm:text-xs">
                    <span class="font-bold text-amber-950">Transaksi Resmi & Aman:</span>
                    <span class="text-amber-900 ml-1">Pembayaran sewa sah hanya ke <strong>Bank Mandiri a.n. MARLIYAH</strong> & WA <strong>0877-8204-9784</strong>.</span>
                </div>
            </div>
            <button 
                type="button" 
                onclick="openSecurityModal()" 
                class="w-full sm:w-auto text-center px-3 py-1.5 bg-amber-200/80 hover:bg-amber-300 text-amber-950 rounded-lg sm:rounded-xl font-bold transition-colors shrink-0 cursor-pointer text-[10px] sm:text-[11px]"
            >
                Cek Verifikasi Keamanan
            </button>
        </div>

        <!-- Filter and Search Bar Section -->
        <div class="bg-white p-3.5 sm:p-5 rounded-2xl sm:rounded-3xl border border-gray-100 shadow-xs mb-6 sm:mb-8 flex flex-col gap-3 sm:gap-4">
            <form action="/catalog" method="GET" class="flex flex-col gap-3 sm:gap-4">
                <div class="flex flex-col md:flex-row gap-2.5 sm:gap-3">
                    <!-- Search Input -->
                    <div class="relative flex-1">
                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input
                            type="text"
                            name="search"
                            placeholder="Cari kamar berdasarkan nama, tipe..."
                            value="{{ $search }}"
                            class="w-full pl-10 pr-4 py-2.5 sm:py-3 bg-gray-50 border border-gray-100 rounded-xl text-xs sm:text-sm outline-none focus:bg-white focus:border-[#006c49] transition-all font-medium"
                        />
                    </div>
                    
                    <!-- Sort Dropdown (Removed rating option) -->
                    <div class="w-full md:w-48">
                        <select
                            name="sort"
                            onchange="this.form.submit()"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl text-sm outline-none focus:bg-white focus:border-[#006c49] text-gray-700 transition-all cursor-pointer font-bold"
                        >
                            <option value="rekomendasi" {{ $sortBy === 'rekomendasi' ? 'selected' : '' }}>Rekomendasi</option>
                            <option value="lowest" {{ $sortBy === 'lowest' ? 'selected' : '' }}>Harga Terendah</option>
                            <option value="highest" {{ $sortBy === 'highest' ? 'selected' : '' }}>Harga Tertinggi</option>
                        </select>
                    </div>
                </div>

                <!-- Hidden inputs to preserve filters when submitting search -->
                <input type="hidden" name="status" value="{{ $selectedStatus }}">

                <!-- Quick Filter Selects -->
                <div class="flex flex-wrap items-center gap-4 pt-3 border-t border-gray-55">
                    <div class="flex items-center gap-1.5 text-xs font-bold text-gray-400 uppercase tracking-wider">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                        </svg>
                        <span>Filter Status:</span>
                    </div>

                    <!-- Status Filter Buttons (Semua, Tersedia, Terisi - Kept exclusively as requested) -->
                    <div class="flex gap-2">
                        @foreach(['Semua', 'Tersedia', 'Terisi'] as $status)
                            <a
                                href="/catalog?{{ http_build_query(array_merge(request()->query(), ['status' => $status, 'page' => 1])) }}"
                                class="px-4 py-1.5 rounded-full text-xs font-semibold cursor-pointer transition-all {{ $selectedStatus === $status ? 'bg-slate-900 text-white shadow-xs' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
                            >
                                {{ $status }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </form>
        </div>

        <!-- Room List Container -->
        <div class="flex flex-col gap-6">
            @if($paginatedRooms->count() > 0)
                @foreach($paginatedRooms as $room)
                    <x-card-kamar :room="$room" layout="horizontal" />
                @endforeach
            @else
                <div class="text-center bg-white p-16 rounded-3xl border border-gray-100 text-gray-400 shadow-xs">
                    <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <p class="font-extrabold text-lg text-gray-700 font-display">Tidak ada kamar ditemukan</p>
                    <p class="text-sm text-gray-400 mt-1">Coba sesuaikan kata kunci pencarian atau bersihkan filter Anda.</p>
                </div>
            @endif
        </div>

        <!-- Pagination Section -->
        @if($totalPages > 1)
            <div class="mt-12 flex justify-center items-center gap-2">
                <!-- Previous Button -->
                @if($currentPage > 1)
                    <a
                        href="/catalog?{{ http_build_query(array_merge(request()->query(), ['page' => $currentPage - 1])) }}"
                        class="w-10 h-10 flex items-center justify-center rounded-xl border border-gray-200 bg-white text-gray-600 hover:bg-gray-100 transition-colors"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"></path>
                        </svg>
                    </a>
                @else
                    <div class="w-10 h-10 flex items-center justify-center rounded-xl border border-gray-200 bg-gray-50 text-gray-300 opacity-50 cursor-not-allowed">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"></path>
                        </svg>
                    </div>
                @endif

                <!-- Page Numbers -->
                @for($page = 1; $page <= $totalPages; $page++)
                    <a
                        href="/catalog?{{ http_build_query(array_merge(request()->query(), ['page' => $page])) }}"
                        class="w-10 h-10 flex items-center justify-center rounded-xl font-bold text-sm transition-all {{ $currentPage === $page ? 'bg-[#006c49] text-white shadow-md' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}"
                    >
                        {{ $page }}
                    </a>
                @endfor

                <!-- Next Button -->
                @if($currentPage < $totalPages)
                    <a
                        href="/catalog?{{ http_build_query(array_merge(request()->query(), ['page' => $currentPage + 1])) }}"
                        class="w-10 h-10 flex items-center justify-center rounded-xl border border-gray-200 bg-white text-gray-600 hover:bg-gray-100 transition-colors"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"></path>
                        </svg>
                    </a>
                @else
                    <div class="w-10 h-10 flex items-center justify-center rounded-xl border border-gray-200 bg-gray-50 text-gray-300 opacity-50 cursor-not-allowed">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"></path>
                        </svg>
                    </div>
                @endif
            </div>
        @endif

        <!-- Dynamic CTA Card (Matches Home & About) -->
        <section class="mt-12 sm:mt-16 cta-dynamic-card relative rounded-2xl sm:rounded-[2.5rem] p-5 sm:p-14 text-center border border-emerald-400/40 shadow-xl overflow-hidden cursor-default group" style="background: linear-gradient(-45deg, #00422b, #006c49, #005a3c, #00875c, #003320); background-size: 300% 300%; animation: ctaGradientFlow 12s ease infinite;">
            <!-- Ambient Moving Auras -->
            <div class="ambient-aura-1 absolute -top-20 -right-20 w-96 h-96 rounded-full bg-gradient-to-br from-emerald-300/40 via-teal-300/30 to-emerald-500/20 blur-3xl pointer-events-none"></div>
            <div class="ambient-aura-2 absolute -bottom-20 -left-20 w-96 h-96 rounded-full bg-gradient-to-tr from-lime-300/35 via-emerald-400/30 to-teal-400/25 blur-3xl pointer-events-none"></div>
            <div class="ambient-aura-3 absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[32rem] h-[32rem] rounded-full bg-teal-300/25 blur-3xl pointer-events-none"></div>
            
            <!-- Card Content -->
            <div class="relative z-10 max-w-2xl mx-auto flex flex-col items-center gap-2.5 sm:gap-4">
                <div class="w-10 h-10 sm:w-16 sm:h-16 rounded-full bg-white/15 text-white flex items-center justify-center mb-0.5 sm:mb-1 shadow-inner border border-white/20">
                    <svg class="w-5 h-5 sm:w-8 sm:h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </div>
                <h2 class="text-xl sm:text-3xl md:text-4xl font-black font-display tracking-tight leading-tight text-white">
                    Siap Menemukan Kamar Pilihan Anda?
                </h2>
                <p class="text-emerald-100 text-xs sm:text-base leading-relaxed font-sans max-w-lg">
                    Tanyakan ketersediaan kamar, tarif sewa, atau jadwalkan survei langsung ke Mama Anis Kos dengan mudah melalui WhatsApp.
                </p>
                <div class="mt-2 sm:mt-4 w-full sm:w-auto">
                    <a 
                        href="https://wa.me/6287782049784?text=Halo%20Mama%20Anis%20Kos%2C%20saya%20tertarik%20untuk%20bertanya%20tentang%20kamar%20kos.%20Terima%20kasih%21" 
                        target="_blank" 
                        rel="noopener" 
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 sm:gap-3 bg-white text-[#006c49] font-bold text-xs sm:text-base px-6 py-3 sm:px-10 sm:py-4 rounded-full shadow-2xl hover:bg-emerald-50 hover:scale-105 active:scale-95 transition-all duration-300 cursor-pointer font-sans"
                    >
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 fill-current text-[#006c49]" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.455L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.825 1.451 5.436 0 9.86-4.37 9.864-9.799.002-2.63-1.023-5.101-2.885-6.965C16.528 1.977 14.07 1.951 12.01 1.95c-5.438 0-9.864 4.372-9.868 9.8-.001 1.714.463 3.39 1.341 4.877L2.45 21.11l4.197-1.956z"/>
                        </svg>
                        <span>Hubungi Kami via WhatsApp</span>
                    </a>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
