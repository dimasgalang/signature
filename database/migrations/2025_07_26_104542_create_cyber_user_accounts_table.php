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
        Schema::create('cyber_user_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('deactivation_request_id');
            $table->date('date_of_request');
            $table->string('approval_id');
            $table->string('preparer_id');
            $table->string('approval_level');
            $table->string('approval_progress');
            $table->string('approval_date')->nullable();
            $table->string('token')->nullable();
            $table->string('document_name');
            $table->string('original_name')->nullable();
            $table->string('deactivate')->nullable();
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->string('reason_id')->nullable();
            $table->string('employee_id')->nullable();
            $table->string('comment')->nullable();
            $table->string('status')->nullable();
            $table->string('void')->default('false');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cyber_user_accounts');
    }
};
