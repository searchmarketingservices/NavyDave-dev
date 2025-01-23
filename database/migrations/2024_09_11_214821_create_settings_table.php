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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('app_name', 150)->default('My Application');
            $table->string('logo')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('location', 255)->nullable();
            $table->string('email', 100)->nullable();
            $table->text('footer_description')->nullable();
            $table->text('copyright')->nullable();
            $table->string('facebook_link')->nullable(); // Social media links
            $table->string('twitter_link')->nullable();
            $table->string('instagram_link')->nullable();
            $table->string('linkedin_link')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
