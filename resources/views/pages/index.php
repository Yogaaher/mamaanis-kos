<?php

/**
 * MAMA ANIS GROUP - LARAVEL BINDINGS AND ROUTING SPECIFICATION
 * 
 * Anda bisa meletakkan data array kamar di bawah ini ke dalam:
 * 1. Database Seeder (Laravel Migration & Eloquent Model) - REKOMENDASI UTAMA
 * 2. Atau langsung di-return dari Controller/Web Routes seperti contoh di bawah ini.
 */

// 1. DATA MASTER KAMAR (Diterjemahkan langsung dari data.ts React)
$rooms_dataset = [
    [
        'id' => '1',
        'name' => 'Mama Anis Central Residence - Suite 101',
        'type' => 'Penthouse',
        'location' => 'Alam Sutera, Tangerang (500m dari BINUS)',
        'price' => 4500000,
        'status' => 'Tersedia',
        'rating' => 4.9,
        'views' => 1250,
        'image' => 'https://images.unsplash.com/photo-1522771739844-6a9f6d5f14af?auto=format&fit=crop&w=800&q=80',
        'amenities' => ['Kamar Mandi Dalam', 'AC Daikin 1 PK', 'Kasur King Size', 'WiFi 100 Mbps', 'Kulkas Mini', 'Akses Kartu RFID'],
        'size' => 32,
        'beds' => 1,
        'description' => 'Kamar Penthouse Suite termewah dengan pemandangan kota langsung. Dilengkapi perabotan premium fully-furnished, kulkas mini, AC Daikin hemat energi, toilet modern kering dengan water heater, dan sistem pencahayaan pintar.'
    ],
    [
        'id' => '2',
        'name' => 'Mama Anis Central Residence - Executive 202',
        'type' => 'Executive',
        'location' => 'Alam Sutera, Tangerang (500m dari BINUS)',
        'price' => 3500000,
        'status' => 'Terisi',
        'rating' => 4.7,
        'views' => 980,
        'image' => 'https://images.unsplash.com/photo-1505691938895-1758d7feb511?auto=format&fit=crop&w=800&q=80',
        'amenities' => ['Kamar Mandi Dalam', 'AC 1 PK', 'Kasur Queen Size', 'WiFi 100 Mbps', 'Meja Kerja Premium'],
        'size' => 24,
        'beds' => 1,
        'description' => 'Sangat cocok untuk kalangan profesional muda dan mahasiswa tingkat akhir yang menginginkan keheningan untuk belajar atau bekerja (WFH). Dilengkapi dengan meja kerja ergonomis, lemari pakaian geser modern, dan pembersihan kamar gratis.'
    ],
    [
        'id' => '3',
        'name' => 'Mama Anis Central Residence - Deluxe 303',
        'type' => 'Deluxe',
        'location' => 'Alam Sutera, Tangerang (500m dari BINUS)',
        'price' => 2800000,
        'status' => 'Tersedia',
        'rating' => 4.5,
        'views' => 840,
        'image' => 'https://images.unsplash.com/photo-1616594039964-ae9021a400a0?auto=format&fit=crop&w=800&q=80',
        'amenities' => ['Kamar Mandi Dalam', 'AC 0.5 PK', 'Kasur Single', 'WiFi 50 Mbps', 'Lemari Pakaian'],
        'size' => 18,
        'beds' => 1,
        'description' => 'Kamar tipe Deluxe yang menawarkan kenyamanan maksimal dengan harga ekonomis. Desain minimalis Jepang yang estetik dengan pencahayaan alami jendela yang luas.'
    ],
    [
        'id' => '4',
        'name' => 'Mama Anis Boulevard - Standard 105',
        'type' => 'Standard',
        'location' => 'Kunciran, Tangerang (1.2km dari Kampus)',
        'price' => 1800000,
        'status' => 'Tersedia',
        'rating' => 4.2,
        'views' => 420,
        'image' => 'https://images.unsplash.com/photo-1598928506311-c55ded91a20c?auto=format&fit=crop&w=800&q=80',
        'amenities' => ['Kamar Mandi Dalam', 'Kipas Angin Dinding', 'Kasur Single', 'WiFi 50 Mbps'],
        'size' => 15,
        'beds' => 1,
        'description' => 'Kamar kos ekonomis dengan sirkulasi udara alami yang sangat baik, ramah kantong untuk mahasiswa baru. Lokasi tenang jauh dari kebisingan jalan utama.'
    ],
    [
        'id' => '5',
        'name' => 'Mama Anis Boulevard - Deluxe 201',
        'type' => 'Deluxe',
        'location' => 'Kunciran, Tangerang (1.2km dari Kampus)',
        'price' => 2500000,
        'status' => 'Pemeliharaan',
        'rating' => 4.6,
        'views' => 310,
        'image' => 'https://images.unsplash.com/photo-1560185007-c5ca9d2c014d?auto=format&fit=crop&w=800&q=80',
        'amenities' => ['Kamar Mandi Dalam', 'AC 0.5 PK', 'Kasur Single', 'WiFi 50 Mbps', 'Balkon Pribadi'],
        'size' => 20,
        'beds' => 1,
        'description' => 'Sedang dalam proses pengecatan ulang dan pemeliharaan rutin AC berkala untuk memastikan kenyamanan prima bagi calon penyewa baru berikutnya.'
    ]
];

?>

<!-- CARA SETUP DAN ATUR ROUTING DI LARAVEL -->
<div class="p-8 bg-slate-900 text-slate-100 rounded-3xl font-sans max-w-4xl mx-auto my-12 shadow-2xl border border-slate-800">
    <div class="flex items-center gap-3 border-b border-slate-800 pb-4 mb-6">
        <span class="w-3.5 h-3.5 bg-rose-500 rounded-full"></span>
        <h2 class="text-xl font-bold tracking-tight">Langkah Integrasi Routing Laravel 12</h2>
    </div>

    <p class="text-sm text-slate-400 mb-6 leading-relaxed">
        Letakkan kode rute berikut ke dalam berkas <code class="text-emerald-400 font-mono bg-slate-950 px-2 py-1 rounded-md text-xs">routes/web.php</code> proyek Laravel Anda agar seluruh template Blade yang kami buat dapat berjalan secara dinamis penuh:
    </p>

    <!-- Code Area -->
    <pre class="bg-slate-950 p-6 rounded-2xl text-xs font-mono text-emerald-400 overflow-x-auto leading-relaxed border border-slate-800 shadow-inner">
&lt;?php

use Illuminate\Support\Facades\Route;

// Dataset Kamar
$rooms_master = [
    // [Salin array $rooms_dataset lengkap dari file ini ke database seeder / controller]
];

// 1. RUTE HALAMAN BERANDA (PUBLIC HOME)
Route::get('/', function () use ($rooms_master) {
    return view('pages.home', [
        'rooms' => collect($rooms_master),
        'currentTab' => 'home'
    ]);
});

// 2. RUTE KATALOG KAMAR (PUBLIC CATALOG DENGAN FILTERING)
Route::get('/catalog', function () use ($rooms_master) {
    return view('pages.catalog', [
        'rooms' => $rooms_master,
        'currentTab' => 'catalog'
    ]);
});

// 3. RUTE TENTANG KAMI (PUBLIC ABOUT US)
Route::get('/about', function () {
    return view('pages.about', [
        'currentTab' => 'about'
    ]);
});

// 4. RUTE DETAIL KAMAR (PUBLIC ROOM DETAILS)
Route::get('/room/{id}', function ($id) use ($rooms_master) {
    $room = collect($rooms_master)->firstWhere('id', $id);
    
    if (!$room) {
        abort(404, 'Kamar tidak ditemukan.');
    }

    return view('pages.room_detail', [
        'room' => $room,
        'currentTab' => 'catalog'
    ]);
});

// 5. RUTE ADMIN DASHBOARD (ADMIN PANEL)
Route::get('/admin', function () use ($rooms_master) {
    return view('pages.dashboard', [
        'rooms' => $rooms_master,
        'activeTab' => 'dashboard'
    ]);
});
    </pre>

    <div class="mt-8 bg-slate-800/50 p-4 rounded-xl border border-slate-700/50 text-xs text-slate-300 leading-relaxed">
        <span class="font-bold text-emerald-400">💡 Tips Laravel 12:</span> Anda bisa menggunakan Laravel Sail dengan perintah <code class="text-white font-mono bg-slate-950 px-1.5 py-0.5 rounded">./vendor/bin/sail up -d</code> untuk menyalakan container lokal, lalu edit <code class="text-white font-mono bg-slate-950 px-1.5 py-0.5 rounded">resources/css/app.css</code> dan jalankan <code class="text-white font-mono bg-slate-950 px-1.5 py-0.5 rounded">npm run dev</code> untuk auto-compile Tailwind v4 secara real-time!
    </div>
</div>
