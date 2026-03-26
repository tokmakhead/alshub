<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('drugs', function (Blueprint $table) {
            $table->text('indication')->nullable()->after('brand_name');
            $table->string('fda_link')->nullable()->after('is_approved_fda');
            $table->string('ema_link')->nullable()->after('is_approved_ema');
            $table->text('price_info')->nullable();
            $table->text('accessibility_info')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('drugs', function (Blueprint $table) {
            $table->dropColumn(['indication', 'fda_link', 'ema_link', 'price_info', 'accessibility_info']);
        });
    }
};
