@extends('layouts.app')

@section('title', 'Tentang Kami | Mama Anis Kos')

@section('content')
<div class="pt-4 sm:pt-8 pb-16 sm:pb-20 font-sans bg-[#f8f9fb] min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-8">
        <!-- Hero Section -->
        <section class="grid gap-8 md:gap-10 md:grid-cols-12 items-center mb-14 sm:mb-20">
            <div class="md:col-span-7 flex flex-col items-start gap-3.5 sm:gap-5">
                <span class="bg-[#006c49]/10 text-[#006c49] text-[10px] sm:text-xs font-bold px-3 py-1 sm:px-4 sm:py-1.5 rounded-full uppercase tracking-wider font-sans border border-[#006c49]/20">
                    Est. 2025 · Tangerang
                </span>
                <h1 class="text-2xl sm:text-4xl md:text-5xl font-extrabold text-gray-900 leading-tight font-display tracking-tight">
                    Membangun <span class="text-[#006c49]">Kenyamanan</span>, Menghadirkan Kehangatan.
                </h1>
                <p class="text-gray-600 text-xs sm:text-base md:text-lg leading-relaxed font-sans">
                    Mama Anis Kos hadir menyediakan hunian sewa yang bersih, tenang, dan terjangkau dengan suasana kekeluargaan yang ramah untuk mahasiswa dan pekerja di kawasan Tangerang.
                </p>
                <div class="flex flex-col sm:flex-row items-center gap-2.5 sm:gap-3 pt-2 w-full sm:w-auto">
                    <a 
                        href="https://wa.me/6287782049784?text=Halo%20Mama%20Anis%20Kos%2C%20saya%20tertarik%20untuk%20bertanya%20tentang%20kamar%20kos.%20Terima%20kasih%21" 
                        target="_blank" 
                        rel="noopener" 
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-[#006c49] hover:bg-[#005538] text-white px-5 py-2.5 sm:px-6 sm:py-3 rounded-full text-xs sm:text-sm font-bold shadow-md shadow-[#006c49]/20 hover:scale-105 active:scale-95 transition-all duration-300 cursor-pointer"
                    >
                        <span>Tanya Ketersediaan</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"></path>
                        </svg>
                    </a>
                    <a 
                        href="/catalog" 
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 px-5 py-2.5 sm:px-6 sm:py-3 rounded-full text-xs sm:text-sm font-bold hover:scale-105 active:scale-95 transition-all duration-300 cursor-pointer shadow-xs"
                    >
                        <span>Lihat Kamar</span>
                    </a>
                </div>
            </div>
            <div class="md:col-span-5 relative">
                <div class="group aspect-[4/3] rounded-2xl sm:rounded-3xl overflow-hidden shadow-lg border border-gray-100 relative">
                    <img src="/images/lorong.jpeg" alt="Lorong Mama Anis Kos" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
                    <div class="absolute bottom-4 left-4 right-4 text-white">
                        <p class="text-xs font-semibold uppercase tracking-wider text-emerald-200">Suasana Kos</p>
                        <p class="text-sm font-bold font-display">Lorong Bersih & Tertata Rapi</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats & Sejarah Section -->
        <section class="grid gap-6 sm:gap-10 md:grid-cols-12 items-center mb-12 sm:mb-20">
            <!-- Left Side: Stats cards with cute background SVG icons -->
            <div class="md:col-span-5 grid grid-cols-2 gap-3 sm:gap-4">                <!-- Stat 1: Kenyamanan -->
                <div class="lift bg-white p-4 sm:p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between min-h-[120px] sm:min-h-[150px] relative overflow-hidden group hover:border-emerald-200 hover:shadow-xl transition-all duration-300">
                    <div class="w-9 h-9 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-emerald-50 text-[#006c49] flex items-center justify-center font-bold text-base sm:text-xl shadow-xs relative z-10 group-hover:scale-105 transition-transform">
                        <svg class="w-4 h-4 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/>
                        </svg>
                    </div>
                    <div class="relative z-10 mt-2 sm:mt-0">
                        <span class="text-2xl sm:text-4xl font-bold text-[#006c49] font-display block leading-none mb-0.5 sm:mb-1">100%</span>
                        <h4 class="font-semibold text-gray-900 text-xs sm:text-base font-display">Kenyamanan</h4>
                        <p class="text-[10px] sm:text-xs text-gray-400 font-medium mt-0.5">Penghuni Terjamin</p>
                    </div>
                </div>

                <!-- Stat 2: Keamanan 24 Jam -->
                <div class="lift bg-[#006c49] text-white p-4 sm:p-6 rounded-2xl shadow-lg shadow-[#006c49]/15 flex flex-col justify-between min-h-[120px] sm:min-h-[150px] relative overflow-hidden group hover:shadow-2xl transition-all duration-300">
                    <div class="w-9 h-9 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-white/15 text-white flex items-center justify-center font-bold text-base sm:text-xl shadow-xs relative z-10 group-hover:scale-105 transition-transform">
                        <svg class="w-4 h-4 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.751h-.152c-3.196 0-6.1-1.249-8.25-3.286z"/>
                        </svg>
                    </div>
                    <div class="relative z-10 mt-2 sm:mt-0">
                        <span class="text-2xl sm:text-4xl font-bold font-display block leading-none mb-0.5 sm:mb-1">24 Jam</span>
                        <h4 class="font-semibold text-white text-xs sm:text-base font-display">Keamanan</h4>
                        <p class="text-[10px] sm:text-xs text-emerald-200/80 font-medium mt-0.5">CCTV Terjaga</p>
                    </div>
                </div>
            </div>

            <!-- Right Side: Sejarah kami text -->
            <div class="md:col-span-7 flex flex-col gap-2.5 sm:gap-4">
                <span class="text-[10px] sm:text-xs font-bold text-[#006c49] uppercase tracking-widest font-sans">Sejarah Kami</span>
                <h2 class="text-xl sm:text-3xl font-bold text-gray-900 font-display tracking-tight">Bagaimana Langkah Awal Kami Dimulai</h2>
                <p class="text-gray-600 text-xs sm:text-base leading-relaxed font-sans">
                    Perjalanan kami dimulai dari usaha <strong>Warung Mama Anis</strong> yang melayani kebutuhan konsumsi harian warga sekitar. Di tahun <strong>2025</strong> kami menghadirkan <strong>Mama Anis Kos</strong> untuk memberikan hunian yang bersih, layak, dan terjangkau.
                </p>
                <p class="text-gray-600 text-xs sm:text-base leading-relaxed font-sans">
                    Kami berfokus menyediakan hunian yang nyaman dengan suasana kekeluargaan yang hangat agar setiap penghuni dapat beristirahat dengan tenang.
                </p>
            </div>
        </section>

        <!-- Visi & Misi Section -->
        <section class="mb-12 sm:mb-20">
            <div class="text-center mb-6 sm:mb-12">
                <span class="text-[10px] sm:text-xs font-bold text-[#006c49] uppercase tracking-widest font-sans">Arah & Tujuan</span>
                <h2 class="text-xl sm:text-3xl font-bold text-gray-900 font-display mt-1 sm:mt-2">Visi & Misi Kami</h2>
                <p class="mt-1 sm:mt-2 text-xs sm:text-base text-gray-500 max-w-xl mx-auto font-sans">
                    Komitmen sederhana kami dalam memberikan tempat tinggal terbaik bagi setiap penghuni.
                </p>
            </div>

            <!-- Vision & Mission cards -->
            <div class="grid gap-4 sm:gap-6 md:grid-cols-2 mb-6 sm:mb-8">
                <!-- Visi Card -->
                <div class="lift bg-white p-5 sm:p-10 rounded-2xl sm:rounded-3xl border border-gray-100 shadow-sm flex flex-col justify-between relative overflow-hidden group hover:border-emerald-200 hover:shadow-2xl transition-all duration-300">
                    <div class="flex flex-col gap-3 sm:gap-4 relative z-10">
                        <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-xl sm:rounded-2xl bg-emerald-50 text-[#006c49] flex items-center justify-center shadow-xs">
                            <svg class="w-5 h-5 sm:w-7 sm:h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </div>
                        <div>
                            <span class="text-[10px] sm:text-xs font-bold uppercase tracking-wider text-[#006c49] font-sans">Prinsip Utama</span>
                            <h3 class="text-base sm:text-2xl font-bold text-gray-900 font-display mt-0.5 sm:mt-1">Visi Kami</h3>
                        </div>
                        <p class="text-xs sm:text-lg text-gray-600 leading-relaxed font-sans">
                            Menjadi penyedia hunian kos di Tangerang yang mengintegrasikan <strong>kenyamanan</strong>, <strong>kebersihan</strong>, dan rasa <strong>kekeluargaan yang tulus</strong>.
                        </p>
                    </div>
                </div>

                <!-- Misi Card -->
                <div class="lift bg-gradient-to-br from-[#006c49] to-[#004d31] p-5 sm:p-10 rounded-2xl sm:rounded-3xl shadow-xl shadow-[#006c49]/15 flex flex-col justify-between text-white relative overflow-hidden group hover:shadow-2xl transition-all duration-300">
                    <div class="flex flex-col gap-3 sm:gap-4 relative z-10">
                        <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-xl sm:rounded-2xl bg-white/15 text-white flex items-center justify-center shadow-xs">
                            <svg class="w-5 h-5 sm:w-7 sm:h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <span class="text-[10px] sm:text-xs font-bold uppercase tracking-wider text-emerald-200 font-sans">Langkah Nyata</span>
                            <h3 class="text-base sm:text-2xl font-bold text-white font-display mt-0.5 sm:mt-1">Misi Kami</h3>
                        </div>
                        <ul class="text-xs sm:text-base space-y-2 sm:space-y-3 text-emerald-50 font-medium font-sans">
                            <li class="flex items-start gap-2 sm:gap-3">
                                <span class="w-4 h-4 sm:w-6 sm:h-6 rounded-full bg-white/20 flex items-center justify-center text-[10px] sm:text-xs shrink-0 mt-0.5 font-bold">✓</span>
                                <span>Menyediakan fasilitas kos lengkap dan fungsional.</span>
                            </li>
                            <li class="flex items-start gap-2 sm:gap-3">
                                <span class="w-4 h-4 sm:w-6 sm:h-6 rounded-full bg-white/20 flex items-center justify-center text-[10px] sm:text-xs shrink-0 mt-0.5 font-bold">✓</span>
                                <span>Menjaga keamanan dan ketertiban lingkungan 24 jam.</span>
                            </li>
                            <li class="flex items-start gap-2 sm:gap-3">
                                <span class="w-4 h-4 sm:w-6 sm:h-6 rounded-full bg-white/20 flex items-center justify-center text-[10px] sm:text-xs shrink-0 mt-0.5 font-bold">✓</span>
                                <span>Membangun lingkungan hunian yang hangat dan bersih.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- 4 Nilai Utama Kos Section -->
        <section class="mb-12 sm:mb-20">
            <div class="text-center mb-6 sm:mb-12">
                <span class="text-[10px] sm:text-xs font-bold text-[#006c49] uppercase tracking-widest font-sans">Nilai Utama</span>
                <h2 class="text-xl sm:text-3xl font-bold text-gray-900 font-display mt-1 sm:mt-2">Komitmen Pelayanan Kami</h2>
                <p class="mt-1 sm:mt-2 text-xs sm:text-base text-gray-500 max-w-xl mx-auto font-sans">
                    Standar pelayanan yang selalu kami jaga untuk ketenangan setiap penghuni kos.
                </p>
            </div>

            <!-- 4 Grid values (2 columns on mobile, 4 on desktop) -->
            <div class="grid gap-3 sm:gap-6 grid-cols-2 lg:grid-cols-4">
                <!-- Kebersihan -->
                <div class="lift bg-white p-4 sm:p-7 rounded-2xl sm:rounded-3xl border border-gray-100 shadow-sm flex flex-col justify-between gap-2.5 sm:gap-4 relative overflow-hidden group hover:border-emerald-200 hover:shadow-xl transition-all duration-300">
                    <div class="w-9 h-9 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-emerald-50 text-[#006c49] flex items-center justify-center shadow-xs relative z-10">
                        <svg class="w-4 h-4 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.286L13 21l-2.286-6.857L5 12l5.714-2.286L13 3z"/>
                        </svg>
                    </div>
                    <div class="relative z-10">
                        <h4 class="font-bold text-gray-900 text-xs sm:text-lg font-display">Kebersihan</h4>
                        <p class="text-[11px] sm:text-sm text-gray-500 font-sans leading-relaxed mt-0.5 sm:mt-1">Area bersama dibersihkan secara berkala.</p>
                    </div>
                </div>

                <!-- Keamanan -->
                <div class="lift bg-white p-4 sm:p-7 rounded-2xl sm:rounded-3xl border border-gray-100 shadow-sm flex flex-col justify-between gap-2.5 sm:gap-4 relative overflow-hidden group hover:border-emerald-200 hover:shadow-xl transition-all duration-300">
                    <div class="w-9 h-9 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-emerald-50 text-[#006c49] flex items-center justify-center shadow-xs relative z-10">
                        <svg class="w-4 h-4 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <div class="relative z-10">
                        <h4 class="font-bold text-gray-900 text-xs sm:text-lg font-display">Keamanan</h4>
                        <p class="text-[11px] sm:text-sm text-gray-500 font-sans leading-relaxed mt-0.5 sm:mt-1">Kunci gerbang dan pengawasan CCTV 24 jam.</p>
                    </div>
                </div>

                <!-- Kekeluargaan -->
                <div class="lift bg-white p-4 sm:p-7 rounded-2xl sm:rounded-3xl border border-gray-100 shadow-sm flex flex-col justify-between gap-2.5 sm:gap-4 relative overflow-hidden group hover:border-emerald-200 hover:shadow-xl transition-all duration-300">
                    <div class="w-9 h-9 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-emerald-50 text-[#006c49] flex items-center justify-center shadow-xs relative z-10">
                        <svg class="w-4 h-4 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <div class="relative z-10">
                        <h4 class="font-bold text-gray-900 text-xs sm:text-lg font-display">Kekeluargaan</h4>
                        <p class="text-[11px] sm:text-sm text-gray-500 font-sans leading-relaxed mt-0.5 sm:mt-1">Komunikasi ramah dan tanggap.</p>
                    </div>
                </div>

                <!-- Terpercaya -->
                <div class="lift bg-white p-4 sm:p-7 rounded-2xl sm:rounded-3xl border border-gray-100 shadow-sm flex flex-col justify-between gap-2.5 sm:gap-4 relative overflow-hidden group hover:border-emerald-200 hover:shadow-xl transition-all duration-300">
                    <div class="w-9 h-9 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-emerald-50 text-[#006c49] flex items-center justify-center shadow-xs relative z-10">
                        <svg class="w-4 h-4 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <div class="relative z-10">
                        <h4 class="font-bold text-gray-900 text-xs sm:text-lg font-display">Terpercaya</h4>
                        <p class="text-[11px] sm:text-sm text-gray-500 font-sans leading-relaxed mt-0.5 sm:mt-1">Keterbukaan informasi tarif & fasilitas.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Galeri & Ruang Kos Section -->
        <section class="grid gap-6 sm:gap-12 md:grid-cols-12 items-center mb-12 sm:mb-20">
            <!-- Left Side: two small images with zoom hover -->
            <div class="md:col-span-5 grid grid-cols-2 sm:grid-cols-1 gap-3 sm:gap-4">
                <div class="group aspect-[16/10] rounded-2xl sm:rounded-3xl overflow-hidden shadow-sm border border-gray-100 relative">
                    <img src="/images/lobby.jpeg" alt="Lobby Tamu Mama Anis Kos" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute bottom-2 left-2 sm:bottom-3 sm:left-3 bg-white/90 backdrop-blur-xs px-2.5 py-0.5 sm:px-3 sm:py-1 rounded-lg sm:rounded-xl text-[10px] sm:text-xs font-bold text-gray-800 font-display shadow-xs">
                        Lobby Tamu
                    </div>
                </div>
                <div class="group aspect-[16/10] rounded-2xl sm:rounded-3xl overflow-hidden shadow-sm border border-gray-100 relative">
                    <img src="/images/AC.jpeg" alt="Kamar dengan AC" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute bottom-2 left-2 sm:bottom-3 sm:left-3 bg-white/90 backdrop-blur-xs px-2.5 py-0.5 sm:px-3 sm:py-1 rounded-xl text-[10px] sm:text-xs font-bold text-gray-800 font-display shadow-xs">
                        AC Tiap Kamar
                    </div>
                </div>
            </div>

            <!-- Right Side: large team photo and text -->
            <div class="md:col-span-7 flex flex-col gap-3 sm:gap-6">
                <div>
                    <span class="text-[10px] sm:text-xs font-bold text-[#006c49] uppercase tracking-widest font-sans">Kerapian & Fungsi</span>
                    <h2 class="text-xl sm:text-3xl font-bold text-gray-900 font-display tracking-tight mt-0.5 sm:mt-1">Ruang yang Rapi & Fungsional</h2>
                    <p class="text-gray-600 text-xs sm:text-base leading-relaxed font-sans mt-1.5 sm:mt-3">
                        Kami mengutamakan kerapian dan kenyamanan di setiap unit kamar. Dilengkapi kasur, lemari, meja, serta ventilasi udara yang baik untuk menunjang istirahat Anda.
                    </p>
                </div>
                <div class="group aspect-[16/10] rounded-2xl sm:rounded-3xl overflow-hidden shadow-md border border-gray-100 relative">
                    <img src="/images/Kamar no 5.jpg" alt="Kamar Mama Anis Kos" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute bottom-2.5 left-2.5 sm:bottom-4 sm:left-4 bg-white/90 backdrop-blur-xs px-2.5 py-1 sm:px-3.5 sm:py-1.5 rounded-lg sm:rounded-xl text-[10px] sm:text-xs font-bold text-gray-800 font-display shadow-xs">
                        Unit Kamar Tidur
                    </div>
                </div>
            </div>
        </section>

        <!-- Anti-Fraud & Safe Transaction Assurance Section -->
        <section class="mb-12 sm:mb-20 bg-gradient-to-br from-amber-500/10 via-amber-50 to-emerald-50/50 p-4 sm:p-12 rounded-2xl sm:rounded-[2.5rem] border border-amber-200/80 shadow-md">
            <div class="max-w-3xl mx-auto text-center mb-5 sm:mb-10">
                <div class="inline-flex items-center gap-1 bg-amber-500 text-white px-2.5 py-0.5 sm:px-3.5 sm:py-1 rounded-full text-[9px] sm:text-xs font-black uppercase tracking-wider mb-1.5 sm:mb-3 shadow-xs">
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
                            Pengelola resmi hanya di WA <strong>0877-8204-9784</strong>. Abaikan kontak lain.
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
        </section>

        <!-- CTA Section (Matches Home layout perfectly) -->
        <section class="cta-dynamic-card relative rounded-2xl sm:rounded-[2.5rem] p-5 sm:p-14 text-center border border-emerald-400/40 shadow-xl overflow-hidden cursor-default group" style="background: linear-gradient(-45deg, #00422b, #006c49, #005a3c, #00875c, #003320); background-size: 300% 300%; animation: ctaGradientFlow 12s ease infinite;">
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

<!-- Script for Interactive Cursor-Following Aura with Smooth Fluid Interpolation -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
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
