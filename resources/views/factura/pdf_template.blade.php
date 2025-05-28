<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Factura {{ $factura->numero_factura }}</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; margin: 0; padding: 0; color: #333; font-size: 12px; }
        .container { width: 100%; margin: 0 auto; padding: 20px; }
        .header, .footer { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 24px; color: #2c3e50; }
        .header p { margin: 5px 0; }
        .company-details p, .customer-details p { margin: 2px 0; }
        .details-section { margin-bottom: 25px; overflow: auto; /* Clearfix */ }
        .company-details { float: left; width: 48%; }
        .customer-details { float: right; width: 48%; text-align: right; }
        .invoice-info { text-align: right; margin-bottom: 20px; }
        .invoice-info p { margin: 2px 0; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .text-right { text-align: right; }
        .totals { margin-top: 20px; float: right; width: 40%; }
        .totals table td { border: none; }
        .totals table td:first-child { font-weight: bold; }
        .footer { font-size: 10px; color: #777; border-top: 1px solid #eee; padding-top: 10px; position: fixed; bottom: 0; width:100%; text-align: center;}
        .clearfix::after { content: ""; clear: both; display: table; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>FACTURA</h1>
            <p>Gimnasio GYMSIS</p>
            <p>Tu Dirección, Ciudad</p>
            <p>Teléfono: (123) 456-7890 | Email: info@gymsis.com</p>
        </div>

        <div class="details-section clearfix">
            <div class="company-details">
                <p><strong>Facturar a:</strong></p>
                <p>{{ $info_cliente['nombre_facturacion'] ?? $compra->user->name }}</p>
                <p>{{ $info_cliente['email_facturacion'] ?? $compra->user->email }}</p>
                {{-- <p>Dirección del Cliente</p> --}}
            </div>
            <div class="customer-details">
                <p><strong>Número de Factura:</strong> {{ $factura->numero_factura }}</p>
                <p><strong>Fecha de Emisión:</strong> {{ $factura->fecha_emision->format('d/m/Y') }}</p>
                <p><strong>ID Compra:</strong> #{{ $compra->id }}</p>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Precio Unit.</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($compra->itemsAlmacen as $item)
                <tr>
                    <td>{{ $item->nombre }} @if($item->sku) (SKU: {{ $item->sku }}) @endif</td>
                    <td class="text-right">{{ $item->pivot->cantidad }}</td>
                    <td class="text-right">{{ number_format($item->pivot->precio_unitario_compra, 2, ',', '.') }} €</td>
                    <td class="text-right">{{ number_format($item->pivot->subtotal, 2, ',', '.') }} €</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals clearfix">
            <table style="float: right;">
                <tr>
                    <td>Subtotal:</td>
                    <td class="text-right">{{ number_format($compra->total_compra, 2, ',', '.') }} €</td>
                </tr>
                <tr>
                    <td>Impuestos (IVA 0% Ejemplo):</td> {{-- Ajusta según tus impuestos --}}
                    <td class="text-right">0.00 €</td>
                </tr>
                <tr>
                    <td style="font-size: 1.2em;"><strong>TOTAL:</strong></td>
                    <td class="text-right" style="font-size: 1.2em;"><strong>{{ number_format($factura->total_factura, 2, ',', '.') }} €</strong></td>
                </tr>
            </table>
        </div>
        <div class="clearfix"></div>

        @if($factura->notas)
        <div style="margin-top: 30px;">
            <strong>Notas Adicionales:</strong>
            <p>{{ $factura->notas }}</p>
        </div>
        @endif

        <div class="footer">
            <p>Gracias por su compra.</p>
            <p>GYMSIS © {{ date('Y') }}</p>
        </div>
    </div>
</body>
</html>