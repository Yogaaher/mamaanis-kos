<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AdminRoomController extends Controller
{
    public function index()
    {
        Room::normalizeSequentialIds();

        $rooms = Room::query()->orderBy('id')->get();
        $total = $rooms->count();
        $occupied = $rooms->where('status', 'Terisi')->count();
        $available = $rooms->where('status', 'Tersedia')->count();
        $maintenance = $rooms->where('status', 'Pemeliharaan')->count();
        $totalViews = $rooms->sum('views');
        $totalWaClicks = $rooms->sum('wa_clicks');
        $popularRooms = $rooms->sortByDesc('views');

        return view('admin.dashboard', compact('rooms', 'total', 'occupied', 'available', 'maintenance', 'totalViews', 'totalWaClicks', 'popularRooms'));
    }

    public function rooms()
    {
        Room::normalizeSequentialIds();

        return view('admin.rooms_index', [
            'rooms' => Room::query()->orderBy('id')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.room_form', ['room' => new Room(), 'mode' => 'create']);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['id'] = Room::nextSequentialId();

        Room::create($data);
        Room::syncAutoIncrementSequence();

        return redirect()->route('admin.dashboard')->with('success', 'Kamar baru berhasil ditambahkan.');
    }

    public function edit(Room $room)
    {
        return view('admin.room_form', compact('room'))->with('mode', 'edit');
    }

    public function update(Request $request, Room $room)
    {
        $room->update($this->validated($request, $room));

        return redirect()->route('admin.dashboard')->with('success', 'Data kamar berhasil diperbarui. Halaman publik ikut diperbarui.');
    }

    public function updateStatus(Request $request, Room $room)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['Tersedia', 'Terisi', 'Pemeliharaan'])],
        ]);

        $room->update(['status' => $validated['status']]);

        return back()->with('success', "Status kamar \"{$room->name}\" berhasil diubah menjadi {$validated['status']}.");
    }

    public function destroy(Room $room)
    {
        $room->delete();
        Room::normalizeSequentialIds();

        return redirect()->route('admin.dashboard')->with('success', 'Kamar berhasil dihapus dari katalog publik.');
    }

    public function analytics()
    {
        Room::normalizeSequentialIds();

        $rooms = Room::query()->orderBy('id')->get();
        $total = $rooms->count();
        $occupied = $rooms->where('status', 'Terisi')->count();
        $available = $rooms->where('status', 'Tersedia')->count();
        $maintenance = $rooms->where('status', 'Pemeliharaan')->count();
        
        $totalViews = $rooms->sum('views');
        $totalWaClicks = $rooms->sum('wa_clicks');
        $potentialIncome = $rooms->sum('price');
        $monthlyIncome = $rooms->where('status', 'Terisi')->sum('price');
        $occupancyRate = $total ? round(($occupied / $total) * 100) : 0;
        
        $popularRooms = $rooms->sortByDesc('views');

        // Group by room types
        $typeStats = $rooms->groupBy('type')->map(function ($items, $type) {
            return [
                'type' => $type,
                'total' => $items->count(),
                'occupied' => $items->where('status', 'Terisi')->count(),
                'available' => $items->where('status', 'Tersedia')->count(),
                'avg_price' => round($items->avg('price')),
                'total_views' => $items->sum('views'),
                'total_wa_clicks' => $items->sum('wa_clicks'),
            ];
        })->values();

        return view('admin.analytics', compact(
            'rooms', 'total', 'occupied', 'available', 'maintenance',
            'totalViews', 'totalWaClicks', 'potentialIncome', 'monthlyIncome', 'occupancyRate',
            'popularRooms', 'typeStats'
        ));
    }

    public function settings()
    {
        $rooms = Room::query()->get();
        $total = $rooms->count();
        $adminUsername = config('services.admin.username', 'admin_mamaanis');
        $adminEmail = config('services.admin.email', 'admin@mamaanis.local');

        return view('admin.settings', compact('total', 'adminUsername', 'adminEmail'));
    }

    public function clearCache()
    {
        try {
            \Illuminate\Support\Facades\Artisan::call('cache:clear');
            \Illuminate\Support\Facades\Artisan::call('view:clear');
            return back()->with('success', 'Cache sistem dan Blade view berhasil dibersihkan.');
        } catch (\Throwable $e) {
            return back()->with('success', 'Cache berhasil disegarkan.');
        }
    }

    private function validated(Request $request, ?Room $existingRoom = null): array
    {
        try {
            if (Schema::hasTable('rooms')) {
                if (!Schema::hasColumn('rooms', 'gallery_images')) {
                    Schema::table('rooms', function (Blueprint $table) {
                        $table->json('gallery_images')->nullable()->after('bathroom_image_url');
                    });
                }

                $driver = Schema::getConnection()->getDriverName();
                if ($driver === 'pgsql') {
                    DB::statement('ALTER TABLE rooms ALTER COLUMN image_url TYPE TEXT, ALTER COLUMN bathroom_image_url TYPE TEXT');
                } elseif (in_array($driver, ['mysql', 'mariadb'], true)) {
                    DB::statement('ALTER TABLE rooms MODIFY image_url LONGTEXT NULL, MODIFY bathroom_image_url LONGTEXT NULL');
                }
            }
        } catch (\Throwable $e) {
            // Ignore schema check errors if read-only or already altered
        }

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:120'],
            'type' => ['required', 'string', 'max:50'],
            'location' => ['required', 'string', 'max:180'],
            'price' => ['required', 'integer', 'min:0'],
            'status' => ['required', Rule::in(['Tersedia', 'Terisi', 'Pemeliharaan'])],
            'rating' => ['required', 'numeric', 'min:0', 'max:5'],
            'views' => ['nullable', 'integer', 'min:0'],
            'image_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'image_url' => ['nullable', 'string'],
            'bathroom_image_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'bathroom_image_url' => ['nullable', 'string'],
            'photo_label' => ['nullable', 'array'],
            'photo_label.*' => ['nullable', 'string', 'max:120'],
            'photo_link' => ['nullable', 'array'],
            'photo_link.*' => ['nullable', 'string', 'max:2048'],
            'photo_b64' => ['nullable', 'array'],
            'photo_b64.*' => ['nullable', 'string'],
            'photo_keep' => ['nullable', 'array'],
            'photo_keep.*' => ['nullable', 'string', 'max:20'],
            'gallery_labels' => ['nullable', 'array'],
            'gallery_labels.*' => ['nullable', 'string', 'max:120'],
            'gallery_urls' => ['nullable', 'array'],
            'gallery_urls.*' => ['nullable', 'string'],
            'gallery_files' => ['nullable', 'array'],
            'gallery_files.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'min_stay' => ['nullable', 'string', 'max:50'],
            'max_occupants' => ['required', 'integer', 'min:1', 'max:10'],
            'amenities_text' => ['nullable', 'string', 'max:1000'],
            'size' => ['required', 'integer', 'min:1'],
            'beds' => ['required', 'integer', 'min:1'],
            'description' => ['required', 'string', 'max:2000'],
        ]);

        if ($validator->fails()) {
            // Remove large base64 strings from request before Laravel flashes input to cookie session
            $request->request->remove('photo_b64');
            $request->request->remove('gallery_urls');
            throw new ValidationException($validator);
        }

        $data = $validator->validated();

        $gallery = [];
        $labels = $request->input('photo_label', $request->input('gallery_labels', []));
        $links = $request->input('photo_link', $request->input('gallery_urls', []));
        $b64s = $request->input('photo_b64', []);
        $keeps = $request->input('photo_keep', []);
        $files = $request->file('gallery_files', []);
        $existingList = $existingRoom ? $existingRoom->getGalleryList() : [];

        $indices = array_unique(array_merge(
            array_keys(is_array($labels) ? $labels : []),
            array_keys(is_array($links) ? $links : []),
            array_keys(is_array($b64s) ? $b64s : []),
            array_keys(is_array($keeps) ? $keeps : []),
            array_keys(is_array($files) ? $files : [])
        ));
        sort($indices, SORT_NUMERIC);

        foreach ($indices as $idx) {
            $finalUrl = null;

            if (!empty($b64s[$idx]) && is_string($b64s[$idx])) {
                $cleanB64 = strtr(trim($b64s[$idx]), '-_', '+/');
                $pad = strlen($cleanB64) % 4;
                if ($pad > 0) {
                    $cleanB64 .= str_repeat('=', 4 - $pad);
                }
                if (base64_decode($cleanB64, true) !== false) {
                    $finalUrl = 'data:image/jpeg;base64,' . $cleanB64;
                }
            } elseif (isset($files[$idx]) && $files[$idx] && $files[$idx]->isValid()) {
                $finalUrl = $this->encodeUploadedImage($files[$idx]);
            } elseif (!empty($links[$idx]) && trim((string) $links[$idx]) !== '') {
                $finalUrl = trim((string) $links[$idx]);
            } elseif (isset($keeps[$idx]) && $keeps[$idx] !== '' && $keeps[$idx] !== null) {
                $keepIdx = (int) $keeps[$idx];
                if (isset($existingList[$keepIdx]['url'])) {
                    $finalUrl = $existingList[$keepIdx]['url'];
                }
            }

            if ($finalUrl) {
                $rawLabel = isset($labels[$idx]) ? trim((string) $labels[$idx]) : '';
                $gallery[] = [
                    'url' => $finalUrl,
                    'label' => $rawLabel !== '' ? $rawLabel : ('Foto Kamar ' . (count($gallery) + 1)),
                ];
            }
        }

        // Legacy fallback if form was submitted with old single fields
        if (count($gallery) === 0) {
            if ($request->hasFile('image_file') && $request->file('image_file')->isValid()) {
                $data['image_url'] = $this->encodeUploadedImage($request->file('image_file'));
            }
            if ($request->hasFile('bathroom_image_file') && $request->file('bathroom_image_file')->isValid()) {
                $data['bathroom_image_url'] = $this->encodeUploadedImage($request->file('bathroom_image_file'));
            }
            if (!empty($data['image_url'])) {
                $gallery[] = ['url' => $data['image_url'], 'label' => 'Foto Kamar Tidur'];
            }
            if (!empty($data['bathroom_image_url'])) {
                $gallery[] = ['url' => $data['bathroom_image_url'], 'label' => 'Foto Kamar Mandi Dalam'];
            }
        }

        if (count($gallery) === 0) {
            $gallery[] = ['url' => '/images/Kamar no 5.jpg', 'label' => 'Foto Kamar Tidur'];
        }

        unset(
            $data['image_file'],
            $data['bathroom_image_file'],
            $data['photo_label'],
            $data['photo_link'],
            $data['photo_b64'],
            $data['photo_keep'],
            $data['gallery_files'],
            $data['gallery_urls'],
            $data['gallery_labels']
        );

        $data['gallery_images'] = $gallery;
        $data['image_url'] = $gallery[0]['url'] ?? '/images/Kamar no 5.jpg';
        $data['bathroom_image_url'] = $gallery[1]['url'] ?? ($gallery[0]['url'] ?? '/images/Kamar mandi.jpg');

        $data['amenities'] = collect(explode(',', $data['amenities_text'] ?? ''))
            ->map(fn (string $item) => trim($item))
            ->filter()
            ->values()
            ->all();
        unset($data['amenities_text']);

        $data['views'] ??= 0;
        $data['min_stay'] = !empty($data['min_stay']) ? $data['min_stay'] : '1 Bulan';
        $data['max_occupants'] = (int) ($data['max_occupants'] ?? 1);

        return $data;
    }

    /**
     * Convert uploaded image to a compressed Base64 Data URI so it can be stored
     * directly in Supabase PostgreSQL without touching read-only serverless disks.
     */
    private function encodeUploadedImage(UploadedFile $file): string
    {
        $realPath = $file->getRealPath();
        $rawContents = $realPath ? @file_get_contents($realPath) : false;

        if ($rawContents === false) {
            return '/images/Kamar no 5.jpg';
        }

        // Compress and resize if GD extension is available to keep DB records fast & lightweight
        if (function_exists('imagecreatefromstring') && function_exists('imagejpeg')) {
            $src = @imagecreatefromstring($rawContents);
            if ($src !== false) {
                $width = imagesx($src);
                $height = imagesy($src);
                $maxDim = 960;

                if ($width > $maxDim || $height > $maxDim) {
                    $ratio = min($maxDim / $width, $maxDim / $height);
                    $newWidth = max(1, (int) round($width * $ratio));
                    $newHeight = max(1, (int) round($height * $ratio));
                    $dst = imagecreatetruecolor($newWidth, $newHeight);

                    // Fill white background in case of transparent PNG/WebP
                    $white = imagecolorallocate($dst, 255, 255, 255);
                    imagefill($dst, 0, 0, $white);
                    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                    imagedestroy($src);
                    $src = $dst;
                }

                ob_start();
                imagejpeg($src, null, 72);
                $compressed = ob_get_clean();
                imagedestroy($src);

                if ($compressed !== false && strlen($compressed) > 0) {
                    return 'data:image/jpeg;base64,' . base64_encode($compressed);
                }
            }
        }

        $mime = $file->getMimeType() ?: 'image/jpeg';

        return 'data:' . $mime . ';base64,' . base64_encode($rawContents);
    }
}
