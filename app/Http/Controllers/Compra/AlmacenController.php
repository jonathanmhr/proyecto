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
    // CORRECCIÓN: Constantes actualizadas con los nuevos tipos.
    const TIPOS_FIJOS = ['EQUIPO DEPORTIVO','NUTRICIONISMO','ENERGIZANTE','PESO/FUERZA','RESISTENCIA','ALIMENTACION','SUPLEMENTACION'];
    const VALORACIONES_FIJAS = ['1', '2', '3', '4', '5'];

    /**
     * Muestra la tienda pública para los clientes con filtros avanzados.
     */
    public function tiendaIndex(Request $request)
    {
        // 1. Validar todos los posibles filtros de entrada
        $validated = $request->validate([
            'search' => 'nullable|string|max:255',
            'tipo' => ['nullable', 'string', Rule::in(self::TIPOS_FIJOS)],
            'valoracion_minima' => 'nullable|integer|min:0|max:5',
        ]);

        // 2. Extraer las variables de los filtros
        $searchTerm = $validated['search'] ?? null;
        $selectedTipo = $validated['tipo'] ?? null;
        $selectedRating = $validated['valoracion_minima'] ?? 0;
        
        // Usamos la constante actualizada para asegurar que los filtros sean consistentes.
        $tiposDisponibles = self::TIPOS_FIJOS;

        // 3. Construir la consulta base
        $query = Almacen::where('cantidad_disponible', '>', 0);

        // 4. Aplicar los filtros de forma condicional
        $query->when($searchTerm, function ($query, $searchTerm) {
            return $query->where('nombre', 'LIKE', '%' . $searchTerm . '%');
        });

        $query->when($selectedTipo, function ($query, $selectedTipo) {
            return $query->where('tipo', $selectedTipo);
        });
        
        $query->when($selectedRating, function ($query, $ratingValue) {
            return $query->where('valoracion', '>=', $ratingValue);
        });

        // 5. Ejecutar la consulta y paginar
        $productos = $query->orderBy('nombre')->paginate(12);
        
        // 6. Mantener los filtros en los enlaces de paginación
        $productos->appends($request->query());

        // 7. Obtener datos adicionales
        $cartItemCount = collect(Session::get('carrito', []))->sum('cantidad');

        // 8. Devolver la vista con todas las variables
        return view('tienda.index', compact(
            'productos',
            'cartItemCount',
            'searchTerm',
            'tiposDisponibles',
            'selectedTipo',
            'selectedRating'
        ));
    }

    /**
     * Muestra la lista de productos para el administrador.
     */
    public function adminIndex(Request $request)
    {
        $searchTerm = $request->input('search');
        $query = Almacen::query();

        if ($searchTerm) {
            $query->where(function($q) use ($searchTerm) {
                $q->where('nombre', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('sku', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        $productos = $query->orderBy('nombre')->paginate(15);
        $productos->appends(['search' => $searchTerm]);
        
        return view('admin.almacen.index', compact('productos', 'searchTerm'));
    }

    /**
     * Muestra el formulario para crear un nuevo producto.
     */
    public function create()
    {
        $tiposDisponibles = self::TIPOS_FIJOS;
        $valoracionesDisponibles = self::VALORACIONES_FIJAS;
        $producto = new Almacen();
        
        return view('admin.almacen.create', compact('producto', 'tiposDisponibles', 'valoracionesDisponibles'));
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
    public function edit(Almacen $producto)
    {
        $tiposDisponibles = self::TIPOS_FIJOS;
        $valoracionesDisponibles = self::VALORACIONES_FIJAS;
        
        return view('admin.almacen.edit', compact('producto', 'tiposDisponibles', 'valoracionesDisponibles'));
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