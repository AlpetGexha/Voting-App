<?php

namespace App\Traits\Spam;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

trait Spamer
{
    public function spammable(): MorphTo
    {
        return $this->morphTo();
    }

    public function spamer(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
