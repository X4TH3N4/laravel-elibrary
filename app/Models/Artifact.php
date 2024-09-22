<?php

namespace App\Models;

use App\Enums\ArtifactEnum\LangEnum;
use App\Enums\ArtifactEnum\QualityEnum;
use App\Enums\ArtifactEnum\StyleEnum;
use App\Enums\ArtifactEnum\TypeEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Artifact extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name',
        'type',
        'type_description',
        'style',
        'lang',
        'lang_description',
        'info',
        'slug',
        'is_draft',
        'writing_date_id',
        'writing_location_id',
        'quality',
        'quality_description'
    ];

    public static array $langs = [
        'Arapça' => 'Arapça',
        'Farsça' => 'Farsça',
        'Osmanlıca' => 'Osmanlıca',
        'Diğer' => 'Diğer',
    ];
    public static array $qualities = [
       'Müstakil' => 'Müstakil',
        'Kısmi' => 'Kısmi',
        'Parçalı' => 'Parçalı',
        'Diğer' => 'Diğer'
    ];
    public static array $styles = [
        'Mensur' => 'Mensur',
        'Manzum' => 'Manzum'
    ];
    public static array $types = [
        'Diğer' => 'Diğer',
        'Hatırat' => 'Hatırat',
        'Günlük' => 'Günlük',
        'Biyografi' => 'Biyografi',
        'Otobiyografi' => 'Otobiyografi',
    ];

    public function writingLocation() : BelongsTo
    {
        return $this->belongsTo(Location::class, 'writing_location_id');
    }

    public function writingDate() : BelongsTo
    {
        return $this->belongsTo(Date::class, 'writing_date_id');
    }

    public function authors() : BelongsToMany {
        return $this->belongsToMany(Author::class, 'author_artifacts');
    }
    public function copies() : HasMany {
        return $this->hasMany(Copy::class);
    }

    public function dates(): BelongsToMany
    {
        return $this->belongsToMany(Date::class, 'artifact_dates');
    }

    public function literatures() : HasMany {
        return $this->hasMany(Literature::class);
    }

    public function getNameById($id)
    {
        return $this->where('id', $id)->first()->name;
    }

    public function getNameByCopyId($id)
    {
        return $this->where('copy_id', $id)->first()->name;
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn($value) => ['slug' => Str::slug($value), 'name' => $value]
        );
    }

}
