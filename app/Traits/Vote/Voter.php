<?php

namespace App\Traits\Vote;

trait Voter
{
    public function votes()
    {
        return $this->belongsToMany(Ideas::class, 'votes');
    }
}
