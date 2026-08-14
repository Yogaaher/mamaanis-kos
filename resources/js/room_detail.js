// JavaScript Khusus untuk Halaman Detail Kamar - Mama Anis Group
document.addEventListener('DOMContentLoaded', function () {
    console.log("Room Detail Scripts Loaded");

    const mainImage = document.getElementById('main-gallery-image');
    const thumbnails = document.querySelectorAll('.gallery-thumbnail');
    const shareBtn = document.getElementById('share-room-btn');
    const durationSelect = document.getElementById('booking-duration-select');
    const bookingTotalDisplay = document.getElementById('booking-total-display');
    const bookingWaLink = document.getElementById('booking-wa-link');

    // 1. Galeri Foto: Tukar gambar utama saat mengklik thumbnail
    if (mainImage && thumbnails.length > 0) {
        thumbnails.forEach(thumb => {
            thumb.addEventListener('click', function () {
                // Hapus kelas aktif dari seluruh thumbnail
                thumbnails.forEach(t => {
                    t.classList.remove('gallery-thumbnail-active', 'border-[#006c49]');
                    t.classList.add('border-transparent');
                });

                // Tambahkan kelas aktif ke thumbnail terpilih
                thumb.classList.add('gallery-thumbnail-active', 'border-[#006c49]');
                thumb.classList.remove('border-transparent');

                // Update sumber gambar utama beserta atribut alt
                const newSrc = thumb.getAttribute('src');
                const newAlt = thumb.getAttribute('alt');
                mainImage.style.opacity = '0.3';
                setTimeout(() => {
                    mainImage.setAttribute('src', newSrc);
                    mainImage.setAttribute('alt', newAlt);
                    mainImage.style.opacity = '1';
                }, 150);
            });
        });
    }

    // 2. Kalkulator Durasi Sewa & Update Pesan WhatsApp
    if (durationSelect && bookingTotalDisplay && bookingWaLink) {
        const basePrice = parseInt(durationSelect.getAttribute('data-price') || '0', 10);
        const roomName = durationSelect.getAttribute('data-room-name') || '';
        const roomLocation = durationSelect.getAttribute('data-room-location') || '';

        function formatRupiah(num) {
            return 'Rp ' + num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function calculateCost() {
            const months = parseInt(durationSelect.value, 10);
            let discount = 0;
            
            // Berikan diskon jika menyewa lebih lama
            if (months >= 12) {
                discount = 0.10; // Diskon 10% untuk sewa 1 tahun
            } else if (months >= 6) {
                discount = 0.05; // Diskon 5% untuk sewa 6 bulan
            }

            const rawTotal = basePrice * months;
            const savings = Math.round(rawTotal * discount);
            const finalTotal = rawTotal - savings;

            // Update Tampilan Total Harga
            bookingTotalDisplay.textContent = formatRupiah(finalTotal);

            // Perbarui URL WhatsApp
            let waMessage = `Halo Admin Mama Anis Kos, saya ingin menyewa kamar berikut:\n\n🏠 *Kamar*: ${roomName}\n📍 *Lokasi*: ${roomLocation}\n⏱️ *Durasi*: ${months} Bulan\n💵 *Estimasi Tarif*: ${formatRupiah(finalTotal)}`;
            if (discount > 0) {
                waMessage += ` (Sudah termasuk diskon sewa jangka panjang)`;
            }
            waMessage += `\n\nApakah masih tersedia untuk dipesan? Terima kasih!`;

            bookingWaLink.setAttribute('href', `https://wa.me/6287782049784?text=${encodeURIComponent(waMessage)}`);
        }

        durationSelect.addEventListener('change', calculateCost);
        calculateCost(); // Jalankan kalkulasi perdana saat render
    }

    // 3. Bagikan Kamar: Copy link ke Clipboard
    if (shareBtn) {
        shareBtn.addEventListener('click', function (e) {
            e.preventDefault();
            const dummyInput = document.createElement('input');
            dummyInput.value = window.location.href;
            document.body.appendChild(dummyInput);
            dummyInput.select();
            document.execCommand('copy');
            document.body.removeChild(dummyInput);

            // Ganti teks tombol sementara untuk memberikan umpan balik sukses
            const origHtml = shareBtn.innerHTML;
            shareBtn.innerHTML = `
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"></path>
                </svg>
                <span class="text-emerald-700">Tersalin!</span>
            `;
            shareBtn.classList.add('bg-emerald-50', 'border-emerald-200');

            setTimeout(() => {
                shareBtn.innerHTML = origHtml;
                shareBtn.classList.remove('bg-emerald-50', 'border-emerald-200');
            }, 2000);
        });
    }
});
