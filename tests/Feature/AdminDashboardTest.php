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

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'services.admin.username' => 'admin_mamaanis',
            'services.admin.email' => 'admin@mamaanis.local',
            'services.admin.password' => 'mamaanis123',
        ]);
    }

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

    public function test_login_honeypot_blocks_automated_bots(): void
    {
        $response = $this->from(route('admin.login'))->post(route('admin.login.store'), [
            'email' => 'admin_mamaanis',
            'password' => 'mamaanis123',
            'website_url' => 'http://spam-bot.example.com',
        ]);

        $response->assertRedirect(route('admin.login'));
        $this->assertNull(session('is_admin'));
    }

    public function test_login_rate_limiting_blocks_brute_force_attacks(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->from(route('admin.login'))->post(route('admin.login.store'), [
                'email' => 'admin_mamaanis',
                'password' => 'wrong_password_' . $i,
            ]);
        }

        // 6th attempt is blocked either by throttle middleware (429) or controller lockout
        $response = $this->from(route('admin.login'))->post(route('admin.login.store'), [
            'email' => 'admin_mamaanis',
            'password' => 'mamaanis123',
        ]);

        $this->assertTrue(in_array($response->status(), [302, 429], true));
        $this->assertNull(session('is_admin'));
    }

    public function test_session_hijacking_with_mismatched_user_agent_is_blocked(): void
    {
        $response = $this->withSession([
            'is_admin' => true,
            'admin_ua_hash' => hash('sha256', 'Original-Browser-Agent'),
            'admin_last_active' => now()->timestamp,
        ])->withHeaders([
            'User-Agent' => 'Attacker-Stolen-Cookie-Agent',
        ])->get(route('admin.dashboard'));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_expired_idle_admin_session_is_automatically_logged_out(): void
    {
        $response = $this->withSession([
            'is_admin' => true,
            'admin_last_active' => now()->subMinutes(35)->timestamp,
        ])->get(route('admin.dashboard'));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_security_headers_are_applied_to_responses(): void
    {
        $response = $this->get(route('admin.login'));

        $response->assertStatus(200);
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->assertHeader('X-Robots-Tag', 'noindex, nofollow');
    }

    public function test_admin_can_quick_toggle_room_status(): void
    {
        $room = Room::create([
            'name' => 'Kamar Quick Status',
            'type' => 'Standard',
            'location' => 'Alam Sutera',
            'price' => 2000000,
            'status' => 'Tersedia',
            'rating' => 4.9,
            'views' => 5,
            'size' => 16,
            'beds' => 1,
            'min_stay' => '1 Bulan',
            'max_occupants' => 1,
            'amenities' => ['AC', 'WiFi'],
            'description' => 'Test quick status update.',
        ]);

        $response = $this->withSession(['is_admin' => true])
            ->patch(route('admin.rooms.update_status', $room), [
                'status' => 'Terisi',
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('rooms', [
            'id' => $room->id,
            'status' => 'Terisi',
        ]);
    }
}
