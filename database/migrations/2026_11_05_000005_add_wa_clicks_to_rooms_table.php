<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('rooms') && ! Schema::hasColumn('rooms', 'wa_clicks')) {
            Schema::table('rooms', function (Blueprint $table) {
                $table->unsignedInteger('wa_clicks')->default(0)->after('views');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('rooms') && Schema::hasColumn('rooms', 'wa_clicks')) {
            Schema::table('rooms', function (Blueprint $table) {
                $table->dropColumn('wa_clicks');
            });
        }
    }
};
