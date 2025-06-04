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
use Barryvdh\DomPDF\Facade\Pdf; // Keep this
use Illuminate\Support\Str;
// use Illuminate\Support\Facades\Storage; // No longer needed for saving PDF here
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
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para procesar la compra.');
        }

        $carrito = Session::get('carrito');

        if (empty($carrito)) {
            return redirect()->route('tienda.index')->with('error', 'Tu carrito está vacío.');
        }

        $rules = [
            'nombre_facturacion' => 'required|string|max:255',
            'email_facturacion' => 'required|email|max:255',
            'direccion_facturacion' => 'required|string|max:255',
            'telefono_facturacion' => 'required|string|max:20',
            'ciudad_facturacion' => 'required|string|max:100',
            'pais_facturacion' => 'required|string|max:100',
            'codigo_postal_facturacion' => 'required|string|max:20',
            'metodo_envio' => 'required|string|max:50',
            'metodo_pago' => 'required|string',
            'card_number_simulado' => ['nullable', 'string', 'regex:/^[\d\s]{13,19}$/'],
            'card_expiry_simulado' => ['nullable', 'string', 'regex:/^(0[1-9]|1[0-2])\s?\/\s?(\d{2})$/'],
            'card_cvc_simulado' => ['nullable', 'string', 'regex:/^\d{3,4}$/'],
        ];

        $messages = [
            'card_number_simulado.regex' => 'El número de tarjeta simulado no es válido.',
            'card_expiry_simulado.regex' => 'La fecha de caducidad simulada debe ser MM/AA.',
            'card_cvc_simulado.regex' => 'El CVC/CVV simulado debe tener 3 o 4 dígitos.',
        ];

        $validatedData = $request->validate($rules, $messages);

        DB::beginTransaction();

        try {
            $totalCompra = 0;
            foreach ($carrito as $item) {
                $totalCompra += $item['precio_unitario'] * $item['cantidad'];
            }

            // Store metodo_envio on Compra
            $compra = Compra::create([
                'user_id' => $user->id,
                'fecha_compra' => now(),
                'total_compra' => $totalCompra,
                'metodo_pago' => $validatedData['metodo_pago'],
                'metodo_envio' => $validatedData['metodo_envio'], // STORED HERE
                'estado' => 'pagada', // Assuming payment is processed
            ]);

            foreach ($carrito as $id_producto => $itemCarrito) {
                $productoAlmacen = Almacen::find($id_producto);
                if (!$productoAlmacen || $productoAlmacen->cantidad_disponible < $itemCarrito['cantidad']) {
                    DB::rollBack();
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
            $notasFactura = 'Compra realizada por: ' . $validatedData['nombre_facturacion'] . ' (' . $validatedData['email_facturacion'] . ').';

            $ultimosDigitosTarjeta = null;
            if ($validatedData['metodo_pago'] === 'simulado_tarjeta' && !empty($validatedData['card_number_simulado'])) {
                $numeroTarjetaLimpio = preg_replace('/\s+/', '', $validatedData['card_number_simulado']);
                if (strlen($numeroTarjetaLimpio) >= 4) {
                    $ultimosDigitosTarjeta = substr($numeroTarjetaLimpio, -4);
                }
            }

            $factura = Factura::create([
                'compra_id' => $compra->id,
                'numero_factura' => $numeroFactura,
                'fecha_emision' => now(),
                'total_factura' => $totalCompra,
                'estado_pago' => 'pagada', // Assuming payment is processed
                'notas' => $notasFactura,
                // Store client details directly on Factura
                'nombre_cliente' => $validatedData['nombre_facturacion'],
                'email_cliente' => $validatedData['email_facturacion'],
                'direccion_cliente' => $validatedData['direccion_facturacion'],
                'telefono_cliente' => $validatedData['telefono_facturacion'], // NEW
                'ciudad_cliente' => $validatedData['ciudad_facturacion'],     // NEW
                'pais_cliente' => $validatedData['pais_facturacion'],         // NEW
                'codigo_postal_cliente' => $validatedData['codigo_postal_facturacion'], // NEW
                'ultimos_digitos_tarjeta' => $ultimosDigitosTarjeta, // NEW
                // 'ruta_pdf' => $rutaEnStorage, // REMOVE THIS
            ]);
            // $factura->save(); // Not needed if all fields are in create() and fillable

            DB::commit();

            Session::forget('carrito');

            // No PDF URL to pass now
            return redirect()->route('compras.show', $compra->id)
                             ->with('success', '¡Compra realizada con éxito! Puedes generar tu factura desde los detalles de la compra.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error al procesar la compra: " . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'user_id' => $user ? $user->id : null,
                'request_data' => $request->all()
            ]);
            return redirect()->route('checkout.index')->with('error', 'Error al procesar la compra. Por favor, inténtalo de nuevo o contacta a soporte. Detalle: ' . $e->getMessage());
        }
    }

    /**
     * Genera y descarga la factura en PDF para una compra específica.
     *
     * @param  \App\Models\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function generarFacturaPdf(Compra $compra)
    {
        // Eager load necessary relationships
        $compra->load('user', 'itemsAlmacen', 'factura');

        if (!$compra->factura) {
            // Or handle this error more gracefully, e.g., redirect back with an error
            abort(404, 'Factura no encontrada para esta compra.');
        }

        $factura = $compra->factura;

        // Reconstruct client info from Factura model
        $infoClienteParaPdf = [
            'nombre_facturacion' => $factura->nombre_cliente,
            'email_facturacion' => $factura->email_cliente,
            'direccion_facturacion' => $factura->direccion_cliente,
            'telefono_facturacion' => $factura->telefono_cliente,
            'ciudad_facturacion' => $factura->ciudad_cliente,
            'pais_facturacion' => $factura->pais_cliente,
            'codigo_postal_facturacion' => $factura->codigo_postal_cliente,
        ];

        $datosFactura = [
            'compra' => $compra,
            'factura' => $factura,
            'info_cliente' => $infoClienteParaPdf,
            'metodo_envio' => $compra->metodo_envio, // Get from Compra model
            'ultimos_digitos_tarjeta' => $factura->ultimos_digitos_tarjeta, // Get from Factura model
        ];

        try {
            $pdf = Pdf::loadView('factura.pdf_template', $datosFactura);
            $nombreArchivoPdf = 'factura-' . $factura->numero_factura . '.pdf';

            // Stream the PDF to the browser for download
            return $pdf->download($nombreArchivoPdf);

        } catch (\Exception $e) {
            Log::error("Error al generar PDF para factura {$factura->numero_factura}: " . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'compra_id' => $compra->id,
                'factura_id' => $factura->id
            ]);
            // You might want to redirect back with an error message
            return redirect()->back()->with('error', 'No se pudo generar el PDF de la factura. Por favor, contacte a soporte.');
        }
    }
}