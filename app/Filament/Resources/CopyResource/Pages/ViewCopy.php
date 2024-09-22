<?php

namespace App\Filament\Resources\CopyResource\Pages;

use App\Filament\Resources\CopyResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCopy extends ViewRecord
{
    protected static string $resource = CopyResource::class;

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
