<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\User;     // Asegúrate que este modelo existe
use App\Models\Almacen;  // Asegúrate que este modelo existe
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator; // Para validación más compleja

class CompraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $compras = Compra::with(['user', 'itemsAlmacen'])->latest()->paginate(10);
        return view('compras.index', compact('compras'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::orderBy('name')->pluck('name', 'id'); // Asumiendo que User tiene un campo 'name'
        $itemsAlmacenDisponibles = Almacen::orderBy('nombre_producto')->get(); // Asumiendo que Almacen tiene 'nombre_producto'
        $estados = ['pendiente' => 'Pendiente', 'procesada' => 'Procesada', 'enviada' => 'Enviada', 'completada' => 'Completada', 'cancelada' => 'Cancelada'];
        $metodosPago = ['efectivo' => 'Efectivo', 'tarjeta' => 'Tarjeta', 'transferencia' => 'Transferencia'];

        return view('compras.create', compact('users', 'itemsAlmacenDisponibles', 'estados', 'metodosPago'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'fecha_compra' => 'required|date',
            'metodo_pago' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.almacen_id' => 'required|exists:almacen,id',
            'items.*.cantidad' => 'required|integer|min:1',
            'items.*.precio_unitario_compra' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $totalCompraCalculado = 0;
            $itemsParaSincronizar = [];

            foreach ($request->input('items') as $item) {
                $subtotal = $item['cantidad'] * $item['precio_unitario_compra'];
                $totalCompraCalculado += $subtotal;
                $itemsParaSincronizar[$item['almacen_id']] = [
                    'cantidad' => $item['cantidad'],
                    'precio_unitario_compra' => $item['precio_unitario_compra'],
                    'subtotal' => $subtotal,
                ];
            }

            $compra = Compra::create([
                'user_id' => $request->input('user_id'),
                'fecha_compra' => $request->input('fecha_compra'),
                'total_compra' => $totalCompraCalculado,
                'metodo_pago' => $request->input('metodo_pago'),
                'estado' => $request->input('estado'),
            ]);

            $compra->itemsAlmacen()->sync($itemsParaSincronizar);

            DB::commit();
            return redirect()->route('compras.index')->with('success', 'Compra creada exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al crear la compra: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Compra $compra)
    {
        $compra->load(['user', 'itemsAlmacen', 'factura']);
        return view('compras.show', compact('compra'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Compra $compra)
    {
        $compra->load('itemsAlmacen');
        $users = User::orderBy('name')->pluck('name', 'id');
        $itemsAlmacenDisponibles = Almacen::orderBy('nombre_producto')->get();
        $estados = ['pendiente' => 'Pendiente', 'procesada' => 'Procesada', 'enviada' => 'Enviada', 'completada' => 'Completada', 'cancelada' => 'Cancelada'];
        $metodosPago = ['efectivo' => 'Efectivo', 'tarjeta' => 'Tarjeta', 'transferencia' => 'Transferencia'];

        // Prepara los items actuales para el formulario
        $itemsActuales = [];
        foreach ($compra->itemsAlmacen as $item) {
            $itemsActuales[] = [
                'almacen_id' => $item->id,
                'cantidad' => $item->pivot->cantidad,
                'precio_unitario_compra' => $item->pivot->precio_unitario_compra,
            ];
        }

        return view('compras.edit', compact('compra', 'users', 'itemsAlmacenDisponibles', 'estados', 'metodosPago', 'itemsActuales'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Compra $compra)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'fecha_compra' => 'required|date',
            'metodo_pago' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.almacen_id' => 'required|exists:almacen,id',
            'items.*.cantidad' => 'required|integer|min:1',
            'items.*.precio_unitario_compra' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $totalCompraCalculado = 0;
            $itemsParaSincronizar = [];

            foreach ($request->input('items') as $item) {
                $subtotal = $item['cantidad'] * $item['precio_unitario_compra'];
                $totalCompraCalculado += $subtotal;
                $itemsParaSincronizar[$item['almacen_id']] = [
                    'cantidad' => $item['cantidad'],
                    'precio_unitario_compra' => $item['precio_unitario_compra'],
                    'subtotal' => $subtotal,
                ];
            }

            $compra->update([
                'user_id' => $request->input('user_id'),
                'fecha_compra' => $request->input('fecha_compra'),
                'total_compra' => $totalCompraCalculado,
                'metodo_pago' => $request->input('metodo_pago'),
                'estado' => $request->input('estado'),
            ]);

            $compra->itemsAlmacen()->sync($itemsParaSincronizar);

            DB::commit();
            return redirect()->route('compras.index')->with('success', 'Compra actualizada exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al actualizar la compra: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Compra $compra)
    {
        DB::beginTransaction();
        try {
            // Los items de la tabla pivot se eliminarán automáticamente si está configurado
            // el borrado en cascada en la migración o puedes hacerlo manualmente:
            // $compra->itemsAlmacen()->detach();
            $compra->delete();
            DB::commit();
            return redirect()->route('compras.index')->with('success', 'Compra eliminada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('compras.index')->with('error', 'Error al eliminar la compra: ' . $e->getMessage());
        }
    }
}