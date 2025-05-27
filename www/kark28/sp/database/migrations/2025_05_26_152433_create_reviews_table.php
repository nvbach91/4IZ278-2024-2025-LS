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
    Schema::create('reviews', function (Blueprint $table) {
        $table->string('user_id');
        $table->unsignedBigInteger('business_id');
        $table->integer('rating');
        $table->text('comment')->nullable();
        $table->timestamps();

        $table->primary(['user_id', 'business_id']);
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('business_id')->references('id')->on('businesses')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
