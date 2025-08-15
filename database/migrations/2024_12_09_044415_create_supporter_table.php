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
        Schema::create('supporter', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('msg_status')->default(0)->comment('1 = close query , 2 = active');
            $table->string('ticket_no')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supporter');
    }
};
