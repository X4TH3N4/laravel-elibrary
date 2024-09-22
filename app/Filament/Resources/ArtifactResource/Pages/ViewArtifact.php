<?php

namespace App\Filament\Resources\ArtifactResource\Pages;

use App\Filament\Resources\ArtifactResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewArtifact extends ViewRecord
{
    protected static string $resource = ArtifactResource::class;

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
