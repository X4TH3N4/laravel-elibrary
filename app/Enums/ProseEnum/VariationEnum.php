<?php

namespace App\Enums\ProseEnum;

use Filament\Support\Contracts\HasLabel;

enum VariationEnum: string implements HasLabel {

    case PRINTED = 'printed';
    case TRANSCRIPTION = 'transcription';
    case TRANSLITERATION = 'transliteration';

    public function getLabel(): ?string
    {

        return match ($this) {
            self::PRINTED => 'Arap Alfabesi / Matbu',
            self::TRANSCRIPTION => 'Latinize / Transkripsiyon',
            self::TRANSLITERATION => 'Transliterasyon',
        };
    }

}
