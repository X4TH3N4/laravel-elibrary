<?php

namespace App\Filament\Resources\ArtifactResource\RelationManagers;

use App\Enums\ArtifactEnum\LangEnum;
use App\Enums\ArtifactEnum\StyleEnum;
use App\Enums\CopyEnum\FontEnum;
use App\Models\Artifact;
use App\Models\Author;
use App\Models\Copy;
use App\Models\Date;
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
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
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
use Njxqlus\Filament\Components\Infolists\LightboxSpatieMediaLibraryImageEntry;

class CopiesRelationManager extends RelationManager
{
    protected static string $relationship = 'copies';

    protected static ?string $title = 'Nüshalar';

    protected static ?string $recordTitleAttribute = 'id';

    protected static ?string $modelLabel = 'Nüsha';

    protected static ?string $label = 'Nüsha';

    protected static ?string $pluralLabel = 'Nüshalar';

    public  function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                \Filament\Infolists\Components\Section::make()
                    ->schema(components: [
                        TextEntry::make('name')
                            ->label('Nüsha Adı :')
                            ->placeholder('Belirtilmedi')
                            ->default('Belirtilmedi')
                            ->inlineLabel(),
                        TextEntry::make('artifact.name')
                            ->label('Eser Adı :')
                            ->placeholder('Belirtilmedi')
                            ->default('Belirtilmedi')
                            ->inlineLabel(),
                        TextEntry::make('library')
                            ->label('Kütüphane :')
                            ->placeholder('Belirtilmedi')
                            ->default('Belirtilmedi')
                            ->inlineLabel(),
                        TextEntry::make('collection')
                            ->label('Koleksiyon :')
                            ->placeholder('Belirtilmedi')
                            ->default('Belirtilmedi')
                            ->inlineLabel(),
                        TextEntry::make('number')
                            ->label('Numara :')
                            ->placeholder('Belirtilmedi')
                            ->default('Belirtilmedi')
                            ->inlineLabel(),
                        TextEntry::make('procure')
                            ->label('Temin :')
                            ->placeholder('Belirtilmedi')
                            ->default('Belirtilmedi')
                            ->inlineLabel(),
                        TextEntry::make('width')
                            ->label('En :')
                            ->placeholder('Belirtilmedi')
                            ->default('Belirtilmedi')
                            ->inlineLabel(),
                        TextEntry::make('height')
                            ->label('Boy :')
                            ->placeholder('Belirtilmedi')
                            ->default('Belirtilmedi')
                            ->inlineLabel(),
                        TextEntry::make('page_count')
                            ->label('Varak Numarası :')
                            ->placeholder('Belirtilmedi')
                            ->default('Belirtilmedi')
                            ->inlineLabel(),
                        TextEntry::make('font')
                            ->label('Yazım Türü :')
                            ->placeholder('Belirtilmedi')
                            ->default('Belirtilmedi')
                            ->inlineLabel(),
                        TextEntry::make('dates.year')
                            ->label('İstinsah Tarih(leri) :')
                            ->placeholder('Belirtilmedi')
                            ->default('Belirtilmedi')
                            ->inlineLabel(),
                        TextEntry::make('info')
                            ->label('Nüsha Bilgisi :')
                            ->html()
                            ->placeholder('Belirtilmedi')
                            ->default('Belirtilmedi')
                            ->inlineLabel(),
                        SpatieMediaLibraryImageEntry::make('cover')
                            ->label('Nüsha Kapağı :')
                            ->inlineLabel()
                            ->disk('media')
                            ->placeholder('Belirtilmedi')
                            ->default('Belirtilmedi')
                            ->collection('copy_covers'),
                        TextEntry::make('is_draft')
                            ->label('Yayında Mı :')
                            ->placeholder('Belirtilmedi')
                            ->default('Belirtilmedi')
                            ->inlineLabel(),
                    ])
            ]);
    }

    public  function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Nüsha Ekle')
                    ->description('Nüsha bilgilerini giriniz.')
                    ->reactive()
                    ->columns(2)
                    ->schema(components: [
                        Forms\Components\TextInput::make('library')->label('Kütüphane')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('collection')->label('Koleksiyon')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('number')->label('Numara')
                            ->maxLength(255)->required(),
                        Forms\Components\TextInput::make('procure')->label('Temin')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('width')->label('En')
                            ->maxLength(255)->numeric(),
                        Forms\Components\TextInput::make('height')->label('Boy')
                            ->maxLength(255)->numeric(),
                        Forms\Components\TextInput::make('page_count')->label('Varak Numarası')
                            ->maxLength(255),
                        Select::make('font')
                            ->label('Yazım Türü')
                            ->options(Copy::$fonts)
                            ->live()
                            ->preload()
                            ->placeholder('ör: Sülüs, Nesih, Rika, Talik')
                            ->native(false),
                        Forms\Components\Repeater::make('dates')
                            ->label('İstinsah Tarihleri')
                            ->live()
                            ->deletable()
                            ->addable()
                            ->relationship('dates')
                            ->columns(4)
                            ->defaultItems(1)
                            ->schema([
                                Date::makeSectionWithoutRelation('istinsah_date', 'İstinsah Tarihi', 'İstinsah Tarihini giriniz.'),
                            ]),
                        Forms\Components\RichEditor::make('info')
                            ->label('Nüsha Bilgisi')
                            ->placeholder('Nüsha ile ilgili açıklama yazınız.')
                            ->disableToolbarButtons([
                                'attachFiles',
                                'blockquote',
                                'codeBlock',
                                'link',
                                'orderedList'])
                            ->columnSpanFull(),
                        TextInput::make('slug')
                            ->label('Yazar Slug')
                            ->maxLength(255)
                            ->placeholder('Eser Adı')
                            ->autocapitalize()
                            ->readOnly()
                            ->hidden(),
                    ]),
                Section::make('Nüsha Yükle')
                    ->description('Nüsha yükleme kısmı. PDF seçerek yükleme yapabilirsiniz.')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('content')
                            ->label('Nüsha Dosyası')
                            ->disk('media')
                            ->collection('copy_pdfs')
                            ->downloadable()
                            ->openable()
                            ->acceptedFileTypes(['application/pdf'])
                            ->maxSize(102400)
                            ->appendFiles()
                            ->previewable(),
                        SpatieMediaLibraryFileUpload::make('cover')
                            ->label('Nüsha Kapağı')
                            ->disk('media')
                            ->optimize('webp')->collection('copy_covers')
                            ->downloadable()
                            ->openable()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/vnd.wap.wbmp'])
                            ->maxSize(102400)
                            ->image()
                            ->imageEditor()
                            ->imageEditorAspectRatios([null, '16:9', '4:3', '1:1',])
                            ->appendFiles()
                            ->previewable(),
                        Forms\Components\Toggle::make('is_draft')
                            ->label('Sayfada Gösterilsin Mi?')
                            ->onColor('success')
                            ->offColor('danger')
                            ->default(true)
                    ])
            ]);
    }

    public  function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                Tables\Columns\TextColumn::make('name')->label('Nüsha Adı')
                    ->numeric()
                    ->sortable()
                    ->placeholder('Belirtilmedi')
                    ->default('Belirtilmedi')
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('artifact.name')
                    ->label('Eser Adı')
                    ->numeric()
                    ->sortable()
                    ->placeholder('Belirtilmedi')
                    ->default('Belirtilmedi')
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('number')
                    ->label('Numara')
                    ->searchable()
                    ->placeholder('Belirtilmedi')
                    ->default('Belirtilmedi')
                    ->limit(25)
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('procure')
                    ->label('Temin')
                    ->searchable()
                    ->placeholder('Belirtilmedi')
                    ->default('Belirtilmedi')
                    ->limit(25)
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('font')
                    ->label('Yazım Türü')
                    ->searchable()
                    ->placeholder('Belirtilmedi')
                    ->default('Belirtilmedi')
                    ->limit(25)
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\SpatieMediaLibraryImageColumn::make('cover')
                    ->collection('copy_covers')
                    ->square()
                    ->placeholder('Belirtilmedi')
                    ->default('Belirtilmedi')
                    ->toggleable()
                    ->label('Kapak'),
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
