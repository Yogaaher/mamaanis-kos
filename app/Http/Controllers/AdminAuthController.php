<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class AdminAuthController extends Controller
{
    private const MAX_ATTEMPTS = 5;
    private const DECAY_SECONDS = 300; // 5 minutes lockout

    public function create(Request $request)
    {
        if ($request->session()->get('is_admin')) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    public function store(Request $request)
    {
        $ipKey = 'admin-login:ip:' . $request->ip();

        // 1. Anti-bot Honeypot check: bots auto-filling hidden fields get penalized immediately
        if ($request->filled('website_url')) {
            RateLimiter::hit($ipKey, self::DECAY_SECONDS);

            return back()->withErrors([
                'email' => 'Permintaan tidak valid terdeteksi oleh sistem keamanan.',
            ]);
        }

        $input = $request->validate([
            'email' => ['required', 'string', 'max:120'],
            'password' => ['required', 'string', 'max:255'],
        ]);

        $inputIdentifier = strtolower(trim($input['email']));
        $idKey = 'admin-login:id:' . sha1($inputIdentifier);

        // 2. Dual-layer Brute-Force Lockout (by IP and by target account identifier)
        if (
            RateLimiter::tooManyAttempts($ipKey, self::MAX_ATTEMPTS)
            || RateLimiter::tooManyAttempts($idKey, self::MAX_ATTEMPTS)
        ) {
            $seconds = max(
                RateLimiter::availableIn($ipKey),
                RateLimiter::availableIn($idKey),
                1
            );

            return back()
                ->withErrors([
                    'email' => "Terlalu banyak percobaan gagal. Silakan tunggu {$seconds} detik sebelum mencoba lagi.",
                ])
                ->onlyInput('email');
        }

        $adminEmail = trim((string) config('services.admin.email'));
        $adminUsername = trim((string) config('services.admin.username'));
        $adminPassword = (string) config('services.admin.password');

        if ($adminPassword === '' || ($adminEmail === '' && $adminUsername === '')) {
            RateLimiter::hit($ipKey, self::DECAY_SECONDS);

            return back()->withErrors([
                'email' => 'Konfigurasi kredensial admin belum diatur dengan benar.',
            ]);
        }

        // 3. Constant-time comparison to prevent timing-attack enumeration
        $emailMatches = $adminEmail !== '' && hash_equals(strtolower($adminEmail), $inputIdentifier);
        $usernameMatches = $adminUsername !== '' && hash_equals(strtolower($adminUsername), $inputIdentifier);
        $identifierMatches = $emailMatches || $usernameMatches;

        $isHashedPassword = str_starts_with($adminPassword, '$2y$')
            || str_starts_with($adminPassword, '$2a$')
            || str_starts_with($adminPassword, '$2b$')
            || str_starts_with($adminPassword, '$argon2');

        $passwordMatches = $isHashedPassword
            ? password_verify($input['password'], $adminPassword)
            : hash_equals($adminPassword, $input['password']);

        if (! $identifierMatches || ! $passwordMatches) {
            RateLimiter::hit($ipKey, self::DECAY_SECONDS);
            RateLimiter::hit($idKey, self::DECAY_SECONDS);

            return back()
                ->withErrors(['email' => 'Username/Email atau kata sandi tidak cocok.'])
                ->onlyInput('email');
        }

        RateLimiter::clear($ipKey);
        RateLimiter::clear($idKey);

        $request->session()->regenerate();
        $request->session()->put([
            'is_admin' => true,
            'admin_username' => $adminUsername,
            'admin_email' => $adminEmail,
            'admin_ua_hash' => hash('sha256', (string) $request->userAgent()),
            'admin_last_active' => now()->timestamp,
        ]);

        return redirect()->route('admin.dashboard');
    }

    public function destroy(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
