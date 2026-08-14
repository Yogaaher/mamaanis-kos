import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/navbar.css',
                'resources/css/footer.css',
                'resources/js/app.js',
                'resources/js/navbar.js'
            ],
            refresh: true,
        }),
    ],
    // TAMBAHKAN BLOK SERVER INI UNTUK DOCKER:
    server: {
        host: '0.0.0.0', // Agar bisa diakses dari luar container
        port: 5173,
        strictPort: true,
        hmr: {
            host: 'localhost', // Browser kamu akan menghubungi host ini untuk Hot Module Replacement
        },
        watch: {
            usePolling: true, // Sangat penting jika memakai Docker di Windows/WSL agar deteksi perubahan file lancar
        }
    },
});