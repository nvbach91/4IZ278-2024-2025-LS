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
    Schema::create('reservations', function (Blueprint $table) {
        $table->id();
        $table->string('user_id')->nullable(); // matches users.id
        $table->unsignedBigInteger('timeslot_id')->nullable(); // matches timeslots.id
        $table->string('status')->nullable();
        $table->timestamps();

        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('timeslot_id')->references('id')->on('timeslots')->onDelete('cascade');
    });



    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
