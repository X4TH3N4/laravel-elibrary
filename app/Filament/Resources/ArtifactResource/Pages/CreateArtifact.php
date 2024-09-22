<?php

namespace App\Filament\Resources\ArtifactResource\Pages;

use App\Filament\Resources\ArtifactResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateArtifact extends CreateRecord
{
    protected static string $resource = ArtifactResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Eser eklendi')
            ->body('Eser başarıyla sisteme kaydedildi.');
    }

}
