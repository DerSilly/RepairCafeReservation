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
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('phone_number')->nullable();
            $table->text('note')->nullable();
        });

        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('phone_number');
            $table->string('email');
            $table->timestamps();
        });

        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->foreignId('location_id')->constrained('locations');
            $table->text('note')->nullable();
            $table->timestamps();
        });

        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('kind_product');
            $table->string('category');
            $table->string('brand');
            $table->string('product_build_year');
            $table->string('model');
            $table->string('cause_of_fault');
            $table->timestamps();
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->timestamps();
        });

        Schema::create('repair_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('repairer_id')->constrained('users');
            $table->foreignId('device_id')->constrained('devices');
            $table->foreignId('appointment_id')->constrained('appointments');
            $table->date('repair_date');
            $table->string('fault');
            $table->string('solution');
            $table->string('repairability');
            $table->string('repair_failed_reason')->nullable();
            $table->text('advice')->nullable();
            $table->string('repair_source')->nullable();
            $table->text('hint')->nullable();
            $table->timestamps();
        });

        Schema::create('device_appointment_assignments', function (Blueprint $table) {
            $table->foreignId('device_id')->constrained('devices');
            $table->foreignId('appointment_id')->constrained('appointments');
            $table->primary(['device_id', 'appointment_id']);
            $table->timestamps();
        });

        Schema::create('user_appointment_assignments', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('appointment_id')->constrained('appointments');
            $table->primary(['user_id', 'appointment_id']);
            $table->timestamps();
        });

        Schema::create('user_role_assignments', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('role_id')->constrained('roles');
            $table->primary(['user_id', 'role_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('phone_number');
            $table->dropColumn('note');
        });

        Schema::dropIfExists('locations');

        Schema::dropIfExists('appointments');

        Schema::dropIfExists('devices');

        Schema::dropIfExists('roles');

        Schema::dropIfExists('repair_details');

        Schema::dropIfExists('device_appointment_assignments');

        Schema::dropIfExists('user_appointment_assignments');

        Schema::dropIfExists('user_role_assignments');
    }
};
