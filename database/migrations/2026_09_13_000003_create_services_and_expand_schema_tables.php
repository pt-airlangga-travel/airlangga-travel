<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Expand tour_packages with pricing_tiers, meeting_point, sub_destinations
        Schema::table('tour_packages', function (Blueprint $table) {
            if (! Schema::hasColumn('tour_packages', 'pricing_tiers')) {
                $table->json('pricing_tiers')->nullable()->after('price');
            }
            if (! Schema::hasColumn('tour_packages', 'meeting_point')) {
                $table->string('meeting_point')->nullable()->after('destination');
            }
            if (! Schema::hasColumn('tour_packages', 'sub_destinations')) {
                $table->json('sub_destinations')->nullable()->after('gallery');
            }
        });

        // Create transport_rentals table for Sewa Transportasi
        Schema::create('transport_rentals', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category')->default('Surabaya Area'); // e.g. Surabaya Area, Antar Kota, Luxury VIP
            $table->json('inclusions')->nullable(); // e.g. ["BBM", "Unit", "Driver"]
            $table->json('fleet_items')->nullable(); // array of {unit, seat, price_per_day}
            $table->string('cover_image');
            $table->json('detail_images')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_featured')->default(true);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Create passport_visa_services table for E-Passport & Visa
        Schema::create('passport_visa_services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('type')->default('passport'); // passport, visa
            $table->json('benefits')->nullable(); // array of benefits string
            $table->json('pricing_options')->nullable(); // array of {item, price, note}
            $table->string('cover_image');
            $table->json('detail_images')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_featured')->default(true);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('passport_visa_services');
        Schema::dropIfExists('transport_rentals');

        Schema::table('tour_packages', function (Blueprint $table) {
            if (Schema::hasColumn('tour_packages', 'sub_destinations')) {
                $table->dropColumn('sub_destinations');
            }
            if (Schema::hasColumn('tour_packages', 'meeting_point')) {
                $table->dropColumn('meeting_point');
            }
            if (Schema::hasColumn('tour_packages', 'pricing_tiers')) {
                $table->dropColumn('pricing_tiers');
            }
        });
    }
};
