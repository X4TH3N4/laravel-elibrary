<?php

namespace App\Filament\Resources\ArtifactResource\Pages;

use App\Filament\Resources\ArtifactResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditArtifact extends EditRecord
{
    protected static string $resource = ArtifactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Eser güncellendi')
            ->body('Eser başarıyla güncellendi.');
    }

}
