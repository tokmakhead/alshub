<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Expert Centers (Hospitals, Research Inst.)
        Schema::create('expert_centers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('location_city')->nullable();
            $table->string('location_country')->nullable();
            $table->string('website_url')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->string('logo_path')->nullable();
            $table->json('raw_metadata_json')->nullable();
            $table->timestamps();
        });

        // 2. Doctors / Researchers
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('expert_center_id')->nullable()->constrained('expert_centers')->onDelete('set null');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('slug')->unique();
            $table->string('title')->nullable(); // Prof, Dr, Assoc Prof
            $table->string('specialty')->nullable();
            $table->text('biography')->nullable();
            $table->string('orcid_id')->nullable()->unique();
            $table->string('researchgate_url')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->string('profile_image_path')->nullable();
            $table->timestamps();
        });

        // 3. Polymorphic linking many-to-many (Articles/Trials related to Centers/Doctors)
        Schema::create('expert_relations', function (Blueprint $table) {
            $table->id();
            $table->morphs('expertizable'); // Doctor or ExpertCenter
            $table->morphs('contentable'); // ResearchArticle or ClinicalTrial
            $table->string('role')->nullable(); // Author, Principal Investigator, Location
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('expert_relations');
        Schema::dropIfExists('doctors');
        Schema::dropIfExists('expert_centers');
    }
};
