@extends('layouts.app')

@section('title', ($room['name'] ?? 'Detail Kamar') . ' | Mama Anis Kos')

@section('content')
@php
    $formatRupiah = function($num) {
        return 'Rp ' . number_format($num, 0, ',', '.');
    };

    $roomData = is_array($room) ? $room : $room->toArray();
    $id = $roomData['id'] ?? '';
    $name = $roomData['name'] ?? 'Kamar Kost Mama Anis';
    $type = $roomData['type'] ?? 'Kamar Standard Eksklusif';
    $location = $roomData['location'] ?? 'Alam Sutera, Tangerang';
    $price = $roomData['price'] ?? 1800000;
    $status = $roomData['status'] ?? 'Tersedia';
    $rating = $roomData['rating'] ?? 4.9;
    $views = $roomData['views'] ?? 0;
    $image = $roomData['image_url'] ?? 'https://images.unsplash.com/photo-1522771739844-6a9f6d5f14af?auto=format&fit=crop&w=1200&q=85';
    $bathroomImage = $roomData['bathroom_image_url'] ?? 'https://images.unsplash.com/photo-1584622781867-46d5a47a07c5?auto=format&fit=crop&w=1200&q=85';
    $minStay = $roomData['min_stay'] ?? '1 Bulan';
    $maxOccupants = $roomData['max_occupants'] ?? 1;
    $amenities = $roomData['amenities'] ?? ['Kamar Mandi Dalam', 'AC', 'WiFi Cepat', 'Kasur Springbed', 'Lemari Pakaian', 'Meja Kerja'];
    $size = $roomData['size'] ?? 16;
    $beds = $roomData['beds'] ?? 1;
    $description = $roomData['description'] ?? 'Unit kamar kost Mama Anis dirancang khusus untuk kenyamanan dan privasi 1 orang penghuni. Dilengkapi fasilitas kamar mandi dalam yang bersih dan higienis, AC, kasur berkualitas, lemari pakaian, meja kerja/belajar, dan koneksi internet WiFi stabil.';
    
    // WhatsApp pre-configured message text
    $whatsappText = "Halo Mama Anis Kos, saya tertarik untuk menyewa unit \"{$name}\" di {$location} dengan tarif sewa {$formatRupiah($price)}/bulan (Minimal sewa {$minStay}, kapasitas max {$maxOccupants} orang). Apakah kamar ini masih tersedia? Terima kasih!";
    $whatsappUrl = "https://wa.me/6287782049784?text=" . rawurlencode($whatsappText);

    // Fetch related rooms dynamically
    $relatedRooms = \App\Models\Room::query()->where('id', '!=', $id)->latest()->take(3)->get();
@endphp

<div class="pt-4 sm:pt-8 pb-16 sm:pb-20 font-sans bg-[#f8f9fb] min-h-screen">
    <!-- Aligned to max-w-7xl px-4 sm:px-8 for perfect symmetry -->
    <div class="max-w-7xl mx-auto px-4 sm:px-8">
        <!-- Top Back Navigation Bar -->
        <div class="mb-4 sm:mb-6 flex items-center justify-between gap-3">
            <a 
                href="/catalog" 
                class="inline-flex items-center gap-2 text-xs sm:text-sm font-bold text-gray-700 hover:text-[#006c49] bg-white border border-gray-200 hover:border-emerald-300 px-3.5 py-2 rounded-xl shadow-2xs hover:shadow-xs transition-all cursor-pointer group active:scale-95 shrink-0"
            >
                <svg class="w-4 h-4 text-gray-500 group-hover:text-[#006c49] transition-transform group-hover:-translate-x-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                </svg>
                <span>Kembali ke Katalog</span>
            </a>
            
            <div class="hidden sm:flex items-center gap-2 text-xs text-gray-400 font-medium">
                <a href="/" class="hover:text-[#006c49] transition-colors">Beranda</a>
                <span>/</span>
                <a href="/catalog" class="hover:text-[#006c49] transition-colors">Kamar</a>
                <span>/</span>
                <span class="text-gray-600 font-bold truncate max-w-[220px]">{{ $name }}</span>
            </div>
        </div>

        <div class="grid gap-6 lg:gap-8 lg:grid-cols-12 items-start">
            <!-- Left Side: Main details -->
            <div class="lg:col-span-8 flex flex-col gap-6 sm:gap-8">
                <!-- Large Image & Gallery (Foto Kamar & Foto Kamar Mandi) with Arrows, Swipe, and Previews -->
                <div class="bg-white p-3 sm:p-4 rounded-2xl sm:rounded-3xl border border-gray-100 shadow-xs flex flex-col gap-3 sm:gap-4">
                    <div id="gallery-carousel-container" class="relative aspect-[16/10] w-full overflow-hidden rounded-xl sm:rounded-2xl bg-slate-100 select-none cursor-grab active:cursor-grabbing">
                        <img
                            id="main-room-gallery"
                            src="{{ $image }}"
                            alt="{{ $name }}"
                            class="w-full h-full object-cover transition-opacity duration-300"
                            onerror="handleImgError(this)"
                        />

                        <!-- Floating Left Navigation Arrow -->
                        <button 
                            type="button" 
                            onclick="prevGalleryImage()" 
                            class="absolute left-2.5 sm:left-4 top-1/2 -translate-y-1/2 w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-black/50 hover:bg-black/80 text-white backdrop-blur-md flex items-center justify-center cursor-pointer transition-all shadow-md active:scale-90 z-20"
                            aria-label="Foto Sebelumnya"
                        >
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
                            </svg>
                        </button>

                        <!-- Floating Right Navigation Arrow -->
                        <button 
                            type="button" 
                            onclick="nextGalleryImage()" 
                            class="absolute right-2.5 sm:right-4 top-1/2 -translate-y-1/2 w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-black/50 hover:bg-black/80 text-white backdrop-blur-md flex items-center justify-center cursor-pointer transition-all shadow-md active:scale-90 z-20"
                            aria-label="Foto Berikutnya"
                        >
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                            </svg>
                        </button>

                        <!-- Caption Badge -->
                        <div id="gallery-badge" class="absolute bottom-2.5 left-2.5 sm:bottom-3.5 sm:left-3.5 bg-black/65 backdrop-blur-md text-white text-[10px] sm:text-xs font-bold px-3 py-1 rounded-full shadow-md z-20">
                            1 / 2 • Foto Kamar Tidur
                        </div>

                        <!-- Dots Indicator -->
                        <div class="absolute bottom-2.5 right-2.5 sm:bottom-3.5 sm:right-3.5 flex items-center gap-1.5 z-20 bg-black/40 backdrop-blur-xs px-2.5 py-1 rounded-full">
                            <button type="button" onclick="setGalleryIndex(0)" id="gallery-dot-0" class="w-2 h-2 rounded-full bg-white transition-all cursor-pointer" aria-label="Slide 1"></button>
                            <button type="button" onclick="setGalleryIndex(1)" id="gallery-dot-1" class="w-2 h-2 rounded-full bg-white/40 transition-all cursor-pointer" aria-label="Slide 2"></button>
                        </div>
                    </div>
                    
                    <!-- Clickable Thumbnails row under placeholder -->
                    <div class="grid grid-cols-2 gap-2 sm:gap-3">
                        <!-- Thumbnail 1: Foto Kamar Utama -->
                        <button 
                            type="button"
                            id="thumb-btn-0"
                            onclick="setGalleryIndex(0)" 
                            class="gallery-thumb flex items-center gap-2 sm:gap-3 p-1.5 sm:p-2 rounded-xl sm:rounded-2xl border-2 border-[#006c49] bg-emerald-50/50 focus:outline-none transition-all cursor-pointer text-left"
                        >
                            <div class="w-12 h-10 sm:w-16 sm:h-12 rounded-lg sm:rounded-xl overflow-hidden shrink-0 bg-slate-200">
                                <img src="{{ $image }}" class="w-full h-full object-cover" alt="Foto Kamar" onerror="handleImgError(this)">
                            </div>
                            <div class="truncate">
                                <span class="text-[11px] sm:text-xs font-bold text-gray-900 block truncate">1. Kamar Tidur</span>
                                <span class="text-[9px] sm:text-[10px] text-gray-500">Tampilan Utama</span>
                            </div>
                        </button>

                        <!-- Thumbnail 2: Foto Kamar Mandi Dalam -->
                        <button 
                            type="button"
                            id="thumb-btn-1"
                            onclick="setGalleryIndex(1)" 
                            class="gallery-thumb flex items-center gap-2 sm:gap-3 p-1.5 sm:p-2 rounded-xl sm:rounded-2xl border border-gray-200 hover:border-gray-300 bg-white focus:outline-none transition-all cursor-pointer text-left"
                        >
                            <div class="w-12 h-10 sm:w-16 sm:h-12 rounded-lg sm:rounded-xl overflow-hidden shrink-0 bg-slate-200">
                                <img src="{{ $bathroomImage }}" class="w-full h-full object-cover" alt="Foto Kamar Mandi" onerror="handleImgError(this)">
                            </div>
                            <div class="truncate">
                                <span class="text-[11px] sm:text-xs font-bold text-gray-900 block truncate">2. Kamar Mandi</span>
                                <span class="text-[9px] sm:text-[10px] text-gray-500">Kamar Mandi Dalam</span>
                            </div>
                        </button>
                    </div>
                </div>

                <!-- Main Specifications -->
                <div class="bg-white p-4 sm:p-8 rounded-2xl sm:rounded-3xl border border-gray-100 shadow-xs flex flex-col gap-4 sm:gap-6">
                    <div class="flex justify-between items-start gap-4">
                        <div>
                            <div class="flex items-center gap-2 flex-wrap">
                                <h1 class="text-xl sm:text-2xl md:text-3xl font-extrabold text-gray-900 leading-tight font-display">
                                    {{ $name }}
                                </h1>
                                <x-badge-status :status="$status" />
                            </div>
                            <p class="text-xs text-gray-400 mt-1 flex items-center gap-1.5 font-medium">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span>{{ $location }}</span>
                            </p>
                        </div>
                    </div>

                    <!-- Specs specs icons/tags -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 sm:gap-4 py-3 sm:py-4 px-3 sm:px-5 bg-gray-50 rounded-xl sm:rounded-2xl border border-gray-100 text-center">
                        <!-- Luas -->
                        <div class="flex flex-col items-center gap-1">
                            <span class="w-5 h-5 sm:w-6 sm:h-6 text-[#006c49] flex items-center justify-center">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5v-4m0 4h-4m4 0l-5-5"/>
                                </svg>
                            </span>
                            <span class="text-[9px] sm:text-[10px] font-bold text-gray-400 uppercase">Luas Kamar</span>
                            <span class="text-xs sm:text-sm font-extrabold text-gray-900">{{ $size }} m²</span>
                        </div>

                        <!-- Tempat Tidur -->
                        <div class="flex flex-col items-center gap-1">
                            <span class="w-5 h-5 sm:w-6 sm:h-6 text-[#006c49] flex items-center justify-center">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10V6a2 2 0 012-2h14a2 2 0 012 2v4M3 10v6a2 2 0 002 2h16a2 2 0 002-2v-6M3 10h18M7 14h1m8 0h1"/>
                                </svg>
                            </span>
                            <span class="text-[9px] sm:text-[10px] font-bold text-gray-400 uppercase">Tempat Tidur</span>
                            <span class="text-xs sm:text-sm font-extrabold text-gray-900">{{ $beds }} Kasur</span>
                        </div>

                        <!-- Kamar Mandi -->
                        <div class="flex flex-col items-center gap-1">
                            <span class="w-5 h-5 sm:w-6 sm:h-6 text-[#006c49] flex items-center justify-center">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 10h16m-16 0v8a2 2 0 002 2h12a2 2 0 002-2v-8m-16 0V6a2 2 0 012-2h2m10 2v4M8 6V4"/>
                                </svg>
                            </span>
                            <span class="text-[9px] sm:text-[10px] font-bold text-gray-400 uppercase">Toilet</span>
                            <span class="text-xs sm:text-sm font-extrabold text-gray-900">Mandi Dalam</span>
                        </div>

                        <!-- Kapasitas Max 1 Orang -->
                        <div class="flex flex-col items-center gap-1">
                            <span class="w-5 h-5 sm:w-6 sm:h-6 text-[#006c49] flex items-center justify-center">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </span>
                            <span class="text-[9px] sm:text-[10px] font-bold text-gray-400 uppercase">Kapasitas</span>
                            <span class="text-xs sm:text-sm font-extrabold text-gray-900">Maks. {{ $maxOccupants }} Orang</span>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="flex flex-col gap-2 pt-4 sm:pt-6 border-t border-gray-100">
                        <h4 class="font-extrabold text-gray-900 text-sm sm:text-base font-display">Tentang Kamar Ini</h4>
                        <div class="text-xs sm:text-sm text-gray-600 leading-relaxed sm:leading-loose font-sans whitespace-pre-line bg-gray-50/70 p-3.5 sm:p-5 rounded-xl sm:rounded-2xl border border-gray-100/80">
                            {{ $description }}
                        </div>
                    </div>

                    <!-- Facilities with accurate vector icons -->
                    <div class="flex flex-col gap-2.5 sm:gap-3 pt-4 sm:pt-6 border-t border-gray-100">
                        <h4 class="font-extrabold text-gray-900 text-sm sm:text-base font-display">Fasilitas Unit</h4>
                        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-2 sm:gap-3 text-xs sm:text-sm text-gray-700 font-medium">
                            @forelse($amenities as $amenity)
                                <div class="flex items-center gap-2 sm:gap-2.5 p-2.5 sm:p-3 rounded-xl sm:rounded-2xl bg-emerald-50/50 border border-emerald-100 hover:bg-emerald-50 transition-colors">
                                    <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-lg sm:rounded-xl bg-white flex items-center justify-center shadow-2xs shrink-0 border border-emerald-100/60">
                                        <x-amenity-icon :amenity="$amenity" class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-[#006c49] shrink-0" />
                                    </div>
                                    <span class="font-semibold text-gray-800 text-[11px] sm:text-xs truncate">{{ $amenity }}</span>
                                </div>
                            @empty
                                <div class="flex items-center gap-2">
                                    <x-amenity-icon amenity="Kamar Mandi Dalam" class="w-4 h-4 text-[#006c49] shrink-0" />
                                    <span>Kamar Mandi Dalam</span>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Booking Card (Static on mobile, Sticky on Desktop) -->
            <div class="lg:col-span-4 static lg:sticky lg:top-28 space-y-4">
                <div class="bg-white p-4.5 sm:p-7 rounded-2xl sm:rounded-3xl border border-gray-100 shadow-soft flex flex-col gap-4 sm:gap-5">
                    <div>
                        <span class="text-[9px] sm:text-[10px] text-gray-400 font-bold uppercase tracking-widest block">Tarif Sewa Kamar</span>
                        <div class="flex items-baseline gap-1 mt-1">
                            <span class="text-2xl sm:text-3xl font-black text-[#006c49] font-display">
                                {{ $formatRupiah($price) }}
                            </span>
                            <span class="text-xs text-gray-400 font-medium">/ bulan</span>
                        </div>
                        <div class="mt-1.5 sm:mt-2 flex items-center gap-1.5 text-xs text-[#006c49] font-bold">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-[#006c49] shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>{{ $status === 'Tersedia' ? 'Unit Siap Ditempati' : 'Status: ' . $status }}</span>
                        </div>
                    </div>

                    <div class="flex flex-col gap-2 sm:gap-2.5 py-3 border-y border-gray-100 text-xs font-semibold text-gray-600">
                        <div class="flex justify-between items-center">
                            <span>Minimal Durasi Sewa</span>
                            <span class="text-gray-900 font-bold bg-emerald-50 px-2 py-0.5 rounded-md text-emerald-800 text-[11px] sm:text-xs">{{ $minStay }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span>Kapasitas Penghuni</span>
                            <span class="text-gray-900 font-bold text-[11px] sm:text-xs">Maks. {{ $maxOccupants }} Orang</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span>Kamar Mandi</span>
                            <span class="text-gray-900 font-bold text-[11px] sm:text-xs">Pribadi (Dalam)</span>
                        </div>
                    </div>

                    <!-- Anti-Fraud & Payment Security Card in Booking Column -->
                    <div class="p-3 sm:p-3.5 rounded-xl sm:rounded-2xl bg-amber-50/80 border border-amber-200/80 flex flex-col gap-2 text-xs">
                        <div class="flex items-center gap-1.5">
                            <span class="w-4 h-4 sm:w-5 sm:h-5 rounded-full bg-amber-500 text-white flex items-center justify-center shrink-0">
                                <svg class="w-2.5 h-2.5 sm:w-3 sm:h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </span>
                            <span class="font-extrabold text-amber-900 text-[10px] sm:text-[11px] uppercase tracking-wide">Rekening Resmi Sah</span>
                        </div>
                        <div class="bg-white p-2 sm:p-2.5 rounded-lg sm:rounded-xl border border-amber-200/60 flex items-center justify-between gap-2">
                            <div>
                                <span class="text-[9px] sm:text-[10px] text-gray-400 font-bold block">BANK MANDIRI</span>
                                <span class="font-mono font-black text-gray-900 text-[11px] sm:text-xs">a.n. MARLIYAH</span>
                            </div>
                            <button 
                                id="copyMandiriBtn"
                                type="button" 
                                onclick="copyMandiriAccount()" 
                                class="text-[9px] sm:text-[10px] font-bold bg-amber-100 hover:bg-amber-200 text-amber-900 px-2.5 py-1 rounded-lg transition-all cursor-pointer shrink-0"
                            >
                                Salin Info
                            </button>
                        </div>
                        <p class="text-[9px] sm:text-[10px] text-amber-800 leading-tight">
                            ⚠️ <em>Hati-hati penipuan! Jangan transfer ke rekening selain nama <strong>MARLIYAH</strong>.</em>
                        </p>
                    </div>

                    <div class="flex flex-col gap-2">
                        @if($status === 'Tersedia')
                            <button
                                type="button"
                                onclick="openBookingSafetyPrompt('{{ $whatsappUrl }}')"
                                class="w-full bg-[#006c49] hover:bg-[#005236] text-white py-3 sm:py-3.5 rounded-full font-bold shadow-md hover:shadow-lg transition-all active:scale-95 flex items-center justify-center gap-2 text-xs sm:text-sm cursor-pointer"
                            >
                                <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.455L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.825 1.451 5.436 0 9.86-4.37 9.864-9.799.002-2.63-1.023-5.101-2.885-6.965C16.528 1.977 14.07 1.951 12.01 1.95c-5.438 0-9.864 4.372-9.868 9.8-.001 1.714.463 3.39 1.341 4.877L2.45 21.11l4.197-1.956z"></path>
                                </svg>
                                <span>Tanya & Booking via WA</span>
                            </button>
                        @else
                            <button
                                disabled
                                class="w-full bg-gray-100 text-gray-400 py-3 sm:py-3.5 rounded-full font-bold cursor-not-allowed text-xs sm:text-sm"
                            >
                                Sedang Tidak Tersedia ({{ $status }})
                            </button>
                        @endif
                        <p class="text-[9px] sm:text-[10px] text-gray-400 text-center font-medium">Pengelola: WA 0877-8204-9784</p>
                    </div>
                </div>
            </div>
        </div>

        @if($relatedRooms->count() > 0)
        <!-- Related Rooms -->
        <section class="mt-8 sm:mt-16 border-t border-gray-100 pt-8 sm:pt-14">
            <h3 class="text-xl sm:text-2xl font-extrabold text-gray-900 font-display mb-6 sm:mb-8">
                Unit Lainnya
            </h3>
            
            <div class="grid gap-4 sm:gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($relatedRooms as $relRoom)
                    <x-card-kamar :room="$relRoom" layout="vertical" />
                @endforeach
            </div>
        </section>
        @endif
    </div>
</div>

<!-- Pre-WhatsApp Booking Safety Confirmation Modal -->
<div 
    id="bookingSafetyModal" 
    class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm z-[100] flex items-center justify-center p-4 transition-opacity duration-300 opacity-0 pointer-events-none"
    role="dialog"
    aria-modal="true"
>
    <div class="bg-white rounded-3xl border border-amber-100 shadow-2xl max-w-md w-full p-6 sm:p-7 flex flex-col gap-5 transform transition-all duration-300 scale-95">
        <div class="flex items-center gap-3 border-b border-gray-100 pb-3">
            <div class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center shrink-0 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div>
                <h3 class="font-extrabold text-gray-900 text-base font-display">Konfirmasi Keamanan Booking</h3>
                <p class="text-[11px] text-gray-400">Verifikasi sebelum terhubung ke WhatsApp</p>
            </div>
        </div>

        <div class="space-y-2.5 text-xs text-gray-600 font-sans">
            <div class="p-3 bg-emerald-50/70 rounded-xl border border-emerald-100 flex items-start gap-2.5">
                <svg class="w-4 h-4 text-[#006c49] shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                <span>Nomor WA Pengelola Resmi: <strong class="text-gray-900 font-mono">0877-8204-9784</strong></span>
            </div>

            <div class="p-3 bg-amber-50/70 rounded-xl border border-amber-200 flex items-start gap-2.5">
                <svg class="w-4 h-4 text-amber-700 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                <span>Rekening Resmi Pembayaran Sah: <strong class="text-gray-900 font-mono">Bank Mandiri a.n. MARLIYAH</strong></span>
            </div>

            <p class="text-[11px] text-red-600 leading-tight">
                ⚠️ Transaksi di luar nomor WA dan rekening Mandiri a.n. MARLIYAH bukan tanggung jawab Mama Anis Kos.
            </p>
        </div>

        <div class="grid grid-cols-2 gap-3 pt-2">
            <button 
                type="button" 
                onclick="closeBookingSafetyModal()" 
                class="py-3 px-4 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 text-xs font-bold transition-colors cursor-pointer"
            >
                Batal
            </button>
            <a 
                id="targetBookingWaLink"
                href="{{ $whatsappUrl }}" 
                target="_blank" 
                rel="noopener"
                onclick="closeBookingSafetyModal()"
                class="py-3 px-4 rounded-xl bg-[#006c49] hover:bg-[#005236] text-white text-xs font-bold transition-all shadow-md shadow-[#006c49]/20 flex items-center justify-center gap-1.5 cursor-pointer text-center"
            >
                <span>Lanjut ke WA</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const galleryItems = [
        { url: @json($image), title: '1 / 2 • Foto Kamar Tidur' },
        { url: @json($bathroomImage), title: '2 / 2 • Foto Kamar Mandi Dalam' }
    ];
    let currentGalleryIdx = 0;

    function setGalleryIndex(idx) {
        if (idx < 0) idx = galleryItems.length - 1;
        if (idx >= galleryItems.length) idx = 0;
        currentGalleryIdx = idx;

        const mainImg = document.getElementById('main-room-gallery');
        const badge = document.getElementById('gallery-badge');
        
        if (mainImg) {
            mainImg.style.opacity = '0.3';
            setTimeout(() => {
                mainImg.src = galleryItems[currentGalleryIdx].url;
                mainImg.style.opacity = '1';
            }, 120);
        }

        if (badge) {
            badge.textContent = galleryItems[currentGalleryIdx].title;
        }

        // Update Dots
        for (let i = 0; i < galleryItems.length; i++) {
            const dot = document.getElementById(`gallery-dot-${i}`);
            if (dot) {
                if (i === currentGalleryIdx) {
                    dot.className = 'w-4 h-2 rounded-full bg-white transition-all cursor-pointer';
                } else {
                    dot.className = 'w-2 h-2 rounded-full bg-white/40 transition-all cursor-pointer';
                }
            }
        }

        // Update Thumbnails
        document.querySelectorAll('.gallery-thumb').forEach((thumb, i) => {
            if (i === currentGalleryIdx) {
                thumb.classList.remove('border-gray-200', 'hover:border-gray-300', 'bg-white');
                thumb.classList.add('border-2', 'border-[#006c49]', 'bg-emerald-50/50');
            } else {
                thumb.classList.remove('border-2', 'border-[#006c49]', 'bg-emerald-50/50');
                thumb.classList.add('border', 'border-gray-200', 'hover:border-gray-300', 'bg-white');
            }
        });
    }

    function prevGalleryImage() {
        setGalleryIndex(currentGalleryIdx - 1);
    }

    function nextGalleryImage() {
        setGalleryIndex(currentGalleryIdx + 1);
    }

    // Touch Swipe Support for Mobile
    document.addEventListener('DOMContentLoaded', function() {
        const carousel = document.getElementById('gallery-carousel-container');
        if (carousel) {
            let touchStartX = 0;
            let touchEndX = 0;

            carousel.addEventListener('touchstart', function(e) {
                touchStartX = e.changedTouches[0].screenX;
            }, { passive: true });

            carousel.addEventListener('touchend', function(e) {
                touchEndX = e.changedTouches[0].screenX;
                handleSwipeGesture();
            }, { passive: true });

            function handleSwipeGesture() {
                const swipeDiff = touchEndX - touchStartX;
                if (Math.abs(swipeDiff) > 40) {
                    if (swipeDiff < 0) {
                        nextGalleryImage(); // swipe left -> next image
                    } else {
                        prevGalleryImage(); // swipe right -> prev image
                    }
                }
            }
        }
    });

    function copyMandiriAccount() {
        navigator.clipboard.writeText('Bank Mandiri a.n. MARLIYAH').then(() => {
            const btn = document.getElementById('copyMandiriBtn');
            if (btn) {
                btn.textContent = '✓ Tersalin!';
                btn.classList.remove('bg-amber-100', 'text-amber-900');
                btn.classList.add('bg-emerald-600', 'text-white');
                setTimeout(() => {
                    btn.textContent = 'Salin Info';
                    btn.classList.remove('bg-emerald-600', 'text-white');
                    btn.classList.add('bg-amber-100', 'text-amber-900');
                }, 2000);
            }
        }).catch(() => {
            alert('Rekening: Bank Mandiri a.n. MARLIYAH');
        });
    }

    let activeBookingUrl = '';

    function openBookingSafetyPrompt(waUrl) {
        activeBookingUrl = waUrl;
        const link = document.getElementById('targetBookingWaLink');
        if (link && waUrl) {
            link.href = waUrl;
        }
        const modal = document.getElementById('bookingSafetyModal');
        if (modal) {
            modal.classList.remove('opacity-0', 'pointer-events-none');
            modal.classList.add('opacity-100', 'pointer-events-auto');
            const card = modal.querySelector('div');
            if (card) card.classList.remove('scale-95');
        }
    }

    function closeBookingSafetyModal() {
        const modal = document.getElementById('bookingSafetyModal');
        if (modal) {
            modal.classList.remove('opacity-100', 'pointer-events-auto');
            modal.classList.add('opacity-0', 'pointer-events-none');
            const card = modal.querySelector('div');
            if (card) card.classList.add('scale-95');
        }
    }
</script>
@endpush
