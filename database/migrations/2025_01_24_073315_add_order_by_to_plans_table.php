<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // In the migration file (e.g. add_order_by_to_plans_table.php)
    public function up()
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->integer('order_by')->nullable()->after('cost_euro');  // Add after 'status'
        });
    }

    public function down()
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn('order_by');
        });
    }

};
