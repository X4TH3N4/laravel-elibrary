<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

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
            ->title('Kullanıcı güncellendi')
            ->body('Kullanıcı başarıyla güncellendi.');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if(array_key_exists('new_password', $data) || filled($data['new_password'])) {
            $this->record->password = Hash::make($data['new_password']);
        }
        return $data;
    }

}
