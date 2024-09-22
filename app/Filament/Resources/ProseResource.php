<?php

namespace App\Filament\Resources;

use App\Enums\ArtifactEnum\LangEnum;
use App\Enums\ArtifactEnum\QualityEnum;
use App\Enums\ArtifactEnum\StyleEnum;
use App\Enums\ArtifactEnum\TypeEnum;
use App\Enums\CopyEnum\FontEnum;
use App\Enums\ProseEnum\VariationEnum;
use App\Filament\Resources\ProseResource\Pages;
use App\Filament\Resources\ProseResource\RelationManagers;
use App\Models\Artifact;
use App\Models\Author;
use App\Models\Copy;
use App\Models\Date;
use App\Models\Event;
use App\Models\Prose;
use Carbon\Carbon;
use Filament\Actions\ActionGroup;
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
use Filament\Resources\Resource;
use Filament\Support\Enums\ActionSize;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Njxqlus\Filament\Components\Infolists\LightboxSpatieMediaLibraryImageEntry;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class ProseResource extends Resource
{
    protected static ?string $model = Prose::class;
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $navigationGroup = 'Veri Girişi';
    protected static ?string $modelLabel = 'Neşir';

    protected static ?string $pluralLabel = 'Neşirler';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $activeNavigationIcon = 'heroicon-s-book-open';
    protected static ?string $navigationLabel = 'Neşirler';

    public static function infolist(Infolist $infolist): Infolist
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

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Neşir Ekle')
                    ->description('Neşir bilgilerini giriniz.')
                    ->reactive()
                    ->columns(2)
                    ->schema(components: [
                        Select::make('copy_id')
                            ->native(false)
                            ->label('Nüsha')
                            ->searchable()
                            ->live()
                            ->preload()
                            ->required()
                            ->relationship('copy', 'name')
                            ->createOptionForm([
                                Section::make('Nüsha Ekle')
                                    ->description('Nüsha bilgilerini giriniz.')
                                    ->reactive()
                                    ->columns(2)
                                    ->schema(components: [
                                        Select::make('artifact_id')
                                            ->label('Eser')
                                            ->native(false)
                                            ->preload()
                                            ->live()
                                            ->required()
                                            ->searchable()
                                            ->relationship('artifact', 'name')
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
                                                        Select::make('author_id')
                                                            ->native(false)
                                                            ->relationship('authors', 'name')
                                                            ->label('Yazar')
                                                            ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->name}")
                                                            ->searchable()
                                                            ->multiple()
                                                            ->preload()
                                                            ->live()
                                                            ->reactive()
                                                            ->createOptionForm([
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
                                                            ])
                                                            ->editOptionForm([
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
                                                            ]),
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
                                                        Select::make('author_id')
                                                            ->native(false)
                                                            ->relationship('authors', 'name')
                                                            ->label('Yazar')
                                                            ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->name}")
                                                            ->searchable()
                                                            ->multiple()
                                                            ->preload()
                                                            ->live()
                                                            ->reactive()
                                                            ->createOptionForm([
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
                                                            ])
                                                            ->editOptionForm([
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
                                                            ]),
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
                            ])
                            ->editOptionForm([
                                Section::make('Nüsha Ekle')
                                    ->description('Nüsha bilgilerini giriniz.')
                                    ->reactive()
                                    ->columns(2)
                                    ->schema(components: [
                                        Select::make('artifact_id')
                                            ->label('Eser')
                                            ->native(false)
                                            ->preload()
                                            ->live()
                                            ->required()
                                            ->searchable()
                                            ->relationship('artifact', 'name')
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
                                                        Select::make('author_id')
                                                            ->native(false)
                                                            ->relationship('authors', 'name')
                                                            ->label('Yazar')
                                                            ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->name}")
                                                            ->searchable()
                                                            ->multiple()
                                                            ->preload()
                                                            ->live()
                                                            ->reactive()
                                                            ->createOptionForm([
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
                                                            ])
                                                            ->editOptionForm([
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
                                                            ]),
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
                                                        Select::make('author_id')
                                                            ->native(false)
                                                            ->relationship('authors', 'name')
                                                            ->label('Yazar')
                                                            ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->name}")
                                                            ->searchable()
                                                            ->multiple()
                                                            ->preload()
                                                            ->live()
                                                            ->reactive()
                                                            ->createOptionForm([
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
                                                            ])
                                                            ->editOptionForm([
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
                                                            ]),
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
                            ]),
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

    public static function table(Table $table): Table
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
                ExportBulkAction::make(),
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

    public static function getRelations(): array
    {
        return [
            RelationManagers\CopyRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProses::route('/'),
            'create' => Pages\CreateProse::route('/create'),
            'view' => Pages\ViewProse::route('/{record}'),
            'edit' => Pages\EditProse::route('/{record}/edit'),
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
