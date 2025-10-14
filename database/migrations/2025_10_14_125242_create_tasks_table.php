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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('date_time')->nullable();
            $table->string('urgency')->nullable();
            $table->string('status')->default('pending');
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('ta_id')->nullable();
            $table->timestamps();
    
            $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('ta_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
