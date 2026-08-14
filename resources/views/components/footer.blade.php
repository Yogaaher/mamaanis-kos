<footer class="bg-gray-50 border-t border-gray-100 mt-auto transition-colors font-sans">
    <!-- Top Security Assurance Row -->
    <div class="border-b border-gray-200/60 bg-emerald-50/50 py-3 sm:py-4 px-4 md:px-8">
        <div class="max-w-[1440px] mx-auto flex flex-col sm:flex-row items-center justify-between gap-2.5 text-xs text-center sm:text-left">
            <div class="flex flex-col sm:flex-row items-center gap-2 sm:gap-2.5 text-gray-700">
                <span class="w-5 h-5 sm:w-6 sm:h-6 rounded-full bg-emerald-100 text-[#006c49] flex items-center justify-center shrink-0">
                    <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </span>
                <p class="leading-relaxed text-[11px] sm:text-xs">
                    <strong>Pusat Keamanan:</strong> Rekening Pembayaran Resmi hanya <strong>Bank Mandiri a.n. MARLIYAH</strong> & WA <strong>0877-8204-9784</strong>.
                </p>
            </div>

            <button 
                type="button" 
                onclick="openSecurityModal()" 
                class="text-[11px] font-bold text-[#006c49] hover:text-[#005236] underline cursor-pointer shrink-0"
            >
                Baca Panduan Anti-Penipuan →
            </button>
        </div>
    </div>

    <div class="max-w-[1440px] mx-auto px-4 md:px-8 py-6 sm:py-8 flex flex-col md:flex-row justify-between items-center gap-5 sm:gap-6 text-center md:text-left">
        <!-- Left column: Brand -->
        <div class="flex flex-col items-center md:items-start gap-1">
            <div class="font-sans text-base sm:text-lg font-bold text-[#006c49] flex items-center gap-2">
                <span>Mama Anis Kos</span>
            </div>
            <p class="font-sans text-xs text-gray-500 max-w-sm">
                Hunian kost eksklusif, aman, dan nyaman di kawasan Alam Sutera, Tangerang.
            </p>
            <p class="font-sans text-[10px] sm:text-[11px] text-gray-400 mt-0.5">
                &copy; 2026 Mama Anis Kos. All rights reserved.
            </p>
        </div>

        <!-- Center: Back to Top -->
        <div class="flex items-center">
            <button
                id="back-to-top-btn"
                type="button"
                class="flex items-center gap-1.5 text-xs sm:text-sm font-semibold text-gray-500 hover:text-[#006c49] transition-colors cursor-pointer active:scale-95 py-1 px-3 rounded-full hover:bg-gray-100"
                title="Kembali ke atas"
            >
                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5"></path>
                </svg>
                <span>Back to Top</span>
            </button>
        </div>

        <!-- Right: Navigation Links -->
        <div class="flex flex-wrap justify-center gap-4 sm:gap-6 text-xs sm:text-sm text-gray-500 font-sans font-medium">
            <a href="/" class="hover:text-[#006c49] transition-colors cursor-pointer">Beranda</a>
            <a href="/catalog" class="hover:text-[#006c49] transition-colors cursor-pointer">Kamar</a>
            <a href="/about" class="hover:text-[#006c49] transition-colors cursor-pointer">Tentang Kami</a>
            <button type="button" onclick="openSecurityModal()" class="text-amber-700 font-bold hover:underline cursor-pointer">Anti-Penipuan</button>
        </div>
    </div>
</footer>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const backToTopBtn = document.getElementById('back-to-top-btn');
        if (backToTopBtn) {
            backToTopBtn.addEventListener('click', function() {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }
    });
</script>
