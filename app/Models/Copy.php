<?php

namespace App\Models;

use App\Enums\CopyEnum\FontEnum;
use App\Enums\CopyEnum\TypeEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Copy extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name',
        'library',
        'collection',
        'number',
        'procure',
        'width',
        'height',
        'page_count',
        'font',
        'info',
        'artifact_id',
        'istinsah_date_id',
        'is_draft',
        'slug'
    ];

    public static array $fonts = [
        'Sülüs' => 'Sülüs',
        'Nesih' => 'Nesih',
        'Rika' => 'Rika',
        'Talik' => 'Talik',
    ];
    public function istinsahDate(): BelongsTo
    {
        return $this->belongsTo(Date::class, 'istinsah_date_id');
    }

    public function istinsahLocation(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'istinsah_location_id');
    }

    public function artifact(): BelongsTo
    {
        return $this->belongsTo(Artifact::class);
    }

    public function dates(): BelongsToMany
    {
        return $this->belongsToMany(Date::class, 'copy_dates');
    }

    public function proses(): HasMany
    {
        return $this->hasMany(Prose::class);
    }

    public function getArtifactById($id, Artifact $artifact)
    {

        return $this->where('id', $id)->first()->artifact_id;
    }
    public function getArtifactNameById($id, Artifact $artifact)
    {
        $artifact_id = $this->where('id', $id)->first()->artifact_id;

        return $artifact->getNameById($artifact_id);
    }
    public function getCopyNumberById($id, Artifact $artifact)
    {
        $artifact_id = $this->where('id', $id)->first()->artifact_id;

        return $this->where('artifact_id', $artifact_id)->first()->number;
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn($value) => ['slug' => Str::slug($value), 'name' => $value]
        );
    }

}
