<?php

namespace App\Filament\Resources\CopyResource\Pages;

use App\Filament\Resources\CopyResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditCopy extends EditRecord
{
    protected static string $resource = CopyResource::class;

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
            ->title('Nüsha güncellendi')
            ->body('Nüsha başarıyla güncellendi.');
    }

}
