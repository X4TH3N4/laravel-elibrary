<?php

namespace App\Enums\DateEnum;

use Filament\Support\Contracts\HasLabel;

enum DateTypeEnum: string implements HasLabel {

    case HIJRI = 'hijri';
    case GREGORIAN = 'gregorian';
    case RUMI = 'rumi';

    public function getLabel(): ?string
    {

        return match ($this) {
            self::HIJRI => 'Hicri',
            self::GREGORIAN => 'Miladi',
            self::RUMI => 'Rumi',
        };
    }

}
