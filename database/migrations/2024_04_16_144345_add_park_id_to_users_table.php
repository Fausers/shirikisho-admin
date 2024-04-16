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
                 // Add 'park_id' column if it doesn't already exist
                 if (!Schema::hasColumn('users', 'park_id')) {
                    $table->string('park_id')->nullable();
                }
                // Add 'chama_id' column if it doesn't already exist
                if (!Schema::hasColumn('users', 'chama_id')) {
                    $table->string('chama_id')->nullable();
                }
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
