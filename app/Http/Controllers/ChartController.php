<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Suscripcion;
use App\Models\ClaseGrupal;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function index()
    {
        $currentYear = Carbon::now()->year;
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthKey = $currentYear . '-' . str_pad($i, 2, '0', STR_PAD_LEFT);
            $months[$monthKey] = 0;
        }

        $usersData = User::select(
                DB::raw('COUNT(*) as count'),
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month")
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();
        $usersByMonth = array_merge($months, $usersData);
        ksort($usersByMonth);

        $subscriptionsCreatedData = Suscripcion::select(
                DB::raw('COUNT(*) as count'),
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month")
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();
        $subscriptionsCreatedByMonth = array_merge($months, $subscriptionsCreatedData);
        ksort($subscriptionsCreatedByMonth);

        $subscriptionsCancelledData = Suscripcion::select(
                DB::raw('COUNT(*) as count'),
                DB::raw("DATE_FORMAT(updated_at, '%Y-%m') as month")
            )
            ->where('estado', 'cancelado')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();
        $subscriptionsCancelledByMonth = array_merge($months, $subscriptionsCancelledData);
        ksort($subscriptionsCancelledByMonth);

        $classesData = ClaseGrupal::select(
                DB::raw('COUNT(*) as count'),
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month")
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();
        $classesByMonth = array_merge($months, $classesData);
        ksort($classesByMonth);

        $usersChartData = [
            'labels' => array_map(function($month) {
                return Carbon::createFromFormat('Y-m', $month)->translatedFormat('F Y');
            }, array_keys($usersByMonth)),
            'series' => [array_values($usersByMonth)],
        ];

        $subscriptionsChartData = [
            'labels' => array_map(function($month) {
                return Carbon::createFromFormat('Y-m', $month)->translatedFormat('F Y');
            }, array_keys($subscriptionsCreatedByMonth)),
            'series' => [
                ['name' => 'Altas', 'data' => array_values($subscriptionsCreatedByMonth)],
                ['name' => 'Bajas', 'data' => array_values($subscriptionsCancelledByMonth)],
            ],
        ];

        $classesChartData = [
            'labels' => array_map(function($month) {
                return Carbon::createFromFormat('Y-m', $month)->translatedFormat('F Y');
            }, array_keys($classesByMonth)),
            'series' => [array_values($classesByMonth)],
        ];

        // Retorna los datos como una respuesta JSON
        return response()->json([
            'usersChartData' => $usersChartData,
            'subscriptionsChartData' => $subscriptionsChartData,
            'classesChartData' => $classesChartData,
        ]);
    }
}