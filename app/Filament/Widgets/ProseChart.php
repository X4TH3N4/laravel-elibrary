<?php

namespace App\Filament\Widgets;

use App\Models\Artifact;
use App\Models\Prose;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class ProseChart extends ChartWidget
{
    public function getHeading(): Stat
    {
        return Stat::make('Neşirler', Prose::count());
    }
    protected static string $color = 'success';


    protected function getData(): array
    {
        $data = Trend::model(Prose::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Neşirler',
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
