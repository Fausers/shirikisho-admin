<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class AddVehicleInsuranceAndDriverIdToUserVehicleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_vehicle', function (Blueprint $table) {
            // Add vehicle_insurance column
            $table->string('vehicle_insurance')->nullable();
            
            // Add driver_id column as foreign key referencing users table
            $table->string('driver_id')->unique()
                  ->nullable();
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
            // Drop vehicle_insurance column
            $table->dropColumn('vehicle_insurance');
            
            // Drop driver_id foreign key constraint
            $table->dropForeign(['driver_id']);
        });
    }
};