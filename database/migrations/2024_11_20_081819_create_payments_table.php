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
            $table->integer('user_id');
            $table->integer('package_id');
            $table->string('receipt_no')->nullable();
            $table->integer('amount')->nullable();
            $table->integer('payment_status')->default(0)->comment("0 = Pending, 1 = Completed");
            $table->string('order_id')->nullable();
            $table->string('payment_id')->nullable();
            $table->string('payment_date')->nullable();
            $table->datetime('active_until')->nullable();
            $table->string('currency')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
