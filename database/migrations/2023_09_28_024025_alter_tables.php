<?php

use App\Models\Copy;
use App\Models\Date;
use App\Models\Prose;
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
        Schema::table('copies', function (Blueprint $table) {
            $table->string('font')->nullable()->change(); // Yazım Türü {Sülüs | Nesih | Rika | Talik} BU SATIR YENİ EKLENDİ
        });
        Schema::table('proses', function (Blueprint $table) {
            $table->string('variation')->nullable()->change(); //Çeşit {Arap
        });
        Schema::table('dates', function (Blueprint $table) {
            $table->string('type')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('copies', function (Blueprint $table) {
            $table->enum('font', Copy::$fonts)->nullable(); // Yazım Türü {Sülüs | Nesih | Rika | Talik} BU SATIR YENİ EKLENDİ
        });
        Schema::table('proses', function (Blueprint $table) {
            $table->enum('variation', Prose::$variations)->nullable(); //Çeşit {Arap
        });
        Schema::table('dates', function (Blueprint $table) {
            $table->enum('type', Date::$date_types)->nullable();
        });
    }
};
