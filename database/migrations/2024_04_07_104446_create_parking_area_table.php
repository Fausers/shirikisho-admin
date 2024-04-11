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
        Schema::create('parking_area', function (Blueprint $table) {
            $table->id();
            $table->foreignId('region_id')->constrained('region');
            $table->foreignId('district_id')->constrained('district');
            $table->foreignId('ward_id')->constrained('ward');
            $table->string('park_name');
            $table->integer('number_of_members');
            $table->string('park_owner');
            $table->string('vehicle_type');
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();
            $table->unsignedInteger('archive')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parking_area');
    }
};
