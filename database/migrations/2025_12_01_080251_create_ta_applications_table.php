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
        Schema::create('ta_applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ta_position_id');
            $table->unsignedBigInteger('user_id'); // TA who applied
            $table->text('message')->nullable(); // Optional application message
            $table->string('status')->default('pending'); // pending, accepted, rejected
            $table->timestamps();

            $table->foreign('ta_position_id')->references('id')->on('t_a_positions')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Prevent duplicate applications
            $table->unique(['ta_position_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ta_applications');
    }
};
