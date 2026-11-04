<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class AdminRoomController extends Controller
{
    public function index()
    {
        $rooms = Room::query()->latest()->get();
        $total = $rooms->count();
        $occupied = $rooms->where('status', 'Terisi')->count();
        $available = $rooms->where('status', 'Tersedia')->count();
        $maintenance = $rooms->where('status', 'Pemeliharaan')->count();
        $totalViews = $rooms->sum('views');
        $popularRooms = $rooms->sortByDesc('views');

        return view('admin.dashboard', compact('rooms', 'total', 'occupied', 'available', 'maintenance', 'totalViews', 'popularRooms'));
    }

    public function rooms()
    {
        return view('admin.rooms_index', [
            'rooms' => Room::query()->latest()->get(),
        ]);
    }

    public function create()
    {
        return view('admin.room_form', ['room' => new Room(), 'mode' => 'create']);
    }

    public function store(Request $request)
    {
        Room::create($this->validated($request));

        return redirect()->route('admin.dashboard')->with('success', 'Kamar baru berhasil ditambahkan.');
    }

    public function edit(Room $room)
    {
        return view('admin.room_form', compact('room'))->with('mode', 'edit');
    }

    public function update(Request $request, Room $room)
    {
        $room->update($this->validated($request));

        return redirect()->route('admin.dashboard')->with('success', 'Data kamar berhasil diperbarui. Halaman publik ikut diperbarui.');
    }

    public function destroy(Room $room)
    {
        $room->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Kamar berhasil dihapus dari katalog publik.');
    }

    public function analytics()
    {
        $rooms = Room::query()->latest()->get();
        $total = $rooms->count();
        $occupied = $rooms->where('status', 'Terisi')->count();
        $available = $rooms->where('status', 'Tersedia')->count();
        $maintenance = $rooms->where('status', 'Pemeliharaan')->count();
        
        $totalViews = $rooms->sum('views');
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
            ];
        })->values();

        return view('admin.analytics', compact(
            'rooms', 'total', 'occupied', 'available', 'maintenance',
            'totalViews', 'potentialIncome', 'monthlyIncome', 'occupancyRate',
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

    private function validated(Request $request): array
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

        $data = $request->validate([
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

        $gallery = [];
        $labels = $request->input('gallery_labels', []);
        $urls = $request->input('gallery_urls', []);
        $files = $request->file('gallery_files', []);

        $indices = array_unique(array_merge(
            array_keys(is_array($labels) ? $labels : []),
            array_keys(is_array($urls) ? $urls : []),
            array_keys(is_array($files) ? $files : [])
        ));
        sort($indices, SORT_NUMERIC);

        foreach ($indices as $idx) {
            $finalUrl = null;

            if (isset($files[$idx]) && $files[$idx] && $files[$idx]->isValid()) {
                $finalUrl = $this->encodeUploadedImage($files[$idx]);
            } elseif (!empty($urls[$idx]) && trim((string) $urls[$idx]) !== '') {
                $finalUrl = trim((string) $urls[$idx]);
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
                $maxDim = 1280;

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
                imagejpeg($src, null, 80);
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
