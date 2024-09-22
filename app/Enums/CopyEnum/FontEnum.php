<?php

namespace App\Enums\CopyEnum;

use Filament\Support\Contracts\HasLabel;

enum FontEnum: string implements HasLabel {

    case THULUTH = 'thuluth';
    case NASKH = 'naskh';
    case RIQA = 'riqa';
    case TALIQ = 'taliq';

    public function getLabel(): ?string
    {

        return match ($this) {
            self::THULUTH => 'Sülüs',
            self::NASKH => 'Nesih',
            self::RIQA => 'Rika',
            self::TALIQ => 'Talik',
        };
    }

}
