<?php

namespace App\Models;

use App\Traits\Spam\Spamable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelLike\Like;
use Overtrue\LaravelLike\Traits\Likeable;
use OwenIt\Auditing\Auditable as  AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class Comments extends Model implements Auditable
{
    use HasFactory, Spamable, Likeable, AuditableTrait;

    protected $fillable = [
        'user_id', 'ideas_id', 'status_id', 'body', 'spam_report', 'is_status_update',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function idea()
    {
        return $this->belongsTo(Ideas::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function scopeIsLikeByUser($query)
    {
        return $query->addSelect([
            //   check if comment is liked by auth user return true or false
            'is_liked_by_user' => Like::selectRaw('1')
                ->whereColumn('likeable_id', 'comments.id')
                ->where('likeable_type', Comments::class)
                ->where('user_id', auth()->id())
                ->limit(1),
        ]);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($comment) {
            if (auth()->check()) {
                $comment->user_id = auth()->id();
            }
        });
    }
}
