<?php

namespace App\Enums\ArtifactEnum;

use Filament\Support\Contracts\HasLabel;

enum StyleEnum: string implements HasLabel {

    case PROSE = 'prose';
    case POETIC = 'poetic';

    public function getLabel(): ?string
    {

        return match ($this) {
            self::PROSE => 'Mensur',
            self::POETIC => 'Manzum'
        };
    }

}
