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
        Schema::create('file_folder_accesses', function (Blueprint $table) {
            $table->id();
            $table->string('id_request_access');
            $table->string('file_folder_name');
            $table->string('read')->default('false');
            $table->string('write')->default('false');
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
        Schema::dropIfExists('file_folder_accesses');
    }
};
