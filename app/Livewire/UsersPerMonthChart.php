<?php

namespace App\Livewire;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UsersPerMonthChart extends ChartWidget
{
    protected static ?string $heading = 'Usuarios registrados por mes';

    protected function getData(): array
    {
        $months = collect();
        $data = collect();

        // Recorremos los últimos 6 meses
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i)->format('Y-m');
            $label = Carbon::now()->subMonths($i)->translatedFormat('M Y');

            $count = DB::table('users')
                ->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = ?", [$month])
                ->count();

            $months->push($label);
            $data->push($count);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Usuarios',
                    'data' => $data,
                    'backgroundColor' => '#3b82f6', // azul
                ],
            ],
            'labels' => $months,
        ];
    }

    protected function getType(): string
    {
        return 'bar'; // Puedes cambiarlo por 'line' si quieres
    }
}
