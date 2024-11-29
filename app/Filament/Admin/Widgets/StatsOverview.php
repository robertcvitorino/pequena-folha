<?php

namespace App\Filament\Admin\Widgets;

use App\Enums\TipoResiduo;
use App\Filament\Mav\Resources\CompostagemResource\Form\CompostagemForm;
use App\Models\Compostagem;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Support\Colors\Color;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('', Compostagem::where(  'created_at', '>=', Carbon::now()->subDays(30) )->count())
                ->description('Quantidade de compostagens no mês')
                ->color(Color::Orange),

            Stat::make('', Compostagem::where(  'tipo', TipoResiduo::Organico->value )->where(  'created_at', '>=', Carbon::now()->subDays(30) )->count())
                ->description('Compostagens orgánicas no mês')
                ->color(Color::Green),

            Stat::make('', Compostagem::where(  'tipo', TipoResiduo::Inorganico->value )->where(  'created_at', '>=', Carbon::now()->subDays(30) )->count())
                ->description('Compostagens inorganicas no mês')
                ->color(Color::Yellow),

            Stat::make('', Compostagem::where(  'tipo', TipoResiduo::Rejeito->value )->where(  'created_at', '>=', Carbon::now()->subDays(30) )->count())
                ->description('Compostagens residuais no mês')
                ->color(Color::Indigo),

        ];
    }
}
