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
        Schema::table('drugs', function (Blueprint $table) {
            $table->text('description_original')->nullable()->after('brand_name');
            $table->text('description_tr')->nullable()->after('description_original');
            $table->longText('ai_summary')->nullable()->after('description_tr');
            $table->boolean('is_approved_fda')->default(false)->after('ai_summary');
            $table->boolean('is_approved_ema')->default(false)->after('is_approved_fda');
            $table->boolean('is_approved_titck')->default(false)->after('is_approved_ema');
            $table->timestamp('last_verified_at')->nullable()->after('is_approved_titck');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('drugs', function (Blueprint $table) {
            $table->dropColumn(['description_original', 'description_tr', 'ai_summary', 'is_approved_fda', 'is_approved_ema', 'is_approved_titck', 'last_verified_at']);
        });
    }
};
