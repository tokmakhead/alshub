<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('source_registry', function (Blueprint $table) {
            $table->integer('verification_tier')->default(1)->after('source_mode');
        });
    }

    public function down(): void
    {
        Schema::table('source_registry', function (Blueprint $table) {
            $table->dropColumn('verification_tier');
        });
    }
};
