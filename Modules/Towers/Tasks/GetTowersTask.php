<?php

namespace Modules\Towers\Tasks;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Modules\Towers\Models\Tower;

class GetTowersTask
{
    public function run(array $params = []): LengthAwarePaginator
    {

        return Tower::query()
            ->leftJoin('operators', 'towers.operator_id', '=', 'operators.id')
            ->leftJoin('standards', 'towers.standard_id', '=', 'standards.id')
            ->select([
                'towers.*',
                'standards.name as standards.name',
                'operators.name as operators.name',
                DB::raw('(select COUNT(*) from tests where towers.id = tests.tower_id limit 1) AS tests_count')
            ])
            ->when(!empty($params['sort']), function ($query) use ($params) {
                $sort = Arr::flatten($params['sort']);
                $query->orderBy($sort[0], $sort[1]);
            })
            ->when(!empty($params['filters']), function ($query) use ($params) {
                foreach ($params['filters'] as $key => $value) {
                    $query = match (gettype($value)) {
                        'integer' => $query->when(!empty($value),
                            fn($query) => $query->where($key, $value)
                        ),
                        'string' => $query->when(!empty($value),
                            fn($query) => $query->where($key, 'like', '%' . $value . '%')
                        ),
                        default => $query
                    };
                }
            })
            ->paginate($params['limit'] ?? 10);
    }
}
