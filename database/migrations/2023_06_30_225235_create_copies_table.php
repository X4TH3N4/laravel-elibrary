<?php

use App\Enums\CopyEnum\TypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \App\Models\Copy;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('copies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('library')->nullable(); //Kütüphane
            $table->string('collection')->nullable(); // Koleksiyon
            $table->string('number')->nullable(); // Numara
            $table->string('procure')->nullable(); // Temin
            $table->string('width')->nullable(); // En | Genişlik
            $table->string('height')->nullable(); // Boy | Uzunluk
            $table->string('page_count')->nullable(); // Varak No
            $table->enum('font', Copy::$fonts)->nullable(); // Yazım Türü {Sülüs | Nesih | Rika | Talik} BU SATIR YENİ EKLENDİ
            $table->text('info')->nullable(); // nüsha hakkında büyük bilgi
            $table->unsignedBigInteger('artifact_id')->nullable();
            $table->foreign('artifact_id')->references('id')->on('artifacts')->nullOnDelete();
            $table->string('is_draft')->nullable(); // Varak No
            $table->string('slug')->unique()->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('copies');
    }
};
