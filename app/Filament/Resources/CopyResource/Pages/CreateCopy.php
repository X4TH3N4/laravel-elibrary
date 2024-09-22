<?php

namespace App\Filament\Resources\CopyResource\Pages;

use App\Filament\Resources\CopyResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateCopy extends CreateRecord
{
    protected static string $resource = CopyResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Nüsha eklendi')
            ->body('Nüsha başarıyla sisteme kaydedildi.');
    }

}
