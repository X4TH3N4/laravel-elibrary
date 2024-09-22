<?php

namespace App\Models;

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
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Author extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name',
        'author_info',
        'birth_date_id',
        'birth_location_id',
        'death_date_id',
        'death_location_id',
        'slug',
    ];

    public function artifacts(): BelongsToMany
    {
        return $this->belongsToMany(Artifact::class, 'author_artifacts');
    }

    public function birthDate(): BelongsTo
    {
        return $this->belongsTo(Date::class, 'birth_date_id');
    }

    public function deathDate(): BelongsTo
    {
        return $this->belongsTo(Date::class, 'death_date_id');
    }

    public function birthLocation() : BelongsTo
    {
        return $this->belongsTo(Location::class, 'birth_location_id');
    }

    public function deathLocation() : BelongsTo
    {
        return $this->belongsTo(Location::class, 'death_location_id');
    }

    public function occupations(): BelongsToMany
    {
        return $this->belongsToMany(Occupation::class, 'author_occupations');
    }
    public function birthDates(): BelongsToMany
    {
        return $this->belongsToMany(Date::class, 'author_birth_dates');
    }
    public function deathDates(): BelongsToMany
    {
        return $this->belongsToMany(Date::class, 'author_death_dates');
    }

    public function cities(): BelongsToMany
    {
        return $this->belongsToMany(City::class, 'author_cities');
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn($value) => ['slug' => Str::slug($value), 'name' => $value]
        );
    }


}
