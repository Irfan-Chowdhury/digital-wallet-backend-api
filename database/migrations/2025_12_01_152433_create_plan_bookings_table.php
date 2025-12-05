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
        Schema::create('plan_bookings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('travel_plan_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->integer('seats')->default(1);
            $table->integer('price_per_seat')->nullable();
            $table->integer('total_amount')->nullable();
            $table->string('currency')->default('USD');

            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending');
            $table->enum('status', ['active', 'cancelled'])->default('active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plan_bookings', function (Blueprint $table) {
            $table->dropForeign(['travel_plan_id']);
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('plan_bookings');
    }
};
