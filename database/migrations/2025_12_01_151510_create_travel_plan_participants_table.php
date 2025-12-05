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
        Schema::create('travel_plan_participants', function (Blueprint $table) {
            $table->id();

            $table->foreignId('travel_plan_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->enum('role', ['host', 'member'])->default('member');
            $table->enum('status', ['approved', 'pending', 'declined'])->default('pending');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('travel_plan_participants', function (Blueprint $table) {
            $table->dropForeign(['travel_plan_id']);
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('travel_plan_participants');
    }
};
