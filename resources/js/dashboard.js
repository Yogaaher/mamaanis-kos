// JavaScript Khusus untuk Admin Dashboard - Mama Anis Group
document.addEventListener('DOMContentLoaded', function () {
    console.log("Admin Dashboard Scripts Loaded");

    const tableSearchInput = document.getElementById('dashboard-table-search');
    const tableRows = document.querySelectorAll('.dashboard-room-row');
    const tabBtns = document.querySelectorAll('.dashboard-tab-btn');
    const tabContents = document.querySelectorAll('.dashboard-tab-content');

    // 1. Pencarian Real-Time / Filter Tabel Kamar Kos
    if (tableSearchInput && tableRows.length > 0) {
        tableSearchInput.addEventListener('input', function () {
            const query = tableSearchInput.value.toLowerCase().trim();
            
            tableRows.forEach(row => {
                const name = row.querySelector('.room-name-cell').textContent.toLowerCase();
                const type = row.querySelector('.room-type-cell').textContent.toLowerCase();
                const loc = row.querySelector('.room-location-cell').textContent.toLowerCase();
                
                if (name.includes(query) || type.includes(query) || loc.includes(query)) {
                    row.classList.remove('hidden');
                } else {
                    row.classList.add('hidden');
                }
            });
        });
    }

    // 2. Navigasi Tab Konten Dashboard
    if (tabBtns.length > 0 && tabContents.length > 0) {
        tabBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                const targetTab = btn.getAttribute('data-tab');

                // Hilangkan status aktif dari semua tombol tab
                tabBtns.forEach(b => {
                    b.classList.remove('border-b-2', 'border-[#006c49]', 'text-[#006c49]', 'font-semibold', 'tab-btn-active');
                    b.classList.add('text-gray-500');
                });

                // Tambahkan status aktif pada tab yang diklik
                btn.classList.add('border-b-2', 'border-[#006c49]', 'text-[#006c49]', 'font-semibold', 'tab-btn-active');
                btn.classList.remove('text-gray-500');

                // Tampilkan konten tab yang dituju, sembunyikan yang lain
                tabContents.forEach(content => {
                    if (content.id === `tab-content-${targetTab}`) {
                        content.classList.remove('hidden');
                    } else {
                        content.classList.add('hidden');
                    }
                });
            });
        });
    }
});
