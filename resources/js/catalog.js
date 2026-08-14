// JavaScript Khusus untuk Halaman Katalog - Mama Anis Group
document.addEventListener('DOMContentLoaded', function () {
    console.log("Catalog Scripts Loaded");

    const searchInput = document.getElementById('catalog-search-input');
    const searchForm = document.getElementById('catalog-search-form');
    const clearFiltersBtn = document.getElementById('clear-filters-btn');

    // 1. Submit otomatis form pencarian jika ada jeda mengetik (Debouncing)
    if (searchInput && searchForm) {
        let debounceTimer;
        searchInput.addEventListener('input', function () {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                // Tambahkan kelas opacity atau spinner pemuatan sementara
                const grid = document.querySelector('.catalog-grid');
                if (grid) {
                    grid.classList.add('opacity-40', 'transition-opacity', 'duration-300');
                }
                searchForm.submit();
            }, 800); // Tunggu 800ms setelah user berhenti mengetik
        });
    }

    // 2. Tombol Reset / Bersihkan Filter
    if (clearFiltersBtn) {
        clearFiltersBtn.addEventListener('click', function (e) {
            e.preventDefault();
            window.location.href = '/catalog'; // Kembalikan ke halaman katalog awal tanpa query strings
        });
    }
});
