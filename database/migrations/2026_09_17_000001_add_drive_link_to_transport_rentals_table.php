<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transport_rentals', function (Blueprint $table) {
            if (! Schema::hasColumn('transport_rentals', 'drive_link')) {
                $table->string('drive_link')->nullable()->after('detail_images');
            }
        });
    }

    public function down(): void
    {
        Schema::table('transport_rentals', function (Blueprint $table) {
            if (Schema::hasColumn('transport_rentals', 'drive_link')) {
                $table->dropColumn('drive_link');
            }
        });
    }
};
