<?php

namespace App\Traits\Report;

use App\Models\Report;

trait Reported
{
    public function report()
    {
        return $this->morphMany('App\Models\Report', 'reportable');
    }

    public function reported()
    {
        return Report::where('reportable_type', $this->getMorphClass())
            ->where('reportable_id', $this->id)
            ->exists();
    }

    public function reports()
    {
        return Report::where('reportable_type', $this->getMorphClass())
            ->where('reportable_id', $this->id)
            ->count();
    }

    public function hasReport()
    {
        return Report::where('reportable_type', $this->getMorphClass())
            ->where('reportable_id', $this->id)
            ->count() > 0;
    }

    public function storeReport($subject, $reason)
    {
        if ($this->report()->where('user_id', auth()->id())->exists()) {
            session()->flash('error', 'You have already reported this profile');

            return;
        }

        if ($this->report()->where('ip', request()->ip())->exists()) {
            session()->flash('error', 'You have already reported this profile');

            return;
        }

        if (auth()->check()) {
            $this->report()->create([
                'user_id' => auth()->user()->id,
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'subject' => $subject,
                'reason' => $reason,
            ]);
        } else {
            $this->report()->create([
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'subject' => $subject,
                'reason' => $reason,
            ]);
        }
    }
}
