<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'name', 'type', 'location', 'price', 'status', 'rating', 'views',
        'image_url', 'bathroom_image_url', 'gallery_images', 'min_stay', 'max_occupants',
        'amenities', 'size', 'beds', 'description',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'rating' => 'decimal:1',
            'views' => 'integer',
            'size' => 'integer',
            'beds' => 'integer',
            'max_occupants' => 'integer',
            'amenities' => 'array',
            'gallery_images' => 'array',
        ];
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
