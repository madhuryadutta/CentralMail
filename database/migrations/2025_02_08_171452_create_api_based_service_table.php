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
        Schema::create('api_based_service', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // Service name (e.g., SendGrid, Twilio, etc wil be avail from code side)
            $table->string('name')->unique();
            $table->string('base_url'); // API Base URL
            $table->string('api_key'); // API Key
            $table->string('auth_method')->default('key'); // Auth type: key, token, basic
            $table->integer('daily_limit')->nullable(); // Max requests per day
            $table->integer('monthly_limit')->nullable(); // Max requests per month
            $table->integer('daily_usage')->default(0); // Requests made today
            $table->integer('monthly_usage')->default(0); // Requests made this month
            $table->json('extra_data')->nullable(); // Store extra service-specific settings
            $table->boolean('is_active')->default(true); // Service status
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_based_service');
    }
};
