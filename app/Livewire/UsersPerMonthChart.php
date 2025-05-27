<?php

namespace App\Livewire;

use Ryangjchandler\FilamentApexCharts\Widgets\ApexChartWidget;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UsersPerMonthChart extends ApexChartWidget
{
    protected static ?string $heading = 'Usuarios registrados por mes';

    protected function getOptions(): array
    {
        $months = [];
        $data = [];

        for ($i = 5; $i >= 0; $i--) {
            $months[] = Carbon::now()->subMonths($i)->translatedFormat('M Y');
            $data[] = DB::table('users')
                ->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = ?", [Carbon::now()->subMonths($i)->format('Y-m')])
                ->count();
        }

        return [
            'chart' => [
                'type' => 'bar',
            ],
            'series' => [
                [
                    'name' => 'Usuarios',
                    'data' => $data,
                ],
            ],
            'xaxis' => [
                'categories' => $months,
            ],
            'colors' => ['#3b82f6'],
        ];
    }
}
