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
        Schema::create('impact_stats', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->unsignedInteger('counter')->default(0);
            $table->string('suffix', 10)->nullable();
            $table->enum('tone', ['red', 'green', 'orange'])->default('red');
            $table->string('icon_key', 30)->nullable();
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->boolean('is_published')->default(true)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('impact_stats');
    }
};
