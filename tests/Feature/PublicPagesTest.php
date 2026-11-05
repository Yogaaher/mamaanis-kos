<?php

namespace Tests\Feature;

use App\Models\Room;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_home_page_renders_with_security_and_anti_fraud(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('MARLIYAH');
        $response->assertSee('0877-8204-9784');
        $response->assertSee('Bank Mandiri');
        $response->assertDontSee('Pengalaman Terbaik di PC / Laptop');
        $response->assertDontSee('desktopExperienceModal');
    }

    public function test_non_existent_route_renders_custom_404_page_with_home_button(): void
    {
        $response = $this->get('/rute-nyasar-tidak-ada');

        $response->assertStatus(404);
        $response->assertSee('404');
        $response->assertSee('Kembali ke Halaman Utama');
    }

    public function test_sitemap_xml_renders_valid_urls_and_rooms(): void
    {
        $room = Room::first();

        $response = $this->get('/sitemap.xml');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/xml; charset=UTF-8');
        $response->assertSee('<urlset', false);
        $response->assertSee('/catalog', false);
        $response->assertSee('/room/' . $room->id, false);
    }

    public function test_catalog_page_renders_with_authentic_room_and_security_notice(): void
    {
        $response = $this->get('/catalog');

        $response->assertStatus(200);
        $response->assertSee('Kamar Kost Mama Anis (Exclusive Room)');
        $response->assertSee('MARLIYAH');
        $response->assertSee('0877-8204-9784');
    }

    public function test_room_detail_page_renders_with_8_mandatory_amenities_and_booking_guard(): void
    {
        $room = Room::first();

        $response = $this->get('/room/' . $room->id);

        $response->assertStatus(200);
        $response->assertSee('Kamar Mandi Dalam');
        $response->assertSee('AC Sejuk');
        $response->assertSee('WiFi Cepat');
        $response->assertSee('Kasur Springbed & Bantal');
        $response->assertSee('Lemari Pakaian');
        $response->assertSee('Meja & Kursi');
        $response->assertSee('Listrik Token');
        $response->assertSee('Air Bersih');
        $response->assertSee('MARLIYAH');
    }

    public function test_about_page_renders_with_anti_fraud_section(): void
    {
        $response = $this->get('/about');

        $response->assertStatus(200);
        $response->assertSee('Panduan Transaksi Aman Mama Anis Kos');
        $response->assertSee('MARLIYAH');
    }

    public function test_skipped_room_id_is_normalized_so_room_2_and_room_3_both_resolve(): void
    {
        // Simulate skipped ID #2 where second room was inserted as ID #3
        Room::create([
            'id' => 3,
            'name' => 'Kamar Kost Unit Kedua',
            'type' => 'Kamar Standard Eksklusif',
            'location' => 'Alam Sutera, Tangerang',
            'price' => 1850000,
            'status' => 'Tersedia',
            'rating' => 4.9,
            'views' => 25,
            'size' => 16,
            'beds' => 1,
            'min_stay' => '1 Bulan',
            'max_occupants' => 1,
            'amenities' => ['Kamar Mandi Dalam', 'AC Sejuk'],
            'description' => 'Unit kedua yang sebelumnya melompat ke ID 3.',
        ]);

        // Visiting /room/2 should normalize ID 3 -> 2 and render 200 OK
        $responseRoom2 = $this->get('/room/2');
        $responseRoom2->assertStatus(200);
        $responseRoom2->assertSee('Kamar Kost Unit Kedua');

        // Visiting /room/3 (old link) should also resolve to the 2nd room instead of 404
        $responseRoom3 = $this->get('/room/3');
        $responseRoom3->assertStatus(200);
        $responseRoom3->assertSee('Kamar Kost Unit Kedua');

        // Database ID is now sequentially 2
        $this->assertDatabaseHas('rooms', [
            'id' => 2,
            'name' => 'Kamar Kost Unit Kedua',
        ]);
    }

    public function test_room_detail_includes_share_button_bubble_chat_faq_and_wa_lead_tracking(): void
    {
        $room = Room::first();

        $response = $this->get('/room/' . $room->id);
        $response->assertStatus(200);
        $response->assertSee('Bagikan Kamar');
        $response->assertSee('Tanya Jawab Kos (FAQ)');
        $response->assertSee('FAQPage', false);
        $response->assertSee('Jadwalkan Survei & Booking WA', false);
        $response->assertSee('Kos Khusus Putri');
        $response->assertSee('ruang tunggu');
        $response->assertSee('iuran sampah juga GRATIS');
        $response->assertSee('Belakang Warteg Barokah Alam Sutera');
        $response->assertSee('https://share.google/j7P9yPSEyOxYYRu47', false);

        // Track WhatsApp Lead Click
        $trackResponse = $this->postJson('/room/' . $room->id . '/wa-click', [
            'intent' => 'Jadwalkan Survei Lokasi',
        ]);
        $trackResponse->assertStatus(200)->assertJson([
            'ok' => true,
            'wa_clicks' => 1,
        ]);

        $this->assertDatabaseHas('rooms', [
            'id' => $room->id,
            'wa_clicks' => 1,
        ]);
    }
}
