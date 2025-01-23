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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('staff_id');
            $table->unsignedBigInteger('slot_id');
            $table->date('appointment_date');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('location')->nullable();
            $table->decimal('price', 8, 2);
            $table->enum('status', ['pending', 'confirmed', 'completed', 'canceled','awaiting_next_slot','fully_completed'])->default('confirmed');
            $table->text('note')->nullable();
            $table->timestamps();

            $table->index(['appointment_date', 'service_id', 'staff_id', 'slot_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
