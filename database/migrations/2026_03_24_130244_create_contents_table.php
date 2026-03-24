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
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // publication, trial, drug, article
            $table->foreignId('source_id')->nullable()->constrained('sources')->onDelete('set null');
            $table->string('source_name')->nullable();
            $table->string('source_url')->nullable();
            $table->string('original_title');
            $table->text('original_summary')->nullable();
            $table->longText('original_content')->nullable();
            $table->string('translated_title')->nullable();
            $table->text('translated_summary')->nullable();
            $table->longText('translated_content')->nullable();
            $table->string('language')->default('en');
            $table->string('status')->default('draft'); // draft, review, published, archived
            $table->timestamp('published_at')->nullable();
            $table->timestamp('source_published_at')->nullable();
            $table->string('external_id')->unique()->nullable();
            $table->json('raw_payload_json')->nullable();
            $table->string('slug')->unique();
            $table->string('author')->nullable(); // source organization
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};
