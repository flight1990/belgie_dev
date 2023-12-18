<?php

namespace App\JsonApi\V2\Towers;

use LaravelJsonApi\Eloquent\Contracts\Paginator;
use LaravelJsonApi\Eloquent\Fields\ID;
use LaravelJsonApi\Eloquent\Fields\Number;
use LaravelJsonApi\Eloquent\Fields\Relations\BelongsTo;
use LaravelJsonApi\Eloquent\Filters\WhereIdIn;
use LaravelJsonApi\Eloquent\Pagination\PagePagination;
use LaravelJsonApi\Eloquent\Schema;
use Modules\Towers\Models\Tower;

class TowerSchema extends Schema
{
    protected ?array $defaultPagination = ['number' => 1];

    protected int $maxDepth = 2;

    /**
     * The model the schema corresponds to.
     *
     * @var string
     */
    public static string $model = Tower::class;

    /**
     * Get the resource fields.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            ID::make(),
            Number::make('standard_id'),
            Number::make('operator_id'),
            BelongsTo::make('standard')->type('standards'),
            BelongsTo::make('operator')->type('operators'),
            Number::make('bsn')->sortable(),
            Number::make('lac')->sortable(),
            Number::make('cell_id')->sortable(),
            Number::make('mnc')->sortable(),
            Number::make('y')->sortable(),
            Number::make('x')->sortable(),
            Number::make('band')->sortable(),
            Number::make('sector')->sortable(),
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
