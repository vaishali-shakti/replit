<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSpecialMusicToSubcategoryTable extends Migration
{
    public function up()
    {
        Schema::table('subcategory', function (Blueprint $table) {
            $table->text('special_music')->after('description');
        });
    }

    public function down()
    {
        Schema::table('subcategory', function (Blueprint $table) {
            $table->dropColumn('special_music');
        });
    }
}
