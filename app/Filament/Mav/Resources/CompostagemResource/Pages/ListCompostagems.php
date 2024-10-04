<?php

namespace App\Filament\Mav\Resources\CompostagemResource\Pages;

use App\Filament\Mav\Resources\CompostagemResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCompostagems extends ListRecords
{
    protected static string $resource = CompostagemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
