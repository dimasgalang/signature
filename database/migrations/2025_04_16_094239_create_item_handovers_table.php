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
        Schema::create('item_handovers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('handover_id')->constrained('handovers')->onDelete('cascade');
            $table->string('item_id')->nullable();
            $table->string('item_details')->nullable();
            $table->string('serial_number')->nullable();
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_handovers');
    }
};
