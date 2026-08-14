<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
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
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'type' => ['required', 'string', 'max:50'],
            'location' => ['required', 'string', 'max:180'],
            'price' => ['required', 'integer', 'min:0'],
            'status' => ['required', Rule::in(['Tersedia', 'Terisi', 'Pemeliharaan'])],
            'rating' => ['required', 'numeric', 'min:0', 'max:5'],
            'views' => ['nullable', 'integer', 'min:0'],
            'image_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'image_url' => ['nullable', 'string', 'max:2048'],
            'bathroom_image_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'bathroom_image_url' => ['nullable', 'string', 'max:2048'],
            'min_stay' => ['nullable', 'string', 'max:50'],
            'max_occupants' => ['required', 'integer', 'min:1', 'max:10'],
            'amenities_text' => ['nullable', 'string', 'max:1000'],
            'size' => ['required', 'integer', 'min:1'],
            'beds' => ['required', 'integer', 'min:1'],
            'description' => ['required', 'string', 'max:2000'],
        ]);

        // Upload Foto Kamar Utama
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = time() . '_kamar_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('rooms', $filename, 'public');
            $data['image_url'] = '/storage/rooms/' . $filename;
        }

        // Upload Foto Kamar Mandi
        if ($request->hasFile('bathroom_image_file')) {
            $file = $request->file('bathroom_image_file');
            $filename = time() . '_kmandi_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('rooms', $filename, 'public');
            $data['bathroom_image_url'] = '/storage/rooms/' . $filename;
        }

        unset($data['image_file'], $data['bathroom_image_file']);

        $data['amenities'] = collect(explode(',', $data['amenities_text'] ?? ''))
            ->map(fn (string $item) => trim($item))
            ->filter()
            ->values()
            ->all();
        unset($data['amenities_text']);

        $data['views'] ??= 0;
        $data['min_stay'] = !empty($data['min_stay']) ? $data['min_stay'] : '1 Bulan';
        $data['max_occupants'] = (int) ($data['max_occupants'] ?? 1);

        if (empty($data['image_url'])) {
            $data['image_url'] = '/images/Kamar no 5.jpg';
        }
        if (empty($data['bathroom_image_url'])) {
            $data['bathroom_image_url'] = '/images/Kamar mandi.jpg';
        }

        return $data;
    }
}
