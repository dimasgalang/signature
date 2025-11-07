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
        Schema::create('computer_inspections', function (Blueprint $table) {
            $table->id();
            $table->string('computer_inspection_id');
            $table->string('assets_number');
            $table->string('user')->nullable();
            $table->string('device_name')->nullable();
            $table->string('location')->nullable();
            $table->string('person_in_charge')->nullable();
            $table->date('date_of_inspection')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('computer_inspections');
    }
};
