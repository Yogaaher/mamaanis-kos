<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'name', 'type', 'location', 'price', 'status', 'rating', 'views',
        'image_url', 'bathroom_image_url', 'min_stay', 'max_occupants',
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
        ];
    }
}
