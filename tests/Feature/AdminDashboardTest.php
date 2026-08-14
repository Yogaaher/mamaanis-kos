<?php

namespace Tests\Feature;

use App\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_admin_dashboard(): void
    {
        $response = $this->get(route('admin.dashboard'));
        $response->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_login_with_email(): void
    {
        $response = $this->post(route('admin.login.store'), [
            'email' => 'admin@mamaanis.local',
            'password' => 'mamaanis123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertTrue(session('is_admin'));
    }

    public function test_admin_can_login_with_username(): void
    {
        $response = $this->post(route('admin.login.store'), [
            'email' => 'admin_mamaanis',
            'password' => 'mamaanis123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertTrue(session('is_admin'));
    }

    public function test_admin_can_view_dashboard_and_username_from_env(): void
    {
        $response = $this->withSession(['is_admin' => true])->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('admin_mamaanis');
        $response->assertSee('Ringkasan Operasional');
        $response->assertSee('Tren View & Kunjungan Kamar', false);
    }

    public function test_admin_can_view_analytics_page(): void
    {
        $response = $this->withSession(['is_admin' => true])->get(route('admin.analytics'));

        $response->assertStatus(200);
        $response->assertSee('Laporan & Analisis Performa', false);
        $response->assertSee('Rincian Statistik Tiap Kamar');
    }

    public function test_admin_can_view_settings_page(): void
    {
        $response = $this->withSession(['is_admin' => true])->get(route('admin.settings'));

        $response->assertStatus(200);
        $response->assertSee('Pengaturan & Profil Admin', false);
        $response->assertSee('admin_mamaanis');
        $response->assertSee('admin@mamaanis.local');
    }

    public function test_admin_can_clear_cache_via_settings(): void
    {
        $response = $this->withSession(['is_admin' => true])
            ->post(route('admin.settings.clear_cache'));

        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    public function test_admin_can_create_room(): void
    {
        $response = $this->withSession(['is_admin' => true])
            ->post(route('admin.rooms.store'), [
                'name' => 'Kamar Baru Test',
                'type' => 'Deluxe Studio',
                'location' => 'Alam Sutera, Tangerang',
                'price' => 3000000,
                'status' => 'Tersedia',
                'rating' => 4.9,
                'views' => 10,
                'size' => 20,
                'beds' => 1,
                'min_stay' => '1 Bulan',
                'max_occupants' => 1,
                'amenities_text' => 'AC, WiFi, Kamar Mandi Dalam',
                'description' => 'Kamar uji coba untuk automated testing.',
            ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertDatabaseHas('rooms', ['name' => 'Kamar Baru Test']);
    }

    public function test_admin_can_create_room_with_image_upload(): void
    {
        Storage::fake('public');
        $kamarFile = UploadedFile::fake()->image('kamar_test.jpg', 800, 600);
        $kmandiFile = UploadedFile::fake()->image('kmandi_test.jpg', 800, 600);

        $response = $this->withSession(['is_admin' => true])
            ->post(route('admin.rooms.store'), [
                'name' => 'Kamar Upload Test',
                'type' => 'Executive Suite',
                'location' => 'Alam Sutera, Tangerang',
                'price' => 4500000,
                'status' => 'Tersedia',
                'rating' => 5.0,
                'views' => 15,
                'size' => 30,
                'beds' => 1,
                'min_stay' => '1 Bulan',
                'max_occupants' => 1,
                'image_file' => $kamarFile,
                'bathroom_image_file' => $kmandiFile,
                'amenities_text' => 'AC, WiFi, Kamar Mandi Dalam',
                'description' => 'Kamar uji coba upload gambar kamar & kamar mandi.',
            ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertDatabaseHas('rooms', ['name' => 'Kamar Upload Test']);
    }
}
