<?php

namespace App\Filament\Resources\LiteratureResource\Pages;

use App\Filament\Resources\LiteratureResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateLiterature extends CreateRecord
{
    protected static string $resource = LiteratureResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Literatür eklendi')
            ->body('Literatür başarıyla sisteme kaydedildi.');
    }


}
