<?php

namespace App\Http\Controllers\Compra;

use App\Http\Controllers\Controller;
use App\Models\Almacen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CarritoController extends Controller
{
    public function __construct()
    {
        
        if (!Session::has('carrito')) {
            Session::put('carrito', []);
        }
    }

    public function agregar(Request $request, $almacen_id)
    {
        $producto = Almacen::findOrFail($almacen_id);
        $cantidadSolicitada = (int) $request->input('cantidad', 1);

        if ($cantidadSolicitada <= 0) {
            return back()->with('error', 'La cantidad debe ser al menos 1.');
        }

        if ($producto->cantidad_disponible < $cantidadSolicitada) {
            return back()->with('error', 'No hay suficiente stock para la cantidad solicitada de ' . $producto->nombre);
        }

        $carrito = Session::get('carrito');

       
        if (isset($carrito[$almacen_id])) {
            $nuevaCantidad = $carrito[$almacen_id]['cantidad'] + $cantidadSolicitada;
            if ($producto->cantidad_disponible < $nuevaCantidad) {
                 return back()->with('error', 'No hay suficiente stock para añadir más unidades de ' . $producto->nombre);
            }
            $carrito[$almacen_id]['cantidad'] = $nuevaCantidad;
        } else {
           
            $carrito[$almacen_id] = [
                "id_producto" => $producto->id,
                "nombre" => $producto->nombre,
                "cantidad" => $cantidadSolicitada,
                "precio_unitario" => $producto->precio_unitario,
                "imagen_url"=>$producto->imagen,
                "sku" => $producto->sku,
                
            ];
        }

        Session::put('carrito', $carrito);
        return redirect()->route('carrito.view')->with('success', $producto->nombre . ' añadido al carrito!');
    }

    public function view()
    {
        $carrito = Session::get('carrito');
        $totalCarrito = 0;
        if ($carrito) {
            foreach ($carrito as $item) {
                $totalCarrito += $item['precio_unitario'] * $item['cantidad'];
            }
        }
        return view('carrito.view', compact('carrito', 'totalCarrito'));
    }

    public function actualizar(Request $request, $almacen_id)
    {
        $producto = Almacen::findOrFail($almacen_id);
        $nuevaCantidad = (int) $request->input('cantidad');
        $carrito = Session::get('carrito');

        if (isset($carrito[$almacen_id])) {
            if ($nuevaCantidad > 0) {
                if ($producto->cantidad_disponible < $nuevaCantidad) {
                    return back()->with('error', 'No hay suficiente stock para ' . $producto->nombre . '. Disponibles: ' . $producto->cantidad_disponible);
                }
                $carrito[$almacen_id]['cantidad'] = $nuevaCantidad;
            } else {
                unset($carrito[$almacen_id]);
            }
            Session::put('carrito', $carrito);
            return back()->with('success', 'Carrito actualizado.');
        }
        return back()->with('error', 'Producto no encontrado en el carrito.');
    }

    public function eliminar($almacen_id)
    {
        $carrito = Session::get('carrito');
        if (isset($carrito[$almacen_id])) {
            unset($carrito[$almacen_id]);
            Session::put('carrito', $carrito);
            return back()->with('success', 'Producto eliminado del carrito.');
        }
        return back()->with('error', 'Producto no encontrado en el carrito.');
    }

    public function vaciar()
    {
        Session::put('carrito', []);
        return redirect()->route('carrito.view')->with('success', 'El carrito ha sido vaciado.');
    }
}