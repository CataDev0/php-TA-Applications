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
        Schema::create('ta_emner', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // TA
            $table->string('emne'); // Subject name
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Prevent duplicate assignments
            $table->unique(['user_id', 'emne']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ta_emner');
    }
};

