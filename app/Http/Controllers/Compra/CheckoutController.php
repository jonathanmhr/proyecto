<?php

namespace App\Http\Controllers\Compra;

use App\Http\Controllers\Controller;
use App\Models\Almacen;
use App\Models\Compra;
use App\Models\Factura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf; 
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage; 
use Illuminate\Support\Facades\Log;     

class CheckoutController extends Controller
{
    public function index()
    {
        $carrito = Session::get('carrito');
        if (empty($carrito)) {
            return redirect()->route('tienda.index')->with('error', 'Tu carrito está vacío.');
        }

        $totalCarrito = 0;
        foreach ($carrito as $item) {
            $totalCarrito += $item['precio_unitario'] * $item['cantidad'];
        }

        return view('checkout.index', compact('carrito', 'totalCarrito'));
    }

    public function procesar(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            // Considera redirigir al login si el usuario no está autenticado
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para procesar la compra.');
        }

        $carrito = Session::get('carrito');

        if (empty($carrito)) {
            return redirect()->route('tienda.index')->with('error', 'Tu carrito está vacío.');
        }

        $request->validate([
            'nombre_facturacion' => 'required|string|max:255',
            'email_facturacion' => 'required|email|max:255',
            // 'direccion_facturacion' => 'required|string|max:255',
            // 'metodo_pago' => 'required|string' // Si tienes varios métodos
        ]);

        DB::beginTransaction();

        try {
            $totalCompra = 0;
            foreach ($carrito as $item) {
                $totalCompra += $item['precio_unitario'] * $item['cantidad'];
            }

            $compra = Compra::create([
                'user_id' => $user->id,
                'fecha_compra' => now(),
                'total_compra' => $totalCompra,
                'metodo_pago' => $request->input('metodo_pago', 'simulado_tarjeta'),
                'estado' => 'pagada',
            ]);

            foreach ($carrito as $id_producto => $itemCarrito) {
                $productoAlmacen = Almacen::find($id_producto);
                if (!$productoAlmacen || $productoAlmacen->cantidad_disponible < $itemCarrito['cantidad']) {
                    DB::rollBack(); // Importante hacer rollback aquí
                    Log::warning('Intento de compra con stock insuficiente o producto no encontrado.', [
                        'producto_id' => $id_producto,
                        'producto_nombre' => $itemCarrito['nombre'] ?? 'N/A',
                        'cantidad_solicitada' => $itemCarrito['cantidad'],
                        'cantidad_disponible' => $productoAlmacen ? $productoAlmacen->cantidad_disponible : 'No encontrado'
                    ]);
                    return redirect()->route('checkout.index')->with('error', 'Stock insuficiente para ' . ($itemCarrito['nombre'] ?? 'un producto') . ' o producto no encontrado.');
                }

                $compra->itemsAlmacen()->attach($id_producto, [
                    'cantidad' => $itemCarrito['cantidad'],
                    'precio_unitario_compra' => $itemCarrito['precio_unitario'],
                    'subtotal' => $itemCarrito['precio_unitario'] * $itemCarrito['cantidad'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $productoAlmacen->cantidad_disponible -= $itemCarrito['cantidad'];
                $productoAlmacen->save();
            }

            $numeroFactura = 'FACT-' . date('Ymd') . '-' . strtoupper(Str::random(6));
            $factura = Factura::create([
                'compra_id' => $compra->id,
                'numero_factura' => $numeroFactura,
                'fecha_emision' => now(),
                'total_factura' => $totalCompra,
                'estado_pago' => 'pagada',
                'notas' => 'Compra realizada por: ' . $request->nombre_facturacion . ' (' . $request->email_facturacion . ')',
            ]);

            $datosFactura = [
                'compra' => $compra->load('user', 'itemsAlmacen'),
                'factura' => $factura,
                'info_cliente' => $request->only(['nombre_facturacion', 'email_facturacion'])
            ];

          
            $pdf = Pdf::loadView('factura.pdf_template', $datosFactura);
        
            $nombreArchivoPdf = 'factura-' . $factura->numero_factura . '.pdf';
           
            $rutaDirectorioRelativa = 'facturas_pdf/' . date('Y/m');
            $rutaEnStorage = $rutaDirectorioRelativa . '/' . $nombreArchivoPdf;

            Storage::disk('public')->put($rutaEnStorage, $pdf->output());

            $factura->ruta_pdf = $rutaEnStorage;
            $factura->save();

            DB::commit();

            Session::forget('carrito');

            $urlPdfPublica = Storage::disk('public')->url($factura->ruta_pdf);
            return redirect()->route('compra.index', $compra->id)
                             ->with('success', '¡Compra realizada con éxito! Tu factura ha sido generada.')
                             ->with('factura_pdf_url', $urlPdfPublica);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error al procesar la compra: " . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'user_id' => $user ? $user->id : null,
                'request_data' => $request->all()
            ]);
            return redirect()->route('checkout.index')->with('error', 'Error al procesar la compra: ' . $e->getMessage() . '. Por favor, inténtalo de nuevo o contacta a soporte.');
        }
    }
}