<?php

namespace App\Providers;

use App\Modules\Admin\Lead\Models\Lead;
use App\Modules\Admin\Lead\Policies\LeadPolicy;
use App\Modules\Admin\LeadComment\Models\LeadComment;
use App\Modules\Admin\LeadComment\Policies\LeadCommentPolicy;
use App\Modules\Admin\Role\Models\Role;
use App\Modules\Admin\Role\Policies\RolePolicy;
use App\Modules\Admin\Sources\Models\Source;
use App\Modules\Admin\Sources\Policies\SourcePolicy;
use App\Modules\Admin\Task\Models\Task;
use App\Modules\Admin\Task\Policies\TaskPolicy;
use App\Modules\Admin\TaskComments\Models\TaskComment;
use App\Modules\Admin\TaskComments\Policies\TaskCommentsPolicy;
use App\Modules\Admin\User\Models\User;
use App\Modules\Admin\User\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Role::class => RolePolicy::class,
        User::class => UserPolicy::class,
        Source::class => SourcePolicy::class,
        Lead::class => LeadPolicy::class,
        LeadComment::class => LeadCommentPolicy::class,
        Task::class => TaskPolicy::class,
        TaskComment::class => TaskCommentsPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

//        Passport::tokensExpireIn(now()->addSeconds(864000));
//        Passport::refreshTokensExpireIn(now()->addDays(10));
//        Passport::personalAccessTokensExpireIn(now()->addSeconds(86400));
    }
}
