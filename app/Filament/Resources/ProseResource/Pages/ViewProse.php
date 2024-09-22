<?php

namespace App\Filament\Resources\ProseResource\Pages;

use App\Filament\Resources\ProseResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewProse extends ViewRecord
{
    protected static string $resource = ProseResource::class;

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
