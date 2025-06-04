<?php

namespace App\Http\Controllers\Compra;

use App\Http\Controllers\Controller;
use App\Models\Almacen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule; 
class AlmacenController extends Controller
{
    // Definir los tipos fijos
    const TIPOS_FIJOS = ['CONSUMICION', 'EQUIPAMIENTO'];

    public function tiendaIndex(Request $request)
    {
        
        $validated = $request->validate([
            'search' => 'nullable|string|max:255',
            'tipo' => ['nullable', 'string', Rule::in(self::TIPOS_FIJOS)],
        ]);

        $searchTerm = $validated['search'] ?? null;
        $selectedTipo = $validated['tipo'] ?? null;

        // Pasar los tipos fijos a la vista
        $tiposDisponibles = self::TIPOS_FIJOS;

        $query = Almacen::where('cantidad_disponible', '>', 0);

        if ($searchTerm) {
            $query->where('nombre', 'LIKE', '%' . $searchTerm . '%');
        }

        if ($selectedTipo) {
            $query->where('tipo', $selectedTipo); 
        }

        $productos = $query->orderBy('nombre')->paginate(12);

        // Mantener filtros en la paginación
        $queryParams = [];
        if ($searchTerm) $queryParams['search'] = $searchTerm;
        if ($selectedTipo) $queryParams['tipo'] = $selectedTipo;
        $productos->appends($queryParams);


        $cartItemCount = 0;
        $cart = Session::get('carrito', []);
        if (is_array($cart)) {
            $cartItemCount = collect($cart)->sum('cantidad');
        }

        return view('tienda.index', compact(
            'productos',
            'cartItemCount',
            'searchTerm',
            'tiposDisponibles', 
            'selectedTipo'
        ));
    }
}