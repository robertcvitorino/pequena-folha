<?php

namespace App\Filament\Mav\Resources;

use App\Filament\Mav\Resources\CompostagemResource\Form\CompostagemForm;
use App\Filament\Resources\CompostagemResource\Pages;
use App\Filament\Resources\CompostagemResource\RelationManagers;
use App\Filament\Resources\VisitaResource\Forms\VisitaForm;
use App\Models\Compostagem;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;


class CompostagemResource extends Resource
{
    protected static ?string $model = Compostagem::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Tabs::make()
                ->columnSpanFull()
                ->schema([]
//                    VisitaForm::getTabs()
                ),

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('data')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('material_id')
                    ->label('Material')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('descricao')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tipo')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('volume')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Mav\Resources\CompostagemResource\Pages\ListCompostagems::route('/'),
            'create' => \App\Filament\Mav\Resources\CompostagemResource\Pages\CreateCompostagem::route('/create'),
            'edit' => \App\Filament\Mav\Resources\CompostagemResource\Pages\EditCompostagem::route('/{record}/edit'),
        ];
    }
}
