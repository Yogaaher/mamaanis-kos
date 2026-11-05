@extends('layouts.app')

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

    // Build dynamic gallery items list
    $rawGallery = [];
    if ($room instanceof \App\Models\Room) {
        $rawGallery = $room->getGalleryList();
    } elseif (!empty($roomData['gallery_images']) && is_array($roomData['gallery_images'])) {
        foreach ($roomData['gallery_images'] as $gIdx => $gItem) {
            if (is_string($gItem) && trim($gItem) !== '') {
                $rawGallery[] = ['url' => trim($gItem), 'label' => 'Foto Kamar ' . ($gIdx + 1)];
            } elseif (is_array($gItem) && !empty($gItem['url'])) {
                $rawGallery[] = [
                    'url' => trim((string) $gItem['url']),
                    'label' => !empty($gItem['label']) ? trim((string) $gItem['label']) : ('Foto Kamar ' . ($gIdx + 1)),
                ];
            }
        }
    }
    if (count($rawGallery) === 0) {
        $rawGallery = [
            ['url' => $image, 'label' => 'Foto Kamar Tidur'],
            ['url' => $bathroomImage, 'label' => 'Foto Kamar Mandi Dalam'],
        ];
    }
    $totalPhotos = count($rawGallery);
    $galleryJsItems = [];
    foreach ($rawGallery as $gIdx => $gItem) {
        $galleryJsItems[] = [
            'url' => $gItem['url'],
            'label' => $gItem['label'],
            'title' => ($gIdx + 1) . ' / ' . $totalPhotos . ' • ' . $gItem['label'],
        ];
    }
    $minStay = $roomData['min_stay'] ?? '1 Bulan';
    $maxOccupants = $roomData['max_occupants'] ?? 1;
    $amenities = $roomData['amenities'] ?? ['Kamar Mandi Dalam', 'AC', 'WiFi Cepat', 'Kasur Springbed', 'Lemari Pakaian', 'Meja Kerja'];
    $size = $roomData['size'] ?? 16;
    $beds = $roomData['beds'] ?? 1;
    $description = $roomData['description'] ?? 'Unit kamar kost Mama Anis dirancang khusus untuk kenyamanan dan privasi 1 orang penghuni. Dilengkapi fasilitas kamar mandi dalam yang bersih dan higienis, AC, kasur berkualitas, lemari pakaian, meja kerja/belajar, dan koneksi internet WiFi stabil.';

    // Resolve HTTP(S) OpenGraph Image for WhatsApp/Social Previews
    $primaryGalleryUrl = $galleryJsItems[0]['url'] ?? $image;
    if (str_starts_with($primaryGalleryUrl, 'http://') || str_starts_with($primaryGalleryUrl, 'https://')) {
        $ogImageUrl = $primaryGalleryUrl;
    } elseif (str_starts_with($primaryGalleryUrl, 'data:')) {
        $ogImageUrl = url('/images/Kamar no 5.jpg');
    } else {
        $ogImageUrl = url($primaryGalleryUrl);
    }
    $metaDescText = "{$name} ({$type}) di {$location} — {$formatRupiah($price)}/bulan. Luas {$size}m², fasilitas: " . implode(', ', array_slice($amenities, 0, 5)) . ".";

    // WhatsApp pre-configured message text
    $whatsappText = "Halo Mama Anis Kos, saya tertarik untuk menyewa unit \"{$name}\" di {$location} dengan tarif sewa {$formatRupiah($price)}/bulan (Minimal sewa {$minStay}, kapasitas max {$maxOccupants} orang). Apakah kamar ini masih tersedia? Terima kasih!";
    $whatsappUrl = "https://wa.me/6287782049784?text=" . rawurlencode($whatsappText);

    // Share to friend/family WA URL
    $shareFriendText = "Cek kamar kos ini di Mama Anis Kos ({$location}): {$name} — {$formatRupiah($price)}/bulan. Lihat foto & fasilitas lengkapnya di: " . url()->current();
    $shareFriendWaUrl = "https://wa.me/?text=" . rawurlencode($shareFriendText);

    // Bubble Chat FAQ Items
    $gmapsUrl = 'https://share.google/j7P9yPSEyOxYYRu47';
    $faqChats = [
        [
            'topic' => 'akses',
            'time_q' => '09:40',
            'time_a' => '09:41',
            'question' => 'Apakah Mama Anis Kos ini kos khusus putri? Bagaimana aturan jam malam & tamu lawan jenis?',
            'answer' => 'Benar Kak, Mama Anis Kos adalah Kos Khusus Putri. Akses keluar-masuk penghuni bebas 24 jam (pegang kunci akses masing-masing) dan dipantau CCTV 24 jam. Untuk tamu lawan jenis hanya diperbolehkan di ruang tunggu (Lobby Tamu) dan tidak diperkenankan masuk ke area kamar demi privasi serta kenyamanan bersama.',
        ],
        [
            'topic' => 'listrik',
            'time_q' => '09:42',
            'time_a' => '09:43',
            'question' => 'Kak, untuk biaya listrik, air bersih, dan iuran sampah bagaimana aturannya?',
            'answer' => 'Untuk air bersih sudah GRATIS & mengalir lancar 24 jam, dan iuran sampah juga GRATIS (tidak ada biaya tambahan iuran sampah). Sedangkan listrik menggunakan meteran Token Mandiri di masing-masing kamar, jadi pemakaiannya fleksibel sesuai kebutuhan Kakak sendiri.',
        ],
        [
            'topic' => 'lokasi',
            'time_q' => '09:44',
            'time_a' => '09:45',
            'question' => 'Alamat lengkap Mama Anis Kos di mana Kak? Patokannya apa biar tidak rancu dengan kos lain?',
            'answer' => 'Lokasi kami di kawasan Alam Sutera, Pinang, Tangerang — patokan paling jelas dan akuratnya persis di Belakang Warteg Barokah Alam Sutera (supaya tidak rancu atau tertukar dengan kos lain di sekitar lokasi). Kakak bisa langsung klik Google Maps resmi kami: ' . $gmapsUrl,
            'answer_html' => 'Lokasi kami di kawasan Alam Sutera, Pinang, Tangerang — patokan paling jelas dan akuratnya persis di <strong>Belakang Warteg Barokah Alam Sutera</strong> (supaya tidak rancu atau tertukar dengan kos lain di sekitar lokasi).<br><br>📍 Titik Lokasi Resmi: <a href="' . $gmapsUrl . '" target="_blank" rel="noopener" class="inline-flex items-center gap-1 font-extrabold text-[#006c49] underline hover:text-[#005236] bg-emerald-50 px-2.5 py-1 rounded-lg border border-emerald-200 mt-1">Klik Buka Google Maps Mama Anis Kos ↗</a>',
        ],
        [
            'topic' => 'kapasitas',
            'time_q' => '09:46',
            'time_a' => '09:46',
            'question' => 'Satu kamar boleh diisi berapa orang Kak? Dan minimal sewa berapa lama?',
            'answer' => "Demi menjaga ketenangan, privasi, dan kenyamanan seluruh penghuni putri, kapasitas unit ini maksimal {$maxOccupants} orang per kamar dengan durasi sewa minimal {$minStay}.",
        ],
        [
            'topic' => 'fasilitas',
            'time_q' => '09:47',
            'time_a' => '09:48',
            'question' => 'Untuk cuci baju, cuci piring, dan simpan makanan apakah ada fasilitasnya?',
            'answer' => 'Lengkap banget Kak! Penghuni bebas pakai Mesin Cuci bersama, Kulkas Bersama, dan Tempat Cuci Piring. Di lingkungan kos juga terintegrasi langsung dengan Sari Prima Laundry (bisa antar-jemput) dan Warung Mama Anis.',
        ],
        [
            'topic' => 'booking',
            'time_q' => '09:49',
            'time_a' => '09:50',
            'question' => 'Gimana cara kalau mau survei lokasi dulu atau langsung booking kamar?',
            'answer' => 'Bisa banget! Kakak tinggal klik tombol "Tanya & Booking via WA" di halaman ini, pilih opsi "Survei Kos" atau "Booking". Ingat ya Kak, WA resmi hanya 0877-8204-9784 dan rekening resmi hanya Bank Mandiri a.n. MARLIYAH.',
        ],
    ];

    $faqSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => array_map(fn ($item) => [
            '@type' => 'Question',
            'name' => $item['question'],
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => $item['answer'],
            ],
        ], $faqChats),
    ];

    // Fetch related rooms dynamically
    $relatedRooms = \App\Models\Room::query()->where('id', '!=', $id)->orderBy('id')->take(3)->get();
@endphp

@section('title', $name . ' | Mama Anis Kos')
@section('meta_description', $metaDescText)
@section('og_image', $ogImageUrl)

@push('head')
    <script type="application/ld+json">{!! json_encode($faqSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush

@section('content')
<div class="pt-4 sm:pt-8 pb-16 sm:pb-20 font-sans bg-[#f8f9fb] min-h-screen">
    <!-- Aligned to max-w-7xl px-4 sm:px-8 for perfect symmetry -->
    <div class="max-w-7xl mx-auto px-4 sm:px-8">
        <!-- Top Back Navigation Bar + Quick Share Action -->
        <div class="mb-4 sm:mb-6 flex items-center justify-between gap-2.5">
            <a 
                href="/catalog" 
                class="inline-flex items-center gap-2 text-xs sm:text-sm font-bold text-gray-700 hover:text-[#006c49] bg-white border border-gray-200 hover:border-emerald-300 px-3.5 py-2 rounded-xl shadow-2xs hover:shadow-xs transition-all cursor-pointer group active:scale-95 shrink-0"
            >
                <svg class="w-4 h-4 text-gray-500 group-hover:text-[#006c49] transition-transform group-hover:-translate-x-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                </svg>
                <span>Kembali ke Katalog</span>
            </a>
            
            <div class="flex items-center gap-2.5 sm:gap-4">
                <div class="hidden md:flex items-center gap-2 text-xs text-gray-400 font-medium">
                    <a href="/" class="hover:text-[#006c49] transition-colors">Beranda</a>
                    <span>/</span>
                    <a href="/catalog" class="hover:text-[#006c49] transition-colors">Kamar</a>
                    <span>/</span>
                    <span class="text-gray-600 font-bold truncate max-w-[200px]">{{ $name }}</span>
                </div>

                <!-- Tombol Bagikan Kamar (Native Share / Copy Link) -->
                <button
                    type="button"
                    id="topShareRoomBtn"
                    onclick="shareRoomPage()"
                    class="inline-flex items-center gap-1.5 text-xs font-bold text-[#006c49] bg-emerald-50/90 hover:bg-emerald-100 border border-emerald-200 px-3.5 py-2 rounded-xl shadow-2xs transition-all cursor-pointer active:scale-95 shrink-0"
                    title="Bagikan Link Kamar Ini"
                >
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                    </svg>
                    <span id="topShareRoomText">Bagikan Kamar</span>
                </button>
            </div>
        </div>

        <div class="grid gap-6 lg:gap-8 lg:grid-cols-12 items-start">
            <!-- Left Side: Main details -->
            <div class="lg:col-span-8 flex flex-col gap-6 sm:gap-8">
                <!-- Large Image & Gallery (Foto Kamar & Foto Kamar Mandi) with Arrows, Swipe, and Previews -->
                <div class="bg-white p-3 sm:p-4 rounded-2xl sm:rounded-3xl border border-gray-100 shadow-xs flex flex-col gap-3 sm:gap-4">
                    <div id="gallery-carousel-container" class="relative aspect-[16/10] w-full overflow-hidden rounded-xl sm:rounded-2xl bg-slate-100 select-none cursor-zoom-in group">
                        <img
                            id="main-room-gallery"
                            src="{{ $galleryJsItems[0]['url'] ?? $image }}"
                            alt="{{ $name }}"
                            onclick="openRoomLightbox()"
                            class="w-full h-full object-cover transition-opacity duration-300"
                            onerror="handleImgError(this)"
                        />

                        <!-- Top Right Fullscreen Zoom Button -->
                        <button
                            type="button"
                            onclick="openRoomLightbox()"
                            class="absolute top-2.5 right-2.5 sm:top-3.5 sm:right-3.5 bg-black/55 hover:bg-black/80 text-white backdrop-blur-md text-[10px] sm:text-xs font-bold px-2.5 py-1.5 sm:px-3 sm:py-1.5 rounded-full flex items-center gap-1.5 shadow-md transition-all cursor-pointer z-20"
                            title="Perbesar Foto Layar Penuh"
                        >
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"/>
                            </svg>
                            <span>Perbesar</span>
                        </button>

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
                            {{ $galleryJsItems[0]['title'] ?? '1 / 1 • Foto Kamar' }}
                        </div>

                        <!-- Dots Indicator -->
                        <div class="absolute bottom-2.5 right-2.5 sm:bottom-3.5 sm:right-3.5 flex items-center gap-1.5 z-20 bg-black/40 backdrop-blur-xs px-2.5 py-1 rounded-full max-w-[50%] overflow-x-auto">
                            @foreach($galleryJsItems as $gIdx => $gItem)
                                <button type="button" onclick="setGalleryIndex({{ $gIdx }})" id="gallery-dot-{{ $gIdx }}" class="{{ $gIdx === 0 ? 'w-4 h-2 rounded-full bg-white' : 'w-2 h-2 rounded-full bg-white/40' }} transition-all cursor-pointer shrink-0" aria-label="Slide {{ $gIdx + 1 }}"></button>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Clickable Thumbnails row under placeholder -->
                    <div class="grid {{ count($galleryJsItems) > 2 ? 'grid-cols-2 sm:grid-cols-3' : 'grid-cols-2' }} gap-2 sm:gap-3">
                        @foreach($galleryJsItems as $gIdx => $gItem)
                            <button 
                                type="button"
                                id="thumb-btn-{{ $gIdx }}"
                                onclick="setGalleryIndex({{ $gIdx }})" 
                                class="gallery-thumb flex items-center gap-2 sm:gap-3 p-1.5 sm:p-2 rounded-xl sm:rounded-2xl {{ $gIdx === 0 ? 'border-2 border-[#006c49] bg-emerald-50/50' : 'border border-gray-200 hover:border-gray-300 bg-white' }} focus:outline-none transition-all cursor-pointer text-left"
                            >
                                <div class="w-12 h-10 sm:w-16 sm:h-12 rounded-lg sm:rounded-xl overflow-hidden shrink-0 bg-slate-200">
                                    <img src="{{ $gItem['url'] }}" class="w-full h-full object-cover" alt="{{ $gItem['label'] }}" onerror="handleImgError(this)">
                                </div>
                                <div class="truncate">
                                    <span class="text-[11px] sm:text-xs font-bold text-gray-900 block truncate">{{ $gIdx + 1 }}. {{ $gItem['label'] }}</span>
                                    <span class="text-[9px] sm:text-[10px] text-gray-500">{{ $gIdx === 0 ? 'Tampilan Utama' : 'Galeri Kamar' }}</span>
                                </div>
                            </button>
                        @endforeach
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
                                <span class="bg-pink-50 text-pink-700 border border-pink-200 px-2.5 py-0.5 rounded-full text-[10px] sm:text-xs font-extrabold">
                                    👩 Kos Khusus Putri
                                </span>
                            </div>
                            <div class="text-xs text-gray-500 mt-1.5 flex flex-wrap items-center gap-x-2 gap-y-1 font-medium">
                                <span class="inline-flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-[#006c49]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span>{{ $location }} (<strong>Belakang Warteg Barokah Alam Sutera</strong>)</span>
                                </span>
                                <a href="{{ $gmapsUrl }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1 text-[#006c49] hover:text-[#005236] font-extrabold underline">
                                    <span>📍 Buka Google Maps ↗</span>
                                </a>
                            </div>
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

                <!-- Interactive Bubble Chat FAQ Section (Tanya Jawab Seputar Kos) -->
                <div id="room-faq-chat" class="bg-white rounded-2xl sm:rounded-3xl border border-gray-100 shadow-xs overflow-hidden flex flex-col">
                    <!-- Chat Room Header Bar -->
                    <div class="bg-gradient-to-r from-[#004d31] via-[#006c49] to-[#005a3c] px-4 py-3.5 sm:px-6 sm:py-4 text-white flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="relative shrink-0">
                                <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-full bg-white/20 border-2 border-emerald-300/60 flex items-center justify-center font-black text-sm sm:text-base shadow-inner">
                                    MA
                                </div>
                                <span class="absolute bottom-0 right-0 w-3 h-3 rounded-full bg-emerald-400 border-2 border-[#004d31]"></span>
                            </div>
                            <div>
                                <div class="flex items-center gap-1.5">
                                    <h3 class="font-extrabold text-sm sm:text-base font-display leading-tight">Tanya Jawab Kos (FAQ)</h3>
                                    <span class="bg-white/20 text-emerald-100 text-[9px] sm:text-[10px] font-bold px-2 py-0.5 rounded-full">Resmi</span>
                                </div>
                                <p class="text-[11px] sm:text-xs text-emerald-100/90 mt-0.5 flex items-center gap-1.5">
                                    <span class="inline-block w-1.5 h-1.5 rounded-full bg-emerald-300 animate-pulse"></span>
                                    <span>Pengelola Mama Anis Kos • Klik topik di bawah</span>
                                </p>
                            </div>
                        </div>

                        <span class="hidden sm:inline-flex items-center gap-1 text-[11px] font-bold bg-black/20 px-3 py-1 rounded-full text-emerald-100">
                            💬 {{ count($faqChats) }} Pertanyaan Populer
                        </span>
                    </div>

                    <!-- Quick Topic Filter Pills -->
                    <div class="px-4 py-2.5 sm:px-6 sm:py-3 bg-emerald-50/60 border-b border-emerald-100/80 flex items-center gap-1.5 sm:gap-2 overflow-x-auto">
                        <button type="button" onclick="filterFaqTopic('ALL')" data-faq-btn="ALL" class="faq-topic-pill px-3 py-1 rounded-full text-[11px] font-bold bg-[#006c49] text-white shadow-2xs transition-all cursor-pointer shrink-0">
                            Semua ({{ count($faqChats) }})
                        </button>
                        <button type="button" onclick="filterFaqTopic('akses')" data-faq-btn="akses" class="faq-topic-pill px-3 py-1 rounded-full text-[11px] font-bold bg-white text-gray-600 hover:bg-emerald-100/60 border border-emerald-100 transition-all cursor-pointer shrink-0">
                            👩 Khusus Putri & Tamu
                        </button>
                        <button type="button" onclick="filterFaqTopic('listrik')" data-faq-btn="listrik" class="faq-topic-pill px-3 py-1 rounded-full text-[11px] font-bold bg-white text-gray-600 hover:bg-emerald-100/60 border border-emerald-100 transition-all cursor-pointer shrink-0">
                            ⚡ Listrik, Air & Sampah
                        </button>
                        <button type="button" onclick="filterFaqTopic('lokasi')" data-faq-btn="lokasi" class="faq-topic-pill px-3 py-1 rounded-full text-[11px] font-bold bg-white text-gray-600 hover:bg-emerald-100/60 border border-emerald-100 transition-all cursor-pointer shrink-0">
                            📍 Alamat & Maps
                        </button>
                        <button type="button" onclick="filterFaqTopic('kapasitas')" data-faq-btn="kapasitas" class="faq-topic-pill px-3 py-1 rounded-full text-[11px] font-bold bg-white text-gray-600 hover:bg-emerald-100/60 border border-emerald-100 transition-all cursor-pointer shrink-0">
                            👤 Kapasitas & Durasi
                        </button>
                        <button type="button" onclick="filterFaqTopic('fasilitas')" data-faq-btn="fasilitas" class="faq-topic-pill px-3 py-1 rounded-full text-[11px] font-bold bg-white text-gray-600 hover:bg-emerald-100/60 border border-emerald-100 transition-all cursor-pointer shrink-0">
                            🧺 Laundry & Kulkas
                        </button>
                        <button type="button" onclick="filterFaqTopic('booking')" data-faq-btn="booking" class="faq-topic-pill px-3 py-1 rounded-full text-[11px] font-bold bg-white text-gray-600 hover:bg-emerald-100/60 border border-emerald-100 transition-all cursor-pointer shrink-0">
                            🛡️ Survei & Booking
                        </button>
                    </div>

                    <!-- Chat Conversation Stream -->
                    <div class="p-4 sm:p-6 bg-[#f3f6f4] flex flex-col gap-5" style="background-image: radial-gradient(rgba(0, 108, 73, 0.06) 1px, transparent 1px); background-size: 18px 18px;">
                        @foreach($faqChats as $fIdx => $chat)
                            <div class="faq-chat-pair flex flex-col gap-2.5 transition-all duration-200" data-faq-topic="{{ $chat['topic'] }}">
                                <!-- Right Bubble: Calon Penghuni Question -->
                                <div class="flex items-end justify-end gap-2 pl-6 sm:pl-16">
                                    <button 
                                        type="button"
                                        onclick="toggleFaqAnswer({{ $fIdx }})"
                                        class="text-left group bg-[#d9fdd3] hover:bg-[#ccf7c4] text-gray-900 px-4 py-2.5 sm:px-4.5 sm:py-3 rounded-2xl rounded-br-xs shadow-2xs border border-emerald-200/80 transition-all cursor-pointer max-w-xl"
                                    >
                                        <div class="flex items-center justify-between gap-3 mb-0.5">
                                            <span class="text-[10px] font-extrabold text-emerald-800 uppercase tracking-wide">Calon Penghuni</span>
                                            <span class="text-[9px] text-gray-500 font-mono">{{ $chat['time_q'] }} ✓✓</span>
                                        </div>
                                        <p class="text-xs sm:text-sm font-bold text-gray-900 leading-snug">
                                            {{ $chat['question'] }}
                                        </p>
                                    </button>
                                    <div class="w-7 h-7 rounded-full bg-emerald-700 text-white text-[10px] font-extrabold flex items-center justify-center shrink-0 shadow-2xs">
                                        🙋
                                    </div>
                                </div>

                                <!-- Left Bubble: Pengelola Mama Anis Answer -->
                                <div id="faq-answer-{{ $fIdx }}" class="flex items-end justify-start gap-2 pr-4 sm:pr-14">
                                    <div class="w-7 h-7 rounded-full bg-[#006c49] text-white text-[10px] font-black flex items-center justify-center shrink-0 shadow-2xs">
                                        MA
                                    </div>
                                    <div class="bg-white text-gray-700 px-4 py-3 sm:px-5 sm:py-3.5 rounded-2xl rounded-bl-xs shadow-2xs border border-gray-200/80 max-w-xl">
                                        <div class="flex items-center justify-between gap-3 mb-1">
                                            <span class="text-[10px] font-extrabold text-[#006c49] flex items-center gap-1">
                                                <span>Mama Anis Kos</span>
                                                <svg class="w-3 h-3 text-[#006c49]" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                            </span>
                                            <span class="text-[9px] text-gray-400 font-mono">{{ $chat['time_a'] }}</span>
                                        </div>
                                        <div class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                                            @if(!empty($chat['answer_html']))
                                                {!! $chat['answer_html'] !!}
                                            @else
                                                {{ $chat['answer'] }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Chat Bottom Input-Like Prompt Bar -->
                    <div class="px-4 py-3 sm:px-6 sm:py-3.5 bg-white border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-2.5">
                        <div class="flex items-center gap-2 text-xs text-gray-500 font-medium">
                            <span class="w-2 h-2 rounded-full bg-[#006c49]"></span>
                            <span>Punya pertanyaan lain atau ingin jadwalkan survei langsung?</span>
                        </div>
                        <button
                            type="button"
                            onclick="openBookingSafetyPrompt('{{ $whatsappUrl }}')"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 bg-[#006c49] hover:bg-[#005236] text-white text-xs font-bold px-4 py-2 rounded-full shadow-xs transition-all cursor-pointer active:scale-95 shrink-0"
                        >
                            <span>Tanya Langsung di WA</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </button>
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

                    <!-- Share Room Box (Bagikan ke Orang Tua / Teman) -->
                    <div class="pt-3 border-t border-gray-100 flex flex-col gap-2">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider text-center">Bagikan Kamar Ini ke Teman / Keluarga</span>
                        <div class="grid grid-cols-2 gap-2">
                            <a
                                href="{{ $shareFriendWaUrl }}"
                                target="_blank"
                                rel="noopener"
                                class="py-2 px-3 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-[#006c49] border border-emerald-200/80 text-[11px] font-bold flex items-center justify-center gap-1.5 transition-all cursor-pointer"
                            >
                                <svg class="w-3.5 h-3.5 fill-current shrink-0" viewBox="0 0 24 24">
                                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.455L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.825 1.451 5.436 0 9.86-4.37 9.864-9.799.002-2.63-1.023-5.101-2.885-6.965C16.528 1.977 14.07 1.951 12.01 1.95c-5.438 0-9.864 4.372-9.868 9.8-.001 1.714.463 3.39 1.341 4.877L2.45 21.11l4.197-1.956z"/>
                                </svg>
                                <span>Kirim ke WA</span>
                            </a>
                            <button
                                type="button"
                                id="cardCopyLinkBtn"
                                onclick="copyRoomLinkOnly()"
                                class="py-2 px-3 rounded-xl bg-gray-50 hover:bg-gray-100 text-gray-700 border border-gray-200 text-[11px] font-bold flex items-center justify-center gap-1.5 transition-all cursor-pointer"
                            >
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                </svg>
                                <span id="cardCopyLinkText">Salin Link</span>
                            </button>
                        </div>
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

<!-- Pre-WhatsApp Booking Safety & Quick Survey/Booking Form Modal -->
<div 
    id="bookingSafetyModal" 
    onclick="if(event.target === this) closeBookingSafetyModal()"
    class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm z-[100] flex items-center justify-center p-3.5 sm:p-4 transition-opacity duration-300 opacity-0 pointer-events-none overflow-y-auto"
    role="dialog"
    aria-modal="true"
>
    <div class="bg-white rounded-3xl border border-amber-100 shadow-2xl max-w-lg w-full p-5 sm:p-7 flex flex-col gap-4 transform transition-all duration-300 scale-95 my-auto">
        <div class="flex items-center justify-between gap-3 border-b border-gray-100 pb-3">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-[#006c49] text-white flex items-center justify-center shrink-0 shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-extrabold text-gray-900 text-sm sm:text-base font-display">Jadwalkan Survei & Booking WA</h3>
                    <p class="text-[11px] text-gray-400">Pilih keperluan Anda & verifikasi rekening resmi</p>
                </div>
            </div>
            <button type="button" onclick="closeBookingSafetyModal()" class="text-gray-400 hover:text-gray-700 p-1 rounded-lg cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Quick Interactive Booking / Survey Form -->
        <div class="space-y-3 text-xs font-sans bg-gray-50/80 p-3.5 sm:p-4 rounded-2xl border border-gray-100">
            <!-- 1. Keperluan -->
            <div>
                <label class="text-[11px] font-extrabold text-gray-700 block mb-1.5">1. Pilih Keperluan Anda:</label>
                <div class="grid grid-cols-3 gap-1.5">
                    <button type="button" onclick="setBookingOption('intent', 'Tanya Ketersediaan', this)" class="booking-intent-btn py-2 px-2 rounded-xl text-[11px] font-bold border border-[#006c49] bg-emerald-50 text-[#006c49] transition-all cursor-pointer text-center">
                        💬 Tanya Info
                    </button>
                    <button type="button" onclick="setBookingOption('intent', 'Jadwalkan Survei Lokasi', this)" class="booking-intent-btn py-2 px-2 rounded-xl text-[11px] font-bold border border-gray-200 bg-white text-gray-600 hover:border-emerald-200 transition-all cursor-pointer text-center">
                        📍 Survei Kos
                    </button>
                    <button type="button" onclick="setBookingOption('intent', 'Langsung Booking Kamar', this)" class="booking-intent-btn py-2 px-2 rounded-xl text-[11px] font-bold border border-gray-200 bg-white text-gray-600 hover:border-emerald-200 transition-all cursor-pointer text-center">
                        🔑 Booking
                    </button>
                </div>
            </div>

            <!-- 2. Rencana Masuk / Survei & Durasi Sewa -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                <div>
                    <label for="bookingPlanTime" class="text-[11px] font-extrabold text-gray-700 block mb-1">2. Rencana Masuk / Survei:</label>
                    <select id="bookingPlanTime" onchange="updateCustomBookingWaLink()" class="w-full rounded-xl border border-gray-200 bg-white px-3 py-2 text-xs font-bold text-gray-800 outline-none focus:border-[#006c49]">
                        <option value="Segera / Minggu Ini">Segera / Minggu Ini</option>
                        <option value="Bulan Ini">Dalam Bulan Ini</option>
                        <option value="Awal Bulan Depan">Awal Bulan Depan</option>
                        <option value="Fleksibel (Tanya Dulu)">Fleksibel (Tanya Dulu)</option>
                    </select>
                </div>
                <div>
                    <label for="bookingDuration" class="text-[11px] font-extrabold text-gray-700 block mb-1">3. Rencana Durasi Sewa:</label>
                    <select id="bookingDuration" onchange="updateCustomBookingWaLink()" class="w-full rounded-xl border border-gray-200 bg-white px-3 py-2 text-xs font-bold text-gray-800 outline-none focus:border-[#006c49]">
                        <option value="{{ $minStay }}">{{ $minStay }} (Minimal)</option>
                        <option value="3 Bulan">3 Bulan</option>
                        <option value="6 Bulan">6 Bulan (1 Semester)</option>
                        <option value="1 Tahun">1 Tahun</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Mandatory Anti-Fraud Verification Info -->
        <div class="space-y-2 text-xs text-gray-600 font-sans">
            <div class="p-2.5 bg-emerald-50/70 rounded-xl border border-emerald-100 flex items-center gap-2.5">
                <svg class="w-4 h-4 text-[#006c49] shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                <span>Nomor WA Pengelola Resmi: <strong class="text-gray-900 font-mono">0877-8204-9784</strong></span>
            </div>

            <div class="p-2.5 bg-amber-50/70 rounded-xl border border-amber-200 flex items-center gap-2.5">
                <svg class="w-4 h-4 text-amber-700 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                <span>Rekening Resmi Pembayaran Sah: <strong class="text-gray-900 font-mono">Bank Mandiri a.n. MARLIYAH</strong></span>
            </div>

            <p class="text-[10px] sm:text-[11px] text-red-600 leading-tight">
                ⚠️ Transaksi di luar nomor WA dan rekening Mandiri a.n. MARLIYAH bukan tanggung jawab Mama Anis Kos.
            </p>
        </div>

        <div class="grid grid-cols-2 gap-3 pt-1">
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
                onclick="trackWaClickAndClose()"
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

<!-- Fullscreen Room Gallery Lightbox Modal (Clean White Theme) -->
<div 
    id="roomGalleryLightbox" 
    onclick="if(event.target === this) closeRoomLightbox()"
    class="fixed inset-0 bg-white/95 backdrop-blur-md z-[130] flex flex-col items-center justify-center p-3 sm:p-6 transition-opacity duration-200 opacity-0 pointer-events-none select-none"
    role="dialog"
    aria-modal="true"
>
    <!-- Close Button -->
    <button 
        type="button" 
        onclick="closeRoomLightbox()" 
        class="absolute top-4 right-4 sm:top-6 sm:right-6 z-30 w-10 h-10 sm:w-11 sm:h-11 rounded-full bg-white hover:bg-emerald-50 text-gray-800 hover:text-[#006c49] border border-gray-200 shadow-md flex items-center justify-center transition-colors cursor-pointer"
        aria-label="Tutup Layar Penuh"
    >
        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>

    <!-- Prev Arrow -->
    <button 
        type="button" 
        onclick="prevGalleryImage()" 
        class="absolute left-3 sm:left-6 top-1/2 -translate-y-1/2 z-30 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-white hover:bg-emerald-50 text-gray-800 hover:text-[#006c49] border border-gray-200 shadow-md flex items-center justify-center transition-colors cursor-pointer"
        aria-label="Foto Sebelumnya"
    >
        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
        </svg>
    </button>

    <!-- Next Arrow -->
    <button 
        type="button" 
        onclick="nextGalleryImage()" 
        class="absolute right-3 sm:right-6 top-1/2 -translate-y-1/2 z-30 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-white hover:bg-emerald-50 text-gray-800 hover:text-[#006c49] border border-gray-200 shadow-md flex items-center justify-center transition-colors cursor-pointer"
        aria-label="Foto Berikutnya"
    >
        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
        </svg>
    </button>

    <!-- Main Fullscreen Image -->
    <div class="max-w-5xl max-h-[85vh] w-full flex flex-col items-center justify-center gap-3.5 bg-white p-3 sm:p-5 rounded-2xl sm:rounded-3xl border border-gray-200 shadow-2xl">
        <div class="w-full flex items-center justify-center bg-[#f8f9fb] rounded-xl sm:rounded-2xl overflow-hidden p-1 sm:p-2">
            <img 
                id="lightbox-room-img" 
                src="{{ $galleryJsItems[0]['url'] ?? $image }}" 
                alt="{{ $name }}" 
                class="max-h-[72vh] w-auto max-w-full rounded-lg sm:rounded-xl object-contain"
                onerror="handleImgError(this)"
            >
        </div>
        <div id="lightbox-room-caption" class="text-[#006c49] text-xs sm:text-sm font-extrabold bg-emerald-50 border border-emerald-200 px-4 py-1.5 rounded-full shadow-2xs">
            {{ $galleryJsItems[0]['title'] ?? '1 / 1 • Foto Kamar' }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const galleryItems = @json(array_map(fn($it) => ['title' => $it['title']], $galleryJsItems));
    let currentGalleryIdx = 0;

    function setGalleryIndex(idx) {
        if (idx < 0) idx = galleryItems.length - 1;
        if (idx >= galleryItems.length) idx = 0;
        currentGalleryIdx = idx;

        const mainImg = document.getElementById('main-room-gallery');
        const badge = document.getElementById('gallery-badge');
        const thumbImg = document.querySelector(`#thumb-btn-${currentGalleryIdx} img`);
        
        if (mainImg && thumbImg) {
            mainImg.style.opacity = '0.3';
            setTimeout(() => {
                mainImg.removeAttribute('data-error-handled');
                mainImg.src = thumbImg.src;
                mainImg.style.opacity = '1';
            }, 120);
        }

        if (badge) {
            badge.textContent = galleryItems[currentGalleryIdx].title;
        }

        const lbImg = document.getElementById('lightbox-room-img');
        const lbCaption = document.getElementById('lightbox-room-caption');
        if (lbImg && thumbImg) {
            lbImg.removeAttribute('data-error-handled');
            lbImg.src = thumbImg.src;
        }
        if (lbCaption) {
            lbCaption.textContent = galleryItems[currentGalleryIdx].title;
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

    // Share & Copy Link Functions
    function copyRoomLinkOnly() {
        const shareUrl = window.location.href;
        navigator.clipboard.writeText(shareUrl).then(() => {
            const topText = document.getElementById('topShareRoomText');
            const cardText = document.getElementById('cardCopyLinkText');
            if (topText) topText.textContent = '✓ Link Tersalin!';
            if (cardText) cardText.textContent = '✓ Tersalin!';
            setTimeout(() => {
                if (topText) topText.textContent = 'Bagikan Kamar';
                if (cardText) cardText.textContent = 'Salin Link';
            }, 2200);
        }).catch(() => {
            prompt('Salin link kamar ini:', shareUrl);
        });
    }

    function shareRoomPage() {
        const shareData = {
            title: @json($name . ' | Mama Anis Kos'),
            text: @json("Cek kamar kos {$name} ({$location}) — {$formatRupiah($price)}/bulan di Mama Anis Kos:"),
            url: window.location.href
        };

        if (navigator.share) {
            navigator.share(shareData).catch(() => {
                copyRoomLinkOnly();
            });
        } else {
            copyRoomLinkOnly();
        }
    }

    // Bubble Chat FAQ Functions
    function filterFaqTopic(topic) {
        document.querySelectorAll('.faq-topic-pill').forEach(btn => {
            if (btn.getAttribute('data-faq-btn') === topic) {
                btn.className = 'faq-topic-pill px-3 py-1 rounded-full text-[11px] font-bold bg-[#006c49] text-white shadow-2xs transition-all cursor-pointer shrink-0';
            } else {
                btn.className = 'faq-topic-pill px-3 py-1 rounded-full text-[11px] font-bold bg-white text-gray-600 hover:bg-emerald-100/60 border border-emerald-100 transition-all cursor-pointer shrink-0';
            }
        });

        document.querySelectorAll('.faq-chat-pair').forEach(pair => {
            if (topic === 'ALL' || pair.getAttribute('data-faq-topic') === topic) {
                pair.classList.remove('hidden');
            } else {
                pair.classList.add('hidden');
            }
        });
    }

    function toggleFaqAnswer(idx) {
        const ans = document.getElementById('faq-answer-' + idx);
        if (ans) {
            ans.classList.toggle('hidden');
        }
    }

    // Interactive Booking & Survey WA Builder + Lead Tracking
    const roomMeta = {
        id: @json($id),
        name: @json($name),
        location: @json($location),
        priceFormatted: @json($formatRupiah($price)),
        maxOccupants: @json($maxOccupants),
        trackUrl: @json(route('rooms.wa_click', ['room' => $id ?: 1])),
        csrf: @json(csrf_token())
    };

    let selectedBookingIntent = 'Tanya Ketersediaan';

    function setBookingOption(type, value, btnEl) {
        if (type === 'intent') {
            selectedBookingIntent = value;
            document.querySelectorAll('.booking-intent-btn').forEach(btn => {
                btn.className = 'booking-intent-btn py-2 px-2 rounded-xl text-[11px] font-bold border border-gray-200 bg-white text-gray-600 hover:border-emerald-200 transition-all cursor-pointer text-center';
            });
            if (btnEl) {
                btnEl.className = 'booking-intent-btn py-2 px-2 rounded-xl text-[11px] font-bold border border-[#006c49] bg-emerald-50 text-[#006c49] transition-all cursor-pointer text-center';
            }
        }
        updateCustomBookingWaLink();
    }

    function updateCustomBookingWaLink() {
        const planTime = document.getElementById('bookingPlanTime')?.value || 'Segera / Minggu Ini';
        const duration = document.getElementById('bookingDuration')?.value || @json($minStay);

        const msg = `Halo Mama Anis Kos, saya tertarik dengan unit "${roomMeta.name}" di ${roomMeta.location} (${roomMeta.priceFormatted}/bulan, maks. ${roomMeta.maxOccupants} orang).\n\n` +
            `• Keperluan: ${selectedBookingIntent}\n` +
            `• Rencana Masuk/Survei: ${planTime}\n` +
            `• Durasi Sewa: ${duration}\n\n` +
            `Apakah unit ini masih tersedia? Terima kasih!`;

        const finalWaUrl = 'https://wa.me/6287782049784?text=' + encodeURIComponent(msg);
        const link = document.getElementById('targetBookingWaLink');
        if (link) {
            link.href = finalWaUrl;
        }
    }

    function openBookingSafetyPrompt(waUrl) {
        updateCustomBookingWaLink();
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

    function trackWaClickAndClose() {
        try {
            fetch(roomMeta.trackUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': roomMeta.csrf,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ intent: selectedBookingIntent }),
                keepalive: true
            });
        } catch (e) {}
        closeBookingSafetyModal();
    }

    function openRoomLightbox() {
        const lb = document.getElementById('roomGalleryLightbox');
        const mainImg = document.getElementById('main-room-gallery');
        const lbImg = document.getElementById('lightbox-room-img');
        if (lb && mainImg && lbImg) {
            lbImg.src = mainImg.src;
            lb.classList.remove('opacity-0', 'pointer-events-none');
            lb.classList.add('opacity-100', 'pointer-events-auto');
        }
    }

    function closeRoomLightbox() {
        const lb = document.getElementById('roomGalleryLightbox');
        if (lb) {
            lb.classList.remove('opacity-100', 'pointer-events-auto');
            lb.classList.add('opacity-0', 'pointer-events-none');
        }
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeRoomLightbox();
            closeBookingSafetyModal();
        } else if (e.key === 'ArrowLeft') {
            prevGalleryImage();
        } else if (e.key === 'ArrowRight') {
            nextGalleryImage();
        }
    });
</script>
@endpush
