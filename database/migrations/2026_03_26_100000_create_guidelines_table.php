<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('guidelines', function (Blueprint $table) {
            $table->id();
            $table->string('source_org'); // NICE, AAN, EAN, etc.
            $table->string('external_id')->nullable()->unique();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('summary_original')->nullable();
            $table->text('summary_tr')->nullable(); // AI Translated/Simplified
            $table->text('full_text_html')->nullable();
            $table->string('pdf_url')->nullable();
            $table->string('source_url')->nullable();
            $table->date('publication_date')->nullable();
            $table->date('last_updated_at')->nullable();
            $table->enum('status', ['draft', 'in_review', 'approved', 'rejected', 'published'])->default('draft');
            $table->integer('verification_tier')->default(1); // Guidelines are Tier 1 by default
            $table->json('raw_payload_json')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('guidelines');
    }
};
