<?php

use App\Enums\ProseEnum\VariationEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \App\Models\Prose;

return new class extends Migration
{
    /**
     * Run the migrations.
     * NEŞİR KISMI BURASI
     */
    public function up(): void
    {
        Schema::create('proses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('source')->nullable(); // Kaynak
            $table->string('isbn')->unique(); // ISBN No
            $table->string('ref_info')->nullable(); // Referans Bilgi
            $table->enum('variation', Prose::$variations)->nullable(); //Çeşit {Arap Alfabesi |  Latinize | Transliterasyon}
            $table->unsignedBigInteger('copy_id')->nullable();
            $table->foreign('copy_id')->references('id')->on('copies')->nullOnDelete();
            $table->boolean('is_draft')->default(true)->nullable();
            $table->string('slug')->unique()->nullable();
            $table->timestamps();
       });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proses');
    }
};
