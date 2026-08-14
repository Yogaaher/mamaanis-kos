@extends('layouts.admin')

@section('title', 'Pengaturan Admin | Mama Anis Group')

@section('content')
<main class="p-3.5 sm:p-8 lg:p-10 flex flex-col gap-4 sm:gap-8 rise w-full max-w-full overflow-x-hidden">
    <!-- Header Page -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs text-slate-400 font-bold tracking-wide">
                <span>Mama Anis Group</span>
                <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="text-brand">Pengaturan</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 mt-1 font-display">Pengaturan & Profil Admin</h1>
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

    <div class="grid gap-6 lg:grid-cols-12">
        <!-- Left: Admin Profile Card -->
        <article class="admin-card lg:col-span-6 bg-white p-6 sm:p-8 rounded-2xl border border-slate-100 shadow-soft flex flex-col gap-6">
            <div class="flex items-center justify-between border-b border-slate-100 pb-5">
                <div class="flex items-center gap-4">
                    <!-- Vector User Avatar Icon (No dummy image) -->
                    <div class="w-16 h-16 rounded-2xl bg-emerald-100 text-brand flex items-center justify-center font-bold border-2 border-emerald-200 shadow-sm shrink-0">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-black text-slate-900 font-display">Admin Mama Anis</h2>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-emerald-100 text-emerald-800 mt-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            Super Administrator
                        </span>
                    </div>
                </div>
            </div>

            <!-- Profile Info Fields -->
            <div class="space-y-4 text-xs font-medium">
                <div>
                    <label class="font-bold text-slate-400 uppercase text-[10px] tracking-wider block">Username Pengelola</label>
                    <div class="mt-1.5 flex items-center gap-2 p-3 bg-slate-50 border border-slate-200/80 rounded-xl">
                        <span class="font-mono text-brand font-bold">@</span>
                        <span class="font-bold text-slate-900 font-mono text-sm">{{ $adminUsername }}</span>
                    </div>
                </div>

                <div>
                    <label class="font-bold text-slate-400 uppercase text-[10px] tracking-wider block">Email Login</label>
                    <div class="mt-1.5 flex items-center gap-2 p-3 bg-slate-50 border border-slate-200/80 rounded-xl">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span class="font-bold text-slate-900">{{ $adminEmail }}</span>
                    </div>
                </div>

            </div>
        </article>

        <!-- Right: Kos Information & System Utilities -->
        <div class="lg:col-span-6 flex flex-col gap-6">
            <!-- Kos Profile Card -->
            <article class="admin-card bg-white p-6 sm:p-8 rounded-2xl border border-slate-100 shadow-soft flex flex-col gap-4">
                <h3 class="font-black text-slate-900 text-base font-display">Informasi Properti Kos</h3>
                
                <div class="grid grid-cols-2 gap-3 text-xs">
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Nama Usaha</span>
                        <span class="font-black text-slate-900 mt-0.5 block">Mama Anis Group</span>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Total Unit Kamar</span>
                        <span class="font-black text-brand mt-0.5 block">{{ $total }} Kamar Terdaftar</span>
                    </div>
                    <div class="col-span-2 p-3 bg-slate-50 rounded-xl border border-slate-100">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Lokasi Properti</span>
                        <span class="font-bold text-slate-800 mt-0.5 block">Kawasan Alam Sutera, Tangerang, Banten</span>
                    </div>
                </div>
            </article>

            <!-- System Utilities Card -->
            <article class="admin-card bg-white p-6 sm:p-8 rounded-2xl border border-slate-100 shadow-soft flex flex-col gap-4">
                <h3 class="font-black text-slate-900 text-base font-display">Pemeliharaan & Aksi Sistem</h3>
                <p class="text-xs text-slate-400">Jalankan penyegaran cache jika data baru belum terupdate seketika.</p>

                <div class="flex flex-wrap gap-3 pt-2">
                    <form method="POST" action="{{ route('admin.settings.clear_cache') }}" class="inline">
                        @csrf
                        <button 
                            type="submit" 
                            class="px-4 py-2.5 bg-slate-100 hover:bg-emerald-100 text-slate-700 hover:text-brand font-bold text-xs rounded-xl flex items-center gap-2 transition-all cursor-pointer"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            <span>Segarkan Cache Sistem</span>
                        </button>
                    </form>

                    <a 
                        href="{{ route('home') }}" 
                        target="_blank"
                        class="px-4 py-2.5 bg-brand hover:bg-brandHover text-white font-bold text-xs rounded-xl flex items-center gap-2 transition-all"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        <span>Cek Website Publik</span>
                    </a>
                </div>
            </article>
        </div>
    </div>
</main>
@endsection
