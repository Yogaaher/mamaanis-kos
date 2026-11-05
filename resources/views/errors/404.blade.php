@php
    $currentTab = '404';
@endphp

@extends('layouts.app')

@section('title', '404 Halaman Tidak Ditemukan | Mama Anis Kos')
@section('meta_description', 'Halaman yang Anda cari tidak ditemukan. Silakan kembali ke halaman utama Mama Anis Kos.')

@section('content')
<section class="relative min-h-[calc(100svh-140px)] flex items-center justify-center px-4 sm:px-6 py-12 sm:py-20 overflow-hidden bg-[#f8f9fb]">
    <!-- Subtle Ambient Background Glows -->
    <div class="absolute -top-24 -left-24 w-72 h-72 sm:w-96 sm:h-96 bg-emerald-200/40 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -right-24 w-72 h-72 sm:w-96 sm:h-96 bg-teal-200/35 rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative z-10 max-w-xl w-full bg-white rounded-3xl border border-gray-100 shadow-xl shadow-emerald-950/5 p-6 sm:p-12 text-center flex flex-col items-center gap-4 sm:gap-6">
        <!-- Icon & 404 Badge -->
        <div class="relative flex items-center justify-center">
            <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl sm:rounded-3xl bg-emerald-50 border border-emerald-100 text-[#006c49] flex items-center justify-center shadow-xs">
                <svg class="w-8 h-8 sm:w-10 sm:h-10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                </svg>
            </div>
            <span class=" -bottom-2 bg-[#006c49] text-white text-[10px] sm:text-xs font-black uppercase tracking-widest px-3 py-0.5 rounded-full shadow-md font-mono absolute">
                Error 404
            </span>
        </div>

        <!-- Text Content -->
        <div class="space-y-2 sm:space-y-3 mt-2">
            <h1 class="text-2xl sm:text-4xl font-black text-gray-900 font-display tracking-tight">
                Waduh, Rutenya Nyasar!
            </h1>
            <p class="text-xs sm:text-base text-gray-500 leading-relaxed font-sans max-w-md mx-auto">
                Halaman atau alamat URL yang Anda tuju tidak ditemukan. Yuk kembali ke halaman utama untuk melihat informasi lengkap <strong>Mama Anis Kos</strong>.
            </p>
        </div>

        <!-- Single CTA back to Home Page -->
        <div class="pt-2 w-full sm:w-auto">
            <a 
                href="{{ url('/') }}" 
                class="w-full sm:w-auto inline-flex items-center justify-center gap-2.5 bg-[#006c49] hover:bg-[#005236] text-white font-bold text-xs sm:text-sm px-7 py-3.5 sm:px-8 sm:py-4 rounded-full shadow-lg shadow-[#006c49]/25 hover:shadow-[#006c49]/40 hover:-translate-y-0.5 active:translate-y-0 active:scale-95 transition-all duration-200 cursor-pointer font-sans"
            >
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                </svg>
                <span>Kembali ke Halaman Utama</span>
            </a>
        </div>
    </div>
</section>
@endsection
