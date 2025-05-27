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
    Schema::create('timeslots', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('service_id')->nullable();
        $table->string('provider_id')->nullable();
        $table->dateTime('start_time');
        $table->dateTime('end_time');
        $table->boolean('available')->nullable();
        $table->timestamps();

        $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
        $table->foreign('provider_id')->references('id')->on('users')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timeslots');
    }
};
