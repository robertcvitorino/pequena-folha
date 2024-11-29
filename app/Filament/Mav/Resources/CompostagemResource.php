<?php

namespace App\Filament\Mav\Resources;

use App\Filament\Mav\Resources\CompostagemResource\Form\CompostagemForm;
use App\Filament\Mav\Resources\CompostagemResource\Pages\CreateCompostagem;
use App\Filament\Mav\Resources\CompostagemResource\Pages\EditCompostagem;
use App\Filament\Mav\Resources\CompostagemResource\Pages\ListCompostagems;
use App\Models\Compostagem;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;


class CompostagemResource extends Resource
{
    protected static ?string $model = Compostagem::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $label = 'Compostagem';

    protected static ?string $title = 'Compostagem';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make()
                ->columns(2)
                ->schema(
                    CompostagemForm::getTabs()
                ),

        ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('id')
                    ->label( 'Código')
                    ->sortable(),

                Tables\Columns\TextColumn::make('tipo')
                    ->badge()
                    ->sortable(),

                TextColumn::make('data')
                    ->dateTime('d/m/Y ')
                    ->sortable(),

                TextColumn::make('volume.quantidade')
                    ->label( 'Volume')
                    ->label( 'Quantidade')

            ])
            ->defaultSort( 'id', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCompostagems::route('/'),
            'create' => CreateCompostagem::route('/create'),
            'edit' => EditCompostagem::route('/{record}/edit'),
        ];
    }
}
