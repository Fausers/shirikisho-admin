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
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('full_name');
                $table->string('email')->unique()->nullable();
                $table->string('phone_number')->unique();
                $table->string('gender')->nullable();
                // 1 = active, 2 = inactive
                $table->integer('status')->default(1);
                // 1 = unverified, 2 = verified
                $table->integer('uniform_status')->default(1);
                $table->string('profile_image')->nullable();
                $table->string('license_number');
                $table->string('marital_status')->nullable();
                $table->date('dob')->nullable();
                $table->string('residence_address')->nullable();
                $table->string('password');
                // for mobile driver
                $table->integer('role')->default(2);
                $table->timestamp('email_verified_at')->nullable();
                $table->rememberToken();
                $table->unsignedInteger('parking_id')->nullable();
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
        Schema::dropIfExists('users');
    }
};

