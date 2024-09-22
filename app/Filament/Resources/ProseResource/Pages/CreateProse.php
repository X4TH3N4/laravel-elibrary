<?php

namespace App\Filament\Resources\ProseResource\Pages;

use App\Filament\Resources\ProseResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateProse extends CreateRecord
{
    protected static string $resource = ProseResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Neşir eklendi')
            ->body('Neşir başarıyla sisteme kaydedildi.');
    }

}
