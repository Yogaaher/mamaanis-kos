@php
    $isHome = request()->routeIs('home') || request()->path() === '/';
@endphp

<!-- Top Announcement Bar (Sleek single-line bar on mobile, hidden on Home Hero) -->
<div id="top-security-bar" class="bg-gradient-to-r from-amber-600 via-amber-700 to-amber-800 text-white text-[11px] font-semibold py-1.5 px-3 sm:px-4 shadow-xs relative z-50 transition-all duration-300 {{ $isHome ? 'hidden' : '' }}">
    <div class="max-w-7xl mx-auto flex items-center justify-between gap-2">
        <div class="flex items-center gap-1.5 truncate">
            <span class="inline-flex items-center justify-center w-4 h-4 rounded-full bg-white/20 text-white shrink-0">
                <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </span>
            <p class="leading-tight truncate text-[10px] sm:text-xs">
                <span class="font-extrabold uppercase bg-white text-amber-900 px-1 py-0.2 rounded text-[9px] mr-1">RESMI</span>
                Bayar sah hanya ke <strong>Bank Mandiri a.n. MARLIYAH</strong> (WA: <strong>0877-8204-9784</strong>)
            </p>
        </div>

        <button 
            type="button" 
            onclick="openSecurityModal()" 
            class="text-[10px] sm:text-[11px] font-bold bg-white/20 hover:bg-white text-white hover:text-amber-900 border border-white/30 px-2.5 py-0.5 rounded-full transition-all shrink-0 cursor-pointer active:scale-95 flex items-center gap-1"
        >
            <span>Verifikasi</span>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
        </button>
    </div>
</div>

<style>
    @keyframes modalPulseGlow {
        0%, 100% { transform: scale(1) translate(0, 0); opacity: 0.4; }
        50% { transform: scale(1.18) translate(12px, -12px); opacity: 0.7; }
    }
    @keyframes modalFloatOrb {
        0%, 100% { transform: translate(0, 0) scale(1); }
        50% { transform: translate(-18px, 18px) scale(1.12); }
    }
    @keyframes modalShimmer {
        0% { transform: translateX(-100%) skewX(-15deg); }
        100% { transform: translateX(200%) skewX(-15deg); }
    }
    .animate-modal-pulse {
        animation: modalPulseGlow 7s ease-in-out infinite;
    }
    .animate-modal-orb {
        animation: modalFloatOrb 9s ease-in-out infinite;
    }
    .animate-modal-shimmer {
        animation: modalShimmer 3.5s infinite;
    }
</style>

<!-- 1. Modal Rekomendasi Pengalaman Desktop / PC (First Visit Step 1) -->
<div 
    id="desktopExperienceModal" 
    class="fixed inset-0 bg-slate-950/80 backdrop-blur-md z-[110] flex items-center justify-center p-4 transition-all duration-300 opacity-0 pointer-events-none"
    role="dialog"
    aria-modal="true"
    aria-labelledby="desktopModalTitle"
>
    <div class="relative bg-white/95 backdrop-blur-xl rounded-3xl border border-emerald-100/80 shadow-2xl max-w-md w-full p-6 sm:p-7 flex flex-col gap-5 transform transition-all duration-300 scale-95 max-h-[92vh] overflow-hidden group">
        <!-- Dynamic Background Animated Orbs & Glow -->
        <div class="absolute -top-20 -left-20 w-52 h-52 bg-emerald-200/50 rounded-full blur-3xl pointer-events-none animate-modal-pulse"></div>
        <div class="absolute -bottom-20 -right-20 w-56 h-56 bg-teal-200/40 rounded-full blur-3xl pointer-events-none animate-modal-orb"></div>
        <div class="absolute top-1/3 right-1/4 w-36 h-36 bg-emerald-100/40 rounded-full blur-2xl pointer-events-none animate-pulse"></div>

        <!-- Header -->
        <div class="relative z-10 flex items-start justify-between border-b border-gray-100 pb-4">
            <div class="flex items-center gap-3.5">
                <div class="relative w-11 h-11 sm:w-12 sm:h-12 rounded-2xl bg-gradient-to-br from-emerald-50 to-emerald-100 border border-emerald-200 text-[#006c49] flex items-center justify-center shrink-0 shadow-sm group-hover:scale-105 transition-transform duration-300">
                    <div class="absolute inset-0 rounded-2xl bg-emerald-400/20 animate-ping opacity-25"></div>
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 relative z-10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <span class="text-[9px] sm:text-[10px] font-black uppercase tracking-wider text-emerald-800 bg-emerald-100/80 border border-emerald-200/50 px-2 py-0.5 rounded-md">Tips Eksplorasi</span>
                    <h2 id="desktopModalTitle" class="text-base sm:text-lg font-black text-gray-900 font-display mt-0.5">Pengalaman Terbaik di PC / Laptop</h2>
                </div>
            </div>

            <button 
                type="button" 
                onclick="proceedFromDesktopToSecurityModal()" 
                class="text-gray-400 hover:text-gray-700 p-2 rounded-xl hover:bg-gray-100/80 transition-all hover:rotate-90 duration-300"
                aria-label="Tutup Rekomendasi"
            >
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Narrative -->
        <p class="relative z-10 text-xs sm:text-sm text-gray-600 leading-relaxed font-sans">
            Website <strong>Mama Anis Kos</strong> dilengkapi tampilan visual katalog interaktif dan foto detail resolusi tinggi. Untuk pengalaman menjelajah dan membandingkan kamar yang paling optimal, kami menyarankan membukanya melalui layar <strong>PC / Laptop</strong>.
        </p>

        <!-- Action Button -->
        <div class="relative z-10 pt-1">
            <button 
                type="button" 
                onclick="proceedFromDesktopToSecurityModal()" 
                class="group/btn relative w-full overflow-hidden bg-gradient-to-r from-[#006c49] to-[#00875a] hover:from-[#005236] hover:to-[#006c49] text-white py-3.5 sm:py-4 rounded-2xl font-bold text-xs shadow-lg shadow-[#006c49]/25 hover:shadow-[#006c49]/40 hover:-translate-y-0.5 active:translate-y-0 active:scale-[0.98] transition-all duration-200 cursor-pointer flex items-center justify-center gap-2"
            >
                <div class="absolute inset-0 w-1/2 h-full bg-white/20 animate-modal-shimmer pointer-events-none"></div>
                <span>Lanjutkan ke Informasi Keamanan</span>
                <svg class="w-4 h-4 group-hover/btn:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </button>
        </div>
    </div>
</div>

<!-- 2. Modal Pusat Keamanan & Anti-Penipuan (Step 2) -->
<div 
    id="securityAdvisoryModal" 
    class="fixed inset-0 bg-slate-950/80 backdrop-blur-md z-[120] flex items-center justify-center p-4 transition-all duration-300 opacity-0 pointer-events-none"
    role="dialog"
    aria-modal="true"
    aria-labelledby="securityModalTitle"
>
    <div class="relative bg-white/95 backdrop-blur-xl rounded-3xl border border-amber-100/80 shadow-2xl max-w-lg w-full p-5 sm:p-8 flex flex-col gap-4 sm:gap-6 transform transition-all duration-300 scale-95 max-h-[90vh] overflow-y-auto overflow-x-hidden group">
        <!-- Dynamic Background Animated Orbs & Glow -->
        <div class="absolute -top-24 -left-24 w-60 h-60 bg-amber-200/40 rounded-full blur-3xl pointer-events-none animate-modal-pulse"></div>
        <div class="absolute -bottom-24 -right-24 w-64 h-64 bg-orange-200/30 rounded-full blur-3xl pointer-events-none animate-modal-orb"></div>

        <!-- Header with Shield Badge -->
        <div class="relative z-10 flex items-start justify-between border-b border-gray-100 pb-3 sm:pb-4">
            <div class="flex items-center gap-3 sm:gap-3.5">
                <div class="relative w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-gradient-to-br from-amber-50 to-amber-100 border border-amber-200 text-amber-600 flex items-center justify-center shrink-0 shadow-sm group-hover:scale-105 transition-transform duration-300">
                    <div class="absolute inset-0 rounded-2xl bg-amber-400/20 animate-ping opacity-25"></div>
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 relative z-10" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <div>
                    <span class="text-[9px] sm:text-[10px] font-black uppercase tracking-wider text-amber-700 bg-amber-100/80 border border-amber-200/50 px-2 py-0.5 rounded-md">Himbauan Resmi Pengelola</span>
                    <h2 id="securityModalTitle" class="text-base sm:text-xl font-black text-gray-900 font-display mt-0.5">Waspada Penipuan Sewa Kos</h2>
                </div>
            </div>

            <button 
                type="button" 
                onclick="closeSecurityModal()" 
                class="text-gray-400 hover:text-gray-700 p-2 rounded-xl hover:bg-gray-100/80 transition-all hover:rotate-90 duration-300"
                aria-label="Tutup Himbauan"
            >
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Warning Narrative -->
        <p class="relative z-10 text-[11px] sm:text-xs text-gray-600 leading-relaxed font-sans">
            Sehubungan dengan maraknya aksi penipuan yang mengatasnamakan sewa kost, manajemen <strong>Mama Anis Kos</strong> mengimbau seluruh calon penyewa untuk selalu memverifikasi informasi sebelum melakukan pembayaran.
        </p>

        <!-- 3 Pillars of Safety Guidelines -->
        <div class="relative z-10 space-y-2.5 sm:space-y-3 font-sans text-xs">
            <!-- Point 1: Official WhatsApp Contact -->
            <div class="flex items-start gap-2.5 sm:gap-3 p-2.5 sm:p-3.5 rounded-2xl bg-emerald-50/70 border border-emerald-100 hover:border-emerald-300 hover:bg-emerald-50 transition-all duration-200">
                <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-xl bg-emerald-100 text-[#006c49] flex items-center justify-center shrink-0 mt-0.5">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                </div>
                <div>
                    <b class="text-gray-900 block font-bold text-[11px] sm:text-xs">1. Kontak Resmi Pengelola Kos</b>
                    <p class="text-gray-600 text-[10px] sm:text-[11px] mt-0.5">
                        Hanya hubungi nomor WhatsApp resmi: <a href="https://wa.me/6287782049784" target="_blank" class="font-bold text-[#006c49] hover:underline font-mono">0877-8204-9784</a>. Kami tidak menggunakan nomor kontak lainnya.
                    </p>
                </div>
            </div>

            <!-- Point 2: Official Bank Mandiri Account -->
            <div class="flex items-start gap-2.5 sm:gap-3 p-2.5 sm:p-3.5 rounded-2xl bg-amber-50/70 border border-amber-200 hover:border-amber-300 hover:bg-amber-50 transition-all duration-200">
                <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center shrink-0 mt-0.5">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <b class="text-gray-900 block font-bold text-[11px] sm:text-xs">2. Rekening Resmi Pembayaran Sah</b>
                    <p class="text-gray-600 text-[10px] sm:text-[11px] mt-0.5">
                        Seluruh transaksi uang muka (DP) maupun pelunasan sewa <strong>HANYA</strong> ditransfer ke:
                    </p>
                    <div class="mt-2 p-2 sm:p-2.5 bg-white border border-amber-200 rounded-xl flex items-center justify-between gap-2 shadow-xs">
                        <div>
                            <span class="text-[9px] sm:text-[10px] text-gray-400 font-bold block uppercase">Bank Mandiri</span>
                            <span class="font-mono font-black text-gray-900 text-[11px] sm:text-xs">a.n. MARLIYAH</span>
                        </div>
                        <button 
                            type="button" 
                            id="btnCopyRekening"
                            onclick="copyMandiriAccount()" 
                            class="px-2.5 py-1 bg-amber-100 hover:bg-amber-200 text-amber-900 font-bold text-[9px] sm:text-[10px] rounded-lg transition-all active:scale-95 cursor-pointer"
                        >
                            Salin Info
                        </button>
                    </div>
                </div>
            </div>

            <!-- Point 3: Liability Statement -->
            <div class="flex items-start gap-2.5 sm:gap-3 p-2.5 sm:p-3.5 rounded-2xl bg-red-50/70 border border-red-200 hover:border-red-300 hover:bg-red-50 transition-all duration-200">
                <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-xl bg-red-100 text-red-700 flex items-center justify-center shrink-0 mt-0.5">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <b class="text-red-900 block font-bold text-[11px] sm:text-xs">3. Batasan Tanggung Jawab</b>
                    <p class="text-red-700 text-[10px] sm:text-[11px] mt-0.5 leading-relaxed">
                        Segala bentuk pembayaran atau transaksi yang dilakukan di luar rekening <strong>Bank Mandiri a.n. MARLIYAH</strong> dan kontak resmi tersebut adalah <strong>di luar tanggung jawab Mama Anis Kos</strong>.
                    </p>
                </div>
            </div>
        </div>

        <!-- Action Button -->
        <div class="relative z-10 pt-1">
            <button 
                type="button" 
                onclick="closeSecurityModal()" 
                class="group/btn relative w-full overflow-hidden bg-gradient-to-r from-[#006c49] to-[#00875a] hover:from-[#005236] hover:to-[#006c49] text-white py-3.5 sm:py-4 rounded-2xl font-bold text-xs shadow-lg shadow-[#006c49]/25 hover:shadow-[#006c49]/40 hover:-translate-y-0.5 active:translate-y-0 active:scale-[0.98] transition-all duration-200 cursor-pointer flex items-center justify-center gap-2"
            >
                <div class="absolute inset-0 w-1/2 h-full bg-white/20 animate-modal-shimmer pointer-events-none"></div>
                <svg class="w-4 h-4 group-hover/btn:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                <span>Saya Mengerti & Mulai Eksplorasi</span>
            </button>
        </div>
    </div>
</div>

<script>
    function openDesktopModal() {
        const modal = document.getElementById('desktopExperienceModal');
        if (modal) {
            modal.classList.remove('opacity-0', 'pointer-events-none');
            modal.classList.add('opacity-100', 'pointer-events-auto');
            const card = modal.querySelector('div');
            if (card) card.classList.remove('scale-95');
        }
    }

    function closeDesktopModal() {
        const modal = document.getElementById('desktopExperienceModal');
        if (modal) {
            modal.classList.remove('opacity-100', 'pointer-events-auto');
            modal.classList.add('opacity-0', 'pointer-events-none');
            const card = modal.querySelector('div');
            if (card) card.classList.add('scale-95');
        }
        try {
            sessionStorage.setItem('mama_anis_desktop_advisory_seen', 'true');
        } catch (e) {}
    }

    function proceedFromDesktopToSecurityModal() {
        closeDesktopModal();
        setTimeout(() => {
            openSecurityModal();
        }, 280);
    }

    function openSecurityModal() {
        const modal = document.getElementById('securityAdvisoryModal');
        if (modal) {
            modal.classList.remove('opacity-0', 'pointer-events-none');
            modal.classList.add('opacity-100', 'pointer-events-auto');
            const card = modal.querySelector('div');
            if (card) card.classList.remove('scale-95');
        }
    }

    function closeSecurityModal() {
        const modal = document.getElementById('securityAdvisoryModal');
        if (modal) {
            modal.classList.remove('opacity-100', 'pointer-events-auto');
            modal.classList.add('opacity-0', 'pointer-events-none');
            const card = modal.querySelector('div');
            if (card) card.classList.add('scale-95');
        }
        try {
            sessionStorage.setItem('mama_anis_security_seen', 'true');
        } catch (e) {}
    }

    function copyMandiriAccount() {
        const text = "Bank Mandiri a.n. MARLIYAH (Mama Anis Kos)";
        if (navigator.clipboard) {
            navigator.clipboard.writeText(text).then(() => {
                const btn = document.getElementById('btnCopyRekening');
                if (btn) {
                    btn.textContent = '✓ Tersalin!';
                    setTimeout(() => { btn.textContent = 'Salin Info'; }, 2000);
                }
            });
        }
    }

    // Sequence on first visit: Desktop Advisory Modal -> Anti-Fraud Security Modal
    document.addEventListener('DOMContentLoaded', function() {
        try {
            const hasSeenDesktop = sessionStorage.getItem('mama_anis_desktop_advisory_seen');
            const hasSeenSecurity = sessionStorage.getItem('mama_anis_security_seen');
            
            if (!hasSeenDesktop && !hasSeenSecurity) {
                setTimeout(() => {
                    openDesktopModal();
                }, 600);
            } else if (!hasSeenSecurity) {
                setTimeout(() => {
                    openSecurityModal();
                }, 600);
            }
        } catch (e) {}

        // Scroll listener for Home page: hide top bar during Hero, show when scrolled past Hero
        const isHomePage = {{ $isHome ? 'true' : 'false' }};
        if (isHomePage) {
            const topBar = document.getElementById('top-security-bar');
            if (topBar) {
                function checkScrollForTopBar() {
                    const heroHeight = window.innerHeight - 100;
                    if (window.scrollY > heroHeight) {
                        topBar.classList.remove('hidden');
                    } else {
                        topBar.classList.add('hidden');
                    }
                }
                checkScrollForTopBar();
                window.addEventListener('scroll', checkScrollForTopBar, { passive: true });
            }
        }
    });
</script>
