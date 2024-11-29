<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\UserResource\Pages\CreateUser;
use App\Filament\Admin\Resources\UserResource\Pages\EditUser;
use App\Filament\Admin\Resources\UserResource\Pages\ListUsers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;
use Leandrocfe\FilamentPtbrFormFields\Cep;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $header = 'name';

    protected static ?string $label = 'Usuário';

    protected static ?string $title = 'Usuário';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make( 'Dados Acesso' )
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label( 'Nome')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        DateTimePicker::make('email_verified_at'),
                        TextInput::make('password')
                            ->password()
                            ->required()
                            ->maxLength(255),
                    ]),

                Section::make( 'Dados Pessoais' )
                    ->columns(2)
                    ->schema([

                        TextInput::make('data_form.data_nacimento')
                            ->required()
                            ->mask('99/99/9999')
                            ->placeholder('DD/MM/AAAA')

                            ->label('Data de Nascimento'),

                        TextInput::make('data_form.telefone')
                            ->mask('(99) 9 9999-9999')
                            ->required()

                            ->prefixIcon('heroicon-o-phone')
                            ->label('Telefone'),


                        Fieldset::make()
                            ->label('Endereço')
                            ->columns([
                                'default' => 1,
                                'lg' => 4,
                            ])
                            ->schema([
                                Placeholder::make('info_endereco')
                                    ->hint('Informe o CEP para preencher os campos de endereço automaticamente. Clique na lupa para localizar o endereço.')
                                    ->hintColor(Color::Yellow)
                                    ->hintIcon('heroicon-o-exclamation-circle')
                                    ->hiddenLabel()
                                    ->columnSpanFull(),

                                Cep::make('data_form.cep')
                                    ->label('CEP')
                                    ->required()
                                    ->columnSpan([
                                        'default' => 1,
                                        'lg' => 1,
                                    ])
                                    ->viaCep(
                                        setFields: [
                                            'data_form.rua' => 'logradouro',
                                            'data_form.numero' => 'numero',
                                            'data_form.ponto_referencia' => 'complemento',
                                            'data_form.bairro' => 'bairro',
                                            'data_form.cidade' => 'localidade',
                                            'data_form.estado' => 'uf'
                                        ],
                                    ),

                                TextInput::make('data_form.rua')
                                    ->required()
                                    ->columnSpan([
                                        'default' => 1,
                                        'lg' => 2,
                                    ])
                                    ->label('Rua'),

                                TextInput::make('data_form.numero')
                                    ->required()
                                    ->numeric()
                                    ->columnSpan([
                                        'default' => 1,
                                        'lg' => 1,
                                    ])
                                    ->label('Número'),
                                TextInput::make('data_form.ponto_referencia')
                                    ->label('Ponto Referência')
                                    ->columnSpan([
                                        'default' => 1,
                                        'sm' => 1,
                                        'md' => 1,
                                        'xl' => 1,
                                    ]),

                                TextInput::make('data_form.bairro')
                                    ->required()
                                    ->columnSpan([
                                        'default' => 1,
                                        'sm' => 1,
                                        'md' => 1,
                                        'xl' => 1,
                                    ])
                                    ->label('Bairro'),

                                TextInput::make('data_form.cidade')
                                    ->required()
                                    ->columnSpan([
                                        'default' => 1,
                                        'sm' => 1,
                                        'md' => 1,
                                        'xl' => 1,
                                    ])
                                    ->readOnly()
                                    ->label('Cidade'),

                                TextInput::make('data_form.estado')
                                    ->required()
                                    ->columnSpan([
                                        'default' => 1,
                                        'sm' => 1,
                                        'md' => 1,
                                        'xl' => 1,
                                    ])
                                    ->readOnly()
                                    ->label('Estado'),
                            ]),

                    ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label( 'Nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
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
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
