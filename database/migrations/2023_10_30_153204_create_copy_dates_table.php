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
        Schema::create('copy_dates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('copy_id')->nullable();
            $table->unsignedBigInteger('date_id')->nullable();
            $table->foreign('copy_id')->references('id')->on('copies')->nullOnDelete();
            $table->foreign('date_id')->references('id')->on('dates')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('copy_dates');
    }
};
