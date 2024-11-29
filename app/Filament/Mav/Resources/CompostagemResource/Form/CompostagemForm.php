<?php

namespace App\Filament\Mav\Resources\CompostagemResource\Form;

use App\Enums\TipoResiduo;
use App\Models\Material;
use Carbon\Carbon;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\HtmlString;

abstract class CompostagemForm
{

    public static function getFormResiduoSchema(): array
    {
        return [
            Section::make()
                ->columns(2)
                ->columnSpanFull()
                ->schema([
                    Select::make('tipo')
                        ->options(TipoResiduo::class)
                        ->default(TipoResiduo::Organico->value)
                        ->required()
                        ->live(),

                    DateTimePicker::make('data')
                        ->default(now())
                        ->columns(1),

                    Hidden::make('user_id')
                        ->default(auth()->user()->id)
                        ->disabled(),

                    Select::make('material')
                        ->options(function (Get $get) {
                            $tipo = $get('tipo');
                            if ($tipo == TipoResiduo::Inorganico->value) {
                                return [
                                    'Garrafa PET' => 'Garrafa PET',
                                    'Isopor' => 'Isopor',
                                    'Vidro' => 'Vidro',
                                    'Embalagem em papel' => 'Embalagem em papel',
                                    'Embalagem plástica' => 'Embalagem plástica',
                                    'Papelão' => 'Papelão',
                                    'Metal' => 'Metal',
                                    'Embalagem Tetra Pak ' => 'Embalagem Tetra Pak ',
                                ];
                            } else if ($tipo == TipoResiduo::Organico->value) {
                                return [
                                    'Verduras' => 'Verduras',
                                    'Legumes' => 'Legumes',
                                    'Frutas' => 'Frutas',
                                    'Filtro e borra de café' => 'Filtro e borra de café',
                                    'sachê de chá' => 'sachê de chá',
                                    'casca de ovo' => 'casca de ovo',
                                ];
                            } else if ($tipo == TipoResiduo::Rejeito->value) {
                                return [
                                    'Papel higiênico usado' => 'Papel higiênico usado',
                                    'Fraldas descartáveis' => 'Fraldas descartáveis',
                                    'Absorventes' => 'Absorventes',
                                    'Espuma de limpeza' => 'Espuma de limpeza',
                                    'Isopor sujo' => 'Isopor sujo',
                                    'Etiquetas adesivas' => 'Etiquetas adesivas',
                                    'Têxteis (roupas, tecidos)' => 'Têxteis (roupas, tecidos)',
                                    'Resíduos industriais' => 'Resíduos industriais',
                                ];
                            }
                        })
                        ->label('Material')
                        ->preload()
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

                ])
        ];
    }

    public static function getFormBodySchema(): array
    {
        return [
            Select::make('tipo')
                ->options(TipoResiduo::class)
                ->default(TipoResiduo::Organico->value)
                ->columns(1)
                ->required()
                ->live(),

            DateTimePicker::make('data')
                ->default(now())
                ->columns(1),

            Hidden::make('user_id')
                ->default(auth()->user()->id),

            Select::make('material')
                ->options(function (Get $get) {
                    $tipo = $get('tipo');

                    if ($tipo == TipoResiduo::Inorganico->value) {
                        return [
                            'Garrafa PET' => 'Garrafa PET',
                            'Isopor' => 'Isopor',
                            'Vidro' => 'Vidro',
                            'Embalagem em papel' => 'Embalagem em papel',
                            'Embalagem plástica' => 'Embalagem plástica',
                            'Papelão' => 'Papelão',
                            'Metal' => 'Metal',
                            'Embalagem Tetra Pak ' => 'Embalagem Tetra Pak ',
                        ];
                    } else if ($tipo == TipoResiduo::Organico->value) {
                        return [
                            'Verduras' => 'Verduras',
                            'Legumes' => 'Legumes',
                            'Frutas' => 'Frutas',
                            'Filtro e borra de café' => 'Filtro e borra de café',
                            'sachê de chá' => 'sachê de chá',
                            'casca de ovo' => 'casca de ovo',
                        ];
                    } else if ($tipo == TipoResiduo::Rejeito->value) {
                        return [
                            'Papel higiênico usado' => 'Papel higiênico usado',
                            'Fraldas descartáveis' => 'Fraldas descartáveis',
                            'Absorventes' => 'Absorventes',
                            'Espuma de limpeza' => 'Espuma de limpeza',
                            'Isopor sujo' => 'Isopor sujo',
                            'Etiquetas adesivas' => 'Etiquetas adesivas',
                            'Têxteis (roupas, tecidos)' => 'Têxteis (roupas, tecidos)',
                            'Resíduos industriais' => 'Resíduos industriais',
                        ];
                    }
                })
                ->label('Material')
                ->preload()
                ->multiple()
                ->columns(1)
                ->live()
                ->required(),

            TextInput::make('descricao')
                ->label('Outros materiais')
                ->maxLength(255),

            Radio::make('volume.quantidade')
                ->label('Volume')
                ->columnSpanFull()
                ->reactive()
                ->columns(2)
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

            ...self::getFormFotoSchema(),
        ];
    }


    public static function getFormFotoSchema(): array
    {
        return [
            FileUpload::make('foto')
                ->hiddenLabel()
                ->label('Foto de identificação')
                ->optimize('webp')
                ->placeholder(fn() => new HtmlString('<span><a class="text-primary-600 font-bold">Clique aqui</a></br>Para adicionar uma foto sua</span>'))
                ->resize(15)
                ->columnSpanFull()
                ->alignCenter()
                ->multiple()
                ->panelLayout('grid')
                ->directory('foto-pequena')
                ->previewable(true),
        ];
    }
    public static function getFormFotoSchemaTabs(): array
    {
        return [
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
                ->columnSpanFull(),
        ];
    }

    public static function getSteps(): array
    {
        return [
            Step::make('Residuo')
                ->columns(2)
                ->schema(self::getFormResiduoSchema()),
            Step::make('Fotos')
                ->schema(self::getFormFotoSchema()),


        ];
    }

    public static function getTabs(): array
    {
        return  self::getFormBodySchema();
    }
}
