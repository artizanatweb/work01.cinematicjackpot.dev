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
        // ISO 4217 currency
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->char('alphabetic_code', 3)->unique();
            $table->char('numeric_code', 3)->unique();
            $table->string('name', 254);
            $table->string('symbol', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currencies');
    }
};
