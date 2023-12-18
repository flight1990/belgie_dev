<?php

namespace App\JsonApi\V2;

use App\JsonApi\V2\AdminUsers\AdminUserSchema;
use App\JsonApi\V2\ConnectionTypes\ConnectionTypeSchema;
use App\JsonApi\V2\Operators\OperatorSchema;
use App\JsonApi\V2\Servers\ServerSchema;
use App\JsonApi\V2\Standards\StandardSchema;
use App\JsonApi\V2\Tests\TestSchema;
use App\JsonApi\V2\Towers\TowerSchema;
use App\JsonApi\V2\Users\UserSchema;
use App\JsonApi\V2\WebResources\WebResourceSchema;
use Illuminate\Support\Facades\Auth;
use LaravelJsonApi\Core\Server\Server as BaseServer;

class Server extends BaseServer
{

    /**
     * The base URI namespace for this server.
     *
     * @var string
     */
    protected string $baseUri = '/api/v2';

    /**
     * Bootstrap the server when it is handling an HTTP request.
     *
     * @return void
     */
    public function serving(): void
    {
        Auth::shouldUse('sanctum');
    }

    /**
     * Get the server's list of schemas.
     *
     * @return array
     */
    protected function allSchemas(): array
    {
        return [
            OperatorSchema::class,
            ServerSchema::class,
            ConnectionTypeSchema::class,
            StandardSchema::class,
            WebResourceSchema::class,
            UserSchema::class,
            AdminUserSchema::class,
            TowerSchema::class,
            TestSchema::class
        ];
    }
}
