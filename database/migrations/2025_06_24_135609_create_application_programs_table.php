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
        Schema::create('application_programs', function (Blueprint $table) {
            $table->id();
            $table->string('id_request_access');
            $table->string('application_name');
            $table->string('login_name');
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
        Schema::dropIfExists('application_programs');
    }
};
