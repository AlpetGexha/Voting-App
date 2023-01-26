<?php

namespace App\Traits\Spam;

use App\Models\Spam;

trait Spamable
{
    public function spams()
    {
        return $this->morphMany(Spam::class, 'spammable');
    }

    public function spam()
    {
        if ($this->isSpammed()) {
            return $this->unspam();
        }

        // createSpam with rate limit
        return $this->createSpam();
    }

    public function markAsSpam()
    {
        $this->spam();
    }

    public function isSpammed()
    {
        return $this->spams()
            ->where('user_id', auth()->id())
            ->exists();
    }

    public function isSpammedFrom(): bool
    {
        return Spam::where('spammable_type', $this->getMorphClass())
            ->where('spammable_id', $this->id)
            ->where('user_id', auth()->id())
            ->exists();
    }

    private function createSpam()
    {
        return $this->spams()->create([
            'user_id' => auth()->id(),
        ]);
    }

    private function unspam()
    {
        return $this->spams()
            ->where('user_id', auth()->id())
            ->delete();
    }

    public function removeAllSpam()
    {
        // remove all spams colum where id = $this->id
        return Spam::where('spammable_type', $this->getMorphClass())
            ->where('spammable_id', $this->id)
            ->delete();
    }

    public function getSpamCount()
    {
        return $this->spams()->count();
    }
}
