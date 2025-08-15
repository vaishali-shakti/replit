<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('dob')->nullable()->after('name'); // Date of Birth
            $table->string('time_of_birth')->nullable()->after('dob'); // Time of birth
            $table->string('place_of_birth')->nullable()->after('time_of_birth'); // Place of birth
            $table->string('mobile_number_2')->nullable()->after('mobile_number_1'); // Mobile number 2
            $table->string('discomfort')->nullable()->after('email'); // Discomfort
            $table->string('image')->nullable()->after('discomfort'); // Photo file path (for uploaded image)
            $table->string('conpassword')->nullable()->after('password');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'dob',
                'time_of_birth',
                'place_of_birth',
                'mobile_number_1',
                'mobile_number_2',
                'discomfort',
                'photo',
                'status',
                'last_login_at',
            ]);
        });
    }
}
