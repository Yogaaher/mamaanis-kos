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
}
