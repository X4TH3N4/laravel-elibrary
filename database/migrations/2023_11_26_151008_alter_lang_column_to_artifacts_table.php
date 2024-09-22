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
        Schema::table('artifacts', function (Blueprint $table) {
            $table->dropColumn('lang');
        });
        Schema::table('artifacts', function (Blueprint $table) {
            $table->string('lang')->nullable();
        });
        Schema::table('artifacts', function (Blueprint $table) {
            $table->dropColumn('lang');
        });
        Schema::table('artifacts', function (Blueprint $table) {
            $table->string('lang')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('artifacts', function (Blueprint $table) {
            $table->dropColumn('lang');
        });
        Schema::table('artifacts', function (Blueprint $table) {
            $table->enum('lang', \App\Models\Artifact::$langs)->nullable();
        });
    }
};
