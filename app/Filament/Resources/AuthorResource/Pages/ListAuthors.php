<?php

namespace App\Filament\Resources\AuthorResource\Pages;

use App\Filament\Resources\AuthorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Kainiklas\FilamentScout\Traits\InteractsWithScout;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;

class ListAuthors extends ListRecords
{

    protected static string $resource = AuthorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ExportAction::make(),
        ];
    }
}
