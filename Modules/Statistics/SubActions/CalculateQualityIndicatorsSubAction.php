<?php

namespace Modules\Statistics\SubActions;

use Illuminate\Database\Eloquent\Collection;
use Modules\Statistics\Tasks\QualityIndicators\GetAvgDlTask;
use Modules\Statistics\Tasks\QualityIndicators\GetAvgTimeVideoTask;
use Modules\Statistics\Tasks\QualityIndicators\GetAvgTimeWebTask;
use Modules\Statistics\Tasks\QualityIndicators\GetAvgUlTask;
use Modules\Statistics\Tasks\QualityIndicators\GetCoefficientLossTask;
use Modules\Statistics\Tasks\QualityIndicators\GetShareDlTask;
use Modules\Statistics\Tasks\QualityIndicators\GetShareIpPaketTask;
use Modules\Statistics\Tasks\QualityIndicators\GetShareTimeVideoTask;
use Modules\Statistics\Tasks\QualityIndicators\GetShareTimeWebTask;
use Modules\Statistics\Tasks\QualityIndicators\GetShareUlTask;

class CalculateQualityIndicatorsSubAction
{
    public function run(Collection $collection, array $response): array
    {
        $collection->each(function ($item, $key) use (&$response) {
            $response['share_dl'][$key] = app(GetShareDlTask::class)->run($item);
            $response['share_ul'][$key] = app(GetShareUlTask::class)->run($item);
            $response['avg_dl'][$key] = app(GetAvgDlTask::class)->run($item);
            $response['avg_ul'][$key] = app(GetAvgUlTask::class)->run($item);
            $response['share_ip_paket'][$key] = app(GetShareIpPaketTask::class)->run($item);
            $response['coefficient_loss'][$key] = app(GetCoefficientLossTask::class)->run($item);
            $response['avg_time_web'][$key] = app(GetAvgTimeWebTask::class)->run($item);
            $response['share_time_web'][$key] = app(GetShareTimeWebTask::class)->run($item);
            $response['avg_time_video'][$key] = app(GetAvgTimeVideoTask::class)->run($item);
            $response['share_time_video'][$key] = app(GetShareTimeVideoTask::class)->run($item);
        });

        $result = [];

        if (!empty($response)) {
            foreach ($response as $key => $item) {
                $result[] = array_merge(['name' => $key, 'group' => 'qualityIndicators'], $item);
            }
        }

        return $result;
    }
}
