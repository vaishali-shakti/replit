<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOriginalImageToSubcategoryTable extends Migration
{
    public function up(): void
    {
        Schema::table('subcategory', function (Blueprint $table) {
            $table->string('original_image')->nullable()->after('image');
        });
    }

    public function down(): void
    {
        Schema::table('subcategory', function (Blueprint $table) {
            $table->dropColumn('original_image');
        });
    }
}
