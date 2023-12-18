<?php

namespace Modules\Tests\Tasks;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Modules\Tests\Models\Test;

class GetTestsForStatisticsTask
{
    public function run(array $params = []): Collection
    {
        $items = [];

        Test::query()
            ->with('operator')
            ->when(!empty($params['filters']), callback: function ($query) use ($params) {
                foreach ($params['filters'] as $key => $value) {
                    $query = match (gettype($value)) {
                        'string' => $query->when(!empty($value), function ($query) use ($key, $value) {
                            match ($value) {
                                'true' => $query->where($key, true),
                                'false' => $query->where($key, false),
                                default => $query,
                            };
                        }),
                        'array' => $query->when(!empty($value[0]),
                            fn($query) => $query->whereDate($key, '>=', Carbon::parse($value[0]))
                        )->when(!empty($value[1]),
                            fn($query) => $query->whereDate($key, '<=', Carbon::parse($value[1]))
                        ),
                        default => $query
                    };
                }
            })
            ->chunk(200, function ($tests) use (&$items) {
                foreach ($tests as $test) {
                    $items[] = $test;
                }
            });

        $collection = Collection::make($items);

        return $collection->groupBy('operator.name');
    }
}
