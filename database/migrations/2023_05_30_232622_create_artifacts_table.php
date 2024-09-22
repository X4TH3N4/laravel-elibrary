<?php

use App\Enums\ArtifactEnum\LangEnum;
use App\Enums\ArtifactEnum\StyleEnum;
use App\Enums\ArtifactEnum\TypeEnum;
use App\Models\Date;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \App\Models\Artifact;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('artifacts', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->unique(); // Adı
            $table->enum('type', Artifact::$types)->nullable(); // Türü {Hatırat | Günlük | Otobiyografi}
            $table->enum('style', Artifact::$styles)->nullable(); // Tarz {Mensur | Manzum}
            $table->enum('lang', Artifact::$langs)->nullable(); // Dil {Arapça | Farsça | Osmanlıca}
            $table->string('writing_place')->nullable();
            $table->date('writing_date')->nullable();
            $table->enum('date_type', Date::$date_types)->nullable();
            $table->text('info')->nullable(); // Bilgi
            $table->boolean('is_draft')->default(true); // görüntülenebilir mi
            $table->string('slug')->unique()->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artifacts');
    }
};
