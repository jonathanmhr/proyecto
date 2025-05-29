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
            'card_number_simulado' => 'nullable|string|regex:/^[\d\s]{13,19}$/', 
            'card_expiry_simulado' => 'nullable|string|regex:/^(0[1-9]|1[0-2])\s?\/\s?(\d{2})$/', 
            'card_cvc_simulado' => 'nullable|string|regex:/^\d{3,4}$/', 
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

            $compra = Compra::create([
                'user_id' => $user->id,
                'fecha_compra' => now(),
                'total_compra' => $totalCompra,
                'metodo_pago' => $validatedData['metodo_pago'],
                'estado' => 'pagada',
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

            $factura = Factura::create([
                'compra_id' => $compra->id,
                'numero_factura' => $numeroFactura,
                'fecha_emision' => now(),
                'total_factura' => $totalCompra,
                'estado_pago' => 'pagada',
                'notas' => $notasFactura,
            ]);

            $infoClienteParaPdf = [
                'nombre_facturacion' => $validatedData['nombre_facturacion'],
                'email_facturacion' => $validatedData['email_facturacion'],
                'direccion_facturacion' => $validatedData['direccion_facturacion'],
                'telefono_facturacion' => $validatedData['telefono_facturacion'],
                'ciudad_facturacion' => $validatedData['ciudad_facturacion'],
                'pais_facturacion' => $validatedData['pais_facturacion'],
                'codigo_postal_facturacion' => $validatedData['codigo_postal_facturacion'],
            ];

            $ultimosDigitosTarjeta = null;
            if ($validatedData['metodo_pago'] === 'simulado_tarjeta' && !empty($validatedData['card_number_simulado'])) {
                $numeroTarjetaLimpio = preg_replace('/\s+/', '', $validatedData['card_number_simulado']);
                if (strlen($numeroTarjetaLimpio) >= 4) {
                    $ultimosDigitosTarjeta = substr($numeroTarjetaLimpio, -4);
                }
            }

            $datosFactura = [
                'compra' => $compra->load('user', 'itemsAlmacen'),
                'factura' => $factura,
                'info_cliente' => $infoClienteParaPdf,
                'metodo_envio' => $validatedData['metodo_envio'],
                'ultimos_digitos_tarjeta' => $ultimosDigitosTarjeta,
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
            return redirect()->route('compra.show', $compra->id)
                             ->with('success', '¡Compra realizada con éxito! Tu factura ha sido generada.')
                             ->with('factura_pdf_url', $urlPdfPublica);

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
}