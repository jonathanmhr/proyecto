<?php

namespace App\Livewire;

use Livewire\Component;
use Akaunting\Apexcharts\Chart;

class UsersPerMonthChart extends Component
{
    public Chart $chart;

    public function mount()
    {
        $months = [];
        $data = [];

        for ($i = 5; $i >= 0; $i--) {
            $months[] = now()->subMonths($i)->format('M Y');
            $data[] = \DB::table('users')
                ->whereYear('created_at', now()->subMonths($i)->year)
                ->whereMonth('created_at', now()->subMonths($i)->month)
                ->count();
        }

        $this->chart = new Chart;
        $this->chart->setType('bar')
            ->setHeight(350)
            ->setColors(['#3b82f6'])
            ->setXAxis($months)
            ->addSeries('Usuarios', $data);
    }

    public function render()
    {
        return view('livewire.users-per-month-chart');
    }
}
