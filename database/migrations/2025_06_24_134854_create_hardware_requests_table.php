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
        Schema::create('hardware_requests', function (Blueprint $table) {
            $table->id();
            $table->string('id_request_access');
            $table->string('hardware_device');
            $table->string('qty');
            $table->string('status_approved')->nullable();
            $table->string('void')->default('false');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hardware_requests');
    }
};
