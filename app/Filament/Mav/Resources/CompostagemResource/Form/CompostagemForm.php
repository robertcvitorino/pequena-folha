<?php

namespace App\Filament\Mav\Resources\CompostagemResource\Form;

use App\Enums\TipoResiduo;
use App\Models\Material;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Novadaemon\FilamentCombobox\Combobox;

abstract class CompostagemForm
{

    public static function getFormSchema(): array
    {
        return [
            Repeater::make('')

                ->columns(2)
                ->columnSpanFull()
                ->schema([
                    Select::make('tipo')
                        ->options(TipoResiduo::class)
                        ->afterStateUpdated( function (Set $set) {
                            $set('material_id', null);
                        })
                        ->required()
                        ->live(),
                    DateTimePicker::make('data')
                        ->default(now())
                        ->columns(1),

                    Hidden::make('user_id')
                        ->default(auth()->user()->id)
                        ->disabled(),

                    Select::make( 'material_id')
                        ->options( fn (Get $get) => Material::query()
                            ->where('tipo', $get('tipo'))
                            ->pluck('descricao', 'id'))
                        ->label( 'Material')
                        ->multiple()
                        ->columns(1)
                        ->live()
                        ->required(),

                    TextInput::make('descricao')
                        ->maxLength(255),

                    TextInput::make('volume')
                        ->suffix( 'L')
                        ->required()
                        ->numeric(),

                ])->addActionLabel('Nova compostagem')
        ];
    }

    public static function getTabs(): array
    {
        return [
            Step::make('Residuo')
                ->columns(2)
                ->schema(self::getFormSchema()),
            Step::make('Fotos')
                ->schema(self::getFormSchema()),

        ];
    }
}
