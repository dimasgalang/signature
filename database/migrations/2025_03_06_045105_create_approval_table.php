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
        Schema::create('approval', function (Blueprint $table) {
            $table->id();
            $table->string('preparer_id');
            $table->string('document_name');
            $table->string('original_name');
            $table->longText('base64');
            $table->string('approval_id');
            $table->string('type');
            $table->integer('approval_level');
            $table->date('approval_date')->nullable();
            $table->string('approval_progress');
            $table->string('document_approve')->nullable();
            $table->longText('approval_base64')->nullable();
            $table->string('status');
            $table->string('stamp');
            $table->string('document_stamp')->nullable();
            $table->longText('stamp_base64')->nullable();
            $table->text('comment')->nullable();
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
        Schema::dropIfExists('approval');
    }
};
