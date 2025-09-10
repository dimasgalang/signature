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
        Schema::create('purchase_requestions', function (Blueprint $table) {
            $table->id();
            $table->string('purchase_requestion_number');
            $table->string('requestion');
            $table->string('employee_id');
            $table->date('date_of_request');
            $table->string('nm_barang');
            $table->string('qty');
            $table->string('supplier')->nullable();
            $table->string('status_code'); // Status Code waiting: 01, process: 02, partially: 03, canceled: 04, finished: 05
            $table->enum('status', ['waiting', 'process', 'partially', 'canceled', 'finished']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_requestions');
    }
};
