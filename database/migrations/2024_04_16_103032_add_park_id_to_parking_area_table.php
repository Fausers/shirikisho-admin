<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddParkIdToParkingAreaTable extends Migration
{
    public function up()
    {
        Schema::table('parking_area', function (Blueprint $table) {
            $table->string('park_id', 225)->after('id')->unique()->nullable();
        });
    }

    public function down()
    {
        Schema::table('parking_area', function (Blueprint $table) {
            $table->dropColumn('park_id');
        });
    }
};
