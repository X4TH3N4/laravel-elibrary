<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Enums\ActionSize;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationGroup = 'Yetkili İşlemleri';
    protected static ?string $modelLabel = 'Kullanıcı';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $pluralLabel = 'Kullanıcılar';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $activeNavigationIcon = 'heroicon-s-user';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Kullanıcı Detayları')
                    ->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255)
                        ->label('Ad'),
                    Forms\Components\TextInput::make('email')
                        ->label('E-posta')
                        ->email()
                        ->required()
                        ->unique(ignoreRecord: true),
                    Forms\Components\TextInput::make('password')
                        ->label('Şifre')
                        ->password()
                        ->required()
                        ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                        ->visible(fn ($livewire) => $livewire instanceof CreateUser)
                        ->rule(Password::default())
                        ->maxLength(255),
                    Forms\Components\Toggle::make('is_active')->default(true)->label('Aktif'),
                    Select::make('roles')
                        ->multiple()
                        ->required()
                        ->relationship('roles', 'name')
                        ->label('Roller')
                        ->native(false)
                        ->live()
                        ->preload()
                ]),
                Forms\Components\Section::make('Şifre Değiştir')->schema([
                    Forms\Components\TextInput::make('new_password')
                        ->label('Yeni Şifre')
                        ->nullable()
                        ->password()
                        ->rule(Password::default())
                        ->maxLength(255),
                    Forms\Components\TextInput::make('new_password_confirmation')
                        ->label('Şifreyi Onayla')
                        ->requiredWith('new_password')
                        ->same('new_password')
                        ->password()
                        ->maxLength(255),
                ])->visible(fn ($livewire) => $livewire instanceof EditUser)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()->label('Ad'),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()->label('E-posta'),
                Tables\Columns\TextColumn::make('roles.name')
                    ->searchable()->sortable()->label('Roller')->color('primary'),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()->label('Aktif'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                ])
                    ->label('İşlemler')
                        ->color('info')
                        ->icon('heroicon-m-ellipsis-vertical')
                        ->size(ActionSize::Small)
                        ->button(),
            ])
            ->bulkActions([
                ExportBulkAction::make(),
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

}
