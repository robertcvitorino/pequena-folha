<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum TipoResiduo: int implements HasColor, HasLabel, HasIcon
{
    case Organico = 1;
    case Inorganico = 2;
    case Rejeito = 3;



    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Organico => 'success',
            self::Inorganico => 'warning',
            self::Rejeito => 'danger'
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Organico => 'iconoir-organic-food',
            self::Inorganico => 'fas-recycle',
            self::Rejeito => 'heroicon-s-trash'
        };
    }

    public function  getLabel(): string
    {
        return match ($this) {
            self::Organico => 'Organico',
            self::Inorganico => 'Inorganico',
            self::Rejeito => 'Rejeito'
        };
    }

}
