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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('plan_booking_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('provider'); // stripe, paypal
            $table->string('provider_charge_id')->nullable();

            $table->integer('amount');
            $table->string('currency');

            $table->enum('status', ['pending', 'succeeded', 'failed', 'refunded'])
                  ->default('pending');

            $table->string('payment_method')->nullable();

            $table->json('meta')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['plan_booking_id']);
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('payments');
    }
};
