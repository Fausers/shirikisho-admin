<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreatedUserIdToUserOtpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_otp', function (Blueprint $table) {
            $table->foreignId('created_user_id')->nullable()->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_otp', function (Blueprint $table) {
            $table->dropForeign(['created_user_id']);
            $table->dropColumn('created_user_id');
        });
    }
}