<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Room extends Model
{
    protected $fillable = [
        'id', 'name', 'type', 'location', 'price', 'status', 'rating', 'views', 'wa_clicks',
        'image_url', 'bathroom_image_url', 'gallery_images', 'min_stay', 'max_occupants',
        'amenities', 'size', 'beds', 'description',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'rating' => 'decimal:1',
            'views' => 'integer',
            'wa_clicks' => 'integer',
            'size' => 'integer',
            'beds' => 'integer',
            'max_occupants' => 'integer',
            'amenities' => 'array',
            'gallery_images' => 'array',
        ];
    }

    /**
     * Ensure room IDs are strictly sequential (1, 2, 3...) without gaps
     * and synchronize the database auto-increment sequence.
     */
    public static function normalizeSequentialIds(): void
    {
        try {
            if (! Schema::hasTable('rooms')) {
                return;
            }

            if (! Schema::hasColumn('rooms', 'wa_clicks')) {
                Schema::table('rooms', function (Blueprint $table) {
                    $table->unsignedInteger('wa_clicks')->default(0)->after('views');
                });
            }

            $ids = DB::table('rooms')->orderBy('id')->pluck('id')->map(fn ($id) => (int) $id)->values()->all();
            $hasGap = false;

            foreach ($ids as $index => $currentId) {
                $targetId = $index + 1;
                if ($currentId !== $targetId) {
                    DB::table('rooms')->where('id', $currentId)->update(['id' => $targetId]);
                    $hasGap = true;
                }
            }

            if ($hasGap || count($ids) <= 1) {
                self::syncAutoIncrementSequence(count($ids));
            }
        } catch (\Throwable $e) {
            // Safely ignore if database connection is read-only
        }
    }

    /**
     * Get the next sequential room ID (lowest available positive integer: 1, 2, 3...).
     */
    public static function nextSequentialId(): int
    {
        self::normalizeSequentialIds();

        $existingIds = DB::table('rooms')->orderBy('id')->pluck('id')->map(fn ($id) => (int) $id)->all();
        $expected = 1;
        foreach ($existingIds as $id) {
            if ($id === $expected) {
                $expected++;
            } elseif ($id > $expected) {
                break;
            }
        }

        return $expected;
    }

    /**
     * Synchronize the underlying SQL sequence (SQLite / PostgreSQL / MySQL) with the current max ID.
     */
    public static function syncAutoIncrementSequence(?int $maxId = null): void
    {
        try {
            $maxId ??= (int) DB::table('rooms')->max('id');
            $driver = Schema::getConnection()->getDriverName();

            if ($driver === 'sqlite') {
                DB::statement('UPDATE sqlite_sequence SET seq = ? WHERE name = ?', [$maxId, 'rooms']);
            } elseif ($driver === 'pgsql') {
                if ($maxId > 0) {
                    DB::statement("SELECT setval(pg_get_serial_sequence('rooms', 'id'), ?, true)", [$maxId]);
                } else {
                    DB::statement("SELECT setval(pg_get_serial_sequence('rooms', 'id'), 1, false)");
                }
            } elseif (in_array($driver, ['mysql', 'mariadb'], true)) {
                $next = max(1, $maxId + 1);
                DB::statement("ALTER TABLE rooms AUTO_INCREMENT = {$next}");
            }
        } catch (\Throwable $e) {
            // Safely ignore sequence sync errors
        }
    }

    /**
     * Custom route model binding that normalizes skipped IDs and resolves fallback index.
     */
    public function resolveRouteBinding($value, $field = null)
    {
        self::normalizeSequentialIds();

        if ($field) {
            return $this->where($field, $value)->first();
        }

        $room = $this->find($value);

        if (! $room && is_scalar($value) && ctype_digit((string) $value)) {
            $roomId = (int) $value;
            if ($roomId > 0) {
                $allRooms = self::query()->orderBy('id')->get()->values();
                if ($roomId <= $allRooms->count()) {
                    $room = $allRooms->get($roomId - 1);
                } elseif ($allRooms->count() >= 2 && $roomId === $allRooms->count() + 1) {
                    $room = $allRooms->last();
                }
            }
        }

        return $room;
    }

    /**
     * Get normalized gallery images list (url + label).
     */
    public function getGalleryList(): array
    {
        $items = [];

        if (is_array($this->gallery_images) && count($this->gallery_images) > 0) {
            foreach ($this->gallery_images as $idx => $item) {
                if (is_string($item) && trim($item) !== '') {
                    $items[] = [
                        'url' => trim($item),
                        'label' => 'Foto Kamar ' . ($idx + 1),
                    ];
                } elseif (is_array($item) && !empty($item['url'])) {
                    $items[] = [
                        'url' => trim((string) $item['url']),
                        'label' => !empty($item['label']) ? trim((string) $item['label']) : ('Foto Kamar ' . ($idx + 1)),
                    ];
                }
            }
        }

        if (count($items) === 0) {
            if (!empty($this->image_url)) {
                $items[] = [
                    'url' => $this->image_url,
                    'label' => 'Foto Kamar Tidur',
                ];
            }
            if (!empty($this->bathroom_image_url)) {
                $items[] = [
                    'url' => $this->bathroom_image_url,
                    'label' => 'Foto Kamar Mandi Dalam',
                ];
            }
        }

        if (count($items) === 0) {
            $items = [
                ['url' => '/images/Kamar no 5.jpg', 'label' => 'Foto Kamar Tidur'],
                ['url' => '/images/Kamar mandi.jpg', 'label' => 'Foto Kamar Mandi Dalam'],
            ];
        }

        return $items;
    }
}
