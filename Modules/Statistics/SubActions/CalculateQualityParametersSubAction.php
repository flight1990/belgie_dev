<?php

namespace Modules\Statistics\SubActions;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Modules\Statistics\Tasks\QualityParameters\GetCountDlTask;
use Modules\Statistics\Tasks\QualityParameters\GetCountFullTestsTask;
use Modules\Statistics\Tasks\QualityParameters\GetCountIpPaketTask;
use Modules\Statistics\Tasks\QualityParameters\GetCountUlTask;
use Modules\Statistics\Tasks\QualityParameters\GetCountUserTask;
use Modules\Statistics\Tasks\QualityParameters\GetCountVideoTask;
use Modules\Statistics\Tasks\QualityParameters\GetCountWebTask;

class CalculateQualityParametersSubAction
{
    public function run(Collection $collection, array $response): array
    {
        $collection->each(function ($item, $key) use (&$response) {
            $response['count_user'][$key] = app(GetCountUserTask::class)->run($item) ?? 0;
            $response['count_full_tests'][$key] = app(GetCountFullTestsTask::class)->run($item);
            $response['count_dl'][$key] = app(GetCountDlTask::class)->run($item);
            $response['count_ul'][$key] = app(GetCountUlTask::class)->run($item);
            $response['count_ip_paket'][$key] = app(GetCountIpPaketTask::class)->run($item);
            $response['count_web'][$key] = app(GetCountWebTask::class)->run($item);
            $response['count_video'][$key] = app(GetCountVideoTask::class)->run($item);
        });

        $result = [];

        if (!empty($response)) {
            foreach ($response as $key => $item) {
                $result[] = array_merge(['name' => $key, 'group' => 'qualityParameters'], $item);
            }
        }

        return $result;
    }
}
