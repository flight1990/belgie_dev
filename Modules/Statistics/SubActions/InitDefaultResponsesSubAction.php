<?php

namespace Modules\Statistics\SubActions;

use Modules\Operators\Actions\GetOperatorsAction;

class InitDefaultResponsesSubAction
{
    public function run(): array
    {
        $qualityParametersResponse = [];
        $qualityIndicatorsResponse = [];

        $operators = app(GetOperatorsAction::class)->run();

        $operators->each(function ($item) use (&$qualityParametersResponse, &$qualityIndicatorsResponse) {
            $qualityParametersResponse['count_user'][$item->name] = 0;
            $qualityParametersResponse['count_full_tests'][$item->name] = 0;
            $qualityParametersResponse['count_dl'][$item->name] = 0;
            $qualityParametersResponse['count_ul'][$item->name] = 0;
            $qualityParametersResponse['count_ip_paket'][$item->name] = 0;
            $qualityParametersResponse['count_web'][$item->name] = 0;
            $qualityParametersResponse['count_video'][$item->name] = 0;
            $qualityIndicatorsResponse['share_dl'][$item->name] = 0;
            $qualityIndicatorsResponse['share_ul'][$item->name] = 0;
            $qualityIndicatorsResponse['avg_dl'][$item->name] = 0;
            $qualityIndicatorsResponse['avg_ul'][$item->name] = 0;
            $qualityIndicatorsResponse['share_ip_paket'][$item->name] = 0;
            $qualityIndicatorsResponse['coefficient_loss'][$item->name] = 0;
            $qualityIndicatorsResponse['avg_time_web'][$item->name] = 0;
            $qualityIndicatorsResponse['share_time_web'][$item->name] = 0;
            $qualityIndicatorsResponse['avg_time_video'][$item->name] = 0;
            $qualityIndicatorsResponse['share_time_video'][$item->name] = 0;
        });

        return [
            'qualityParametersResponse' => $qualityParametersResponse,
            'qualityIndicatorsResponse' => $qualityIndicatorsResponse
        ];
    }
}
