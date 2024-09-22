<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{

    protected $fillable = [
        'name'
    ];

    protected $casts = [
      'name' => 'string'
    ];

    use HasFactory;

    public function getCityName()
    {
        return $this->name;
    }

    public function getAllCitiesByName(): array
    {
        $cities = $this->all()->sortBy('name');

        return $cities->pluck('name')->toArray();
    }

    public function authors() : BelongsToMany {
        return $this->belongsToMany(Author::class, 'author_cities');
    }
}
