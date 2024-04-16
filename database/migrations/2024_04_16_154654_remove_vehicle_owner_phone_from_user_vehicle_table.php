<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveVehicleOwnerPhoneFromUserVehicleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_vehicle', function (Blueprint $table) {
            $table->dropColumn('vehicle_owner_phone');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_vehicle', function (Blueprint $table) {
            $table->string('vehicle_owner_phone')->nullable();
        });
    }
};
