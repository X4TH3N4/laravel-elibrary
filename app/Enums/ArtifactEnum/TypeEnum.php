<?php

namespace App\Enums\ArtifactEnum;

use Filament\Support\Contracts\HasLabel;

enum TypeEnum: string implements HasLabel {

    case MEMOIR = 'memoir';
    case DIARY = 'diary';
    case BIOGRAPHY = 'biography';
    case AUTOBIOGRAPHY = 'autobiography';

    case OTHER = 'other';
    public function getLabel(): ?string
    {

        return match ($this) {
            self::OTHER => 'Diğer',
            self::MEMOIR => 'Hatırat',
            self::DIARY => 'Günlük',
            self::BIOGRAPHY => 'Biyografi',
            self::AUTOBIOGRAPHY => 'Otobiyografi',
        };
    }

}
