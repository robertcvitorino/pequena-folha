<?php

namespace App\Filament\Mav\Resources\CompostagemResource\Pages;

use App\Filament\Mav\Resources\CompostagemResource;
use App\Filament\Mav\Resources\CompostagemResource\Form\CompostagemForm;
use App\Filament\Resources\VisitaResource\Forms\VisitaForm;
use App\Models\Compostagem;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\CreateRecord\Concerns\HasWizard;
use Illuminate\Support\Facades\Auth;

class CreateCompostagem extends CreateRecord
{
    protected static string $resource = CompostagemResource::class;

    use HasWizard;

    public function getSteps(): array
    {
        return [
            ...CompostagemForm::getSteps()
        ];
    }
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();
        return $data;
    }
}
