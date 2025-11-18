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
        Schema::create('finger_inspections', function (Blueprint $table) {
            $table->id();
            $table->string('finger_inspection_id');
            $table->string('machine_number')->nullable();
            $table->string('person_in_charge')->nullable();
            $table->date('date_of_inspection')->nullable();
            $table->string('void')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finger_inspections');
    }
};
