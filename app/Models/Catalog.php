<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperCatalog
 */
class Catalog extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'artifact_label',
        'artifact_plural_label',
    ];

    public function artifacts(): HasMany
    {
        return $this->hasMany(Artifact::class);
    }
}
