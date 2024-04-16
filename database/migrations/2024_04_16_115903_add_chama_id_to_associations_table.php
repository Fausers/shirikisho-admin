<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddChamaIdToAssociationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('associations', function (Blueprint $table) {
            // Add chama_id column as foreign key referencing associations table
            $table->string('chama_id')->unique()->after('id')
                  ->nullable(); // Place the new column after the id column
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('associations', function (Blueprint $table) {
            // Drop chama_id foreign key constraint
            
            // Drop chama_id column
            $table->dropColumn('chama_id');
        });
    }
};
