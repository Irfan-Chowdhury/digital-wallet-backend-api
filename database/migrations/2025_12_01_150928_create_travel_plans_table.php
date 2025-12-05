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
        Schema::create('travel_plans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('destination');
            $table->date('start_date');
            $table->date('end_date');

            $table->integer('budget')->nullable();
            $table->string('travel_type')->nullable();

            $table->json('itinerary')->nullable();
            $table->integer('group_size')->default(1);

            $table->enum('status', ['active', 'completed', 'cancelled'])->default('active');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('travel_plans', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('travel_plans');
    }
};
