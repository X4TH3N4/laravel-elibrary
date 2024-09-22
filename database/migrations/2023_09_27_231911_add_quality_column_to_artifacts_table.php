<?php

use App\Models\Artifact;
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
            $table->string('type_description')->after('type')->nullable();
            $table->string('quality')->after('lang')->nullable();
            $table->string('quality_description')->after('quality')->nullable();
            $table->string('type')->change()->nullable(); // Türü {Hatırat | Günlük | Otobiyografi}
            $table->string('style')->change()->nullable(); // Tarz {Mensur | Manzum}
            $table->string('lang')->change()->nullable(); // Dil {Arapça | Farsça | Osmanlıca}
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('artifacts', function (Blueprint $table) {
            $table->dropColumn('quality');
            $table->dropColumn('quality_description');
            $table->enum('type', Artifact::$types)->nullable(); // Türü {Hatırat | Günlük | Otobiyografi}
            $table->enum('style', Artifact::$styles)->nullable(); // Tarz {Mensur | Manzum}
            $table->enum('lang', Artifact::$langs)->nullable(); // Dil {Arapça | Farsça | Osmanlıca}
        });
    }
};
