<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('rooms')) {
            if (!Schema::hasColumn('rooms', 'gallery_images')) {
                Schema::table('rooms', function (Blueprint $table) {
                    $table->json('gallery_images')->nullable()->after('bathroom_image_url');
                });
            }

            try {
                $driver = Schema::getConnection()->getDriverName();
                if ($driver === 'pgsql') {
                    DB::statement('ALTER TABLE rooms ALTER COLUMN image_url TYPE TEXT, ALTER COLUMN bathroom_image_url TYPE TEXT');
                } elseif (in_array($driver, ['mysql', 'mariadb'], true)) {
                    DB::statement('ALTER TABLE rooms MODIFY image_url LONGTEXT NULL, MODIFY bathroom_image_url LONGTEXT NULL');
                }
            } catch (\Throwable $e) {
                // Ignore if already text or SQLite
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('rooms') && Schema::hasColumn('rooms', 'gallery_images')) {
            Schema::table('rooms', function (Blueprint $table) {
                $table->dropColumn('gallery_images');
            });
        }
    }
};
