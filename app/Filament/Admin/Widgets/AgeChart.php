<?php

namespace App\Filament\Admin\Widgets;

use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class AgeChart extends ApexChartWidget
{

    /**
     * Chart Id
     */
    protected static ?string $chartId = 'inscriptionsByAgeChart';

    /**
     * Widget Title
     */
    protected static ?string $heading = 'Idade dos Participantes';

    protected  static ?int $sort  = 0;

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     */
    protected function getOptions(): array
    {
        $data = User::select('data_form')->get();

        $ages = [
            '18-24' => 0,
            '25-34' => 0,
            '35-44' => 0,
            '45-54' => 0,
            '55-64' => 0,
            '65+' => 0,
        ];

        foreach ($data as $key => $value) {
            // Verifica se o campo data_nacimento existe no array `data_form`
            if (!isset($value->data_form['data_nacimento'])) continue;

            try {
                // Cria um objeto Carbon a partir da data de nascimento
                $birthDate = Carbon::createFromFormat('d/m/Y', $value->data_form['data_nacimento']);
                $age = Carbon::now()->diffInYears($birthDate) * -1;

                // Adiciona a idade à categoria apropriada
                if ($age >= 18 && $age <= 24) {
                    $ages['18-24']++;
                } elseif ($age >= 25 && $age <= 34) {
                    $ages['25-34']++;
                } elseif ($age >= 35 && $age <= 44) {
                    $ages['35-44']++;
                } elseif ($age >= 45 && $age <= 54) {
                    $ages['45-54']++;
                } elseif ($age >= 55 && $age <= 64) {
                    $ages['55-64']++;
                } elseif ($age >= 65) {
                    $ages['65+']++;
                }
            } catch (Exception $e) {
                // Caso haja algum erro na formatação da data, apenas continue
                continue;
            }
        }

        $maxAgeInscription = max($ages);

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 300,
            ],
            'plotOptions' => [
                'bar' => [
                    'barHeight' => '100%',
                    'horizontal' => false,
                    'borderRadius' => 4,
                    'borderRadiusApplication' => 'end',
                    'dataLabels' => [
                        'position' => 'bottom',
                    ],
                ],
            ],
            'dataLabels' => [
                'enabled' => true,
                'textAnchor' => 'start',
            ],
            'series' => [
                [
                    'name' => 'Número de Inscrições',
                    'data' => [
                        $ages['18-24'], $ages['25-34'], $ages['35-44'], $ages['45-54'], $ages['55-64'], $ages['65+'],
                    ],
                ],
            ],
            'xaxis' => [
                'categories' => ['18-24', '25-34', '35-44', '45-54', '55-64', '65+'],
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'yaxis' => [
                'min' => 0,
                'max' => $maxAgeInscription,
                'stepSize' => ceil($maxAgeInscription / 5),
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],

            ],
            'colors' => ['#5E00B6'],


        ];
    }

}
