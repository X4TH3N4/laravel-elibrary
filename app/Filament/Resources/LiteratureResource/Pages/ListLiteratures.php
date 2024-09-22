<?php

namespace App\Filament\Resources\LiteratureResource\Pages;

use App\Filament\Resources\LiteratureResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Kainiklas\FilamentScout\Traits\InteractsWithScout;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;

class ListLiteratures extends ListRecords
{

    protected static string $resource = LiteratureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ExportAction::make(),
        ];
    }
}
