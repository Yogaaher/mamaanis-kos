// JavaScript Khusus untuk Navbar - Mama Anis Group
document.addEventListener('DOMContentLoaded', function () {
    const navbar = document.getElementById('main-navbar');
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');

    // 1. Efek scroll pada Header
    if (navbar) {
        function checkScroll() {
            if (window.scrollY > 20) {
                navbar.classList.add('navbar-scrolled');
                navbar.classList.remove('bg-white/80', 'backdrop-blur-md');
            } else {
                navbar.classList.remove('navbar-scrolled');
                navbar.classList.add('bg-white/80', 'backdrop-blur-md');
            }
        }
        window.addEventListener('scroll', checkScroll);
        checkScroll(); // Jalankan sekali saat startup
    }

    // 2. Toggle Menu Mobile
    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            const isHidden = mobileMenu.classList.contains('hidden');
            if (isHidden) {
                mobileMenu.classList.remove('hidden');
                // Berikan jeda kecil agar transisi CSS berjalan lancar
                setTimeout(() => {
                    mobileMenu.classList.add('mobile-menu-visible');
                    mobileMenu.classList.remove('mobile-menu-hidden');
                }, 10);
            } else {
                mobileMenu.classList.add('mobile-menu-hidden');
                mobileMenu.classList.remove('mobile-menu-visible');
                // Tunggu transisi selesai sebelum menambahkan display: none
                setTimeout(() => {
                    mobileMenu.classList.add('hidden');
                }, 300);
            }
        });

        // Tutup menu mobile jika mengklik di luar area menu
        document.addEventListener('click', function (e) {
            if (!mobileMenu.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
                if (!mobileMenu.classList.contains('hidden')) {
                    mobileMenu.classList.add('mobile-menu-hidden');
                    mobileMenu.classList.remove('mobile-menu-visible');
                    setTimeout(() => {
                        mobileMenu.classList.add('hidden');
                    }, 300);
                }
            }
        });
    }
});
