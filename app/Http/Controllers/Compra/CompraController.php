<?php

namespace App\Http\Controllers\Compra;

use App\Http\Controllers\Controller;
use App\Models\Compra;
use App\Models\Factura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Bouncer;

class CompraController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $compras = Compra::where('user_id', $user->id)
                         ->with('factura')
                         ->orderBy('fecha_compra', 'desc')
                         ->paginate(10);

        return view('cliente.compras.index', compact('compras'));
    }

    public function show(Compra $compra)
    {
        if (Auth::id() !== $compra->user_id && !Bouncer::is(Auth::user())->an('admin')) {
            abort(403);
        }
        $compra->load('user', 'itemsAlmacen.almacen', 'factura');

        $facturaPdfUrl = session('factura_pdf_url');

        if (!$facturaPdfUrl && $compra->factura && $compra->factura->ruta_pdf) {
            $facturaPdfUrl = Storage::disk('public')->url($compra->factura->ruta_pdf);
        }

        $datosCheckout = [];
        if ($compra->factura && $compra->factura->notas) {
            $notas = $compra->factura->notas;

            if (preg_match('/Compra realizada por: (.*?) \((.*?)\)/', $notas, $matches)) {
                $datosCheckout['nombre_facturacion'] = $matches[1];
                $datosCheckout['email_facturacion'] = $matches[2];
            } else {
                $datosCheckout['info_general'] = $notas;
            }
        }

        return view('cliente.compras.show', compact('compra', 'facturaPdfUrl', 'datosCheckout'));
    }


    public function downloadFactura(Compra $compra)
    {
        if (Auth::id() !== $compra->user_id && !Bouncer::is(Auth::user())->an('admin')) {
            abort(403);
        }

        if (!$compra->factura || !$compra->factura->ruta_pdf) {
            Log::warning("Intento de descarga de factura sin PDF para compra ID: {$compra->id}");
            return redirect()->back()->with('error', 'La factura para esta compra no está disponible para descarga.');
        }

        $path = $compra->factura->ruta_pdf;

        if (!Storage::disk('public')->exists($path)) {
            Log::error("Archivo PDF no encontrado en storage para factura: {$path}, compra ID: {$compra->id}");
            return redirect()->back()->with('error', 'El archivo de la factura no se encontró. Contacte a soporte.');
        }

        return Storage::disk('public')->download($path);
    }

   public function adminIndex(Request $request) 
    {
        $user = Auth::user(); 

        $searchTerm = $request->input('search'); 

        $query = Compra::with(['user', 'factura']);

        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                
                if (is_numeric($searchTerm)) {
                    $q->where('id', '=', $searchTerm);
                } else {
                    $q->orWhere('id', 'LIKE', '%' . $searchTerm . '%');
                }

                $q->orWhereHas('factura', function ($facturaQuery) use ($searchTerm) {
                    $facturaQuery->where('numero_factura', 'LIKE', '%' . $searchTerm . '%');
                });

                
                $q->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                     $userQuery->where('name', 'LIKE', '%' . $searchTerm . '%')
                               ->orWhere('email', 'LIKE', '%' . $searchTerm . '%');
                 });
            });
        }

        $compras = $query->orderBy('fecha_compra', 'desc')
                         ->paginate(15);

       
        $compras->appends(['search' => $searchTerm]);

        
        return view('admin.compras.index', compact('compras', 'searchTerm'));
    }

    public function adminShow(Compra $compra)
    {
        $user = Auth::user();

        $compra->load('user', 'itemsAlmacen.almacen', 'factura');

        $facturaPdfUrl = null;
        if ($compra->factura && $compra->factura->ruta_pdf) {
            $facturaPdfUrl = Storage::disk('public')->url($compra->factura->ruta_pdf);
        }

        $datosCheckout = [];
        if ($compra->factura && $compra->factura->notas) {
            $notas = $compra->factura->notas;
            if (preg_match('/Compra realizada por: (.*?) \((.*?)\)/', $notas, $matches)) {
                $datosCheckout['nombre_facturacion'] = $matches[1];
                $datosCheckout['email_facturacion'] = $matches[2];
            } else {
                $datosCheckout['info_general'] = $notas;
            }
        }

        return view('admin.compras.show', compact('compra', 'facturaPdfUrl', 'datosCheckout'));
    }
}
