<?php

namespace App\Enums\ArtifactEnum;

use Filament\Support\Contracts\HasLabel;

enum LangEnum: string implements HasLabel {

    case ARABIC = 'arabic';
    case PERSIAN = 'persian';
    case OTTOMAN = 'ottoman';


    public function getLabel(): ?string
    {

        return match ($this) {
            self::ARABIC => 'Arapça',
            self::PERSIAN => 'Farsça',
            self::OTTOMAN => 'Osmanlıca'
        };
    }
}
