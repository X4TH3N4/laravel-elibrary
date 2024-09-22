<?php

namespace App\Filament\Resources\LiteratureResource\Pages;

use App\Filament\Resources\LiteratureResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewLiterature extends ViewRecord
{
    protected static string $resource = LiteratureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\EditAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
