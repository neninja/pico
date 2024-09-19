<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperArtifact
 */
class Artifact extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'order',
        'catalog_id',
    ];

    protected $casts = [
        'order' => 'double',
    ];

    public function catalog(): BelongsTo
    {
        return $this->belongsTo(Catalog::class);
    }
}
