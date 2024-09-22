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
        Schema::create('literatures', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('ref_info')->nullable(); // Referans Bilgi
            $table->string('link')->nullable(); // Link
            $table->string('isbn')->nullable(); // ISBN No
            $table->unsignedBigInteger('artifact_id')->nullable();
            $table->foreign('artifact_id')->references('id')->on('artifacts')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('literatures');
    }
};
