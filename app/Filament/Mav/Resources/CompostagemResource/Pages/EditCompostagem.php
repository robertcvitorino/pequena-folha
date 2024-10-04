<?php

namespace App\Filament\Mav\Resources\CompostagemResource\Pages;

use App\Filament\Mav\Resources\CompostagemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCompostagem extends EditRecord
{
    protected static string $resource = CompostagemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
