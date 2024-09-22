<?php

namespace App\Filament\Widgets;

use App\Models\Artifact;
use App\Models\Author;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class AuthorChart extends ChartWidget
{
    public function getHeading(): Stat
    {
        return Stat::make('Yazarlar', Author::count());
    }
    protected static string $color = 'danger';


    protected function getData(): array
    {
        $data = Trend::model(Author::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Yazarlar',
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
