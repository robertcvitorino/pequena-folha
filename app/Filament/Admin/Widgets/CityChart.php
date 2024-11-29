<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Compostagem;
use App\Models\User;

use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class CityChart extends ApexChartWidget
{

    /**
     * Chart Id
     */
    protected static ?string $chartId = 'inscriptionsByCityChart';

    /**
     * Widget Title
     */
    protected static ?string $heading = 'Composteira por cidade';

    protected  static ?int $sort  = 1;

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     */
    protected function getOptions(): array
    {
        $data = $this->getData();

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'Composteira por cidade',
                    'data' => array_values($data),
                ],
            ],
            'xaxis' => [
                'categories' => array_keys($data),
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
                'stepSize' => 1,
                'min' => 0,
                'floating' => false,
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'colors' => ['#f59e0b'],
            'plotOptions' => [
                'bar' => [
                    'borderRadius' => 3,
                    'horizontal' => true,
                ],
            ],
        ];
    }

    public function getData(): array
    {
        $data = User::select( 'data_form' )
            ->where('data_form', '!=', null)
            ->where('data_form', '!=', '')
            ->get();
        $cities = [];
        foreach ($data as $value) {
            if (array_key_exists($value->data_form['cidade'].'/'.$value->data_form['estado'], $cities)) {
                $cities[$value->data_form['cidade'].'/'.$value->data_form['estado']]++;
            } else {
                $cities[$value->data_form['cidade'].'/'.$value->data_form['estado']] = 1;
            }
        }
        array_multisort($cities, SORT_DESC, $cities);

        return $cities;
    }
}
