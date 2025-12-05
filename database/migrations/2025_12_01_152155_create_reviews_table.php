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
            $table->id();

            $table->foreignId('reviewer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('reviewed_user_id')->references('id')->on('users')->onDelete('cascade');

            $table->foreignId('travel_plan_id')->constrained()->onDelete('cascade');

            $table->integer('rating');
            $table->text('comment')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['reviewer_id']);
            $table->dropForeign(['reviewed_user_id']);
        });

        Schema::dropIfExists('reviews');
    }
};
