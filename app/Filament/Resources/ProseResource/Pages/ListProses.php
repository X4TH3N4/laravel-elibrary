<?php

namespace App\Filament\Resources\ProseResource\Pages;

use App\Filament\Resources\ProseResource;
use App\Models\Copy;
use App\Models\Prose;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Kainiklas\FilamentScout\Traits\InteractsWithScout;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;

class ListProses extends ListRecords
{

    protected static string $resource = ProseResource::class;

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
            'Arap Alfabesi / Matbu' => Tab::make('Arap Alfabesi / Matbu')
                ->badgeColor('warning')
                ->badge(Prose::query()->where('variation', 'Arap Alfabesi / Matbu')->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('variation', 'Arap Alfabesi / Matbu')),
            'Latinize / Transkripsiyon' => Tab::make('Latinize / Transkripsiyon')
                ->badgeColor('success')
                ->badge(Prose::query()->where('variation', 'Latinize / Transkripsiyon')->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('variation', 'Latinize / Transkripsiyon')),
            'Transliterasyon' => Tab::make('Transliterasyon')
                ->badgeColor('danger')
                ->badge(Prose::query()->where('variation', 'Transliterasyon')->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('variation', 'Transliterasyon')),
            'Yayındakiler' => Tab::make('Yayındakiler')
                ->badgeColor('success')
                ->badge(Prose::query()->where('is_draft', '1')->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_draft', '1')),
        ];
    }
}
