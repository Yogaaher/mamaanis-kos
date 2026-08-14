@props(['currentTab' => 'home'])

@php
    $isHome = request()->routeIs('home') || request()->path() === '/';
@endphp

<nav id="global-navbar" class="{{ $isHome ? 'fixed top-0' : 'sticky top-0' }} w-full z-50 border-b transition-all duration-300 ease-in-out {{ $isHome ? 'bg-transparent border-transparent text-white' : 'bg-white/95 backdrop-blur-md border-gray-100 shadow-xs text-slate-800' }}">
    <!-- Full width container with responsive side paddings -->
    <div class="w-full flex justify-between items-center px-4 sm:px-6 md:px-12 py-3 md:py-4">
        <!-- Brand Logo with green vector house icon -->
        <a
            href="/"
            id="brand-logo-link"
            class="flex items-center gap-2 font-sans text-lg sm:text-xl md:text-2xl font-bold transition-colors duration-300 shrink-0 {{ $isHome ? 'text-white' : 'text-[#006c49]' }}"
        >
            <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-emerald-50 border border-emerald-200/80 text-[#006c49] flex items-center justify-center shrink-0 shadow-xs group hover:scale-105 transition-transform duration-300">
                <svg id="brand-svg" class="w-5 h-5 fill-current text-[#006c49] shrink-0" viewBox="0 0 24 24">
                    <path d="M12 3L2 12h3v8h14v-8h3L12 3zm-1 15v-5h2v5h-2z"/>
                </svg>
            </div>
            <span id="brand-name">Mama Anis Kos</span>
        </a>

        <!-- Desktop Navigation in the Center -->
        <div class="hidden md:flex gap-8 items-center absolute left-1/2 transform -translate-x-1/2">
            <a
                href="/"
                data-tab="home"
                class="nav-link-item font-sans text-sm font-semibold transition-all duration-300 py-1 {{ $currentTab === 'home' ? ($isHome ? 'text-white border-b-2 border-white' : 'text-[#006c49] border-b-2 border-[#006c49]') : ($isHome ? 'text-white/80 hover:text-white' : 'text-gray-500 hover:text-[#006c49]') }}"
            >
                Beranda
            </a>
            <a
                href="/catalog"
                data-tab="catalog"
                class="nav-link-item font-sans text-sm font-semibold transition-all duration-300 py-1 {{ $currentTab === 'catalog' ? 'text-[#006c49] border-b-2 border-[#006c49]' : ($isHome ? 'text-white/80 hover:text-white' : 'text-gray-500 hover:text-[#006c49]') }}"
            >
                Kamar
            </a>
            <a
                href="/about"
                data-tab="about"
                class="nav-link-item font-sans text-sm font-semibold transition-all duration-300 py-1 {{ $currentTab === 'about' ? 'text-[#006c49] border-b-2 border-[#006c49]' : ($isHome ? 'text-white/80 hover:text-white' : 'text-gray-500 hover:text-[#006c49]') }}"
            >
                Tentang Kami
            </a>
        </div>

        <!-- Right Controls -->
        <div class="flex items-center gap-2 sm:gap-4">
            <!-- Hubungi Kami Button (Desktop only on top bar) -->
            <a
                href="https://wa.me/6287782049784"
                target="_blank"
                rel="noopener"
                id="navbar-cta-btn"
                class="hidden md:inline-flex font-sans text-xs font-bold px-6 py-2.5 rounded-full border-2 transition-all duration-300 active:scale-95 cursor-pointer text-center {{ $isHome ? 'border-white text-white hover:bg-white hover:text-[#006c49]' : 'border-[#006c49] text-[#006c49] hover:bg-[#006c49] hover:text-white' }}"
            >
                Hubungi Kami
            </a>

            <!-- Mobile Menu Toggle -->
            <button
                id="mobile-menu-toggle"
                type="button"
                class="md:hidden hover:bg-black/5 p-2 rounded-xl cursor-pointer transition-colors duration-300 {{ $isHome ? 'text-white' : 'text-[#006c49]' }}"
                aria-label="Toggle navigation menu"
            >
                <svg id="menu-icon" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
                <svg id="close-icon" class="w-6 h-6 hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Drawer -->
    <div id="mobile-drawer" class="hidden md:hidden px-4 py-4 flex flex-col gap-2 transition-all duration-300 rounded-b-2xl shadow-2xl border-t {{ $isHome ? 'bg-slate-900/98 border-slate-800 text-white' : 'bg-white border-slate-100 text-slate-800' }}">
        <a
            href="/"
            class="drawer-link-item flex items-center gap-3 py-2.5 px-3.5 rounded-xl font-sans text-xs sm:text-sm font-bold transition-colors {{ $currentTab === 'home' ? ($isHome ? 'bg-white/15 text-white' : 'bg-emerald-50 text-[#006c49]') : ($isHome ? 'text-slate-200 hover:bg-white/10 hover:text-white' : 'text-slate-700 hover:bg-slate-50 hover:text-[#006c49]') }}"
            data-tab="home"
        >
            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            <span>Beranda</span>
        </a>
        <a
            href="/catalog"
            class="drawer-link-item flex items-center gap-3 py-2.5 px-3.5 rounded-xl font-sans text-xs sm:text-sm font-bold transition-colors {{ $currentTab === 'catalog' ? 'bg-emerald-50 text-[#006c49]' : ($isHome ? 'text-slate-200 hover:bg-white/10 hover:text-white' : 'text-slate-700 hover:bg-slate-50 hover:text-[#006c49]') }}"
            data-tab="catalog"
        >
            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
            <span>Kamar</span>
        </a>
        <a
            href="/about"
            class="drawer-link-item flex items-center gap-3 py-2.5 px-3.5 rounded-xl font-sans text-xs sm:text-sm font-bold transition-colors {{ $currentTab === 'about' ? 'bg-emerald-50 text-[#006c49]' : ($isHome ? 'text-slate-200 hover:bg-white/10 hover:text-white' : 'text-slate-700 hover:bg-slate-50 hover:text-[#006c49]') }}"
            data-tab="about"
        >
            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>Tentang Kami</span>
        </a>

        <!-- Mobile Drawer CTA Button -->
        <div id="drawer-cta-wrapper" class="pt-2 mt-1 border-t {{ $isHome ? 'border-slate-800' : 'border-slate-100' }}">
            <a
                href="https://wa.me/6287782049784"
                target="_blank"
                rel="noopener"
                id="drawer-cta-btn"
                class="w-full font-sans text-xs font-bold py-2.5 px-4 rounded-xl flex items-center justify-center gap-2 transition-transform active:scale-95 text-white shadow-md cursor-pointer {{ $isHome ? 'bg-emerald-500 hover:bg-emerald-600' : 'bg-[#006c49] hover:bg-[#005236]' }}"
            >
                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.455L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.825 1.451 5.436 0 9.86-4.37 9.864-9.799.002-2.63-1.023-5.101-2.885-6.965C16.528 1.977 14.07 1.951 12.01 1.95c-5.438 0-9.864 4.372-9.868 9.8-.001 1.714.463 3.39 1.341 4.877L2.45 21.11l4.197-1.956z"/>
                </svg>
                <span>Hubungi Kami via WhatsApp</span>
            </a>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.getElementById('mobile-menu-toggle');
        const mobileDrawer = document.getElementById('mobile-drawer');
        const menuIcon = document.getElementById('menu-icon');
        const closeIcon = document.getElementById('close-icon');
        const navbar = document.getElementById('global-navbar');
        const brandLogoLink = document.getElementById('brand-logo-link');
        const brandSvg = document.getElementById('brand-svg');
        const ctaButton = document.getElementById('navbar-cta-btn');
        const toggleBtnIcon = document.getElementById('mobile-menu-toggle');
        const navLinks = document.querySelectorAll('.nav-link-item');
        const drawerLinks = document.querySelectorAll('.drawer-link-item');
        const drawerCtaBtn = document.getElementById('drawer-cta-btn');
        const drawerCtaWrapper = document.getElementById('drawer-cta-wrapper');
        const currentTab = '{{ $currentTab }}';
        
        const isHome = {{ $isHome ? 'true' : 'false' }};

        function updateDrawerTheme(isDark) {
            if (!mobileDrawer) return;
            if (isDark) {
                mobileDrawer.className = 'md:hidden px-4 py-4 flex flex-col gap-2 transition-all duration-300 rounded-b-2xl shadow-2xl border-t bg-slate-900/98 border-slate-800 text-white';
                drawerLinks.forEach(link => {
                    const tab = link.getAttribute('data-tab');
                    if (tab === currentTab) {
                        link.className = 'drawer-link-item flex items-center gap-3 py-2.5 px-3.5 rounded-xl font-sans text-xs sm:text-sm font-bold transition-colors bg-white/15 text-white';
                    } else {
                        link.className = 'drawer-link-item flex items-center gap-3 py-2.5 px-3.5 rounded-xl font-sans text-xs sm:text-sm font-bold transition-colors text-slate-200 hover:bg-white/10 hover:text-white';
                    }
                });
                if (drawerCtaWrapper) drawerCtaWrapper.className = 'pt-2 mt-1 border-t border-slate-800';
                if (drawerCtaBtn) drawerCtaBtn.className = 'w-full font-sans text-xs font-bold py-2.5 px-4 rounded-xl flex items-center justify-center gap-2 transition-transform active:scale-95 text-white shadow-md bg-emerald-500 hover:bg-emerald-600 cursor-pointer';
            } else {
                mobileDrawer.className = 'md:hidden px-4 py-4 flex flex-col gap-2 transition-all duration-300 rounded-b-2xl shadow-2xl border-t bg-white border-slate-100 text-slate-800';
                drawerLinks.forEach(link => {
                    const tab = link.getAttribute('data-tab');
                    if (tab === currentTab) {
                        link.className = 'drawer-link-item flex items-center gap-3 py-2.5 px-3.5 rounded-xl font-sans text-xs sm:text-sm font-bold transition-colors bg-emerald-50 text-[#006c49]';
                    } else {
                        link.className = 'drawer-link-item flex items-center gap-3 py-2.5 px-3.5 rounded-xl font-sans text-xs sm:text-sm font-bold transition-colors text-slate-700 hover:bg-slate-50 hover:text-[#006c49]';
                    }
                });
                if (drawerCtaWrapper) drawerCtaWrapper.className = 'pt-2 mt-1 border-t border-slate-100';
                if (drawerCtaBtn) drawerCtaBtn.className = 'w-full font-sans text-xs font-bold py-2.5 px-4 rounded-xl flex items-center justify-center gap-2 transition-transform active:scale-95 text-white shadow-md bg-[#006c49] hover:bg-[#005236] cursor-pointer';
            }
        }

        if (toggleBtn && mobileDrawer && navbar) {
            toggleBtn.addEventListener('click', function () {
                const isCurrentlyOpen = !mobileDrawer.classList.contains('hidden');
                if (isCurrentlyOpen) {
                    mobileDrawer.classList.add('hidden');
                    menuIcon.classList.remove('hidden');
                    closeIcon.classList.add('hidden');
                    
                    if (isHome) {
                        const heroHeight = window.innerHeight - 80;
                        if (window.scrollY <= heroHeight) {
                            navbar.className = 'fixed top-0 w-full z-50 border-b transition-all duration-300 ease-in-out bg-transparent border-transparent text-white';
                            brandLogoLink.className = 'flex items-center gap-2 font-sans text-lg sm:text-xl md:text-2xl font-bold transition-colors duration-300 shrink-0 text-white';
                            if (brandSvg) brandSvg.className = 'w-5 h-5 fill-current text-[#006c49] shrink-0';
                            toggleBtnIcon.className = 'md:hidden hover:bg-black/5 p-2 rounded-xl cursor-pointer transition-colors duration-300 text-white';
                        }
                    }
                } else {
                    mobileDrawer.classList.remove('hidden');
                    menuIcon.classList.add('hidden');
                    closeIcon.classList.remove('hidden');
                    
                    if (isHome) {
                        const heroHeight = window.innerHeight - 80;
                        if (window.scrollY <= heroHeight) {
                            // In Hero: Use Dark theme
                            navbar.className = 'fixed top-0 w-full z-50 border-b transition-all duration-300 ease-in-out bg-slate-900/98 backdrop-blur-2xl border-slate-800 text-white';
                            brandLogoLink.className = 'flex items-center gap-2 font-sans text-lg sm:text-xl md:text-2xl font-bold transition-colors duration-300 shrink-0 text-white';
                            if (brandSvg) brandSvg.className = 'w-5 h-5 fill-current text-[#006c49] shrink-0';
                            toggleBtnIcon.className = 'md:hidden hover:bg-white/10 p-2 rounded-xl cursor-pointer transition-colors duration-300 text-white';
                            updateDrawerTheme(true);
                        } else {
                            // Below Hero: Use White theme
                            navbar.className = 'fixed top-0 w-full z-50 border-b transition-all duration-300 ease-in-out bg-white/95 backdrop-blur-md border-gray-100 shadow-xs text-slate-800';
                            brandLogoLink.className = 'flex items-center gap-2 font-sans text-lg sm:text-xl md:text-2xl font-bold transition-colors duration-300 shrink-0 text-[#006c49]';
                            if (brandSvg) brandSvg.className = 'w-5 h-5 fill-current text-[#006c49] shrink-0';
                            toggleBtnIcon.className = 'md:hidden hover:bg-black/5 p-2 rounded-xl cursor-pointer transition-colors duration-300 text-[#006c49]';
                            updateDrawerTheme(false);
                        }
                    } else {
                        // Non-home pages: Always White theme
                        updateDrawerTheme(false);
                    }
                }
            });
        }

        if (isHome && navbar) {
            function handleScroll() {
                const heroHeight = window.innerHeight - 80;
                const isDrawerOpen = mobileDrawer && !mobileDrawer.classList.contains('hidden');

                if (window.scrollY > heroHeight) {
                    // Below Hero (Scrolled Down)
                    navbar.className = 'fixed top-0 w-full z-50 border-b transition-all duration-300 ease-in-out bg-white/95 backdrop-blur-md border-gray-100 shadow-xs text-slate-800';
                    brandLogoLink.className = 'flex items-center gap-2 font-sans text-lg sm:text-xl md:text-2xl font-bold transition-colors duration-300 shrink-0 text-[#006c49]';
                    if (brandSvg) brandSvg.className = 'w-5 h-5 fill-current text-[#006c49] shrink-0';
                    if (toggleBtnIcon) {
                        toggleBtnIcon.className = 'md:hidden hover:bg-black/5 p-2 rounded-xl cursor-pointer transition-colors duration-300 text-[#006c49]';
                    }
                    navLinks.forEach(link => {
                        const tab = link.getAttribute('data-tab');
                        if (tab === currentTab) {
                            link.className = 'nav-link-item font-sans text-sm font-semibold transition-all duration-300 py-1 text-[#006c49] border-b-2 border-[#006c49]';
                        } else {
                            link.className = 'nav-link-item font-sans text-sm font-semibold transition-all duration-300 py-1 text-gray-500 hover:text-[#006c49]';
                        }
                    });
                    if (ctaButton) {
                        ctaButton.className = 'hidden md:inline-flex font-sans text-xs font-bold px-6 py-2.5 rounded-full border-2 transition-all duration-300 active:scale-95 cursor-pointer text-center border-[#006c49] text-[#006c49] hover:bg-[#006c49] hover:text-white';
                    }
                    if (isDrawerOpen) {
                        updateDrawerTheme(false);
                    }
                } else {
                    // In Hero
                    if (isDrawerOpen) {
                        navbar.className = 'fixed top-0 w-full z-50 border-b transition-all duration-300 ease-in-out bg-slate-900/98 backdrop-blur-2xl border-slate-800 text-white';
                        brandLogoLink.className = 'flex items-center gap-2 font-sans text-lg sm:text-xl md:text-2xl font-bold transition-colors duration-300 shrink-0 text-white';
                        if (brandSvg) brandSvg.className = 'w-5 h-5 fill-current text-[#006c49] shrink-0';
                        if (toggleBtnIcon) {
                            toggleBtnIcon.className = 'md:hidden hover:bg-white/10 p-2 rounded-xl cursor-pointer transition-colors duration-300 text-white';
                        }
                        updateDrawerTheme(true);
                    } else {
                        navbar.className = 'fixed top-0 w-full z-50 border-b transition-all duration-300 ease-in-out bg-transparent border-transparent text-white';
                        brandLogoLink.className = 'flex items-center gap-2 font-sans text-lg sm:text-xl md:text-2xl font-bold transition-colors duration-300 shrink-0 text-white';
                        if (brandSvg) brandSvg.className = 'w-5 h-5 fill-current text-[#006c49] shrink-0';
                        if (toggleBtnIcon) {
                            toggleBtnIcon.className = 'md:hidden hover:bg-black/5 p-2 rounded-xl cursor-pointer transition-colors duration-300 text-white';
                        }
                    }
                    navLinks.forEach(link => {
                        const tab = link.getAttribute('data-tab');
                        if (tab === currentTab) {
                            link.className = 'nav-link-item font-sans text-sm font-semibold transition-all duration-300 py-1 text-white border-b-2 border-white';
                        } else {
                            link.className = 'nav-link-item font-sans text-sm font-semibold transition-all duration-300 py-1 text-white/80 hover:text-white';
                        }
                    });
                    if (ctaButton) {
                        ctaButton.className = 'hidden md:inline-flex font-sans text-xs font-bold px-6 py-2.5 rounded-full border-2 transition-all duration-300 active:scale-95 cursor-pointer text-center border-white text-white hover:bg-white hover:text-[#006c49]';
                    }
                }
            }

            handleScroll();
            window.addEventListener('scroll', handleScroll, { passive: true });
        }
    });
</script>
