<?php

namespace App\Filament\Mav\Resources\CompostagemResource\Pages;

use App\Filament\Mav\Resources\CompostagemResource;
use App\Filament\Mav\Resources\CompostagemResource\Form\CompostagemForm;
use App\Filament\Resources\VisitaResource\Forms\VisitaForm;
use Filament\Resources\Pages\CreateRecord;

class CreateCompostagem extends CreateRecord
{
    protected static string $resource = CompostagemResource::class;

    use CreateRecord\Concerns\HasWizard;

    public function getSteps(): array
    {
        return CompostagemForm::getSteps();
    }
}
