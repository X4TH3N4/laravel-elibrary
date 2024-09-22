<?php

namespace App\Models;

use App\Enums\DateEnum\DateTypeEnum;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Date extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'day',
        'month',
        'year',
        'type',
    ];

    public static array $date_types = [
        'Hicri' => 'Hicri',
        'Miladi' => 'Miladi',
        'Rumi' => 'Rumi'
    ];

    public static function field($required): array
    {
        $select = Select::make('type')
            ->label('Türü')
            ->options(self::$date_types)
            ->native(false)
            ->preload();

        if ($required) {
            $select = Select::make('type')
                ->label('Türü')
                ->options(self::$date_types)
                ->default(self::$date_types['Miladi'])
                ->native(false)
                ->required()
                ->preload();
        }

        return [
            $select,
            TextInput::make('day')
                ->numeric()
                ->label('Gün')
                ->maxValue(31)
                ->minValue(1),
            TextInput::make('month')
                ->numeric()
                ->label('Ay')
                ->maxValue(12)
                ->minValue(1),
            TextInput::make('year')
                ->label('Yıl')
                ->maxValue(2023)
                ->minValue(1),
        ];
    }

    public static function makeSection($setRelationName, $setRelationAttribute, $setMake = 'date', $setName = 'Tarih', $setDescription = '', $required = false): Section
    {
        return Section::make($setMake . '_id')
            ->heading($setName)
            ->relationship($setRelationName, $setRelationAttribute)
            ->description($setDescription)
            ->schema(self::field($required)
            )
            ->columns(2);
    }
    public static function makeSectionWithoutRelation($setMake = 'date', $setName = 'Tarih', $setDescription = '', $required = false): Section
    {
        return Section::make($setMake . '_id')
            ->heading($setName)
            ->description($setDescription)
            ->schema(self::field($required)
            )
            ->columns(2);
    }

    public function artifacts(): BelongsToMany
    {
        return $this->belongsToMany(Artifact::class);
    }

    public function authors(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Author::class);
    }

    public function copies(): BelongsToMany
    {
        return $this->belongsToMany(Copy::class);
    }

    public function proses(): BelongsToMany
    {
        return $this->belongsToMany(Prose::class);
    }

}
