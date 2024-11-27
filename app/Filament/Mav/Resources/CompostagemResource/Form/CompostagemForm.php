<?php

namespace App\Filament\Mav\Resources\CompostagemResource\Form;

use App\Enums\TipoResiduo;
use App\Models\Material;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\HtmlString;

abstract class CompostagemForm
{

    public static function getFormSchema(): array
    {
        return [
            Repeater::make('compostagens_repeater')
                ->columns(2)
                ->columnSpanFull()
                ->schema([
                    Select::make('tipo')
                        ->options(TipoResiduo::class)
                        ->afterStateUpdated(function (Set $set) {
                            $set('material_id', null);
                        })
                        ->default(TipoResiduo::Organico->value)
                        ->required()
                        ->live(),

                    DateTimePicker::make('data')
                        ->default(now())
                        ->columns(1),

                    Hidden::make('user_id')
                        ->default(auth()->user()->id)
                        ->disabled(),

                    Select::make('material_id')
                        ->options(fn(Get $get) => Material::query()
                            ->where('tipo', $get('tipo'))
                            ->pluck('descricao', 'id'))
                        ->label('Material')
                        ->multiple()
                        ->columns(1)
                        ->live()
                        ->required(),

                    TextInput::make('descricao')
                        ->label('Outros materiais')
                        ->maxLength(255),

                    Radio::make('volume.quantidade')
                        ->label('Volume')
                        ->columns(2)
                        ->reactive()
                        ->required()
                        ->options(function (Get $get) {
                            $tipo = $get('tipo');

                            if ($tipo == TipoResiduo::Inorganico->value) {
                                return [
                                    'Sacola de supermercado (5 Litros)' => 'Sacola de supermercado (5 Litros)',
                                    'Saco de lixo (15 Litros)' => 'Saco de lixo (15 Litros)',
                                    'Saco de lixo (30 Litros)' => 'Saco de lixo (30 Litros)',
                                    'Saco de lixo (50 Litros)' => 'Saco de lixo (50 Litros)',
                                    'Mais de 50 Litros' => 'Mais de 50 Litros',
                                    'O' => 'Outro',
                                ];
                            } else if ($tipo == TipoResiduo::Organico->value) {

                                return [
                                    '1 pote de sorvete cheio' => '1 pote de sorvete cheio',
                                    '1/2 pote de sorvete' => '1/2 pote de sorvete',
                                    '2 potes de sorvete cheios' => '2 potes de sorvete cheios',
                                    '1 pote e 1/2 de sorvete' => '1 pote e 1/2 de sorvete',
                                    '1/3 do pote de sorvete' => '1/3 do pote de sorvete',
                                    'O' => 'Outro',
                                ];
                            } else if ($tipo == TipoResiduo::Rejeito->value) {
                                return [
                                    'Sacola de supermercado (5 Litros)' => 'Sacola de supermercado (5 Litros)',
                                    'Saco de lixo (15 Litros)' => 'Saco de lixo (15 Litros)',
                                    'Saco de lixo (30 Litros)' => 'Saco de lixo (30 Litros)',
                                    'Saco de lixo (50 Litros)' => 'Saco de lixo (50 Litros)',
                                    'Mais de 50 Litros' => 'Mais de 50 Litros',
                                    'O' => 'Outro',
                                ];

                            }

                        })
                        ->required(),


                    TextInput::make('volume.outro')
                        ->label('Outro')
                        ->required()
                        ->requiredIf('quantidade', fn(Get $get) => $get('volume.quantidade') == 'O')
                        ->visible(fn(Get $get) => $get('volume.quantidade') == 'O'),

                ])->addActionLabel('Nova compostagem')
        ];
    }

    public static function getSteps(): array
    {
        return [
            Step::make('Fotos')
                ->schema([
                    FileUpload::make('foto')
                        ->hiddenLabel()
                        ->label('Foto de identificação')
                        ->optimize('webp')
                        ->placeholder(fn() => new HtmlString('<span><a class="text-primary-600 font-bold">Clique aqui</a></br>Para adicionar uma foto sua</span>'))
                        ->resize(15)
                        ->alignCenter()
                        ->multiple()
                        ->panelLayout('grid')
                        ->directory('foto-formulario')
                        ->previewable(true)
                        ->columnSpan(1)
                        ->required(),
                ]),

            Step::make('Residuo')
                ->columns(2)
                ->schema(self::getFormSchema()),

        ];
    }
}
