<?php

namespace App\Models;

use App\Traits\Report\Reporter;
use App\Traits\Spam\Spamer;
use App\Traits\Vote\Voter;
use Cog\Contracts\Ban\Bannable as BannableContract;
use Cog\Laravel\Ban\Traits\Bannable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Query;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use MBarlow\Megaphone\HasMegaphone;
use Overtrue\LaravelLike\Traits\Liker;
use OwenIt\Auditing\Auditable as  AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use Rappasoft\LaravelAuthenticationLog\Traits\AuthenticationLoggable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements BannableContract, Auditable
{
    use HasApiTokens, HasFactory, HasProfilePhoto, Notifiable, TwoFactorAuthenticatable, HasMegaphone, Voter, AuthenticationLoggable, HasRoles, Bannable, Spamer, Liker, AuditableTrait, Reporter;

    protected $fillable = [
        'name', 'email', 'password', 'profile_photo_path',
    ];

    protected $hidden = [
        'password', 'remember_token', 'two_factor_recovery_codes', 'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    public function ideas()
    {
        return $this->hasMany(Ideas::class);
    }

    public function comments()
    {
        return $this->hasMany(Comments::class);
    }

    public function status()
    {
        return $this->hasMany(Status::class);
    }

    public function categories()
    {
        return $this->hasMany(Categorie::class);
    }

    // check if user have super_admin and admin role
    public function isAdmin(): bool
    {
        return $this->hasRole(['super_admin', 'admin']);
    }

    public function isVerified(): bool
    {
        return $this->is_verified == 1;
    }

    public function isBlackList(): bool
    {
        return $this->is_banned == 1;
    }

    public function isBanned(): bool
    {
        return $this->banned_at != null;
    }

    public function scopeIsBan($query)
    {
        return $query->whereNotNull('banned_at');
    }

    public function scopeIsNotBan($query)
    {
        return $query->whereNull('banned_at');
    }

    public function scopeIsVerified($query)
    {
        return $query->where('is_verified', 1);
    }

    public function scopeIsNotVerified($query)
    {
        return $query->where('is_verified', 0);
    }

    public function scopeIsBlackList($query)
    {
        return $query->where('is_banned', 1);
    }

    public function scopeIsNotBlackList($query)
    {
        return $query->where('is_banned', 0);
    }

    public function scopeIsAdmin($query)
    {
        return $query->whereHas('roles', function ($query) {
            $query->whereIn('name', ['super_admin', 'admin']);
        });
    }

    public function canManageSettings(): bool
    {
        return $this->can('manage.settings');
    }

    public function getAvatar()
    {
        $firstCharacter = $this->name[0];
        $color = '7F9CF5';
        $bgColor = 'EBF4FF';

        return 'https://ui-avatars.com/api/'
            .'?name='.$firstCharacter
            .'&color='.$color
            .'&background='.$bgColor;
    }
}
