<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('guidelines', function (Blueprint $table) {
            $table->string('title_tr')->nullable()->after('title');
        });
    }

    public function down()
    {
        Schema::table('guidelines', function (Blueprint $table) {
            $table->dropColumn('title_tr');
        });
    }
};
