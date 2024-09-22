<?php

namespace App\Filament\Resources\CopyResource\Pages;

use App\Filament\Resources\CopyResource;
use App\Models\Artifact;
use App\Models\Copy;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Kainiklas\FilamentScout\Traits\InteractsWithScout;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;

class ListCopies extends ListRecords
{

    protected static string $resource = CopyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ExportAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'Hepsi' => Tab::make(),
            'Sülüs' => Tab::make('Sülüs')
                ->badgeColor('warning')
                ->badge(Copy::query()->where('font', 'Sülüs')->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('font', 'Sülüs')),
            'Nesih' => Tab::make('Nesih')
                ->badgeColor('success')
                ->badge(Copy::query()->where('font', 'Nesih')->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('font', 'Nesih')),
            'Rika' => Tab::make('Rika')
                ->badgeColor('danger')
                ->badge(Copy::query()->where('font', 'Rika')->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('font', 'Rika')),
            'Talik' => Tab::make('Talik')
                ->badgeColor('info')
                ->badge(Copy::query()->where('font', 'Talik')->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('font', 'Talik')),
            'Yayındakiler' => Tab::make('Yayındakiler')
                ->badgeColor('success')
                ->badge(Copy::query()->where('is_draft', '1')->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_draft', '1')),
        ];
    }
}
