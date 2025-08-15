<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appbanner', function (Blueprint $table) {
            $table->id(); // Primary key for the table
            $table->string('title'); // Title field
            $table->string('image'); // Image field (you can store image paths here)
            $table->text('description'); // Description field
            $table->timestamps(); // Created_at and updated_at fields
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appbanner');
    }
}
