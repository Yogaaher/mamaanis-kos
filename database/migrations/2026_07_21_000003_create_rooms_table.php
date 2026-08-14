<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->string('location');
            $table->unsignedBigInteger('price');
            $table->string('status')->default('Tersedia');
            $table->decimal('rating', 2, 1)->default(4.5);
            $table->unsignedInteger('views')->default(0);
            $table->string('image_url', 2048)->nullable();
            $table->string('bathroom_image_url', 2048)->nullable();
            $table->string('min_stay', 50)->default('1 Bulan');
            $table->unsignedSmallInteger('max_occupants')->default(1);
            $table->json('amenities')->nullable();
            $table->unsignedSmallInteger('size')->default(16);
            $table->unsignedSmallInteger('beds')->default(1);
            $table->text('description');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
