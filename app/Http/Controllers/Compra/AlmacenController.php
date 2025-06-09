<?php

namespace App\Http\Controllers\Compra;

use App\Http\Controllers\Controller;
use App\Models\Almacen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AlmacenController extends Controller
{
    // Definir constantes para valores fijos
    const TIPOS_FIJOS = ['CONSUMICION', 'EQUIPAMIENTO'];
    const VALORACIONES_FIJAS = ['1', '2', '3', '4', '5'];

    /**
     * Muestra la tienda pública para los clientes.
     */
    public function tiendaIndex(Request $request)
    {
        $validated = $request->validate([
            'search' => 'nullable|string|max:255',
            'tipo' => ['nullable', 'string', Rule::in(self::TIPOS_FIJOS)],
        ]);

        $searchTerm = $validated['search'] ?? null;
        $selectedTipo = $validated['tipo'] ?? null;
        $tiposDisponibles = self::TIPOS_FIJOS;

        $query = Almacen::where('cantidad_disponible', '>', 0);

        if ($searchTerm) {
            $query->where('nombre', 'LIKE', '%' . $searchTerm . '%');
        }
        if ($selectedTipo) {
            $query->where('tipo', $selectedTipo);
        }

        $productos = $query->orderBy('nombre')->paginate(12);
        
        $queryParams = [];
        if ($searchTerm) $queryParams['search'] = $searchTerm;
        if ($selectedTipo) $queryParams['tipo'] = $selectedTipo;
        $productos->appends($queryParams);

        $cartItemCount = collect(Session::get('carrito', []))->sum('cantidad');

        return view('tienda.index', compact(
            'productos',
            'cartItemCount',
            'searchTerm',
            'tiposDisponibles',
            'selectedTipo'
        ));
    }
    /**
     * Muestra la lista de productos para el administrador.
     */
    public function adminIndex()
    {
        $productos = Almacen::orderBy('nombre')->paginate(15);
        return view('admin.almacen.index', compact('productos'));
    }

    /**
     * Muestra el formulario para crear un nuevo producto.
     */
    public function create()
    {
        $tiposDisponibles = self::TIPOS_FIJOS;
        $valoracionesDisponibles = self::VALORACIONES_FIJAS;
        $producto = new Almacen();
        
        return view('admin.almacen.create', compact(
            'producto',
            'tiposDisponibles',
            'valoracionesDisponibles'
        ));
    }

    /**
     * Guarda un nuevo producto en la base de datos.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'sku' => 'required|string|max:50|unique:almacen,sku',
            'cantidad_disponible' => 'required|integer|min:0',
            'precio_unitario' => 'required|numeric|min:0',
            'proveedor' => 'nullable|string|max:255',
            'tipo' => ['required', 'string', Rule::in(self::TIPOS_FIJOS)],
            'valoracion' => ['nullable', 'integer', Rule::in(self::VALORACIONES_FIJAS)],
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('public/images');
            $validatedData['imagen'] = basename($path);
        }

        Almacen::create($validatedData);

        return redirect()->route('admin.almacen.index')->with('success', 'Producto creado con éxito.');
    }

    /**
     * Muestra el formulario para editar un producto existente.
     */
    public function edit(Almacen $almacen)
    {
        $tiposDisponibles = self::TIPOS_FIJOS;
        $valoracionesDisponibles = self::VALORACIONES_FIJAS;
        
        // El modelo $almacen se pasa automáticamente por la inyección de dependencias
        return view('admin.almacen.edit', compact(
            'producto',
            'tiposDisponibles',
            'valoracionesDisponibles'
        ));
    }

    /**
     * Actualiza un producto existente en la base de datos.
     */
    public function update(Request $request, Almacen $almacen)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'sku' => ['required', 'string', 'max:50', Rule::unique('almacen')->ignore($almacen->id)],
            'cantidad_disponible' => 'required|integer|min:0',
            'precio_unitario' => 'required|numeric|min:0',
            'proveedor' => 'nullable|string|max:255',
            'tipo' => ['required', 'string', Rule::in(self::TIPOS_FIJOS)],
            'valoracion' => ['nullable', 'integer', Rule::in(self::VALORACIONES_FIJAS)],
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            if ($almacen->imagen) {
                Storage::delete('public/images/' . $almacen->imagen);
            }
            $path = $request->file('imagen')->store('public/images');
            $validatedData['imagen'] = basename($path);
        }

        $almacen->update($validatedData);

        return redirect()->route('admin.almacen.index')->with('success', 'Producto actualizado con éxito.');
    }

    /**
     * Elimina un producto de la base de datos y su imagen asociada.
     */
    public function destroy(Almacen $almacen)
    {
        if ($almacen->imagen) {
            Storage::delete('public/images/' . $almacen->imagen);
        }
        $almacen->delete();

        return redirect()->route('admin.almacen.index')->with('success', 'Producto eliminado con éxito.');
    }
}