<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Mama Anis Kos - Alam Sutera')</title>
    <meta name="description" content="@yield('meta_description', 'Mama Anis kost hunian nyaman strategis Alam Sutera')">
    <meta name="google-site-verification" content="vqfQ0eyfzyXhNNGaBJ6wBiDNDhBET175d-Lv6op8nyA">

    <!-- Google Analytics 4 -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-Z0J9Y49CGN"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());
        gtag('config', 'G-Z0J9Y49CGN');
    </script>
    
    <!-- Open Graph / Facebook / WhatsApp -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title', 'Mama Anis Kos - Alam Sutera')">
    <meta property="og:description" content="@yield('meta_description', 'Mama Anis kost hunian nyaman strategis Alam Sutera')">
    <meta property="og:image" content="@yield('og_image', asset('icon-512.png'))">
    <meta property="og:url" content="{{ url()->current() }}">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'Mama Anis Kos - Alam Sutera')">
    <meta name="twitter:description" content="@yield('meta_description', 'Mama Anis kost hunian nyaman strategis Alam Sutera')">
    <meta name="twitter:image" content="@yield('og_image', asset('icon-512.png'))">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Schema.org Structured Data (LodgingBusiness / Kost) for Google Rich Results -->
    @php
        $schemaData = [
            '@context' => 'https://schema.org',
            '@type' => 'LodgingBusiness',
            'name' => 'Mama Anis Kos',
            'description' => 'Hunian kost eksklusif, aman, bersih, dan strategis di kawasan Alam Sutera, Pinang, Tangerang dekat BINUS University & Mall Alam Sutera.',
            'url' => url('/'),
            'telephone' => '+62-877-8204-9784',
            'priceRange' => 'Rp 1.800.000 - Rp 5.000.000',
            'image' => asset('icon-512.png'),
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => 'Pinang, Tangerang',
                'addressRegion' => 'Banten',
                'addressCountry' => 'ID',
            ],
            'amenityFeature' => [
                ['@type' => 'LocationFeatureSpecification', 'name' => 'WiFi Cepat 200 Mbps', 'value' => true],
                ['@type' => 'LocationFeatureSpecification', 'name' => 'CCTV 24 Jam', 'value' => true],
                ['@type' => 'LocationFeatureSpecification', 'name' => 'AC Setiap Kamar', 'value' => true],
                ['@type' => 'LocationFeatureSpecification', 'name' => 'Kamar Mandi Dalam', 'value' => true],
            ],
        ];
    @endphp
    <script type="application/ld+json">{!! json_encode($schemaData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
    
    <!-- Favicon & Touch Icons for Browsers & Google Search -->
    <link rel="icon" type="image/png" sizes="48x48" href="{{ asset('favicon-48x48.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <meta name="theme-color" content="#006c49">

    <!-- Google Fonts: Montserrat & Plus Jakarta Sans (Modern, Relaxed, Elegant & Friendly) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,600;1,700&family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,600&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN (Guaranteed to render under any environment without Vite dependency) -->
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
                        sans: ['Plus Jakarta Sans', 'Montserrat', 'sans-serif'],
                        display: ['Montserrat', 'Plus Jakarta Sans', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    },
                    colors: {
                        brand: '#006c49',
                    }
                }
            }
        }
    </script>

    <style>
        /* Global SVG Safety Rules (Prevents raw uncompiled SVG explosion) */
        svg {
            display: inline-block;
            vertical-align: middle;
            max-width: 100%;
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

        body {
            font-family: 'Plus Jakarta Sans', 'Montserrat', sans-serif;
            overflow-x: hidden;
            touch-action: manipulation;
        }
        html {
            overflow-x: hidden;
            scroll-behavior: smooth;
        }
        .font-display {
            font-family: 'Montserrat', sans-serif;
        }
        .font-sans {
            font-family: 'Plus Jakarta Sans', 'Montserrat', sans-serif;
        }
        .font-mono {
            font-family: 'JetBrains Mono', monospace;
        }
        
        /* Mobile Touch & Tap Highlights */
        * {
            -webkit-tap-highlight-color: transparent;
        }
        
        /* App/Global styles */
        .lift {
            transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.25s cubic-bezier(0.4, 0, 0.2, 1), border-color 0.25s ease;
        }
        .lift:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 30px -10px rgba(0, 108, 73, 0.08), 0 8px 16px -8px rgba(0, 108, 73, 0.06);
        }
        
        /* Navbar custom styles */
        .navbar-scrolled {
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
            border-color: rgba(243, 244, 246, 1);
        }
        .nav-link-active {
            color: #006c49 !important;
            font-weight: 700;
        }
        .nav-link-active::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: #006c49;
            border-radius: 9999px;
        }
        #mobile-menu {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .mobile-menu-hidden {
            opacity: 0;
            transform: translateY(-10px);
            pointer-events: none;
        }
        .mobile-menu-visible {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
        }
        
        /* Footer custom styles */
        .footer-link-hover {
            transition: all 0.2s ease-in-out;
        }
        .footer-link-hover:hover {
            color: #10b981;
            transform: translateX(4px);
        }
        .footer-social-btn {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .footer-social-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.2);
        }
        
        /* Catalog custom styles */
        .filter-btn-active {
            background-color: #006c49 !important;
            color: #ffffff !important;
            box-shadow: 0 4px 12px rgba(0, 108, 73, 0.2);
        }
        .search-input-focus:focus {
            border-color: #006c49;
            box-shadow: 0 0 0 3px rgba(0, 108, 73, 0.1);
        }
        .pagination-btn-active {
            background-color: #006c49 !important;
            color: #ffffff !important;
            box-shadow: 0 4px 10px rgba(0, 108, 73, 0.15);
        }
        .catalog-grid {
            display: grid;
            gap: 2rem;
            animation: fadeInGrid 0.5s ease;
        }
        @keyframes fadeInGrid {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Room Detail custom styles */
        .gallery-thumbnail {
            transition: all 0.2s ease;
            cursor: pointer;
        }
        .gallery-thumbnail:hover {
            transform: scale(1.05);
        }
        .gallery-thumbnail-active {
            border-color: #006c49 !important;
            box-shadow: 0 0 0 3px rgba(0, 108, 73, 0.15);
        }
        .amenity-pill-hover {
            transition: all 0.2s ease;
        }
        .amenity-pill-hover:hover {
            background-color: rgba(0, 108, 73, 0.05);
            border-color: rgba(0, 108, 73, 0.2);
        }
        .sticky-booking-widget {
            position: sticky;
            top: 100px;
        }

        /* SPA-style page transition overlay */
        .page-transition-overlay {
            position: fixed;
            inset: 0;
            background-color: #f8f9fb;
            z-index: 9999;
            pointer-events: none;
            opacity: 1;
            transition: opacity 0.3s ease-in-out;
        }
        .page-transition-overlay.fade-out {
            opacity: 0;
        }
    </style>
    @stack('styles')
    @stack('head')
</head>
<body class="min-h-screen bg-[#f8f9fb] flex flex-col selection:bg-[#006c49]/10 selection:text-[#006c49]">

    <!-- Global Security & Anti-Fraud Advisory (Top Banner + First-Visit Pop-Up Modal) -->
    <x-security-advisory-modal />

    <!-- Page transition overlay -->
    <div id="transition-overlay" class="page-transition-overlay"></div>

    <!-- Global Header Navbar Component -->
    <x-navbar :currentTab="$currentTab ?? 'home'" />

    <!-- Main dynamic slot content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Global Footer Component -->
    <x-footer />

    <!-- Floating Quick-Chat WhatsApp Button -->
    <a 
        href="https://wa.me/6287782049784?text=Halo%20Mama%20Anis%20Kos%2C%20saya%20ingin%20bertanya%20mengenai%20ketersediaan%20kamar%20kos.%20Terima%20kasih%21" 
        target="_blank" 
        rel="noopener"
        aria-label="Chat WhatsApp Pengelola Mama Anis Kos"
        class="fixed bottom-5 right-5 sm:bottom-7 sm:right-7 z-40 group flex items-center gap-2.5 bg-[#006c49] hover:bg-[#005236] text-white p-3.5 sm:px-5 sm:py-3.5 rounded-full shadow-2xl shadow-[#006c49]/40 border border-emerald-400/30 hover:scale-105 active:scale-95 transition-all duration-300 cursor-pointer"
    >
        <span class="absolute -top-1 -right-1 flex h-3.5 w-3.5">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-300 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-3.5 w-3.5 bg-emerald-400 border-2 border-white"></span>
        </span>
        <svg class="w-5 h-5 sm:w-5 sm:h-5 fill-current shrink-0" viewBox="0 0 24 24">
            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.455L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.825 1.451 5.436 0 9.86-4.37 9.864-9.799.002-2.63-1.023-5.101-2.885-6.965C16.528 1.977 14.07 1.951 12.01 1.95c-5.438 0-9.864 4.372-9.868 9.8-.001 1.714.463 3.39 1.341 4.877L2.45 21.11l4.197-1.956z"/>
        </svg>
        <span class="hidden sm:inline font-sans font-bold text-xs tracking-wide">Tanya via WA</span>
    </a>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const overlay = document.getElementById('transition-overlay');
            if (overlay) {
                // Fade out overlay on load
                setTimeout(() => {
                    overlay.classList.add('fade-out');
                }, 50);
            }

            // Fade in overlay on local page transitions
            const links = document.querySelectorAll('a[href^="/"]');
            links.forEach(link => {
                const target = link.getAttribute('target');
                const href = link.getAttribute('href');
                if (target === '_blank' || href.startsWith('#') || href.includes(':')) return;

                link.addEventListener('click', function(e) {
                    if (e.button === 0 && !e.ctrlKey && !e.metaKey && !e.shiftKey && !e.altKey) {
                        e.preventDefault();
                        if (overlay) {
                            overlay.classList.remove('fade-out');
                        }
                        setTimeout(() => {
                            window.location.href = href;
                        }, 300); // Matches transition duration
                    }
                });
            });
        });

        // Prevent bfcache lock on back/forward navigation
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                const overlay = document.getElementById('transition-overlay');
                if (overlay) {
                    overlay.classList.add('fade-out');
                }
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
