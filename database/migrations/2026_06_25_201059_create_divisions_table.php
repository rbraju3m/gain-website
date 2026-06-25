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
        Schema::create('divisions', function (Blueprint $table) {
            $table->id();
            // 'key' matches the SVG <g id="..."> on the Bangladesh map
            // (rongpur/rajshahi/mymensingh/sylhet/dhaka/khulna/barisal/chittagong).
            $table->string('key', 20)->unique();
            $table->string('name', 50);
            $table->string('families', 30)->nullable();   // e.g. "4,200+"
            $table->unsignedInteger('programmes')->default(0);
            $table->string('success_rate', 10)->nullable(); // e.g. "98%"
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('divisions');
    }
};
