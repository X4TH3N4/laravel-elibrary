<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Occupation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

public function authors() : BelongsToMany {
    return $this->belongsToMany(Author::class, 'author_occupations');
}

}
