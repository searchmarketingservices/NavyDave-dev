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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('name');
            $table->integer('category_id');
            $table->double('price');
            $table->integer('duration');
            $table->string('type_duration')->enum(['mins', 'hours' ,'days']);
            $table->integer('buffer_time_before')->nullable();
            $table->string('type_buffer_time_before')->enum(['mins', 'hours']);
            $table->integer('buffer_time_after')->nullable();
            $table->string('type_buffer_time_after')->enum(['mins', 'hours']);
            $table->integer('min_capacity');
            $table->integer('max_capacity');
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
