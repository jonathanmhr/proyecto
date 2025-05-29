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
        .company-details p, .customer-details p, .payment-details p { margin: 2px 0; line-height: 1.4; }
        .details-section { margin-bottom: 25px; overflow: auto; }
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
        .payment-details { margin-top: 20px; padding-top:10px; border-top: 1px solid #eee; }
        .footer { font-size: 10px; color: #777; border-top: 1px solid #eee; padding-top: 10px; position: fixed; bottom: 0; width:100%; text-align: center;}
        .clearfix::after { content: ""; clear: both; display: table; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>FACTURA</h1>
            <p>POWE-CORE</p>
            <p>Teléfono: +34 659 12 34 56 | Email: info@powercore.es</p>
        </div>

        <div class="details-section clearfix">
            <div class="company-details">
                <p><strong>Facturar a:</strong></p>
                <p>{{ $info_cliente['nombre_facturacion'] ?? ($compra->user->name ?? 'N/D') }}</p>
                @if(!empty($info_cliente['direccion_facturacion']))
                    <p>{{ $info_cliente['direccion_facturacion'] }}</p>
                @endif
                <p>
                    @if(!empty($info_cliente['ciudad_facturacion']))
                        {{ $info_cliente['ciudad_facturacion'] }}
                    @endif
                    @if(!empty($info_cliente['codigo_postal_facturacion']))
                        ({{ $info_cliente['codigo_postal_facturacion'] }})
                    @endif
                </p>
                @if(!empty($info_cliente['pais_facturacion']))
                    <p>{{ $info_cliente['pais_facturacion'] }}</p>
                @endif
                <p>Email: {{ $info_cliente['email_facturacion'] ?? ($compra->user->email ?? 'N/D') }}</p>
                @if(!empty($info_cliente['telefono_facturacion']))
                    <p>Tel: {{ $info_cliente['telefono_facturacion'] }}</p>
                @endif
            </div>
            <div class="customer-details">
                <p><strong>Número de Factura:</strong> {{ $factura->numero_factura }}</p>
                <p><strong>Fecha de Emisión:</strong> {{ $factura->fecha_emision->format('d/m/Y') }}</p>
                <p><strong>ID Compra:</strong> #{{ $compra->id }}</p>
                @if(isset($metodo_envio) && !empty($metodo_envio))
                    <p><strong>Método de Envío:</strong> {{ ucfirst(str_replace('_', ' ', $metodo_envio)) }}</p>
                @endif
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
                    <td>Impuestos (IVA 0% Ejemplo):</td>
                    <td class="text-right">0.00 €</td>
                </tr>
                <tr>
                    <td style="font-size: 1.2em;"><strong>TOTAL:</strong></td>
                    <td class="text-right" style="font-size: 1.2em;"><strong>{{ number_format($factura->total_factura, 2, ',', '.') }} €</strong></td>
                </tr>
            </table>
        </div>
        <div class="clearfix"></div>

        <div class="payment-details">
            <p><strong>Método de Pago:</strong>
                @if($compra->metodo_pago === 'simulado_tarjeta')
                    Tarjeta (Simulado)
                    @if(!empty($ultimos_digitos_tarjeta))
                        <span>- terminada en {{ $ultimos_digitos_tarjeta }}</span>
                    @endif
                @else
                    {{ ucfirst(str_replace('_', ' ', $compra->metodo_pago)) }}
                @endif
            </p>
        </div>

        @if($factura->notas)
        <div style="margin-top: 15px;">
            <strong>Notas Adicionales:</strong>
            <p>{{ $factura->notas }}</p>
        </div>
        @endif

        <div class="footer">
            <p>Gracias por su compra.</p>
            <p>POWER_CORE © {{ date('Y') }}</p>
        </div>
    </div>
</body>
</html>