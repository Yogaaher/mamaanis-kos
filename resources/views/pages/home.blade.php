@extends('layouts.app')

@section('title', 'Beranda | Mama Anis Kos - Hunian Modern & Nyaman')

@section('content')
@php
    // Fallback mock rooms matching Screenshot 1 in case SQLite database is empty
    if (!isset($rooms) || $rooms->isEmpty()) {
        $rooms = collect([
            [
                'id' => '1',
                'name' => 'Deluxe Studio A',
                'type' => 'Deluxe Studio',
                'location' => 'Alam Sutera, Tangerang',
                'price' => 3500000,
                'status' => 'Tersedia',
                'views' => 1250,
                'size' => 24,
                'beds' => 1,
                'image_url' => 'https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?auto=format&fit=crop&w=1200&q=85',
                'amenities' => ['Mini Kitchen', 'AC', 'WiFi', 'Kamar Mandi Dalam'],
                'description' => 'Studio luas dengan kenyamanan maksimal dan pemandangan kota. Cocok untuk mahasiswa dan profesional yang menginginkan ruang tinggal modern.'
            ],
            [
                'id' => '2',
                'name' => 'Premium Suite',
                'type' => 'Executive Suite',
                'location' => 'Alam Sutera, Tangerang',
                'price' => 5000000,
                'status' => 'Terisi',
                'views' => 980,
                'size' => 32,
                'beds' => 1,
                'image_url' => 'https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?auto=format&fit=crop&w=1200&q=85',
                'amenities' => ['Mini Kitchen', 'AC', 'WiFi', 'Smart TV'],
                'description' => 'Suite eksklusif dengan area kerja dan furnitur premium. Dirancang untuk penghuni yang mengutamakan privasi dan produktivitas.'
            ],
            [
                'id' => '3',
                'name' => 'Standard Room',
                'type' => 'Standard',
                'location' => 'Alam Sutera, Tangerang',
                'price' => 2500000,
                'status' => 'Tersedia',
                'views' => 845,
                'size' => 18,
                'beds' => 1,
                'image_url' => 'https://images.unsplash.com/photo-1505691938895-1758d7feb511?auto=format&fit=crop&w=1200&q=85',
                'amenities' => ['AC', 'WiFi', 'Kamar Mandi Dalam'],
                'description' => 'Pilihan ekonomis dengan fasilitas lengkap bagi mahasiswa. Tata ruang efisien, bersih, dan nyaman untuk kebutuhan harian.'
            ]
        ]);
    }
@endphp

    <!-- Epic Hero Section with Smooth Scroll Blur & Fade Transitions (Responsive svh for Mobile) -->
    <section id="hero-section" class="relative min-h-[100svh] w-full overflow-hidden flex items-center justify-center bg-black pt-16 pb-12 sm:py-0">
        <!-- Background Image Container with Dynamic Blur/Scale/Parallax -->
        <div id="hero-bg-container" class="absolute inset-0 w-full h-full will-change-transform">
            <img 
                id="hero-bg-img"
                src="/images/lorong.jpeg" 
                alt="Lorong Mama Anis Kos" 
                class="w-full h-full object-cover opacity-85 transition-all duration-100 ease-out"
                style="transform-origin: center center;"
            >
            <!-- Gradient Overlay for smoke-effect and contrast -->
            <div id="hero-dark-overlay" class="absolute inset-0 bg-gradient-to-b from-black/70 via-black/45 to-black/90"></div>
        </div>

        <!-- Centered Interactive Content (Fades & rises on scroll) -->
        <div id="hero-content" class="relative z-10 max-w-4xl px-4 sm:px-6 text-center text-white flex flex-col items-center gap-3.5 sm:gap-6 select-none will-change-transform transition-all duration-100 ease-out my-auto">
            <span class="bg-[#006c49] text-white text-[10px] sm:text-xs font-bold px-3 py-1 sm:px-4 sm:py-1.5 rounded-full uppercase tracking-widest shadow-lg">
                Hunian Kos Nyaman & Bersih
            </span>
            <h1 class="text-2xl sm:text-4xl md:text-5xl lg:text-6xl font-black tracking-tight leading-snug sm:leading-tight font-display drop-shadow-sm max-w-3xl">
                Hunian Tenang & Nyaman untuk Keseharian Anda
            </h1>
            <p class="max-w-xl text-xs sm:text-base md:text-lg text-gray-200/90 font-medium leading-relaxed drop-shadow-xs px-2">
                Pilihan tepat untuk tempat tinggal kost dengan fasilitas lengkap, lokasi strategis, dan lingkungan yang nyaman untuk mahasiswa dan pekerja.
            </p>
            <div class="mt-2 sm:mt-4 flex flex-col sm:flex-row gap-2.5 sm:gap-4 justify-center w-full sm:w-auto px-4 sm:px-0">
                <!-- WhatsApp booking button with "Negative/Inversion" hover effect -->
                <a href="https://wa.me/6287782049784" target="_blank" rel="noopener" class="w-full sm:w-auto inline-flex items-center justify-center rounded-full bg-[#006c49] text-white hover:bg-white hover:text-[#006c49] px-6 py-2.5 sm:px-8 sm:py-3.5 text-xs sm:text-sm font-bold shadow-lg shadow-[#006c49]/20 hover:scale-105 active:scale-95 transition-all duration-300 cursor-pointer">
                    Hubungi Kami
                </a>
                <!-- Catalog button with "Negative/Inversion" hover effect -->
                <a href="/catalog" class="w-full sm:w-auto inline-flex items-center justify-center rounded-full border-2 border-white/80 text-white hover:bg-white hover:text-gray-900 px-6 py-2.5 sm:px-8 sm:py-3.5 text-xs sm:text-sm font-bold hover:scale-105 active:scale-95 transition-all duration-300 cursor-pointer">
                    Lihat Katalog Kamar
                </a>
            </div>
        </div>

        <!-- Bouncing Scroll Down Indicator -->
        <div id="hero-scroll-indicator" class="absolute bottom-3 sm:bottom-8 left-1/2 transform -translate-x-1/2 z-10 flex flex-col items-center gap-1.5 cursor-pointer text-white/60 hover:text-white transition-all duration-200" onclick="document.getElementById('main-content').scrollIntoView({ behavior: 'smooth' })">
            <span class="text-[9px] sm:text-[10px] font-bold uppercase tracking-widest">Scroll Down</span>
            <svg class="w-4 h-4 sm:w-5 sm:h-5 animate-bounce" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
            </svg>
        </div>

        <!-- Bottom Fade/Blur overlay blending seamlessly to white content below -->
        <div id="hero-bottom-fade" class="absolute bottom-0 left-0 right-0 h-24 sm:h-32 bg-gradient-to-t from-white via-white/50 to-transparent pointer-events-none z-10 opacity-0 transition-opacity duration-200"></div>
    </section>

    <!-- Content Anchor Wrapper for Scroll-to -->
    <div id="main-content"></div>

    <!-- Fasilitas Unggulan Section -->
    <section class="bg-white py-10 sm:py-16 md:py-20 border-t border-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-8">
            <div class="text-center mb-8 sm:mb-14">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 font-display">Fasilitas Kos</h2>
                <p class="mt-2 sm:mt-3 text-xs sm:text-base md:text-lg text-gray-600 max-w-2xl mx-auto font-sans">
                    Fasilitas lengkap dan bersih untuk menunjang kenyamanan tinggal Anda sehari-hari.
                </p>
            </div>

            @php
            $facilities = [
                [
                    'title' => 'WiFi & CCTV',
                    'text' => 'WiFi up to 200 Mbps untuk kerja & hiburan, dilengkapi CCTV keamanan 24 jam.',
                    'image' => '/images/Wifi_cctv.jpeg',
                    'svg' => '<svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M4 6h8a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2z"/><path stroke-linecap="round" stroke-linejoin="round" d="M7 3.5a7 7 0 016 0M8.5 5a4 4 0 013 0"/></svg>'
                ],
                [
                    'title' => 'AC Setiap Kamar',
                    'text' => 'Pendingin ruangan berkualitas di setiap unit kamar.',
                    'image' => '/images/AC.jpeg',
                    'svg' => '<svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="4" width="20" height="9" rx="2" stroke-linecap="round" stroke-linejoin="round"/><path stroke-linecap="round" stroke-linejoin="round" d="M6 9h4m6 0h.01M6 16c1 1.5 2 1.5 3 0s2-1.5 3 0m0 0c1 1.5 2 1.5 3 0s2-1.5 3 0M8 20c1 1 2 1 3 0s2-1 3 0"/></svg>'
                ],
                [
                    'title' => 'Kamar Mandi Dalam',
                    'text' => 'Fasilitas mandi pribadi di setiap kamar untuk kenyamanan maksimal.',
                    'image' => '/images/Kamar mandi.jpeg',
                    'svg' => '<svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v3a4 4 0 004 4h8"/><path stroke-linecap="round" stroke-linejoin="round" d="M16 8l4 6H12l4-6z"/><path stroke-linecap="round" stroke-linejoin="round" d="M13 18v1m3-2v2m3-2v1M14 22v.01m3-.01v.01m3-.01v.01"/></svg>'
                ],
                [
                    'title' => 'Akses 24 Jam',
                    'text' => 'Akses bebas keluar masuk kapan saja dengan sistem keamanan terjaga.',
                    'image' => '/images/pintu depan.jpeg',
                    'svg' => '<svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M5 21V5a2 2 0 012-2h8a2 2 0 012 2v16"/><circle cx="14" cy="12" r="1" fill="currentColor"/><path stroke-linecap="round" stroke-linejoin="round" d="M9 9h3v3H9v3h4"/></svg>'
                ],
                [
                    'title' => 'Mesin Cuci',
                    'text' => 'Mesin cuci bersama tersedia untuk kebutuhan laundry harian Anda.',
                    'image' => '/images/mesin_cuci.jpeg',
                    'svg' => '<svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="2" width="18" height="20" rx="3" stroke-linecap="round" stroke-linejoin="round"/><circle cx="7.5" cy="6" r="1" fill="currentColor"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6h4.5"/><circle cx="12" cy="14" r="5" stroke-linecap="round" stroke-linejoin="round"/><path stroke-linecap="round" stroke-linejoin="round" d="M10 14c.7.7 1.3.7 2 0s1.3-.7 2 0"/></svg>'
                ],
                [
                    'title' => 'Cuci Piring',
                    'text' => 'Tempat cuci piring bersama yang bersih dan nyaman.',
                    'image' => '/images/cuci_piring.jpg',
                    'svg' => '<svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 10V5a3 3 0 016 0v2M12 11v1M2 14h20M4 14v4a3 3 0 003 3h10a3 3 0 003-3v-4"/><ellipse cx="14" cy="17" rx="3" ry="1.5"/></svg>'
                ],
                [
                    'title' => 'Lobby Tamu',
                    'text' => 'Area ruang tamu yang bersih untuk menerima kerabat atau teman yang berkunjung.',
                    'image' => '/images/lobby.jpeg',
                    'svg' => '<svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 11V7a3 3 0 013-3h10a3 3 0 013 3v4M2 11h20v5a2 2 0 01-2 2H4a2 2 0 01-2-2v-5zM5 18v2m14-2v2M8 11v4m8-4v4"/></svg>'
                ],
                [
                    'title' => 'Kulkas Bersama',
                    'text' => 'Kulkas bersama untuk menyimpan makanan dan minuman penghuni.',
                    'image' => '/images/kulkas.jpeg',
                    'svg' => '<svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="5" y="2" width="14" height="20" rx="2.5" stroke-linecap="round" stroke-linejoin="round"/><path stroke-linecap="round" stroke-linejoin="round" d="M5 9h14M8 5v2m0 5v4M7 22v1m10-1v1"/></svg>'
                ]
            ];
            @endphp

            <div class="grid gap-3.5 sm:gap-6 grid-cols-2 lg:grid-cols-4">
                @foreach($facilities as $fac)
                    <article class="lift overflow-hidden rounded-xl sm:rounded-2xl bg-white border border-gray-100 shadow-xs flex flex-col cursor-pointer">
                        <div class="h-28 sm:h-44 overflow-hidden relative">
                            <img src="{{ $fac['image'] }}" alt="{{ $fac['title'] }}" class="h-full w-full object-cover transition duration-500 hover:scale-105">
                        </div>
                        <div class="p-3 sm:p-5 flex-1 flex flex-col gap-1 sm:gap-2">
                            <div class="flex items-center gap-1.5 sm:gap-2.5 text-[#006c49]">
                                {!! $fac['svg'] !!}
                                <h3 class="font-bold text-gray-900 text-xs sm:text-base leading-tight font-display">{{ $fac['title'] }}</h3>
                            </div>
                            <p class="text-[11px] sm:text-sm leading-relaxed text-gray-600 font-sans line-clamp-2 sm:line-clamp-none">{{ $fac['text'] }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Fasilitas Integrasi Section -->
    <section class="border-y border-gray-100 bg-[#f8f9fb] py-8 sm:py-14 md:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-8">
            <div class="text-center mb-6 sm:mb-12">
                <h2 class="text-xl sm:text-3xl md:text-4xl font-bold text-gray-900 font-display">Fasilitas Integrasi</h2>
                <p class="mt-1 sm:mt-2 text-xs sm:text-base md:text-lg text-gray-600 max-w-2xl mx-auto font-sans">
                    Mitra lokal terpercaya untuk menunjang segala keperluan harian Anda di kawasan kos.
                </p>
            </div>
            
            <div class="grid gap-4 sm:gap-6 md:grid-cols-2">
                <!-- Sari Prima Laundry -->
                <article class="lift flex flex-col sm:flex-row overflow-hidden rounded-2xl sm:rounded-3xl bg-white border border-gray-100 shadow-xs group hover:border-emerald-200 transition-all">
                    <div class="relative w-full sm:w-5/12 h-44 sm:h-auto min-h-[160px] shrink-0 bg-slate-100 overflow-hidden">
                        <img src="/images/laundry.jpeg" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Sari Prima Laundry" loading="lazy">
                    </div>
                    <div class="p-4 sm:p-6 flex-1 flex flex-col justify-center gap-2 sm:gap-2.5">
                        <div class="flex items-center gap-2.5 sm:gap-3">
                            <span class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl bg-emerald-50 text-[#006c49] flex items-center justify-center shrink-0 shadow-2xs border border-emerald-100">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-[#006c49]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 7a2 2 0 10-2-2m2 2l8.5 6.5a1 1 0 01-.6 1.5H4.1a1 1 0 01-.6-1.5L12 7zM4 17h16a2 2 0 012 2v1H2v-1a2 2 0 012-2z"/>
                                </svg>
                            </span>
                            <h3 class="font-bold text-sm sm:text-lg text-gray-900 font-display">Sari Prima Laundry</h3>
                        </div>
                        <p class="text-xs sm:text-sm leading-relaxed text-gray-600 font-sans">
                            Layanan laundry kiloan harian yang praktis. Cucian Anda bisa dijemput dan diantar kembali langsung ke area kos.
                        </p>
                    </div>
                </article>

                <!-- Warung Mama Anis -->
                <article class="lift flex flex-col sm:flex-row overflow-hidden rounded-2xl sm:rounded-3xl bg-white border border-gray-100 shadow-xs group hover:border-emerald-200 transition-all">
                    <div class="relative w-full sm:w-5/12 h-44 sm:h-auto min-h-[160px] shrink-0 bg-slate-100 overflow-hidden">
                        <img src="/images/warung.jpg" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Warung Mama Anis" loading="lazy">
                    </div>
                    <div class="p-4 sm:p-6 flex-1 flex flex-col justify-center gap-2 sm:gap-2.5">
                        <div class="flex items-center gap-2.5 sm:gap-3">
                            <span class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl bg-emerald-50 text-[#006c49] flex items-center justify-center shrink-0 shadow-2xs border border-emerald-100">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-[#006c49]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 4h18l-1.5 5.5a2 2 0 01-3 0 2 2 0 01-3 0 2 2 0 01-3 0 2 2 0 01-3 0L3 4zM4 9.5V20a1 1 0 001 1h14a1 1 0 001-1V9.5M8 14h8v7H8z"/>
                                </svg>
                            </span>
                            <h3 class="font-bold text-sm sm:text-lg text-gray-900 font-display">Warung Mama Anis</h3>
                        </div>
                        <p class="text-xs sm:text-sm leading-relaxed text-gray-600 font-sans">
                            Menyediakan aneka minuman dan makanan favorit instan yang menyegarkan, langsung di lingkungan kos Anda.
                        </p>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <!-- Lokasi Strategis Section -->
    <section class="bg-white py-10 sm:py-16 md:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-8">
            <div class="grid gap-8 lg:gap-12 lg:grid-cols-2 lg:items-center">
                <div>
                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 font-display">
                        Lokasi Strategis & Dekat Fasilitas
                    </h2>
                    <p class="mt-2 sm:mt-4 text-xs sm:text-base md:text-lg text-gray-600 leading-relaxed font-sans">
                        Terletak di pusat mobilitas Tangerang, memudahkan akses menuju kampus maupun pusat perbelanjaan.
                    </p>
                    <div class="mt-4 sm:mt-8 grid grid-cols-2 sm:grid-cols-2 gap-2.5 sm:gap-4">
                        @php
                        $togaSvg = '<svg class="w-4 h-4 sm:w-5 sm:h-5 text-[#006c49]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 10v6"/></svg>';
                        $shoppingBagSvg = '<svg class="w-4 h-4 sm:w-5 sm:h-5 text-[#006c49]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/><path stroke-linecap="round" stroke-linejoin="round" d="M10 14h4"/></svg>';
                        $ayamGorengSvg = '<svg class="w-4 h-4 sm:w-5 sm:h-5 text-[#006c49]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.828 4.929a5 5 0 017.071 7.071l-2.121 2.121a5 5 0 01-6.364.636l-3.536 3.536a2 2 0 01-2.828 0 2 2 0 010-2.828l3.535-3.536a5 5 0 01.637-6.364l2.121-2.121z"/><circle cx="5.5" cy="18.5" r="1.5" fill="currentColor"/></svg>';
                        $cartSvg = '<svg class="w-4 h-4 sm:w-5 sm:h-5 text-[#006c49]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>';

                        $nearbyLocations = [
                            [
                                'name' => 'BINUS University',
                                'distance' => '500 meter',
                                'svg' => $togaSvg
                            ],
                            [
                                'name' => 'Mall Alam Sutera',
                                'distance' => '800 meter',
                                'svg' => $shoppingBagSvg
                            ],
                            [
                                'name' => 'Univ. Bunda Mulia',
                                'distance' => '600 meter',
                                'svg' => $togaSvg
                            ],
                            [
                                'name' => 'Jakarta Premium Outlet',
                                'distance' => '900 meter',
                                'svg' => $shoppingBagSvg
                            ],
                            [
                                'name' => 'Alfamart',
                                'distance' => '100 meter',
                                'svg' => $cartSvg
                            ],
                            [
                                'name' => 'Kuliner Sekitar',
                                'distance' => 'Banyak Pilihan',
                                'svg' => $ayamGorengSvg
                            ]
                        ];
                        @endphp

                        @foreach($nearbyLocations as $loc)
                            <div class="lift flex items-center gap-2 sm:gap-3.5 bg-[#f8f9fb] p-2.5 sm:p-4.5 rounded-xl sm:rounded-2xl border border-gray-100 shadow-xs cursor-pointer hover:bg-white hover:border-emerald-200 transition-all duration-300">
                                <span class="w-8 h-8 sm:w-11 sm:h-11 rounded-lg sm:rounded-xl bg-white text-[#006c49] border border-gray-100 flex items-center justify-center shrink-0 shadow-xs">
                                    {!! $loc['svg'] !!}
                                </span>
                                <div class="truncate">
                                    <b class="block text-xs sm:text-base text-gray-900 font-sans font-bold truncate">{{ $loc['name'] }}</b>
                                    <span class="text-[10px] sm:text-sm text-gray-500 font-medium font-sans truncate">{{ $loc['distance'] }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Real Interactive Google Maps Preview Frame -->
                <div class="relative w-full max-w-[520px] mx-auto z-10">
                    <div class="relative bg-white rounded-2xl sm:rounded-3xl p-2 sm:p-3 shadow-xl border border-gray-100 overflow-hidden">
                        <!-- Top bar info -->
                        <div class="flex items-center justify-between px-2 sm:px-3 py-1.5 sm:py-2 border-b border-gray-100 mb-1.5 sm:mb-2">
                            <div class="flex items-center gap-1.5 sm:gap-2">
                                <span class="relative flex h-2 w-2 sm:h-2.5 sm:w-2.5">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 sm:h-2.5 sm:w-2.5 bg-[#006c49]"></span>
                                </span>
                                <span class="text-xs sm:text-sm font-bold text-gray-800 font-display">Lokasi Kos Mama Anis</span>
                            </div>
                            <span class="text-[10px] sm:text-xs text-[#006c49] font-bold bg-emerald-50 px-2 sm:px-3 py-0.5 sm:py-1 rounded-full border border-emerald-100">Live Maps</span>
                        </div>
                        
                        <!-- Google Maps Iframe Container -->
                        <div class="relative aspect-[16/10] sm:aspect-[4/3] rounded-xl sm:rounded-2xl overflow-hidden bg-slate-100 shadow-inner">
                            <iframe 
                                title="Peta Lokasi Mama Anis Kos"
                                src="https://maps.google.com/maps?q=Mama+Anis+Kos+Pinang+Tangerang&t=&z=16&ie=UTF8&iwloc=&output=embed" 
                                class="w-full h-full border-0" 
                                allowfullscreen="" 
                                loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>

                            <!-- Floating Action: Open in Google Maps -->
                            <a 
                                href="https://share.google/xtb2nkiQbL87nVgco" 
                                target="_blank" 
                                rel="noopener" 
                                class="absolute bottom-2.5 left-2.5 sm:bottom-3 sm:left-3 bg-white/95 backdrop-blur-md hover:bg-white text-[#006c49] font-bold text-xs sm:text-sm px-3.5 py-2 sm:px-5 sm:py-2.5 rounded-lg sm:rounded-xl flex items-center gap-1.5 sm:gap-2 shadow-lg border border-gray-100 transition-all hover:scale-105 active:scale-95 z-20 group font-sans"
                            >
                                <svg class="w-3.5 h-3.5 sm:w-4.5 sm:h-4.5 text-red-500 fill-current group-hover:scale-110 transition-transform" viewBox="0 0 24 24">
                                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                                </svg>
                                <span>Buka Maps</span>
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5l15-15m0 0H8.25m11.25 0v11.25"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Kamar Tersedia Section -->
    <section class="bg-[#f8f9fb] py-10 sm:py-16 md:py-20 border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-8">
            <div class="flex flex-wrap items-end justify-between gap-3 mb-6 sm:mb-10">
                <div>
                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 font-display">Kamar Tersedia</h2>
                    <p class="mt-1 sm:mt-2 text-xs sm:text-base text-gray-600 font-sans">Pilih tipe hunian yang paling sesuai dengan kebutuhan Anda.</p>
                </div>
                <a href="/catalog" class="font-bold text-xs sm:text-base text-[#006c49] hover:text-[#005236] transition-colors flex items-center gap-1 font-sans">
                    <span>Lihat semua</span>
                    <span>→</span>
                </a>
            </div>
            
            <div class="grid gap-4 sm:gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse($rooms->take(3) as $room)
                    <x-card-kamar :room="$room" layout="vertical" />
                @empty
                    <p class="col-span-full rounded-2xl border border-dashed border-gray-200 p-8 sm:p-12 text-center text-gray-400 font-semibold text-xs sm:text-base bg-white shadow-xs">
                        Belum ada kamar terdaftar. Silakan tambahkan unit dari dashboard admin.
                    </p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Anti-Fraud & Safe Transaction Assurance Section (Same as About Us) -->
    <section class="bg-[#f8f9fb] py-8 sm:py-14 border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-8">
            <div class="bg-gradient-to-br from-amber-500/10 via-amber-50 to-emerald-50/50 p-4 sm:p-10 md:p-12 rounded-2xl sm:rounded-[2.5rem] border border-amber-200/80 shadow-md">
                <div class="max-w-3xl mx-auto text-center mb-5 sm:mb-10">
                    <div class="inline-flex items-center gap-1 bg-amber-500 text-white px-2.5 py-0.5 sm:px-3 sm:py-1 rounded-full text-[9px] sm:text-xs font-black uppercase tracking-wider mb-1.5 sm:mb-3 shadow-xs">
                        <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <span>Pusat Keamanan Transaksi</span>
                    </div>
                    <h2 class="text-lg sm:text-2xl md:text-3xl font-extrabold text-gray-900 font-display">Panduan Transaksi Aman Mama Anis Kos</h2>
                    <p class="mt-1 sm:mt-2 text-[11px] sm:text-sm md:text-base text-gray-600 font-sans leading-relaxed px-2">
                        Demi keamanan bersama, perhatikan 3 prinsip keabsahan transaksi berikut sebelum menyewa.
                    </p>
                </div>

                <div class="grid gap-2.5 sm:gap-6 md:grid-cols-3">
                    <div class="bg-white p-3.5 sm:p-6 rounded-xl sm:rounded-3xl border border-amber-100 shadow-xs flex flex-row sm:flex-col items-start gap-3 sm:gap-4">
                        <div class="w-7 h-7 sm:w-10 sm:h-10 rounded-lg sm:rounded-2xl bg-emerald-100 text-[#006c49] flex items-center justify-center font-black text-xs sm:text-base shrink-0">
                            1
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-xs sm:text-base font-display">Satu Nomor WhatsApp</h4>
                            <p class="text-[11px] sm:text-xs text-gray-600 mt-0.5 sm:mt-1 leading-relaxed">
                                Pengelola resmi hanya via WA <strong>0877-8204-9784</strong>. Abaikan kontak lain.
                            </p>
                        </div>
                    </div>

                    <div class="bg-white p-3.5 sm:p-6 rounded-xl sm:rounded-3xl border border-amber-200 shadow-xs flex flex-row sm:flex-col items-start gap-3 sm:gap-4">
                        <div class="w-7 h-7 sm:w-10 sm:h-10 rounded-lg sm:rounded-2xl bg-amber-100 text-amber-800 flex items-center justify-center font-black text-xs sm:text-base shrink-0">
                            2
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-xs sm:text-base font-display">Rekening Mandiri Marliyah</h4>
                            <p class="text-[11px] sm:text-xs text-gray-600 mt-0.5 sm:mt-1 leading-relaxed">
                                Pembayaran sah hanya ke <strong>Bank Mandiri a.n. MARLIYAH</strong>.
                            </p>
                        </div>
                    </div>

                    <div class="bg-white p-3.5 sm:p-6 rounded-xl sm:rounded-3xl border border-red-100 shadow-xs flex flex-row sm:flex-col items-start gap-3 sm:gap-4">
                        <div class="w-7 h-7 sm:w-10 sm:h-10 rounded-lg sm:rounded-2xl bg-red-100 text-red-700 flex items-center justify-center font-black text-xs sm:text-base shrink-0">
                            3
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-xs sm:text-base font-display">Batas Tanggung Jawab</h4>
                            <p class="text-[11px] sm:text-xs text-gray-600 mt-0.5 sm:mt-1 leading-relaxed">
                                Transaksi di luar data di atas di luar tanggung jawab Mama Anis Kos.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- WhatsApp CTA Section with Lively Dynamic Orbiting Auras & Silky Smooth Cursor Spotlight -->
    <section id="contact" class="bg-white py-8 sm:py-14">
        <div class="max-w-7xl mx-auto px-4 sm:px-8">
            <div class="cta-dynamic-card relative rounded-2xl sm:rounded-[2.5rem] p-5 sm:p-14 text-center border border-emerald-400/40 shadow-xl overflow-hidden cursor-default group" style="background: linear-gradient(-45deg, #00422b, #006c49, #005a3c, #00875c, #003320); background-size: 300% 300%; animation: ctaGradientFlow 12s ease infinite;">
                <!-- 1. Ambient Moving Aura 1 (Top Right Emerald Mint) -->
                <div class="ambient-aura-1 absolute -top-20 -right-20 w-96 h-96 rounded-full bg-gradient-to-br from-emerald-300/40 via-teal-300/30 to-emerald-500/20 blur-3xl pointer-events-none"></div>
                
                <!-- 2. Ambient Moving Aura 2 (Bottom Left Lime Gold) -->
                <div class="ambient-aura-2 absolute -bottom-20 -left-20 w-96 h-96 rounded-full bg-gradient-to-tr from-lime-300/35 via-emerald-400/30 to-teal-400/25 blur-3xl pointer-events-none"></div>
                
                <!-- 3. Ambient Moving Aura 3 (Center Pulsing Cyan Orb) -->
                <div class="ambient-aura-3 absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[32rem] h-[32rem] rounded-full bg-teal-300/25 blur-3xl pointer-events-none"></div>

                <!-- 4. Ambient Moving Aura 4 (Floating Light Emerald Orb) -->
                <div class="ambient-aura-4 absolute top-10 left-1/4 w-80 h-80 rounded-full bg-emerald-400/30 blur-3xl pointer-events-none"></div>

                <!-- 5. Interactive Single Mouse-Following Spotlight Aura (Silky Smooth Lerp Tracking) -->
                <div class="mouse-follow-aura absolute w-96 h-96 rounded-full blur-2xl pointer-events-none opacity-0 transition-opacity duration-300" style="background: radial-gradient(circle, rgba(52, 211, 153, 0.45) 0%, rgba(45, 212, 191, 0.25) 45%, transparent 70%); will-change: transform, opacity;"></div>

                <!-- Card Content -->
                <div class="relative z-10 max-w-2xl mx-auto flex flex-col items-center gap-2.5 sm:gap-4">
                    <div class="w-10 h-10 sm:w-16 sm:h-16 rounded-full bg-white/15 text-white flex items-center justify-center mb-0.5 sm:mb-1 shadow-inner border border-white/20">
                        <svg class="w-5 h-5 sm:w-8 sm:h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                    </div>
                    <h2 class="text-xl sm:text-3xl md:text-4xl font-black font-display tracking-tight leading-tight text-white">
                        Siap untuk Pindah ke Hunian Nyaman?
                    </h2>
                    <p class="text-emerald-100 text-xs sm:text-base leading-relaxed font-sans max-w-lg">
                        Tim kami siap menjawab pertanyaan Anda, mengecek unit kamar yang tersedia, atau menjadwalkan survei langsung ke kos.
                    </p>
                    <div class="mt-2 sm:mt-4 w-full sm:w-auto">
                        <a 
                            href="https://wa.me/6287782049784?text=Halo%20Mama%20Anis%20Kos%2C%20saya%20tertarik%20untuk%20bertanya%20tentang%20kost%20yang%20tersedia.%20Terima%20kasih%21" 
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
            </div>
        </div>
    </section>

    <!-- Custom Style for Lively Ambient Rotating Auras -->
    <style>
        @keyframes ctaGradientFlow {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        @keyframes auraOrbit1 {
            0% { transform: translate(0, 0) scale(1) rotate(0deg); }
            25% { transform: translate(-140px, 90px) scale(1.3) rotate(90deg); }
            50% { transform: translate(-240px, 40px) scale(0.9) rotate(180deg); }
            75% { transform: translate(-110px, -60px) scale(1.25) rotate(270deg); }
            100% { transform: translate(0, 0) scale(1) rotate(360deg); }
        }
        @keyframes auraOrbit2 {
            0% { transform: translate(0, 0) scale(1) rotate(0deg); }
            25% { transform: translate(150px, -100px) scale(1.35) rotate(-90deg); }
            50% { transform: translate(260px, -40px) scale(0.85) rotate(-180deg); }
            75% { transform: translate(120px, 60px) scale(1.2) rotate(-270deg); }
            100% { transform: translate(0, 0) scale(1) rotate(-360deg); }
        }
        @keyframes auraOrbit3 {
            0% { transform: translate(-50%, -50%) scale(0.8) translate(-60px, -30px); opacity: 0.25; }
            50% { transform: translate(-50%, -50%) scale(1.4) translate(80px, 40px); opacity: 0.45; }
            100% { transform: translate(-50%, -50%) scale(0.8) translate(-60px, -30px); opacity: 0.25; }
        }
        @keyframes auraOrbit4 {
            0% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(-160px, 110px) scale(1.35); }
            100% { transform: translate(0, 0) scale(1); }
        }
        .ambient-aura-1 {
            animation: auraOrbit1 12s cubic-bezier(0.45, 0.05, 0.55, 0.95) infinite;
        }
        .ambient-aura-2 {
            animation: auraOrbit2 14s cubic-bezier(0.45, 0.05, 0.55, 0.95) infinite;
        }
        .ambient-aura-3 {
            animation: auraOrbit3 8s ease-in-out infinite;
        }
        .ambient-aura-4 {
            animation: auraOrbit4 10s ease-in-out infinite;
        }
    </style>

    <!-- Scroll Fade and Blur Animation Logic for Hero Section & Smooth Interactive Mouse-Following Aura -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 1. Hero Scroll Effects
            const heroSection = document.getElementById('hero-section');
            const heroBgImg = document.getElementById('hero-bg-img');
            const heroContent = document.getElementById('hero-content');
            const heroBottomFade = document.getElementById('hero-bottom-fade');
            const scrollIndicator = document.getElementById('hero-scroll-indicator');

            if (heroSection && heroBgImg && heroContent) {
                let ticking = false;

                function updateHeroScrollEffects() {
                    const scrollY = window.scrollY;
                    const heroHeight = heroSection.offsetHeight || window.innerHeight;

                    if (scrollY <= heroHeight * 1.2) {
                        const progress = Math.min(Math.max(scrollY / heroHeight, 0), 1);

                        // Dynamic progressive blur (0px -> 14px) and subtle scale zoom (1 -> 1.08)
                        const blurAmount = progress * 14;
                        const scaleAmount = 1 + progress * 0.08;
                        heroBgImg.style.filter = `blur(${blurAmount}px)`;
                        heroBgImg.style.transform = `scale(${scaleAmount})`;

                        // Hero content text & CTA fade out (1 -> 0) with gentle upward parallax
                        const contentOpacity = Math.max(1 - progress * 1.6, 0);
                        const contentTranslateY = scrollY * 0.35;
                        heroContent.style.opacity = contentOpacity;
                        heroContent.style.transform = `translateY(-${contentTranslateY}px)`;

                        // Scroll Down indicator fades quickly
                        if (scrollIndicator) {
                            scrollIndicator.style.opacity = Math.max(1 - progress * 3.5, 0);
                        }

                        // Bottom white blend transition fades in smoothly near the bottom of hero
                        if (heroBottomFade) {
                            const fadeProgress = Math.min(Math.max((progress - 0.3) / 0.65, 0), 1);
                            heroBottomFade.style.opacity = fadeProgress;
                        }
                    }
                    ticking = false;
                }

                window.addEventListener('scroll', function () {
                    if (!ticking) {
                        window.requestAnimationFrame(updateHeroScrollEffects);
                        ticking = true;
                    }
                }, { passive: true });

                updateHeroScrollEffects(); // Trigger once on mount
            }

            // 2. Interactive Cursor-Following Aura with Smooth Fluid Interpolation
            document.querySelectorAll('.cta-dynamic-card').forEach(card => {
                const mouseAura = card.querySelector('.mouse-follow-aura');
                if (!mouseAura) return;

                let targetX = 0, targetY = 0;
                let currentX = 0, currentY = 0;
                let isHovered = false;
                let animId = null;

                function renderAura() {
                    if (isHovered) {
                        currentX += (targetX - currentX) * 0.18;
                        currentY += (targetY - currentY) * 0.18;
                        mouseAura.style.transform = `translate(${currentX - 192}px, ${currentY - 192}px)`;
                        animId = requestAnimationFrame(renderAura);
                    }
                }

                card.addEventListener('mouseenter', (e) => {
                    isHovered = true;
                    mouseAura.style.opacity = '1';
                    const rect = card.getBoundingClientRect();
                    targetX = e.clientX - rect.left;
                    targetY = e.clientY - rect.top;
                    currentX = targetX;
                    currentY = targetY;
                    mouseAura.style.transform = `translate(${currentX - 192}px, ${currentY - 192}px)`;
                    cancelAnimationFrame(animId);
                    animId = requestAnimationFrame(renderAura);
                });

                card.addEventListener('mouseleave', () => {
                    isHovered = false;
                    mouseAura.style.opacity = '0';
                    cancelAnimationFrame(animId);
                });

                card.addEventListener('mousemove', (e) => {
                    const rect = card.getBoundingClientRect();
                    targetX = e.clientX - rect.left;
                    targetY = e.clientY - rect.top;
                    if (!isHovered) {
                        isHovered = true;
                        mouseAura.style.opacity = '1';
                        animId = requestAnimationFrame(renderAura);
                    }
                });
            });
        });
    </script>
@endsection
