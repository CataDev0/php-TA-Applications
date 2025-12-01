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
        Schema::create('t_a_positions', function (Blueprint $table) {
            $table->id();
            $table->string('emne'); // Subject/course name
            $table->text('description')->nullable();
            $table->integer('positions_available')->default(1); // Number of TA positions
            $table->string('status')->default('open'); // open, closed
            $table->unsignedBigInteger('created_by'); // Teacher who created it
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_a_positions');
    }
};
