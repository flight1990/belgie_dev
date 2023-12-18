<?php

namespace App\Imports;

use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Modules\Operators\Actions\GetOperatorsAction;
use Modules\Standards\Actions\GetStandardsAction;
use Modules\Towers\Models\Tower;
use Maatwebsite\Excel\Concerns\ToModel;

class TowersImport implements
    ToModel,
    WithChunkReading,
    ShouldQueue,
    WithHeadingRow,
    SkipsOnError,
    WithEvents
{
    use
        SkipsErrors,
        RegistersEventListeners;


    public function model(array $row): Tower
    {
        $operators = app(GetOperatorsAction::class)->run()->pluck('id', 'mnc')->toArray();
        $standards = app(GetStandardsAction::class)->run()->pluck('id', 'name')->toArray();

        return new Tower([
            'standard_id' => $standards[$row['tech']],
            'bsn' => $row['bsn'],
            'lac' => $row['lac'],
            'cell_id' => $row['cellid'],
            'mnc' => $row['mnc'],
            'x' => str_replace(',', '.', $row['x']),
            'y' => str_replace(',', '.', $row['y']),
            'band' => $row['band'],
            'sector' => $row['sector'],
            'operator_id' => $operators[$row['mnc']],
        ]);
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
