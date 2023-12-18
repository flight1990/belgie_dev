<?php

namespace App\JsonApi\V2\Tests;

use LaravelJsonApi\Eloquent\Contracts\Paginator;
use LaravelJsonApi\Eloquent\Fields\Boolean;
use LaravelJsonApi\Eloquent\Fields\DateTime;
use LaravelJsonApi\Eloquent\Fields\ID;
use LaravelJsonApi\Eloquent\Fields\Number;
use LaravelJsonApi\Eloquent\Fields\Relations\BelongsTo;
use LaravelJsonApi\Eloquent\Fields\Str;
use LaravelJsonApi\Eloquent\Filters\Scope;
use LaravelJsonApi\Eloquent\Filters\WhereIdIn;
use LaravelJsonApi\Eloquent\Pagination\PagePagination;
use LaravelJsonApi\Eloquent\Schema;
use Modules\Tests\Models\Test;

class TestSchema extends Schema
{

    protected ?array $defaultPagination = ['number' => 1];

    protected int $maxDepth = 2;

    /**
     * The model the schema corresponds to.
     *
     * @var string
     */
    public static string $model = Test::class;

    /**
     * Get the resource fields.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            ID::make(),
            Number::make('y')->sortable(),
            Number::make('x')->sortable(),
            Number::make('band')->sortable(),
            Number::make('sector')->sortable(),
            Str::make('model_phone')->sortable(),
            Str::make('version_os')->sortable(),
            Str::make('level_signal')->sortable(),
            Number::make('distance')->sortable(),
            Number::make('max_speed_download')->sortable(),
            Number::make('medium_speed_download')->sortable(),
            Number::make('max_speed_upload')->sortable(),
            Number::make('min_speed_upload')->sortable(),
            Number::make('max_ping')->sortable(),
            Number::make('medium_ping')->sortable(),
            Str::make('address_site_1')->sortable(),
            Str::make('address_site_2')->sortable(),
            Str::make('address_site_3')->sortable(),
            Str::make('address_youtube')->sortable(),
            Str::make('screen_resolution')->sortable(),
            Str::make('data_used')->sortable(),
            Boolean::make('complaint')->sortable(),
            Number::make('operator_id'),
            Number::make('standard_id'),
            Number::make('connection_type_id'),
            Number::make('server_id'),
            Number::make('user_id'),
            Number::make('tower_id'),
            Str::make('load_web_1')->sortable(),
            Str::make('load_web_2')->sortable(),
            Str::make('load_web_3')->sortable(),
            Boolean::make('is_room')->sortable(),
            Number::make('time_start')->sortable(),
            Number::make('time_download_web_1')->sortable(),
            Number::make('time_download_web_2')->sortable(),
            Number::make('time_download_web_3')->sortable(),
            Number::make('loss_ping')->sortable(),
            BelongsTo::make('operator')->type('operators'),
            BelongsTo::make('standard')->type('standards'),
            BelongsTo::make('connction-type')->type('connection-types'),
            BelongsTo::make('server')->type('servers'),
            BelongsTo::make('user')->type('users'),
            BelongsTo::make('tower')->type('towers'),
            DateTime::make('createdAt')->sortable()->readOnly(),
        ];
    }

    /**
     * Get the resource filters.
     *
     * @return array
     */
    public function filters(): array
    {
        return [
            WhereIdIn::make($this),
            Scope::make('room')->asBoolean(),
            Scope::make('complaint')->asBoolean(),
        ];
    }

    /**
     * Get the resource paginator.
     *
     * @return Paginator|null
     */
    public function pagination(): ?Paginator
    {
        return PagePagination::make();
    }

}
