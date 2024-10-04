<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum TipoResiduo: int implements HasColor, HasLabel, HasIcon
{
    case Organico = 0;
    case Inorganico = 1;
    case Rejeito = 2;

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Organico => 'warning',
            self::Inorganico => 'success',
            self::Rejeito => 'danger'
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Organico => 'fas-clock',
            self::Inorganico => 'polaris-payment-icon',
            self::Rejeito => 'fas-xmark'
        };
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::Organico => 'Organico',
            self::Inorganico => 'Inorganico',
            self::Rejeito => 'Rejeito'
        };
    }
}
