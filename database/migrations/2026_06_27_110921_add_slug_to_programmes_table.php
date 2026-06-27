<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('programmes', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('title');
        });

        $taken = [];
        foreach (DB::table('programmes')->orderBy('id')->get(['id', 'title']) as $row) {
            $base = Str::slug($row->title) ?: 'programme';
            $slug = $base;
            $n    = 2;
            while (in_array($slug, $taken, true)) {
                $slug = "{$base}-{$n}";
                $n++;
            }
            $taken[] = $slug;
            DB::table('programmes')->where('id', $row->id)->update(['slug' => $slug]);
        }
    }

    public function down(): void
    {
        Schema::table('programmes', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn('slug');
        });
    }
};
