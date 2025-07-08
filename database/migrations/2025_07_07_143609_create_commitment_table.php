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
        Schema::create('commitment', function (Blueprint $table) {
            $table->id();
            $table->string('npk');
            $table->string('name');
            $table->string('dept');
            $table->string('position');
            $table->date('date');
            $table->date('joining_date');
            $table->string('document_name')->nullable();
            $table->string('original_name')->nullable();
            $table->longText('base64')->nullable();
            $table->string('void')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commitment');
    }
};
