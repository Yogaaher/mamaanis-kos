<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Admin | Mama Anis Group</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        display: ['Montserrat', 'Plus Jakarta Sans', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    },
                    colors: {
                        brand: '#006c49',
                        brandHover: '#005438',
                        ink: '#0f172a',
                        mist: '#f8fafc'
                    }
                }
            }
        }
    </script>
</head>
<body class="min-h-screen bg-mist flex items-center justify-center p-5 font-sans text-ink antialiased">
    <main class="w-full max-w-md rounded-3xl bg-white p-8 sm:p-10 shadow-xl shadow-emerald-950/5 border border-slate-100">
        <!-- Logo & Header -->
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-brand text-white flex items-center justify-center shadow-md shadow-brand/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
            </div>
            <div>
                <a href="{{ route('home') }}" class="text-lg font-black text-slate-900 font-display block">Mama Anis Group</a>
                <span class="text-[10px] font-bold text-brand uppercase tracking-wider">Akses Pengelola</span>
            </div>
        </div>

        <div class="mt-8">
            <h1 class="text-2xl font-black text-slate-900 font-display">Masuk Dashboard</h1>
            <p class="mt-1 text-xs text-slate-400">Silakan masukkan username/email dan kata sandi admin.</p>
        </div>

        @if(session('error'))
            <div class="mt-5 rounded-2xl bg-red-50 border border-red-200 p-3.5 text-xs font-semibold text-red-700 flex items-center gap-2">
                <svg class="w-4 h-4 text-red-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.store') }}" class="mt-6 space-y-4">
            @csrf
            <div>
                <label class="text-xs font-bold text-slate-700 block">Username atau Email</label>
                <div class="relative mt-1.5">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <input 
                        name="email" 
                        type="text" 
                        value="{{ old('email') }}" 
                        placeholder="Masukkan username atau email Anda" 
                        required 
                        autofocus 
                        class="w-full pl-10 pr-4 py-3 text-xs rounded-xl border border-slate-200 outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 font-medium"
                    >
                </div>
                @error('email')
                    <p class="mt-1 text-[11px] font-semibold text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="text-xs font-bold text-slate-700 block">Kata Sandi</label>
                <div class="relative mt-1.5">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    <input 
                        name="password" 
                        type="password" 
                        placeholder="Masukkan kata sandi" 
                        required 
                        class="w-full pl-10 pr-4 py-3 text-xs rounded-xl border border-slate-200 outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 font-medium"
                    >
                </div>
                @error('password')
                    <p class="mt-1 text-[11px] font-semibold text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <button 
                type="submit"
                class="w-full rounded-xl bg-brand hover:bg-brandHover py-3 font-bold text-xs text-white shadow-md shadow-brand/20 transition-all cursor-pointer mt-2"
            >
                Masuk ke Dashboard
            </button>
        </form>

        <div class="mt-6 pt-5 border-t border-slate-100 flex items-center justify-between text-xs">
            <a href="{{ route('home') }}" class="font-bold text-slate-400 hover:text-brand transition-colors flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Halaman Publik</span>
            </a>
            <span class="text-[10px] font-mono text-slate-400">Single Admin Mode</span>
        </div>
    </main>
</body>
</html>
