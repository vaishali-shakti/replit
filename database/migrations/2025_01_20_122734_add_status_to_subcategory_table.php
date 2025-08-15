<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('subcategory', function (Blueprint $table) {
            // Add the 'status' column after 'payment_type'
            $table->tinyInteger('status')->default(1)->comment('1=Active, 2=Inactive')->after('payment_type');
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('subcategory', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
