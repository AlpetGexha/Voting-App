<?php

namespace App\Traits\Report;

trait Reporter
{
    public function report()
    {
        return $this->hasMany(Report::class, 'reportable');
    }
}
