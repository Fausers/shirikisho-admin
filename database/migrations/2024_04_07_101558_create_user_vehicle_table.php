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
        Schema::create('user_vehicle', function (Blueprint $table) {
            $table->id();
            $table->string('vehicle_type');
            $table->string('vehicle_number');
            $table->string('ownership');
            $table->string('vehicle_owner_name')->nullable();
            $table->string('vehicle_owner_phone')->unique()->nullable();
            $table->foreignId('user_id')->constrained('users');
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
        Schema::dropIfExists('user_vehicle');
    }
};
