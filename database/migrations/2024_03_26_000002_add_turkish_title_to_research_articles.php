<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('research_articles', function (Blueprint $table) {
            $table->string('turkish_title', 500)->nullable()->after('title');
        });
    }

    public function down(): void
    {
        Schema::table('research_articles', function (Blueprint $table) {
            $table->dropColumn('turkish_title');
        });
    }
};
