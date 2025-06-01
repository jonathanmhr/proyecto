<?php
namespace App\Http\Controllers\Compra;
use App\Http\Controllers\Controller;
use App\Models\Almacen;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Session;

class AlmacenController extends Controller
{
    public function tiendaIndex(Request $request) 
    {
        $searchTerm = $request->input('search'); 

        $query = Almacen::where('cantidad_disponible', '>', 0);

        if ($searchTerm) {
            $query->where('nombre', 'LIKE', '%' . $searchTerm . '%');
        }

        $productos = $query->orderBy('nombre')->paginate(12);

        $productos->appends(['search' => $searchTerm]);

        $cartItemCount = 0;
        if (Session::has('carrito')) {
            $cart = Session::get('carrito');

            if (is_array($cart)) {
                $cartItemCount = collect($cart)->sum('cantidad');
            }
        }
        return view('tienda.index', compact('productos', 'cartItemCount', 'searchTerm'));
    }
}