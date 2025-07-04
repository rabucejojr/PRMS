<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('press_releases', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained()->after('id');
        });

        // Backfill with the first user
        $firstUser = DB::table('users')->orderBy('id')->first();
        if ($firstUser) {
            DB::table('press_releases')->update(['user_id' => $firstUser->id]);
        }

        // Now make user_id not nullable
        Schema::table('press_releases', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('press_releases', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
