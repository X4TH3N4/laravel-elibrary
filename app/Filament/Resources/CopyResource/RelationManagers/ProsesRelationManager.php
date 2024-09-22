<?php

namespace App\Filament\Resources\CopyResource\RelationManagers;

use App\Enums\ArtifactEnum\LangEnum;
use App\Enums\ArtifactEnum\StyleEnum;
use App\Enums\ProseEnum\VariationEnum;
use App\Models\Artifact;
use App\Models\Author;
use App\Models\Copy;
use App\Models\Date;
use App\Models\Prose;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
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
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Njxqlus\Filament\Components\Infolists\LightboxSpatieMediaLibraryImageEntry;

class ProsesRelationManager extends RelationManager
{
    protected static string $relationship = 'proses';

    protected static ?string $title = 'Neşirler';

    protected static ?string $model = Prose::class;

    protected static ?string $navigationGroup = 'Veri Girişi';
    protected static ?string $modelLabel = 'Neşir';

    protected static ?string $pluralLabel = 'Neşirler';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public  function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                \Filament\Infolists\Components\Section::make()
                    ->schema(components: [
                        TextEntry::make('name')
                            ->label('Neşir Adı :')
                            ->placeholder('Belirtilmedi')
                            ->default('Belirtilmedi')
                            ->inlineLabel(),
                        TextEntry::make('copy.name')
                            ->label('Nüsha Adı :')
                            ->placeholder('Belirtilmedi')
                            ->default('Belirtilmedi')
                            ->inlineLabel(),
                        TextEntry::make('copy.artifact.name')
                            ->label('Eser Adı :')
                            ->placeholder('Belirtilmedi')
                            ->default('Belirtilmedi')
                            ->inlineLabel(),
                        TextEntry::make('source')
                            ->label('Kaynak :')
                            ->placeholder('Belirtilmedi')
                            ->default('Belirtilmedi')
                            ->inlineLabel(),
                        TextEntry::make('isbn')
                            ->label('ISBN :')
                            ->placeholder('Belirtilmedi')
                            ->default('Belirtilmedi')
                            ->inlineLabel(),
                        TextEntry::make('variation')
                            ->label('Çeşit :')
                            ->placeholder('Belirtilmedi')
                            ->default('Belirtilmedi')
                            ->inlineLabel(),
                        TextEntry::make('ref_info')
                            ->html()
                            ->label('Referans Bilgisi :')
                            ->placeholder('Belirtilmedi')
                            ->default('Belirtilmedi')
                            ->inlineLabel(),
                        TextEntry::make('dates.year')
                            ->label('Basım Tarihi :')
                            ->placeholder('Belirtilmedi')
                            ->default('Belirtilmedi')
                            ->inlineLabel(),
                        SpatieMediaLibraryImageEntry::make('cover')
                            ->label('Eser Kapağı :')
                            ->inlineLabel()
                            ->disk('media')
                            ->placeholder('Belirtilmedi')
                            ->default('Belirtilmedi')
                            ->collection('prose_covers'),
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
                Section::make('Neşir Ekle')
                    ->description('Neşir bilgilerini giriniz.')
                    ->reactive()
                    ->columns(2)
                    ->schema(components: [
                        Forms\Components\TextInput::make('source')->label('Kaynak')
                            ->maxLength(255)->required()->autocapitalize(),
                        Forms\Components\TextInput::make('isbn')->label('ISBN')
                            ->maxLength(255)->required(),
                        Select::make('variation')->label('Çeşit')
                            ->options(Prose::$variations)->placeholder('örnek: Matbu, Transkripsiyon, Transliterasyon')->native(false),
                        RichEditor::make('ref_info')
                            ->label('Referans Bilgisi')
                            ->placeholder('Referans ile ilgili açıklama yazınız.')
                            ->disableToolbarButtons([
                                'attachFiles',
                                'blockquote',
                                'codeBlock',
                                'link',
                                'orderedList'])
                            ->columnSpanFull(),
                        Forms\Components\Repeater::make('publication_date')
                            ->label('Basım Tarihleri')
                            ->live()
                            ->deletable()
                            ->addable()
                            ->relationship('dates')
                            ->columns(4)
                            ->defaultItems(1)
                            ->schema([
                                Date::makeSectionWithoutRelation('publication_date', 'Basım Tarihi', 'Basım tarihi bilgilerini giriniz.'),
                            ]),
                        Section::make('Neşir Yükle')
                            ->description('Neşir yükleme kısmı. PDF seçerek yükleme yapabilirsiniz.')
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('content')
                                    ->label('Neşir Dosyası')
                                    ->disk('media')
                                    ->collection('prose_pdfs')
                                    ->downloadable()
                                    ->openable()
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->maxSize(102400)
                                    ->appendFiles()
                                    ->previewable(),
                                SpatieMediaLibraryFileUpload::make('cover')
                                    ->label('Neşir Kapağı')
                                    ->disk('media')
                                    ->optimize('webp')->collection('prose_covers')
                                    ->downloadable()->openable()
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/vnd.wap.wbmp'])
                                    ->maxSize(102400)
                                    ->image()
                                    ->imageEditor()
                                    ->imageEditorAspectRatios([null, '16:9', '4:3', '1:1',])
                                    ->appendFiles()
                                    ->previewable()
                            ]),
                        Forms\Components\Toggle::make('is_draft')->default(true)->label('Sayfada Göster'),
                        TextInput::make('slug')
                            ->label('Yazar Slug')
                            ->maxLength(255)
                            ->placeholder('Eser Adı')
                            ->autocapitalize()
                            ->readOnly()
                            ->hidden(),
                    ])
            ]);
    }

    public  function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('ID')->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->numeric()
                    ->sortable()
                    ->placeholder('Belirtilmedi')
                    ->default('Belirtilmedi')
                    ->searchable()
                    ->label('Neşir Adı'),
                Tables\Columns\TextColumn::make('copy.name')
                    ->numeric()
                    ->sortable()
                    ->hidden()
                    ->placeholder('Belirtilmedi')
                    ->default('Belirtilmedi')
                    ->searchable()
                    ->label('Nüsha Adı'),
                Tables\Columns\TextColumn::make('copy.artifact.name')
                    ->numeric()
                    ->sortable()
                    ->placeholder('Belirtilmedi')
                    ->default('Belirtilmedi')
                    ->searchable()
                    ->label('Eser Adı'),
                Tables\Columns\TextColumn::make('isbn')
                    ->placeholder('Belirtilmedi')
                    ->default('Belirtilmedi')
                    ->searchable()->sortable(),
                Tables\Columns\SpatieMediaLibraryImageColumn::make('cover')
                    ->collection('prose_covers')
                    ->square()
                    ->placeholder('Belirtilmedi')
                    ->default('Belirtilmedi')
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
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
}
