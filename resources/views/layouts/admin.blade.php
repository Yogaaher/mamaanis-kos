<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard Admin | Mama Anis Kos')</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23006c49'%3E%3Cpath d='M12 3L2 12h3v8h14v-8h3L12 3zm-1 15v-5h2v5h-2z'/%3E%3C/svg%3E">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        window.MAMA_ANIS_PLACEHOLDER = "data:image/svg+xml;charset=UTF-8,%3Csvg xmlns='http://www.w3.org/2000/svg' width='800' height='600' viewBox='0 0 800 600'%3E%3Cdefs%3E%3ClinearGradient id='bg' x1='0%25' y1='0%25' x2='100%25' y2='100%25'%3E%3Cstop offset='0%25' stop-color='%23004d31'/%3E%3Cstop offset='100%25' stop-color='%23006c49'/%3E%3C/linearGradient%3E%3C/defs%3E%3Crect width='100%25' height='100%25' fill='url(%23bg)'/%3E%3Cg transform='translate(400, 250)' text-anchor='middle'%3E%3Crect x='-70' y='-70' width='140' height='140' rx='28' fill='%23ffffff' fill-opacity='0.12' stroke='%23ffffff' stroke-width='2' stroke-opacity='0.25'/%3E%3Cpath d='M-35,15 L0,-25 L35,15 L35,35 L-35,35 Z M-12,35 L-12,12 L12,12 L12,35' fill='none' stroke='%23ffffff' stroke-width='4' stroke-linecap='round' stroke-linejoin='round'/%3E%3Ctext y='110' fill='%23ffffff' font-family='sans-serif' font-size='22' font-weight='800' letter-spacing='0.5'%3EMAMA ANIS KOS%3C/text%3E%3Ctext y='138' fill='%236ee7b7' font-family='sans-serif' font-size='14' font-weight='700' letter-spacing='1'%3EFOTO UNIT KAMAR%3C/text%3E%3C/g%3E%3C/svg%3E";

        function handleImgError(img) {
            if (img && !img.getAttribute('data-error-handled')) {
                img.setAttribute('data-error-handled', 'true');
                img.src = window.MAMA_ANIS_PLACEHOLDER;
            }
        }

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
                    },
                    boxShadow: {
                        soft: '0 10px 30px -5px rgba(0, 108, 73, 0.08), 0 4px 12px -2px rgba(0, 0, 0, 0.03)'
                    }
                }
            }
        }
    </script>

    <!-- Chart.js CDN for Interactive Analytics -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        /* Global SVG Safety Sizing Rules */
        svg {
            display: inline-block;
            vertical-align: middle;
            max-width: 100%;
            flex-shrink: 0;
        }
        svg.w-3 { width: 0.75rem !important; height: 0.75rem !important; }
        svg.w-3\.5 { width: 0.875rem !important; height: 0.875rem !important; }
        svg.w-4 { width: 1rem !important; height: 1rem !important; }
        svg.w-4\.5 { width: 1.125rem !important; height: 1.125rem !important; }
        svg.w-5 { width: 1.25rem !important; height: 1.25rem !important; }
        svg.w-6 { width: 1.5rem !important; height: 1.5rem !important; }
        svg.w-7 { width: 1.75rem !important; height: 1.75rem !important; }
        svg.w-8 { width: 2rem !important; height: 2rem !important; }
        svg.w-10 { width: 2.5rem !important; height: 2.5rem !important; }
        svg.w-12 { width: 3rem !important; height: 3rem !important; }
        svg.w-16 { width: 4rem !important; height: 4rem !important; }
        @keyframes rise {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .rise {
            animation: rise .4s cubic-bezier(0.16, 1, 0.3, 1) both;
        }
        .admin-card {
            transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
        }
        .admin-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 28px -6px rgba(0, 108, 73, 0.09);
        }
        a, button, input, select {
            transition: all .15s ease-in-out;
        }
        
        /* Mobile UX: Prevent iOS Safari Auto-Zoom on Input Focus */
        @media (max-width: 640px) {
            input[type="text"], input[type="number"], input[type="email"], input[type="password"], select, textarea {
                font-size: 16px !important;
            }
        }

        @media print {
            aside, header, .no-print {
                display: none !important;
            }
            main {
                padding: 0 !important;
            }
        }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen bg-mist font-sans text-ink antialiased selection:bg-brand/10 selection:text-brand overflow-x-hidden">
    <div class="min-h-screen lg:grid lg:grid-cols-[280px_1fr] w-full max-w-full overflow-x-hidden">
        <!-- Mobile Top Navigation Header -->
        <header class="lg:hidden flex items-center justify-between bg-white border-b border-slate-200 px-5 py-4 sticky top-0 z-40 shadow-xs">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-brand flex items-center justify-center text-white shadow-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-sm font-black text-slate-900 font-display">Mama Anis Group</h1>
                    <p class="text-[10px] font-bold text-brand uppercase tracking-wider">Admin Panel</p>
                </div>
            </div>

            <button 
                id="mobile-nav-toggle"
                onclick="document.getElementById('mobile-sidebar').classList.toggle('hidden')"
                class="p-2 rounded-xl text-slate-600 hover:bg-slate-100 hover:text-slate-900 focus:outline-none"
                aria-label="Buka Menu"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </header>

        <!-- Sidebar Navigation (Desktop + Mobile Drawer) -->
        <aside 
            id="mobile-sidebar"
            class="hidden lg:flex flex-col border-b border-slate-200 bg-white px-6 py-7 lg:min-h-screen lg:border-b-0 lg:border-r z-30 fixed lg:static inset-x-0 top-[65px] bottom-0 overflow-y-auto lg:overflow-visible"
        >
            <!-- Brand header -->
            <div class="hidden lg:block">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-xl bg-brand group-hover:bg-brandHover text-white flex items-center justify-center shadow-md shadow-brand/20 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-lg font-black text-slate-900 tracking-tight font-display">Mama Anis</span>
                        <p class="text-[10px] font-bold text-brand uppercase tracking-wider">Admin Workspace</p>
                    </div>
                </a>
            </div>

            <!-- Navigation Links -->
            <nav class="mt-6 lg:mt-10 flex flex-col gap-1.5">
                <a 
                    href="{{ route('admin.dashboard') }}" 
                    class="flex items-center gap-3 rounded-xl px-4 py-3 font-bold text-xs transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-brand text-white shadow-md shadow-brand/20' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Dashboard Utama</span>
                </a>

                <a 
                    href="{{ route('admin.rooms.index') }}" 
                    class="flex items-center gap-3 rounded-xl px-4 py-3 font-bold text-xs transition-colors {{ request()->routeIs('admin.rooms.*') ? 'bg-brand text-white shadow-md shadow-brand/20' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <span>Kelola Kamar</span>
                </a>

                <a 
                    href="{{ route('admin.analytics') }}" 
                    class="flex items-center gap-3 rounded-xl px-4 py-3 font-bold text-xs transition-colors {{ request()->routeIs('admin.analytics') ? 'bg-brand text-white shadow-md shadow-brand/20' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <span>Analitik & Laporan</span>
                </a>

                <a 
                    href="{{ route('admin.settings') }}" 
                    class="flex items-center gap-3 rounded-xl px-4 py-3 font-bold text-xs transition-colors {{ request()->routeIs('admin.settings') ? 'bg-brand text-white shadow-md shadow-brand/20' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span>Pengaturan</span>
                </a>
            </nav>

            <!-- Bottom: Public Link, Profile card & Logout -->
            <div class="mt-auto flex flex-col gap-3 pt-6 border-t border-slate-100">
                <a 
                    href="/" 
                    target="_blank" 
                    class="flex items-center justify-between rounded-xl bg-slate-50 hover:bg-emerald-50 px-4 py-2.5 text-xs font-bold text-slate-600 hover:text-brand transition-colors"
                >
                    <span class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        <span>Lihat Website Publik</span>
                    </span>
                    <span class="text-[10px] text-slate-400">↗</span>
                </a>

                <!-- Profile info card -->
                <div class="rounded-xl border border-slate-100 bg-white p-3 shadow-2xs">
                    <div class="flex items-center gap-3">
                        <div class="relative w-9 h-9 rounded-xl bg-brand/10 text-brand flex items-center justify-center font-bold text-xs shrink-0">
                            <svg class="w-5 h-5 text-brand" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span class="absolute bottom-0 right-0 w-2.5 h-2.5 rounded-full bg-emerald-500 ring-2 ring-white"></span>
                        </div>
                        <div class="min-w-0 flex-1">
                            <span class="font-extrabold text-slate-900 text-xs truncate block font-display">Pengelola Kos</span>
                            <span class="text-[10px] font-mono font-bold text-brand truncate bg-brand/10 px-1.5 py-0.5 rounded">
                                @<span>{{ config('services.admin.username', 'admin_mamaanis') }}</span>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Logout Form -->
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button 
                        type="submit"
                        class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-left font-bold text-xs text-slate-600 hover:bg-red-50 hover:text-red-600 hover:border-red-200 flex items-center gap-2.5 transition-colors cursor-pointer"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span>Keluar Sesi</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main content area (Strictly prevents outer horizontal scroll) -->
        <div class="min-w-0 w-full max-w-full overflow-y-auto max-h-screen flex flex-col overflow-x-hidden">
            @yield('content')
        </div>
    </div>

    @stack('scripts')

    <!-- Vercel Web Analytics -->
    <script defer src="https://cdn.vercel-insights.com/v1/script.js"></script>
</body>
</html>
