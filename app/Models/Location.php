<?php

namespace App\Models;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'whg_pid',
        'lon',
        'lat',
    ];


    public function artifacts(): HasMany
    {
        return $this->hasMany(Artifact::class);
    }

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class);
    }

    public function copies(): HasMany
    {
        return $this->hasMany(Copy::class);
    }

    public function proses(): HasMany
    {
        return $this->hasMany(Prose::class);
    }

}
