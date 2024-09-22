<?php

namespace App\Filament\Resources\ArtifactResource\RelationManagers;

use App\Enums\ArtifactEnum\LangEnum;
use App\Enums\ArtifactEnum\StyleEnum;
use App\Enums\ArtifactEnum\TypeEnum;
use App\Models\Artifact;
use App\Models\Author;
use App\Models\Date;
use App\Models\Event;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\ActionSize;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LiteraturesRelationManager extends RelationManager
{
    protected static string $relationship = 'literatures';

    protected static ?string $pluralLabel = 'Literatürler';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $modelLabel = 'Literatür';

    protected static ?string $label = 'Literatür';

    protected static ?string $title = 'Literatürler';

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                \Filament\Infolists\Components\Section::make()
                    ->schema(components: [
                        TextEntry::make('artifact.name')
                            ->label('Eser :')
                            ->placeholder('Belirtilmedi')
                            ->default('Belirtilmedi')
                            ->inlineLabel(),
                        TextEntry::make('title')
                            ->label('Başlık :')
                            ->placeholder('Belirtilmedi')
                            ->default('Belirtilmedi')
                            ->inlineLabel(),
                        TextEntry::make('ref_info')
                            ->label('Referans Bilgi :')
                            ->placeholder('Belirtilmedi')
                            ->default('Belirtilmedi')
                            ->inlineLabel(),
                        TextEntry::make('link')
                            ->label('Link :')
                            ->placeholder('Belirtilmedi')
                            ->default('Belirtilmedi')
                            ->inlineLabel(),
                        TextEntry::make('isbn')
                            ->label('ISBN :')
                            ->placeholder('Belirtilmedi')
                            ->default('Belirtilmedi')
                            ->inlineLabel(),
                    ])
            ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Literatür Ekle')
                    ->description('Literatür bilgilerini giriniz.')
                    ->reactive()
                    ->columns(2)
                    ->schema(components: [
                        Forms\Components\TextInput::make('title')->columnSpanFull()
                            ->maxLength(255)->label('Başlık')->required(),
                        Forms\Components\TextInput::make('ref_info')
                            ->maxLength(255)->label('Referans Bilgi'),
                        Forms\Components\TextInput::make('link')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('isbn')
                            ->maxLength(255),
                    ])

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                Tables\Columns\TextColumn::make('title')->label('Başlık')
                    ->sortable()->searchable()->limit(80)->default('Belirtilmedi')
                    ->placeholder('Belirtilmedi'),
                Tables\Columns\TextColumn::make('artifact.name')->label('Eser Adı')
                    ->sortable()->searchable()->limit(50)
                    ->default('Belirtilmedi')
                    ->placeholder('Belirtilmedi'),
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
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\ForceDeleteAction::make()])->label('İşlemler')
                    ->color('info')
                    ->icon('heroicon-m-ellipsis-vertical')
                    ->size(ActionSize::Small)
                    ->button(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
}
