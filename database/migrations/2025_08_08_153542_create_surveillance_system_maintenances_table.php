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
        Schema::create('surveillance_system_maintenances', function (Blueprint $table) {
            $table->id();
            $table->string('surveillance_system_maintenance_id');
            $table->date('date_of_maintenance');
            $table->string('number_of_camera');
            $table->string('number_of_server');
            $table->string('approval_id');
            $table->string('preparer_id');
            $table->string('approval_level');
            $table->string('approval_progress');
            $table->string('approval_date')->nullable();
            $table->string('token')->nullable();
            $table->string('document_name');
            $table->string('status')->default('pending');
            $table->string('void')->default('false');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surveillance_system_maintenances');
    }
};
