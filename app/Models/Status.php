<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as  AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class Status extends Model implements Auditable
{
    use HasFactory, AuditableTrait;

    public const OPEN = 1;

    public const CLOSED = 2;

    public const CONSIDERING = 3;

    public const IN_PROGRESS = 4;

    public const IMPLEMENTED = 5;

    protected $fillable = [
        'name', 'slug',
    ];

    public function ideas()
    {
        return $this->hasMany(Ideas::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }

    public function getStatusClass()
    {
        // dd($this->status);
        $allStatus = [
            1 => 'bg-gray-200 ',
            2 => 'bg-red-500 text-white ',
            3 => 'bg-purple-500 text-white ',
            4 => 'bg-yellow-500 text-white ',
            5 => 'bg-green-500 text-white ',
        ];

        return $allStatus[$this->id] ?? null;
    }

    public static function getCount()
    {
        return Ideas::query()
            ->selectRaw('count(id) as all_statuses')
            ->selectRaw('count(case when status_id = 1 then 1 end) as open')
            ->selectRaw('count(case when status_id = 2 then 1 end) as considering')
            ->selectRaw('count(case when status_id = 3 then 1 end) as in_progress')
            ->selectRaw('count(case when status_id = 4 then 1 end) as implemented')
            ->selectRaw('count(case when status_id = 5 then 1 end) as closed')
            ->first()
            ->toArray();
    }
}
