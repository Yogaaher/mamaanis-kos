<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Clear all previous dummy rooms
        Room::query()->truncate();

        // 1 Single Authentic Room for Mama Anis Kos
        Room::create([
            'name' => 'Kamar Kost Mama Anis (Exclusive Room)',
            'type' => 'Kamar Standard Eksklusif',
            'location' => 'Alam Sutera, Tangerang',
            'price' => 1800000,
            'status' => 'Tersedia',
            'rating' => 4.9,
            'views' => 150,
            'size' => 16,
            'beds' => 1,
            'min_stay' => '1 Bulan',
            'max_occupants' => 1,
            'image_url' => '/images/Kamar no 5.jpg',
            'bathroom_image_url' => '/images/Kamar mandi.jpg',
            'amenities' => [
                'Kamar Mandi Dalam',
                'AC Sejuk',
                'WiFi Cepat',
                'Kasur Springbed & Bantal',
                'Lemari Pakaian',
                'Meja & Kursi',
                'Listrik Token',
                'Air Bersih'
            ],
            'description' => 'Unit kamar kost Mama Anis dirancang khusus untuk kenyamanan dan privasi 1 orang penghuni. Dilengkapi fasilitas kamar mandi dalam yang bersih dan higienis, AC sejuk, kasur springbed & bantal berkualitas, lemari pakaian, meja & kursi kerja, listrik token mandiri, air bersih lancar, dan koneksi internet WiFi cepat. Minimal durasi sewa 1 bulan.',
        ]);
    }
}
