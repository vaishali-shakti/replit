<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
    */
    // In the migration file:
    public function up()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->integer('packages_order_by')->nullable()->after('status');  // Add after 'status'
        });
    }

    public function down()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn('packages_order_by');
        });
    }

};
