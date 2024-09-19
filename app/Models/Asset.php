<?php

namespace App\Models;

use App\Traits\RestrictToUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperAsset
 */
class Asset extends Model
{
    use HasFactory;
    use RestrictToUser;
    use SoftDeletes;

    protected $casts = [
        'paid_amount' => 'float:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function artifact(): BelongsTo
    {
        return $this->belongsTo(Artifact::class);
    }
}
