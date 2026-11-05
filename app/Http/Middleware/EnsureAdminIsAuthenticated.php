<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminIsAuthenticated
{
    private const IDLE_TIMEOUT_SECONDS = 1800; // 30 minutes

    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->session()->get('is_admin')) {
            return redirect()->route('admin.login')->with('error', 'Silakan masuk untuk mengakses dashboard.');
        }

        // Anti-Session Hijacking: verify User-Agent fingerprint if recorded at login
        $expectedUaHash = $request->session()->get('admin_ua_hash');
        $currentUaHash = hash('sha256', (string) $request->userAgent());
        if ($expectedUaHash && ! hash_equals((string) $expectedUaHash, $currentUaHash)) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('admin.login')->with('error', 'Sesi tidak valid. Silakan masuk kembali.');
        }

        // Automatic Idle Session Timeout (30 minutes)
        $lastActive = $request->session()->get('admin_last_active');
        if ($lastActive && (now()->timestamp - (int) $lastActive) > self::IDLE_TIMEOUT_SECONDS) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('admin.login')->with('error', 'Sesi telah berakhir karena tidak ada aktivitas. Silakan masuk kembali.');
        }

        $request->session()->put('admin_last_active', now()->timestamp);

        return $next($request);
    }
}
