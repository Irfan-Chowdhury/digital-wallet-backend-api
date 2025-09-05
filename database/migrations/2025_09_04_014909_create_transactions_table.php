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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_id'); //new
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('from');
            $table->string('to');
            $table->decimal('amount', 10, 2)->nullable()->default(50.00);
            $table->string('type');
            $table->string('status');

            $table->timestamps();

            $table->foreign('wallet_id')->references('id')->on('wallets')->onDelete('cascade');
            // $table->foreign('to')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign('transactions_wallet_id_foreign');
            $table->dropForeign('transactions_user_id_foreign');
            // $table->dropForeign('transactions_to_foreign');
            $table->dropIfExists();
        });
    }
};
