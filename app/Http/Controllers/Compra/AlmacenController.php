<?php
namespace App\Http\Controllers\Compra; 
use App\Http\Controllers\Controller;
use App\Models\Almacen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session; 

class AlmacenController extends Controller
{
    public function tiendaIndex()
    {
        $productos = Almacen::where('cantidad_disponible', '>', 0) 
                            ->orderBy('nombre')
                            ->paginate(12);

        $cartItemCount = 0;
        if (Session::has('carrito')) {
            $cart = Session::get('carrito');
          
            if (is_array($cart)) {
              
                $cartItemCount = collect($cart)->sum('cantidad');
            }
           
        }

        return view('tienda.index', compact('productos', 'cartItemCount'));
    }


}