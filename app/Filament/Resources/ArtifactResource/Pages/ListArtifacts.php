<?php

namespace App\Filament\Resources\ArtifactResource\Pages;

use App\Filament\Resources\ArtifactResource;
use App\Filament\Resources\ArtifactResource\RelationManagers\CopiesRelationManager;
use App\Models\Artifact;
use Filament\Actions;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Illuminate\Database\Eloquent\Builder;
use Kainiklas\FilamentScout\Traits\InteractsWithScout;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;

class ListArtifacts extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = ArtifactResource::class;



    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ExportAction::make()
        ];
    }

    public function getTabs(): array
    {
        return [
            'Hepsi' => Tab::make(),
            'Hatırat' => Tab::make('Hatırat')
                ->badgeColor('warning')
                ->badge(Artifact::query()->where('type', 'Hatırat')->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', 'Hatırat')),
            'Günlük' => Tab::make('Günlük')
                ->badgeColor('success')
                ->badge(Artifact::query()->where('type', 'Günlük')->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', 'Günlük')),
            'Biyografi' => Tab::make('Biyografi')
                ->badgeColor('danger')
                ->badge(Artifact::query()->where('type', 'Biyografi')->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', 'Biyografi')),
            'Otobiyografi' => Tab::make('Otobiyografi')
                ->badgeColor('info')
                ->badge(Artifact::query()->where('type', 'Otobiyografi')->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', 'Otobiyografi')),
            'Yayındakiler' => Tab::make('Yayındakiler')
                ->badgeColor('success')
                ->badge(Artifact::query()->where('is_draft', '1')->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_draft', '1')),
        ];
    }
}
