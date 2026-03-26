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
        Schema::table('clinical_trials', function (Blueprint $row) {
            $row->string('title_tr')->nullable()->after('title');
            $row->longText('summary_tr')->nullable()->after('summary');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clinical_trials', function (Blueprint $row) {
            $row->dropColumn(['title_tr', 'summary_tr']);
        });
    }
};
