<?php

namespace App\Filament\Resources\LiteratureResource\Pages;

use App\Filament\Resources\LiteratureResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditLiterature extends EditRecord
{
    protected static string $resource = LiteratureResource::class;

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
            ->title('Literatür güncellendi')
            ->body('Literatür başarıyla güncellendi.');
    }

}
