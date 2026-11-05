<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminRoomController;
use App\Http\Controllers\PublicPageController;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:public')->group(function () {
    Route::get('/', [PublicPageController::class, 'home'])->name('home');
    Route::get('/catalog', [PublicPageController::class, 'catalog'])->name('catalog');
    Route::get('/about', [PublicPageController::class, 'about'])->name('about');
    Route::get('/room/{room}', [PublicPageController::class, 'show'])->name('rooms.show');
    Route::post('/room/{room}/wa-click', [PublicPageController::class, 'trackWaClick'])->name('rooms.wa_click');
    Route::get('/sitemap.xml', [PublicPageController::class, 'sitemap'])->name('sitemap');
});

Route::get('/login', [AdminAuthController::class, 'create'])->middleware('throttle:login-page')->name('admin.login');
Route::post('/login', [AdminAuthController::class, 'store'])->middleware('throttle:login-submit')->name('admin.login.store');

Route::middleware(['admin.auth', 'throttle:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminRoomController::class, 'index'])->name('dashboard');
    Route::get('/rooms', [AdminRoomController::class, 'rooms'])->name('rooms.index');
    Route::get('/rooms/create', [AdminRoomController::class, 'create'])->name('rooms.create');
    Route::post('/rooms', [AdminRoomController::class, 'store'])->name('rooms.store');
    Route::get('/rooms/{room}/edit', [AdminRoomController::class, 'edit'])->name('rooms.edit');
    Route::patch('/rooms/{room}/status', [AdminRoomController::class, 'updateStatus'])->name('rooms.update_status');
    Route::match(['post', 'put'], '/rooms/{room}', [AdminRoomController::class, 'update'])->name('rooms.update');
    Route::delete('/rooms/{room}', [AdminRoomController::class, 'destroy'])->name('rooms.destroy');
    Route::get('/analytics', [AdminRoomController::class, 'analytics'])->name('analytics');
    Route::get('/settings', [AdminRoomController::class, 'settings'])->name('settings');
    Route::post('/settings/clear-cache', [AdminRoomController::class, 'clearCache'])->name('settings.clear_cache');
    Route::post('/logout', [AdminAuthController::class, 'destroy'])->name('logout');
});

Route::fallback(function () {
    return response()->view('errors.404', ['currentTab' => '404'], 404);
})->middleware('throttle:public');
