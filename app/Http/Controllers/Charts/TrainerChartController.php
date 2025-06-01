<?php

namespace App\Http\Controllers\Charts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClaseGrupal;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TrainerChartController extends Controller
{
    public function index()
    {
        $currentYear = Carbon::now()->year;
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthKey = $currentYear . '-' . str_pad($i, 2, '0', STR_PAD_LEFT);
            $months[$monthKey] = 0;
        }

        // --- Lógica para obtener datos de Clases (Ejemplo: clases creadas por el entrenador actual) ---
        $classesData = ClaseGrupal::select(
                DB::raw('COUNT(*) as count'),
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month")
            )
            // ->where('created_by_user_id', auth()->id()) // Descomenta y ajusta si quieres filtrar por el entrenador logueado
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();
        $classesByMonth = $classesData + $months;
        ksort($classesByMonth);

        // --- Lógica para obtener datos de Usuarios (Alumnos) ---
        $usersData = User::select(
                DB::raw('COUNT(*) as count'),
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month")
            )
            // ->whereHas('suscripciones', function ($query) {
            //     $query->where('estado', 'activa');
            // })
            // ->where('trainer_id', auth()->id())
            // ->where('rol', 'alumno')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();
        $usersByMonth = $usersData + $months;
        ksort($usersByMonth);

        $filterValidMonths = function($array) {
            return array_filter($array, function($key) {
                return preg_match('/^\d{4}-\d{2}$/', $key);
            }, ARRAY_FILTER_USE_KEY);
        };

        $classesByMonth = $filterValidMonths($classesByMonth);
        $usersByMonth = $filterValidMonths($usersByMonth);

        $classesChartData = [
            'labels' => array_map(function($month) {
                return Carbon::createFromFormat('Y-m', $month)->translatedFormat('F Y');
            }, array_keys($classesByMonth)),
            'series' => [array_values($classesByMonth)],
        ];

        $usersChartData = [
            'labels' => array_map(function($month) {
                return Carbon::createFromFormat('Y-m', $month)->translatedFormat('F Y');
            }, array_keys($usersByMonth)),
            'series' => [array_values($usersByMonth)],
        ];

        return response()->json([
            'classesChartData' => $classesChartData,
            'usersChartData' => $usersChartData,
        ]);
    }
}