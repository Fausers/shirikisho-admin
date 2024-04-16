<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddParkIdToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('park_id')->nullable();
            $table->string('chama_id')->nullable();
            // If you want to make 'parking_id' a foreign key referencing the 'id' column of a 'parkings' table:
            // $table->foreign('parking_id')->references('id')->on('parkings')->onDelete('set null');
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
            $table->dropColumn('park_id','chama_id');
        });
    }
}
