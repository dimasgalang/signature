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
        Schema::create('stampel', function (Blueprint $table) {
            $table->id();
            $table->string('preparer_id');
            $table->string('document_name');
            $table->string('original_name');
            $table->longText('base64');
            $table->string('document_stamp')->nullable();
            $table->longText('stamp_base64')->nullable();
            $table->string('void');
            $table->longText('token');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stampel');
    }
};
