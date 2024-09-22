<?php

namespace App\Filament\Widgets;

use App\Models\Artifact;
use App\Models\Copy;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class CopyChart extends ChartWidget
{
    public function getHeading(): Stat
    {
        return Stat::make('Nüshalar', Copy::count());
    }
    protected static string $color = 'warning';


    protected function getData(): array
    {
        $data = Trend::model(Copy::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Nüshalar',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
