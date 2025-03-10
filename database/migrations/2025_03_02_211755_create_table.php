<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {

        Schema::create('company_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('email')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('location')->nullable();
            $table->json('banner')->nullable();
            $table->timestamps();
        });

        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('content');
            $table->json('categories');
            $table->json('themes');
            $table->date('registration_start');
            $table->date('registration_end');
            $table->date('event_start');
            $table->date('event_end');
            $table->string('time');
            $table->integer('estimated_visitors')->nullable();
            $table->string('location');
            $table->string('city');
            $table->string('url')->nullable();
            $table->string('detailed_location')->nullable();
            $table->fullText(['name', 'content', 'location', 'city', 'detailed_location'], 'events_fulltext');
            $table->foreignId('company_profile_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('events');
        Schema::dropIfExists('company_profiles');
    }
};
