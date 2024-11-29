<?php

namespace App\Filament\Mav\Resources\CompostagemResource\Pages;

use App\Filament\Mav\Resources\CompostagemResource;
use Filament\Actions;
use Filament\Forms\Get;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ListCompostagems extends ListRecords
{
    protected static string $resource = CompostagemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTableQuery(): Builder
    {
        return parent::getTableQuery()->where('user_id', auth()->id());
    }
    public function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('id')
                    ->label( 'Código')
                    ->sortable(),

                TextColumn::make('tipo')
                    ->badge()
                    ->sortable(),

                TextColumn::make('data')
                    ->dateTime('d/m/Y ')
                    ->sortable(),

                TextColumn::make('volume.quantidade')
                    ->label( 'Volume')
                    ->formatStateUsing(function ($state, $record) {
                        if ($state == 'O' ) {
                            return $record->volume['outro'] ?? 'N/A';
                        }
                        return $state;
                    })
                    ->label( 'Quantidade')

            ])
            ->defaultSort( 'id', 'desc')
            ->filters([
                //
            ])
            ->actions([

            ])
            ->bulkActions([


            ]);
    }

}
