<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Literature extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'ref_info',
        'link',
        'isbn',
        'artifact_id'
    ];

    public function artifact() : BelongsTo {
        return $this->belongsTo(Artifact::class);
    }

}
