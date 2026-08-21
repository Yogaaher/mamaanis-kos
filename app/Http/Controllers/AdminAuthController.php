<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class AdminAuthController extends Controller
{
    public function create()
    {
        return view('admin.login');
    }

    public function store(Request $request)
    {
        $input = $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $key = 'admin-login:'.$request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            return back()->withErrors(['email' => 'Terlalu banyak percobaan. Coba lagi dalam satu menit.'])->onlyInput('email');
        }

        $adminEmail = (string) config('services.admin.email');
        $adminUsername = (string) config('services.admin.username');
        $adminPassword = (string) config('services.admin.password');

        $inputIdentifier = trim($input['email']);
        $identifierMatches = hash_equals(strtolower($adminEmail), strtolower($inputIdentifier)) 
            || hash_equals(strtolower($adminUsername), strtolower($inputIdentifier));
        $passwordMatches = hash_equals($adminPassword, $input['password']);

        if (! $identifierMatches || ! $passwordMatches) {
            RateLimiter::hit($key, 60);

            return back()->withErrors(['email' => 'Username/Email atau kata sandi tidak cocok.'])->onlyInput('email');
        }

        RateLimiter::clear($key);
        $request->session()->regenerate();
        $request->session()->put('is_admin', true);
        $request->session()->put('admin_username', $adminUsername);
        $request->session()->put('admin_email', $adminEmail);

        return redirect()->route('admin.dashboard');
    }

    public function destroy(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
