<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Mama Anis Group - Hunian Modern & Nyaman')</title>

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
