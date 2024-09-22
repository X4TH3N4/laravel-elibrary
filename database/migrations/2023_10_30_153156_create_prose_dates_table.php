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
        Schema::create('prose_dates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prose_id')->nullable();
            $table->unsignedBigInteger('date_id')->nullable();
            $table->foreign('prose_id')->references('id')->on('proses')->nullOnDelete();
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
        Schema::dropIfExists('prose_dates');
    }
};
