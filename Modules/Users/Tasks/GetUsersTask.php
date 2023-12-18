<?php

namespace Modules\Users\Tasks;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Modules\Users\Models\User;

class GetUsersTask
{
    public function run($params = []): LengthAwarePaginator
    {
        return User::query()
            ->select(['id', 'name', 'email', 'login', 'hash', 'created_at', 'updated_at'])
            ->withCount('tests')
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
