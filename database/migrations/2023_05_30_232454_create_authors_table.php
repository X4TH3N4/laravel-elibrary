<?php

use App\Models\Author;
use App\Models\Date;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function     up(): void
    {
        Schema::create('authors', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->nullable(); // Ad
            $table->text('author_info')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('birth_place')->nullable();
            $table->date('death_date')->nullable();
            $table->string('death_place')->nullable();
            $table->enum('date_type', Date::$date_types)->nullable();
            $table->string('slug')->unique()->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('authors');
    }
};
