<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Language;
use App\Models\ProductSignage;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_signage_values', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ProductSignage::class);
            $table->foreignIdFor(Language::class);
            $table->string('value', 254);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_signage_values');
    }
};
