<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Comments;
use App\Models\Ideas;
use App\Policies\ActivityPolicy;
use App\Policies\CommentPolicy;
use App\Policies\IdeasPolicies;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Spatie\Activitylog\Models\Activity;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Ideas::class => IdeasPolicies::class,
        Comments::class => CommentPolicy::class,
        // 'App\Models\Comments' => 'App\Policies\RolePolicy',
        FailedJob::class => FailedJobPolicy::class,
        JobBatch::class => JobBatchPolicy::class,
        // Activity::class => ActivityPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user, $ability) {
            return $user->hasRole('super_admin') ? true : null;
        });

        Gate::define('report', function ($user, $idea) {
            if ($user->id == $idea->id) {
                return false;
            }

            if ($idea->isNotClose()) {
                return false;
            }

            if ($idea->report()->where('user_id', $user->id)->exists()) {
                return false;
            }

            if ($idea->report()->whereIsNull('user_id')) {
                if ($idea->report()->where('ip', request()->ip())->where('user_agent', request()->userAgent())->exists()) {
                    return false;
                }
            }

            if (auth()->check() || auth()->guest()) {
                return true;
            }

            return true;
        });
    }
}
