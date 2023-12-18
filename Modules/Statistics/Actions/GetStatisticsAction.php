<?php

namespace Modules\Statistics\Actions;

use Modules\Statistics\SubActions\CalculateQualityIndicatorsSubAction;
use Modules\Statistics\SubActions\CalculateQualityParametersSubAction;
use Modules\Statistics\SubActions\InitDefaultResponsesSubAction;
use Modules\Tests\Tasks\GetTestsForStatisticsTask;

class GetStatisticsAction
{
    public function run(array $params = []): array
    {
        $collection = app(GetTestsForStatisticsTask::class)->run($params);

        $initDefaultResponses = app(InitDefaultResponsesSubAction::class)->run();

        $qualityParameters = app(CalculateQualityParametersSubAction::class)
            ->run($collection, $initDefaultResponses['qualityParametersResponse']);

        $qualityIndicators = app(CalculateQualityIndicatorsSubAction::class)
            ->run($collection, $initDefaultResponses['qualityIndicatorsResponse']);




        return array_merge($qualityParameters, $qualityIndicators);
    }
}
