<?php

namespace App\Filament\Resources\ProseResource\Pages;

use App\Filament\Resources\ProseResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditProse extends EditRecord
{
    protected static string $resource = ProseResource::class;

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
            ->title('Neşir güncellendi')
            ->body('Neşir başarıyla güncellendi.');
    }

}
