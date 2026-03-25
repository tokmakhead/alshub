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
        // 1. Source Registry
        Schema::create('source_registry', function (Blueprint $table) {
            $table->id();
            $table->string('source_name');
            $table->string('source_mode'); // api, web_ingest, manual
            $table->boolean('is_enabled')->default(true);
            $table->json('config_json')->nullable();
            $table->timestamp('last_successful_sync')->nullable();
            $table->timestamp('last_failed_sync')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 2. Ingestion Logs
        Schema::create('ingestion_logs', function (Blueprint $table) {
            $table->id();
            $table->string('source_name');
            $table->string('content_type');
            $table->string('run_identifier')->nullable();
            $table->integer('fetched_count')->default(0);
            $table->integer('inserted_count')->default(0);
            $table->integer('updated_count')->default(0);
            $table->integer('failed_count')->default(0);
            $table->string('status'); // started, success, partial, failed
            $table->text('error_message')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->timestamps();
        });

        // 3. Research Articles
        Schema::create('research_articles', function (Blueprint $table) {
            $table->id();
            $table->string('pmid')->unique();
            $table->string('doi')->nullable()->index();
            $table->text('title');
            $table->longText('abstract_original')->nullable();
            $table->longText('abstract_tr')->nullable();
            $table->string('journal')->nullable();
            $table->json('authors_json')->nullable();
            $table->date('publication_date')->nullable();
            $table->string('source_url')->nullable();
            $table->json('raw_payload_json')->nullable();
            $table->integer('verification_tier')->default(1);
            $table->string('status')->default('draft'); // draft, in_review, approved, rejected, published
            $table->timestamp('fetched_at')->nullable();
            $table->timestamp('last_verified_at')->nullable();
            $table->timestamps();
        });

        // 4. Clinical Trials
        Schema::create('clinical_trials', function (Blueprint $table) {
            $table->id();
            $table->string('nct_id')->unique();
            $table->text('title');
            $table->longText('summary')->nullable();
            $table->string('phase')->nullable();
            $table->string('recruitment_status')->nullable();
            $table->string('sponsor')->nullable();
            $table->text('intervention')->nullable();
            $table->json('countries_json')->nullable();
            $table->json('locations_json')->nullable();
            $table->string('source_url')->nullable();
            $table->json('raw_payload_json')->nullable();
            $table->integer('verification_tier')->default(1);
            $table->string('status')->default('draft');
            $table->timestamp('fetched_at')->nullable();
            $table->timestamp('last_verified_at')->nullable();
            $table->timestamps();
        });

        // 5. Drugs
        Schema::create('drugs', function (Blueprint $table) {
            $table->id();
            $table->string('generic_name');
            $table->string('brand_name')->nullable();
            $table->string('slug')->unique();
            $table->string('source_name')->nullable();
            $table->integer('verification_tier')->default(1);
            $table->string('status')->default('draft');
            $table->timestamps();
        });

        // 6. Drug Regional Statuses
        Schema::create('drug_regional_statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('drug_id')->constrained()->onDelete('cascade');
            $table->string('region'); // US, EU, etc.
            $table->string('regulator_name')->nullable(); // FDA, EMA
            $table->string('external_id')->nullable();
            $table->text('indication')->nullable();
            $table->string('approval_status')->nullable();
            $table->date('approval_date')->nullable();
            $table->string('label_url')->nullable();
            $table->boolean('change_detected')->default(false);
            $table->json('raw_payload_json')->nullable();
            $table->timestamp('fetched_at')->nullable();
            $table->timestamp('last_verified_at')->nullable();
            $table->timestamps();
        });

        // 7. Review Decision Logs
        Schema::create('review_decision_logs', function (Blueprint $table) {
            $table->id();
            $table->string('content_type'); // research, trial, drug, etc.
            $table->unsignedBigInteger('content_id');
            $table->string('decision'); // approved, rejected
            $table->unsignedBigInteger('reviewer_id');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_decision_logs');
        Schema::dropIfExists('drug_regional_statuses');
        Schema::dropIfExists('drugs');
        Schema::dropIfExists('clinical_trials');
        Schema::dropIfExists('research_articles');
        Schema::dropIfExists('ingestion_logs');
        Schema::dropIfExists('source_registry');
    }
};
