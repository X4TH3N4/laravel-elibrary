<?php

namespace App\Enums\ArtifactEnum;

use Filament\Support\Contracts\HasLabel;

enum QualityEnum: string implements HasLabel {

    case DETACHED = 'detached';
    case PARTIAL = 'partial';
    case FRAGMENTED = 'fragmented';

    case OTHER = 'other';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::DETACHED => 'Müstakil',
            self::PARTIAL => 'Kısmi',
            self::FRAGMENTED => 'Parçalı',
            self::OTHER => 'Diğer'
        };
    }
}
