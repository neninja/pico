<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait RestrictToUser
{
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        parent::booted();

        static::addGlobalScope('user', function (Builder $builder) {
            if (auth()->check()) {
                $builder->where('user_id', auth()->user()->id);
            }
        });
    }
}
