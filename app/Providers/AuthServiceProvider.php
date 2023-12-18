<?php

namespace App\Providers;

use App\Policies\AdminUsersPolicy;
use App\Policies\ConnectionTypesPolicy;
use App\Policies\OperatorPolicy;
use App\Policies\OperatorsPolicy;
use App\Policies\ServersPolicy;
use App\Policies\StandardsPolicy;
use App\Policies\TestsPolicy;
use App\Policies\TowersPolicy;
use App\Policies\UsersPolicy;
use App\Policies\WebResourcesPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Modules\AdminUsers\Models\AdminUser;
use Modules\ConnectionTypes\Models\ConnectionType;
use Modules\Operators\Models\Operator;
use Modules\Servers\Models\Server;
use Modules\Standards\Models\Standard;
use Modules\Tests\Models\Test;
use Modules\Towers\Models\Tower;
use Modules\Users\Models\User;
use Modules\WebResources\Models\WebResource;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        AdminUser::class => AdminUsersPolicy::class,
        Operator::class => OperatorsPolicy::class,
        ConnectionType::class => ConnectionTypesPolicy::class,
        Server::class => ServersPolicy::class,
        Standard::class => StandardsPolicy::class,
        Test::class => TestsPolicy::class,
        Tower::class => TowersPolicy::class,
        User::class => UsersPolicy::class,
        WebResource::class => WebResourcesPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {

    }
}
