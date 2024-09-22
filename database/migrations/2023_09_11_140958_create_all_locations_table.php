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

        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(); // İsim
            $table->string('whg_pid')->nullable(); // World Historical Gazetteer Place ID, Konum Veriyor
            $table->decimal('lon', 10, 7)->unsigned()->nullable(); // Longitude
            $table->decimal('lat', 10, 7)->unsigned()->nullable(); // Latitude
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('authors', function (Blueprint $table) {
            $table->dropColumn('birth_place');
            $table->dropColumn('death_place');
            $table->unsignedBigInteger('birth_location_id')->nullable();
            $table->foreign('birth_location_id')->references('id')->on('locations')->cascadeOnDelete();
            $table->unsignedBigInteger('death_location_id')->nullable();
            $table->foreign('death_location_id')->references('id')->on('locations')->cascadeOnDelete();
        });
        Schema::table('artifacts', function (Blueprint $table) {
            $table->dropColumn('writing_place');
            $table->unsignedBigInteger('writing_location_id')->nullable();
            $table->foreign('writing_location_id')->references('id')->on('locations')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');

        Schema::table('authors', function (Blueprint $table) {
            $table->string('birth_place')->nullable();
            $table->string('death_place')->nullable();
            $table->dropColumn('birth_location_id');
            $table->dropColumn('death_location_id');
        });

        Schema::table('artifacts', function (Blueprint $table) {
            $table->string('writing_place')->nullable();
            $table->dropColumn('writing_location_id');
        });
    }
};
