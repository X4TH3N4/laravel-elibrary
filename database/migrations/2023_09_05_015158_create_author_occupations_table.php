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
        Schema::create('author_occupations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->references('id')->on('authors')->onDelete('cascade');
            $table->foreignId('occupation_id')->references('id')->on('occupations')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('author_occupations');
    }
};
