<?php

namespace App\Models;

use App\Enums\ProseEnum\VariationEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Prose extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'source',
        'isbn',
        'ref_info',
        'variation',
        'is_draft',
        'copy_id',
        'publication_date_id',
        'slug'
    ];

    public static array $variations = [
        'Arap Alfabesi / Matbu' => 'Arap Alfabesi / Matbu',
        'Latinize / Transkripsiyon' => 'Latinize / Transkripsiyon',
        'Transliterasyon' => 'Transliterasyon',
    ];

    public function publicationDate(): BelongsToMany
    {
        return $this->belongsToMany(Date::class, 'publication_date_id');
    }
    public function publicationLocation(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'publication_location_id');
    }

    public function dates(): BelongsToMany
    {
        return $this->belongsToMany(Date::class, 'prose_dates');
    }

    public function copy(): BelongsTo
    {
        return $this->belongsTo(Copy::class);
    }

    public function getNameById($id)
    {
        return $this->where('copy_id', $id)->first()->name;
    }

    public function getArtifactNameById($id, Artifact $artifact, Copy $copy)
    {
        $artifact_id = $this->copy()->where('id', $id)->first()->artifact_id;
        return $artifact->where('id', $artifact_id)->first()->name;
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn($value) => ['slug' => Str::slug($value), 'name' => $value]
        );
    }

}
