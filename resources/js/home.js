// JavaScript Khusus untuk Halaman Home - Mama Anis Group
document.addEventListener('DOMContentLoaded', function () {
    console.log("Home Scripts Initialized");

    // 1. FAQ Accordion Logic
    const faqItems = document.querySelectorAll('.faq-item');
    faqItems.forEach(item => {
        const header = item.querySelector('.faq-header');
        if (header) {
            header.addEventListener('click', function () {
                const isActive = item.classList.contains('active');
                
                // Tutup semua FAQ lainnya terlebih dahulu
                faqItems.forEach(otherItem => {
                    otherItem.classList.remove('active');
                    const otherAnswer = otherItem.querySelector('.faq-answer');
                    if (otherAnswer) {
                        otherAnswer.style.maxHeight = null;
                    }
                });

                // Toggle status FAQ yang diklik
                if (!isActive) {
                    item.classList.add('active');
                    const answer = item.querySelector('.faq-answer');
                    if (answer) {
                        answer.style.maxHeight = answer.scrollHeight + "px";
                    }
                }
            });
        }
    });

    // 2. Testimonial Auto-Slider/Carousel (jika ada elemen slider)
    const testimonialContainer = document.getElementById('testimonial-slider');
    if (testimonialContainer) {
        let index = 0;
        const items = testimonialContainer.children;
        const totalItems = items.length;

        function showNextTestimonial() {
            if (totalItems <= 1) return;
            // Sembunyikan item saat ini dengan transisi halus
            items[index].classList.add('opacity-0', 'absolute');
            items[index].classList.remove('opacity-100', 'relative');
            
            // Perbarui index
            index = (index + 1) % totalItems;
            
            // Tampilkan item baru
            items[index].classList.remove('opacity-0', 'absolute');
            items[index].classList.add('opacity-100', 'relative');
        }

        // Tampilkan testimonial pertama terlebih dahulu
        for (let i = 0; i < totalItems; i++) {
            if (i === 0) {
                items[i].classList.add('opacity-100', 'relative', 'transition-all', 'duration-500');
                items[i].classList.remove('opacity-0', 'absolute');
            } else {
                items[i].classList.add('opacity-0', 'absolute', 'transition-all', 'duration-500');
                items[i].classList.remove('opacity-100', 'relative');
            }
        }

        // Jalankan interval pergantian otomatis setiap 5 detik
        setInterval(showNextTestimonial, 5000);
    }
});
