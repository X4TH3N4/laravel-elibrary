<?php

namespace App\Filament\Resources;

use App\Enums\ArtifactEnum\LangEnum;
use App\Enums\ArtifactEnum\QualityEnum;
use App\Enums\ArtifactEnum\StyleEnum;
use App\Enums\ArtifactEnum\TypeEnum;
use App\Filament\Resources\ArtifactResource\RelationManagers\CopiesRelationManager;
use App\Filament\Resources\AuthorResource\Pages;
use App\Filament\Resources\AuthorResource\RelationManagers;
use App\Filament\Resources\AuthorResource\RelationManagers\ArtifactsRelationManager;
use App\Filament\Resources\AuthorResource\RelationManagers\EventsRelationManager;
use App\Models\Artifact;
use App\Models\Author;
use App\Models\City;
use App\Models\Date;
use App\Models\Event;
use App\Models\Occupation;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
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
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationGroup;
use Filament\Resources\Resource;
use Filament\Support\Enums\ActionSize;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Kainiklas\FilamentScout\Traits\InteractsWithScout;
use Njxqlus\Filament\Components\Infolists\LightboxSpatieMediaLibraryImageEntry;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;


class AuthorResource extends Resource
{

    protected static ?string $model = Author::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationGroup = 'Veri Girişi';
    protected static ?string $modelLabel = 'Yazar';

    protected static ?string $pluralLabel = 'Yazarlar';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $activeNavigationIcon = 'heroicon-s-users';

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                \Filament\Infolists\Components\Section::make()
                    ->schema(components: [
                        TextEntry::make('name')
                            ->label('Tam Ad :')
                            ->placeholder('Belirtilmedi')
                            ->default('Belirtilmedi')
                            ->inlineLabel(),
                        TextEntry::make('occupations.name')
                            ->label('Meslek(ler) :')
                            ->placeholder('Belirtilmedi')
                            ->default('Belirtilmedi')
                            ->inlineLabel(),
                        TextEntry::make('author_info')
                            ->label('Yazar Bilgisi :')
                            ->html()
                            ->placeholder('Belirtilmedi')
                            ->default('Belirtilmedi')
                            ->inlineLabel(),
                        TextEntry::make('cities.name')
                            ->label('Yaşadığı Şehir(ler) :')
                            ->placeholder('Belirtilmedi')
                            ->default('Belirtilmedi')
                            ->inlineLabel(),
                        TextEntry::make('artifacts.name')
                            ->label('Eser(leri) :')
                            ->placeholder('Belirtilmedi')
                            ->default('Belirtilmedi')
                            ->inlineLabel(),
                        TextEntry::make('birthLocation.name')
                            ->label('Doğum Yeri :')
                            ->placeholder('Belirtilmedi')
                            ->default('Belirtilmedi')
                            ->inlineLabel(),
                        TextEntry::make('birthDates.year')
                            ->label('Doğum Tarih(leri) :')
                            ->placeholder('Belirtilmedi')
                            ->default('Belirtilmedi')
                            ->inlineLabel(),
                        TextEntry::make('deathLocation.name')
                            ->label('Ölüm Yeri :')
                            ->placeholder('Belirtilmedi')
                            ->default('Belirtilmedi')
                            ->inlineLabel(),
                        TextEntry::make('deathDates.year')
                            ->label('Ölüm Tarih(leri) :')
                            ->placeholder('Belirtilmedi')
                            ->default('Belirtilmedi')
                            ->inlineLabel(),
                        SpatieMediaLibraryImageEntry::make('author')
                            ->label('Yazar Resmi :')
                            ->inlineLabel()
                            ->disk('media')
                            ->circular()
                            ->placeholder('Belirtilmedi')
                            ->default('Belirtilmedi')
                            ->collection('author_pictures'),
                    ])
            ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Yazar Ekle')
                    ->description('Yazar eklemek için aşağıdaki bilgileri doldurun.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Tam Adı')
                            ->maxLength(255)
                            ->required()
                            ->autocapitalize()
                            ->required(),
                        Select::make('occupation_id')
                            ->label('Meslek')
                            ->native(false)
                            ->preload()
                            ->live()
                            ->searchable()
                            ->multiple()
                            ->relationship('occupations', 'name')
                            ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->name}"),
                        RichEditor::make('author_info')
                            ->label('Yazar Açıklaması')
                            ->placeholder('Yazar ile ilgili açıklama yazınız.')
                            ->disableToolbarButtons([
                                'attachFiles',
                                'blockquote',
                                'codeBlock',
                                'link',
                                'orderedList'])
                            ->columnSpanFull(),
                        Select::make('city_id')
                            ->label('Yaşadığı Şehirler')
                            ->native(false)
                            ->searchable()
                            ->live()
                            ->preload()
                            ->multiple()
                            ->relationship('cities', 'name')
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->label('Şehir Adı')
                                    ->validationAttribute('Şehir Adı')
                                    ->maxLength(255)
                            ])
                            ->editOptionForm([
                                TextInput::make('name')
                                    ->label('Şehir Adı')
                                    ->validationAttribute('Şehir Adı')
                                    ->maxLength(255)
                            ]),
                        Select::make('artifact_id')
                            ->label('Eser')
                            ->native(false)
                            ->preload()
                            ->live()
                            ->searchable()
                            ->multiple()
                            ->relationship('artifacts', 'name')
                            ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->name}")
                            ->createOptionForm([
                                Section::make('Artifact')
                                    ->heading('Eser Bilgisi')
                                    ->description('Aşağıdan eser detaylarını doldurunuz.')
                                    ->reactive()
                                    ->columns(2)
                                    ->schema(components: [
                                        TextInput::make('name')
                                            ->label('Eser Adı')
                                            ->maxLength(255)
                                            ->required()
                                            ->unique(ignoreRecord: true)
                                            ->placeholder('Eser Adı')
                                            ->autocapitalize(),
                                        Select::make('type')
                                            ->live()
                                            ->preload()
                                            ->native(false)
                                            ->label('Tür')
                                            ->options(Artifact::$types)
                                            ->placeholder('ör: Hatırat, Günlük, Biyografi')
                                            ->required(),
                                        TextInput::make('type_description')
                                            ->label('Tür Açıklaması')
                                            ->validationAttribute('Tür Açıklaması')
                                            ->maxLength(255)
                                            ->autocapitalize()
                                            ->hidden(fn(Get $get): string => $get('type') !== 'Diğer'),
                                        Select::make('style')
                                            ->live()
                                            ->preload()
                                            ->label('Tarz')
                                            ->options(Artifact::$styles)
                                            ->native(false)
                                            ->placeholder('ör: Mensur, Manzum')
                                            ->required(),
                                        Select::make('lang')
                                            ->live()
                                            ->preload()
                                            ->label('Dil')
                                            ->options(Artifact::$langs)
                                            ->placeholder('ör: Arapça, Farsça, Osmanlıca')
                                            ->native(false)
                                            ->required(),
                                        TextInput::make('lang_description')
                                            ->label('Dil')
                                            ->validationAttribute('Dil Açıklaması')
                                            ->helperText('Lütfen diğer dili belirtiniz.')
                                            ->maxLength(255)
                                            ->autocapitalize()
                                            ->hidden(fn(Get $get): string => $get('lang') !== 'Diğer'),
                                        Select::make('quality')
                                            ->reactive()
                                            ->live()
                                            ->preload()
                                            ->label('Nitelik')
                                            ->options(Artifact::$qualities)
                                            ->placeholder('ör: Müstakil, Kısmi, Parçalı, Diğer')
                                            ->native(false),
                                        TextInput::make('quality_description')
                                            ->label('Nitelik Açıklaması')
                                            ->validationAttribute('Nitelik Açıklaması')
                                            ->maxLength(255)
                                            ->autocapitalize()
                                            ->hidden(fn(Get $get): string => $get('quality') !== 'Diğer'),
                                        Select::make('writing_location_id')
                                            ->label('Yazım Yeri')
                                            ->relationship('writingLocation', 'name')
                                            ->native(false)
                                            ->preload()
                                            ->live()
                                            ->searchable()
                                            ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->name}")
                                            ->createOptionForm([
                                                TextInput::make('name')
                                                    ->label('Konum Adı')
                                                    ->maxLength(255)
                                                    ->requiredWith(['type']),
                                                TextInput::make('whg_pid')->hidden()
                                                    ->numeric()
                                                    ->label('WHG Kodu')
                                                    ->requiredWithout(['lon', 'lat']),
                                                TextInput::make('lon')
                                                    ->numeric()
                                                    ->label('Boylam')
                                                    ->requiredWith('lat'),
                                                TextInput::make('lat')
                                                    ->numeric()
                                                    ->label('Enlem')
                                                    ->requiredWith('lon')
                                            ])
                                            ->editOptionForm([
                                                TextInput::make('name')
                                                    ->label('Konum Adı')
                                                    ->maxLength(255)
                                                    ->requiredWith(['type']),
                                                TextInput::make('whg_pid')->hidden()
                                                    ->numeric()
                                                    ->label('WHG Kodu')
                                                    ->requiredWithout(['lon', 'lat']),
                                                TextInput::make('lon')
                                                    ->numeric()
                                                    ->label('Boylam')
                                                    ->requiredWith('lat'),
                                                TextInput::make('lat')
                                                    ->numeric()
                                                    ->label('Enlem')
                                                    ->requiredWith('lon')
                                            ]),
                                        Forms\Components\Repeater::make('dates')
                                            ->label('Yazım Tarihleri')
                                            ->live()
                                            ->deletable()
                                            ->addable()
                                            ->relationship('dates')
                                            ->columns(4)
                                            ->defaultItems(1)
                                            ->schema([
                                                Date::makeSectionWithoutRelation('writing_date', 'Yazım Tarihi', 'Yazım Tarihini giriniz.'),
                                            ]),
                                    ]),
                                TextInput::make('slug')
                                    ->label('Eser Slug')
                                    ->maxLength(255)
                                    ->placeholder('Eser Adı')
                                    ->autocapitalize()
                                    ->readOnly()
                                    ->hidden(),
                                Section::make('Eser Açıklaması')
                                    ->description('Aşağıya eser açıklamasını yazınız.')
                                    ->schema([
                                        RichEditor::make('info')
                                            ->label('')
                                            ->placeholder('Eser ile ilgili açıklama yazınız.')
                                            ->disableToolbarButtons([
                                                'attachFiles',
                                                'blockquote',
                                                'codeBlock',
                                                'link',
                                                'orderedList'])
                                            ->columnSpanFull(),
                                    ]),
                                Section::make('Eser Yükle')
                                    ->description('Eser ve eser kapağı yükleme kısmı. PDF seçerek yükleme yapabilirsiniz.')
                                    ->schema([
                                        SpatieMediaLibraryFileUpload::make('content')
                                            ->label('Eser Dosyası')
                                            ->disk('media')
                                            ->collection('artifact_pdfs')
                                            ->downloadable()
                                            ->openable()
                                            ->reorderable()
                                            ->deletable()
                                            ->acceptedFileTypes(['application/pdf'])
                                            ->maxSize(102400)
                                            ->appendFiles()
                                            ->previewable(),
                                        SpatieMediaLibraryFileUpload::make('cover')
                                            ->label('Eser Kapağı')
                                            ->disk('media')
                                            ->optimize('webp')->collection('artifact_covers')
                                            ->downloadable()
                                            ->openable()
                                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/vnd.wap.wbmp'])
                                            ->maxSize(102400)
                                            ->image()
                                            ->reorderable()
                                            ->deletable()
                                            ->imageEditor()
                                            ->imageEditorAspectRatios([null, '16:9', '4:3', '1:1',])
                                            ->appendFiles()
                                            ->previewable(),
                                        Toggle::make('is_draft')
                                            ->label('Ana Sayfada Yayınlansın Mı?')
                                            ->onColor('success')
                                            ->offColor('danger')
                                            ->default(true)
                                    ]),
                            ])
                            ->editOptionForm([
                                Section::make('Artifact')
                                    ->heading('Eser Bilgisi')
                                    ->description('Aşağıdan eser detaylarını doldurunuz.')
                                    ->reactive()
                                    ->columns(2)
                                    ->schema(components: [
                                        TextInput::make('name')
                                            ->label('Eser Adı')
                                            ->maxLength(255)
                                            ->required()
                                            ->unique(ignoreRecord: true)
                                            ->placeholder('Eser Adı')
                                            ->autocapitalize(),
                                        Select::make('type')
                                            ->live()
                                            ->preload()
                                            ->native(false)
                                            ->label('Tür')
                                            ->options(Artifact::$types)
                                            ->placeholder('ör: Hatırat, Günlük, Biyografi')
                                            ->required(),
                                        TextInput::make('type_description')
                                            ->label('Tür Açıklaması')
                                            ->validationAttribute('Tür Açıklaması')
                                            ->maxLength(255)
                                            ->autocapitalize()
                                            ->hidden(fn(Get $get): string => $get('type') !== 'Diğer'),
                                        Select::make('style')
                                            ->live()
                                            ->preload()
                                            ->label('Tarz')
                                            ->options(Artifact::$styles)
                                            ->native(false)
                                            ->placeholder('ör: Mensur, Manzum')
                                            ->required(),
                                        Select::make('lang')
                                            ->live()
                                            ->preload()
                                            ->label('Dil')
                                            ->options(Artifact::$langs)
                                            ->placeholder('ör: Arapça, Farsça, Osmanlıca')
                                            ->native(false)
                                            ->required(),
                                        TextInput::make('lang_description')
                                            ->label('Dil')
                                            ->validationAttribute('Dil Açıklaması')
                                            ->helperText('Lütfen diğer dili belirtiniz.')
                                            ->maxLength(255)
                                            ->autocapitalize()
                                            ->hidden(fn(Get $get): string => $get('lang') !== 'Diğer'),
                                        Select::make('quality')
                                            ->reactive()
                                            ->live()
                                            ->preload()
                                            ->label('Nitelik')
                                            ->options(Artifact::$qualities)
                                            ->placeholder('ör: Müstakil, Kısmi, Parçalı, Diğer')
                                            ->native(false),
                                        TextInput::make('quality_description')
                                            ->label('Nitelik Açıklaması')
                                            ->validationAttribute('Nitelik Açıklaması')
                                            ->maxLength(255)
                                            ->autocapitalize()
                                            ->hidden(fn(Get $get): string => $get('quality') !== 'Diğer'),
                                        Select::make('writing_location_id')
                                            ->label('Yazım Yeri')
                                            ->relationship('writingLocation', 'name')
                                            ->native(false)
                                            ->preload()
                                            ->live()
                                            ->searchable()
                                            ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->name}")
                                            ->createOptionForm([
                                                TextInput::make('name')
                                                    ->label('Konum Adı')
                                                    ->maxLength(255)
                                                    ->requiredWith(['type']),
                                                TextInput::make('whg_pid')->hidden()
                                                    ->numeric()
                                                    ->label('WHG Kodu')
                                                    ->requiredWithout(['lon', 'lat']),
                                                TextInput::make('lon')
                                                    ->numeric()
                                                    ->label('Boylam')
                                                    ->requiredWith('lat'),
                                                TextInput::make('lat')
                                                    ->numeric()
                                                    ->label('Enlem')
                                                    ->requiredWith('lon')
                                            ])
                                            ->editOptionForm([
                                                TextInput::make('name')
                                                    ->label('Konum Adı')
                                                    ->maxLength(255)
                                                    ->requiredWith(['type']),
                                                TextInput::make('whg_pid')->hidden()
                                                    ->numeric()
                                                    ->label('WHG Kodu')
                                                    ->requiredWithout(['lon', 'lat']),
                                                TextInput::make('lon')
                                                    ->numeric()
                                                    ->label('Boylam')
                                                    ->requiredWith('lat'),
                                                TextInput::make('lat')
                                                    ->numeric()
                                                    ->label('Enlem')
                                                    ->requiredWith('lon')
                                            ]),
                                        Forms\Components\Repeater::make('dates')
                                            ->label('Yazım Tarihleri')
                                            ->live()
                                            ->deletable()
                                            ->addable()
                                            ->relationship('dates')
                                            ->columns(4)
                                            ->defaultItems(1)
                                            ->schema([
                                                Date::makeSectionWithoutRelation('writing_date', 'Yazım Tarihi', 'Yazım Tarihini giriniz.'),
                                            ]),
                                    ]),
                                TextInput::make('slug')
                                    ->label('Eser Slug')
                                    ->maxLength(255)
                                    ->placeholder('Eser Adı')
                                    ->autocapitalize()
                                    ->readOnly()
                                    ->hidden(),
                                Section::make('Eser Açıklaması')
                                    ->description('Aşağıya eser açıklamasını yazınız.')
                                    ->schema([
                                        RichEditor::make('info')
                                            ->label('')
                                            ->placeholder('Eser ile ilgili açıklama yazınız.')
                                            ->disableToolbarButtons([
                                                'attachFiles',
                                                'blockquote',
                                                'codeBlock',
                                                'link',
                                                'orderedList'])
                                            ->columnSpanFull(),
                                    ]),
                                Section::make('Eser Yükle')
                                    ->description('Eser ve eser kapağı yükleme kısmı. PDF seçerek yükleme yapabilirsiniz.')
                                    ->schema([
                                        SpatieMediaLibraryFileUpload::make('content')
                                            ->label('Eser Dosyası')
                                            ->disk('media')
                                            ->collection('artifact_pdfs')
                                            ->downloadable()
                                            ->openable()
                                            ->reorderable()
                                            ->deletable()
                                            ->acceptedFileTypes(['application/pdf'])
                                            ->maxSize(102400)
                                            ->appendFiles()
                                            ->previewable(),
                                        SpatieMediaLibraryFileUpload::make('cover')
                                            ->label('Eser Kapağı')
                                            ->disk('media')
                                            ->optimize('webp')->collection('artifact_covers')
                                            ->downloadable()
                                            ->openable()
                                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/vnd.wap.wbmp'])
                                            ->maxSize(102400)
                                            ->image()
                                            ->reorderable()
                                            ->deletable()
                                            ->imageEditor()
                                            ->imageEditorAspectRatios([null, '16:9', '4:3', '1:1',])
                                            ->appendFiles()
                                            ->previewable(),
                                        Toggle::make('is_draft')
                                            ->label('Ana Sayfada Yayınlansın Mı?')
                                            ->onColor('success')
                                            ->offColor('danger')
                                            ->default(true)
                                    ]),
                            ]),
                        Select::make('birth_location_id')
                            ->label('Doğum Yeri')
                            ->relationship('birthLocation', 'name')
                            ->native(false)
                            ->preload()
                            ->live()
                            ->searchable()
                            ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->name}")
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->label('Konum Adı')
                                    ->maxLength(255)
                                    ->requiredWith(['type']),
                                TextInput::make('whg_pid')->hidden()
                                    ->numeric()
                                    ->label('WHG Kodu')
                                    ->requiredWithout(['lon', 'lat']),
                                TextInput::make('lon')
                                    ->numeric()
                                    ->label('Boylam')
                                    ->requiredWith('lat'),
                                TextInput::make('lat')
                                    ->numeric()
                                    ->label('Enlem')
                                    ->requiredWith('lon')
                            ])
                            ->editOptionForm([
                                TextInput::make('name')
                                    ->label('Konum Adı')
                                    ->maxLength(255)
                                    ->requiredWith(['type']),
                                TextInput::make('whg_pid')->hidden()
                                    ->numeric()
                                    ->label('WHG Kodu')
                                    ->requiredWithout(['lon', 'lat']),
                                TextInput::make('lon')
                                    ->numeric()
                                    ->label('Boylam')
                                    ->requiredWith('lat'),
                                TextInput::make('lat')
                                    ->numeric()
                                    ->label('Enlem')
                                    ->requiredWith('lon')
                            ]),
                        Forms\Components\Repeater::make('birthDates')
                        ->label('Doğum Tarihleri')
                        ->live()
                        ->deletable()
                        ->addable()
                            ->defaultItems(1)
                            ->relationship('birthDates')
                        ->columns(4)
                        ->schema([
                            Date::makeSectionWithoutRelation('birth_date', 'Doğum Tarihi', 'Doğum tarihini giriniz.'),
                        ]),
                        Select::make('death_location_id')
                            ->label('Ölüm Yeri')
                            ->relationship('deathLocation', 'name')
                            ->native(false)
                            ->preload()
                            ->live()
                            ->searchable()
                            ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->name}")
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->label('Konum Adı')
                                    ->maxLength(255)
                                    ->requiredWith(['type']),
                                TextInput::make('whg_pid')->hidden()
                                    ->numeric()
                                    ->label('WHG Kodu')
                                    ->requiredWithout(['lon', 'lat']),
                                TextInput::make('lon')
                                    ->numeric()
                                    ->label('Boylam')
                                    ->requiredWith('lat'),
                                TextInput::make('lat')
                                    ->numeric()
                                    ->label('Enlem')
                                    ->requiredWith('lon')
                            ])
                            ->editOptionForm([
                                TextInput::make('name')
                                    ->label('Konum Adı')
                                    ->maxLength(255)
                                    ->requiredWith(['type']),
                                TextInput::make('whg_pid')->hidden()
                                    ->numeric()
                                    ->label('WHG Kodu')
                                    ->requiredWithout(['lon', 'lat']),
                                TextInput::make('lon')
                                    ->numeric()
                                    ->label('Boylam')
                                    ->requiredWith('lat'),
                                TextInput::make('lat')
                                    ->numeric()
                                    ->label('Enlem')
                                    ->requiredWith('lon')
                            ]),
                        Forms\Components\Repeater::make('deathDates')
                            ->label('Ölüm Tarihleri')
                            ->live()
                            ->deletable()
                            ->addable()
                            ->relationship('deathDates')
                            ->columns(4)
                            ->defaultItems(1)
                            ->schema([
                                Date::makeSectionWithoutRelation('death_date', 'Ölüm Tarihi', 'Ölüm tarihini giriniz.'),
                            ]),
                        Section::make('Yazar Resmi Yükle')
                            ->description('Yazar resmi yükleme kısmı. Resim dosyası seçerek yükleme yapabilirsiniz.')
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('author')
                                    ->label('Yazar Resmi')
                                    ->disk('media')
                                    ->optimize('webp')->collection('author_pictures')
                                    ->downloadable()
                                    ->openable()
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/vnd.wap.wbmp'])
                                    ->maxSize(102400)
                                    ->image()
                                    ->reorderable()
                                    ->deletable()
                                    ->imageEditor()
                                    ->imageEditorAspectRatios([null, '16:9', '4:3', '1:1',])
                                    ->appendFiles()
                                    ->previewable(),
                                Toggle::make('is_draft')
                                    ->label('Ana Sayfada Yayınlansın Mı?')
                                    ->onColor('success')
                                    ->offColor('danger')
                                    ->default(true)
                            ]),
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Ad')
                    ->searchable()
                    ->placeholder('Belirtilmedi')
                    ->default('Belirtilmedi')
                    ->sortable()
                    ->limit(50)
                    ->toggleable(),
                Tables\Columns\TextColumn::make('occupations.name')->exists('occupations')
                    ->label('Meslek')
                    ->searchable()
                    ->sortable()
                    ->placeholder('Belirtilmedi')
                    ->default('Belirtilmedi')
                    ->toggleable()
                    ->limit(15),
                TextColumn::make('birthLocation.name')
                    ->label('Doğum Yeri')
                    ->searchable()
                    ->sortable()
                    ->placeholder('Belirtilmedi')
                    ->default('Belirtilmedi')
                    ->toggleable(),
                TextColumn::make('birthDates.year')
                    ->label('Doğum Tarihi')
                    ->placeholder('Belirtilmedi')
                    ->default('Belirtilmedi')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                SpatieMediaLibraryImageColumn::make('author')
                    ->collection('author_pictures')
                    ->circular()
                    ->placeholder('Belirtilmedi')
                    ->default('Belirtilmedi')
                    ->default('Yok')
                    ->label('Resmi'),
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
                    Tables\Actions\ForceDeleteAction::make()])
                    ->label('İşlemler')
                    ->color('info')
                    ->icon('heroicon-m-ellipsis-vertical')
                    ->size(ActionSize::Small)
                    ->button(),
            ])
            ->bulkActions([
                ExportBulkAction::make(),
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\ForceDeleteBulkAction::make(),
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
            RelationGroup::make('AuthorRelation', [
                ArtifactsRelationManager::class,
            ])
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAuthors::route('/'),
            'create' => Pages\CreateAuthor::route('/create'),
            'view' => Pages\ViewAuthor::route('/{record}'),
            'edit' => Pages\EditAuthor::route('/{record}/edit'),
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
