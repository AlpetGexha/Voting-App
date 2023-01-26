<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as  AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class Spam extends Model implements Auditable
{
    use HasFactory, AuditableTrait;

    protected $fillable = [
        'user_id',
        'type',
        'spammable_id',
        'spammable_type',
    ];

    public function spammable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeSpam($query)
    {
        return $query->where('user_id', auth()->id());
    }

    public function scopeSpamCount($query)
    {
        return $query->where('user_id', auth()->id())->count();
    }

    public function scopeWithType()
    {
        return $this->where('type', 'spam');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($spam) {
            if (auth()->check()) {
                $spam->user_id = auth()->id();
            }
        });
    }
}
