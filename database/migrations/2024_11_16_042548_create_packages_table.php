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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->integer('cat_id')->nullable();
            $table->integer('sub_cat_id')->nullable();
            $table->string('name')->nullable();
            $table->integer('times_day')->nullable();
            $table->integer('days')->nullable();
            $table->integer('cost')->nullable();
            $table->integer('cost_usd')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
