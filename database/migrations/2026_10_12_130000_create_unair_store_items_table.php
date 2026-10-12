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
        if (! Schema::hasTable('unair_store_items')) {
            Schema::create('unair_store_items', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('slug')->unique();
                $table->string('category')->default('Apparel & Fashion');
                $table->decimal('price', 14, 2)->nullable();
                $table->decimal('discount_price', 14, 2)->nullable();
                $table->string('stock_status')->default('Tersedia');
                $table->string('badge')->nullable();
                $table->text('description')->nullable();
                $table->string('cover_image')->nullable();
                $table->json('detail_images')->nullable();
                $table->string('wa_template_message')->nullable();
                $table->boolean('is_featured')->default(true);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unair_store_items');
    }
};
