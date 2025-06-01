<?php

namespace App\Http\Controllers\Charts;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Suscripcion;
use App\Models\ClaseGrupal;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller;

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
        $usersByMonth = $usersData + $months; // usar + para preservar claves
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
        $subscriptionsCreatedByMonth = $subscriptionsCreatedData + $months;
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
        $subscriptionsCancelledByMonth = $subscriptionsCancelledData + $months;
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
        $classesByMonth = $classesData + $months;
        ksort($classesByMonth);

        // Función para filtrar claves que no tengan formato YYYY-MM válido
        $filterValidMonths = function($array) {
            return array_filter($array, function($key) {
                return preg_match('/^\d{4}-\d{2}$/', $key);
            }, ARRAY_FILTER_USE_KEY);
        };

        $usersByMonth = $filterValidMonths($usersByMonth);
        $subscriptionsCreatedByMonth = $filterValidMonths($subscriptionsCreatedByMonth);
        $subscriptionsCancelledByMonth = $filterValidMonths($subscriptionsCancelledByMonth);
        $classesByMonth = $filterValidMonths($classesByMonth);

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
                return Carbon::createFromFormat('Y-m', $month)->format('F Y');
            }, array_keys($classesByMonth)),
            'series' => [array_values($classesByMonth)],
        ];

        // Retorna los datos como JSON
        return response()->json([
            'usersChartData' => $usersChartData,
            'subscriptionsChartData' => $subscriptionsChartData,
            'classesChartData' => $classesChartData,
        ]);
    }
}
