<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAssociationIdAndHealthInsuranceToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Add association_id column as foreign key referencing associations table
            $table->foreignId('association_id')
                  ->nullable()
                  ->constrained('associations');

            // Add health_insurance column
            $table->string('health_insurance')->nullable()->after('association_id');
            $table->string('chama_id')->nullable()->unique();
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
            // Drop association_id foreign key constraint
            $table->dropForeign(['association_id']);

            // Drop association_id and health_insurance columns
            $table->dropColumn(['association_id', 'health_insurance','chama_id']);
        });
    }
};
