<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('associations')) {
            Schema::create('associations', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->foreignId('region_id')->constrained('region');
                $table->foreignId('district_id')->constrained('district');
                // both in users tables
                $table->foreignId('chairperson_id')->nullable()->constrained('users');
                $table->foreignId('secretary_id')->nullable()->constrained('users');
                $table->foreignId('created_by')->nullable()->constrained('users');
                $table->foreignId('updated_by')->nullable()->constrained('users');
                $table->timestamps();
                $table->unsignedInteger('archive')->default(0);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('associations');
    }
};
