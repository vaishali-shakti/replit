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
        Schema::create('main_category', function (Blueprint $table) {
            $table->id();
            $table->integer('super_cat_id');
            $table->string('name');
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->string('slug_name')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('keyword')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('canonical')->nullable();
            $table->integer('special_music')->nullable()->default(0)->comment("0 = No, 1 = Yes");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('main_category');
    }
};
