<?php

use App\Models\Date;
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
        Schema::create('dates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('day')->nullable();
            $table->unsignedBigInteger('month')->nullable();
            $table->bigInteger('year')->nullable();
            $table->enum('type', Date::$date_types)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('authors', function (Blueprint $table) {
            $table->dropColumn('birth_date');
            $table->dropColumn('death_date');
            $table->dropColumn('date_type');
            $table->unsignedBigInteger('birth_date_id')->nullable();
            $table->unsignedBigInteger('death_date_id')->nullable();

            $table->foreign('birth_date_id')->references('id')->on('dates')->onDelete('cascade');
            $table->foreign('death_date_id')->references('id')->on('dates')->onDelete('cascade');

        });

        Schema::table('artifacts', function (Blueprint $table) {
            $table->dropColumn('date_type');
            $table->dropColumn('writing_date');

            $table->unsignedBigInteger('writing_date_id')->nullable();
            $table->foreign('writing_date_id')->references('id')->on('dates')->onDelete('cascade');

        });

        Schema::table('copies', function (Blueprint $table) {
            $table->unsignedBigInteger('istinsah_date_id')->nullable();
            $table->foreign('istinsah_date_id')->references('id')->on('dates')->onDelete('cascade');

        });
        Schema::table('proses', function (Blueprint $table) {
            $table->unsignedBigInteger('publication_date_id')->nullable();
            $table->foreign('publication_date_id')->references('id')->on('dates')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dates');

        Schema::table('authors', function (Blueprint $table) {
            $table->date('birth_date')->nullable();
            $table->date('death_date')->nullable();
            $table->enum('date_type', Date::$date_types)->nullable();

            $table->dropColumn('birth_date_id');
            $table->dropColumn('death_date_id');
        });

        Schema::table('artifacts', function (Blueprint $table) {

            $table->date('writing_date')->nullable();
            $table->enum('date_type', Date::$date_types)->nullable();

            $table->dropColumn('writing_date_id');
        });

        Schema::table('copies', function (Blueprint $table) {
            $table->dropColumn('istinsah_date_id')->nullable();
        });
        Schema::table('proses', function (Blueprint $table) {
            $table->dropColumn('publication_date_id')->nullable();
        });

    }
};
