<?php

namespace App\Http\Controllers\Compra;

use App\Http\Controllers\Controller;
use App\Models\Compra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class CompraController extends Controller
{
    
    public function index()
    {
        // Si eres administrador, podrías ver todas las compras
       
            //$compras = Compra::with('user')->latest()->paginate(10);
            // $compras = Compra::where('user_id', Auth::id())->with('user')->latest()->paginate(10);
        

        // Por simplicidad, por ahora mostraremos todas (ajusta la lógica de roles según necesites)
        $compras = Compra::with('user')->latest()->paginate(15); // Carga la relación 'user' para mostrar el nombre

        return view('compra.index', compact('compra'));
    }

    /**
     * Muestra el formulario para crear una nueva compra.
     * (Este es más complejo, implica un carrito. Lo dejaremos pendiente por ahora)
     */
    public function create()
    {
    //     Lógica para mostrar productos, etc.
    //     return view('compras.create');
    // }

    /**
     * Almacena una nueva compra en la base de datos.
     * (Este es más complejo)
     */
    // public function store(Request $request)
    // {
    //     // Validación
    //     // Crear la compra
    //     // Añadir items a compra_almacen_item
    //     // Actualizar stock en almacen
    //     // Generar factura
    //     // Redireccionar
    // }

    /**
     * Muestra la compra especificada.
     */
    }
    public function show(Compra $compra)
    {
        // Opcional: Verificar que el usuario autenticado pueda ver esta compra
        // (si no es admin, solo puede ver las suyas)
        // if (!Auth::user()->isAdmin() && $compra->user_id !== Auth::id()) {
        //     abort(403, 'No tienes permiso para ver esta compra.');
        // }

        // Cargar relaciones necesarias para la vista de detalle
        $compra->load('user', 'itemsAlmacen', 'factura');

        return view('compra.show', compact('compra'));
    }

    /**
     * Muestra el formulario para editar la compra especificada.
     * (Generalmente las compras no se "editan" de la misma forma que otros recursos,
     *  se podrían cancelar, reembolsar, etc.)
     */
    // public function edit(Compra $compra)
    // {
    //     //
    // }

    /**
     * Actualiza la compra especificada en la base de datos.
     */
    // public function update(Request $request, Compra $compra)
    // {
    //     //
    // }

    /**
     * Elimina la compra especificada de la base de datos.
     * (Considera si realmente quieres eliminar compras o solo cambiar su estado a 'cancelada')
     */
    // public function destroy(Compra $compra)
    // {
    //     // $compra->delete();
    //     // return redirect()->route('compras.index')->with('success', 'Compra eliminada correctamente.');
    // }
}