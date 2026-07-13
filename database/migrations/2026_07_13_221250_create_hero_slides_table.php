<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hero_slides', function (Blueprint $table) {
            $table->id();
            $table->string('image_alt')->nullable();

            // Per-slide overrides for the left-column copy. All nullable — if
            // blank, the frontend falls back to the corresponding setting('hero.*').
            $table->string('badge')->nullable();
            $table->string('line1')->nullable();
            $table->string('line2_prefix')->nullable();
            $table->string('line2_accent')->nullable();
            $table->string('line2_suffix')->nullable();
            $table->string('line3_prefix')->nullable();
            $table->string('line3_accent')->nullable();
            $table->text('subhead')->nullable();

            $table->string('cta_primary_label')->nullable();
            $table->string('cta_primary_url')->nullable();
            $table->string('cta_secondary_label')->nullable();
            $table->string('cta_secondary_url')->nullable();

            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->boolean('is_published')->default(true)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hero_slides');
    }
};
