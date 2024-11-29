<?php

namespace App\Filament\Admin\Reports;

use App\Enums\TipoResiduo;
use App\Models\Compostagem;
use App\Models\User;
use Carbon\Carbon;
use EightyNine\Reports\Components\Body;
use EightyNine\Reports\Components\Footer;
use EightyNine\Reports\Components\Header;
use EightyNine\Reports\Components\Header\Layout\HeaderColumn;
use EightyNine\Reports\Report;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use EightyNine\Reports\Components\Header\Layout\HeaderRow;
use EightyNine\Reports\Components\Image;
use EightyNine\Reports\Components\Text;

class CompostagemReport extends Report
{
    public ?string $heading = "Compostagem";

    // public ?string $subHeading = "A great report";

    public function header(Header $header): Header
    {
        return $header
            ->schema([
                HeaderColumn::make()->schema([

                    Image::make(asset('image/logo.png'))->height(50),

                    Text::make('Pequena Folha - MAV')
                        ->title()
                        ->primary(),

                    Text::make('Projeto mav de controle de compostagem')
                        ->secondary()
                        ->subTitle(),

                    HeaderRow::make()->schema([
                        Text::make('Relatório gerado em ' . Carbon::now()->format('d/m/Y H:i:s'))
                    ])->alignRight()

                ])

            ]);
    }


    public function body(Body $body): Body
    {
        return $body
            ->schema([
                Body\Table::make()
                    ->columns([
                        Body\TextColumn::make('id')
                            ->label('#'),

                        Body\TextColumn::make('participante')
                            ->label('Participante'),

                        Body\TextColumn::make('novoTipo')
                            ->label('Tipo'),

                        Body\TextColumn::make('material')
                            ->badge()
                            ->label('Material'),

                        Body\TextColumn::make('data')
                            ->dateTime('d/m/Y')
                            ->label('Data'),

                        Body\TextColumn::make('volume')
                            ->label('Volume')
                            ->columnSpan(1)
                            ->label('Quantidade'),

                    ])
                    ->data($this->getDataQuery())
            ]);
    }

    public function footer(Footer $footer): Footer
    {
        return $footer
            ->schema([
                // ...
            ]);
    }

    public function filterForm(Form $form): Form
    {
        return $form
            ->schema([


                Select::make('tipo_filter')
                    ->label('Tipo de Resíduo')
                    ->options(TipoResiduo::class),


                DatePicker::make('data_filter_inicio')
                    ->label('De Data')
                    ->format('d/m/Y')
                    ->displayFormat('d/m/Y'),

                DatePicker::make('data_filter_fim')
                    ->label('Até Data')
                    ->format('d/m/Y')
                    ->displayFormat('d/m/Y'),

                Select::make('participante_filter')
                    ->label('Participante')
                    ->searchable()
                    ->preload()
                    ->options(User::pluck('name', 'id')),


            ]);
    }

    private function getDataQuery(): \Closure
    {
        return function (?array $filters) {
            if (!empty($filters)) {

                $data = Compostagem::query()
                    ->with('user')
                    ->when(
                        array_key_exists('tipo_filter', $filters) && $filters['tipo_filter'],
                        function ($query) use ($filters) {
                            $query->where('tipo', $filters['tipo_filter']);
                        }
                    )
                    ->when(
                        array_key_exists('data_filter_inicio', $filters) && array_key_exists('data_filter_fim', $filters),
                        function ($query) use ($filters) {

                            if (!empty($filters['data_filter_inicio']) && !empty($filters['data_filter_fim'])) {
                                $startDate = Carbon::createFromFormat('d/m/Y', $filters['data_filter_inicio'])->toDateString();
                                $endDate = Carbon::createFromFormat('d/m/Y', $filters['data_filter_fim'])->toDateString();
                                $query->whereBetween('data', [$startDate, $endDate]);
                            } elseif (!empty($filters['data_filter_inicio'])) {
                                // Only start date is provided
                                $startDate = Carbon::createFromFormat('d/m/Y', $filters['data_filter_inicio'])->toDateString();
                                $query->whereDate('data', '>=', $startDate);
                            } elseif (!empty($filters['data_filter_fim'])) {
                                // Only end date is provided
                                $endDate = Carbon::createFromFormat('d/m/Y', $filters['data_filter_fim'])->toDateString();
                                $query->whereDate('data', '>=', $endDate);
                            }
                        }
                    )
                    ->when(
                        array_key_exists('participante_filter', $filters) && $filters['participante_filter'],
                        function ($query) use ($filters) {
                            $query->where('user_id', $filters['participante_filter']);
                        }
                    )
                    ->get();


                foreach ($data as $key => $value) {
                    if ($value['volume'] !== null && is_array($value['volume'])) {
                        $data[$key]['volume'] = implode(', ', $value['volume']);
                    }
                    if ($value['material'] !== null && is_array($value['material'])) {
                        $data[$key]['material'] = implode(', ', $value['material']);
                    }
                    if ($value['tipo'] !== null && isset($value['tipo'])) {
                        $teste = TipoResiduo::tryFrom($value['tipo']->value)->getLabel();

                        $data[$key]['descricao'] = $teste;
                        $value->novoTipo = $teste;
                    }
                    $value->participante = $value->user->name;
                }
            }
            return $data ?? collect([]);
        };
    }
}
