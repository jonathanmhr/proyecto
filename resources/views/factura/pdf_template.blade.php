<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Factura {{ $factura->numero_factura }}</title>
    <style>
        @page {
            margin: 20px 25px;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            font-size: 11px; /* Slightly smaller base font for more content room */
            line-height: 1.5;
        }
        .container {
            width: 100%;
            margin: 0 auto;
            padding: 10px; /* Reduced padding as page margin handles some */
        }

        /* --- Header --- */
        .header-section {
            margin-bottom: 20px;
            overflow: hidden; /* Clearfix */
        }
        .logo-container {
            float: left;
            width: 40%; /* Adjust as needed */
            text-align: left;
        }
        .logo-container img {
            max-width: 150px; /* Adjust for your logo */
            max-height: 70px;
        }
        .logo-placeholder { /* If you don't have an image yet */
            display: inline-block;
            padding: 20px;
            border: 1px dashed #ccc;
            color: #aaa;
            font-size: 16px;
        }
        .company-info-header {
            float: right;
            width: 58%; /* Adjust as needed */
            text-align: right;
        }
        .company-info-header h2 {
            margin: 0 0 5px 0;
            font-size: 16px;
            color: #2c3e50;
        }
        .company-info-header p {
            margin: 2px 0;
            font-size: 10px;
        }

        /* --- Invoice Title & Meta --- */
        .invoice-title-section {
            text-align: right;
            margin-bottom: 20px;
        }
        .invoice-title-section h1 {
            margin: 0;
            font-size: 28px;
            color: #3498db; /* Accent color */
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* --- Billing & Shipping Details --- */
        .details-section {
            margin-bottom: 25px;
            overflow: hidden; /* Clearfix */
        }
        .billing-details, .invoice-meta {
            padding: 10px;
            border: 1px solid #eee;
            border-radius: 4px;
            min-height: 120px; /* Ensure consistent height */
        }
        .billing-details {
            float: left;
            width: 47%;
        }
        .invoice-meta {
            float: right;
            width: 47%;
            text-align: right;
        }
        .section-subtitle {
            font-size: 13px;
            font-weight: bold;
            color: #3498db; /* Accent color */
            margin-top: 0;
            margin-bottom: 8px;
            border-bottom: 1px solid #f0f0f0;
            padding-bottom: 4px;
        }
        .billing-details p, .invoice-meta p {
            margin: 3px 0;
        }

        /* --- Items Table --- */
        .items-table-section table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .items-table-section th, .items-table-section td {
            border: 1px solid #ddd;
            padding: 10px; /* Increased padding */
            text-align: left;
            vertical-align: top;
        }
        .items-table-section th {
            background-color: #f7f7f7; /* Lighter grey */
            color: #333;
            font-weight: bold;
            font-size: 11px;
        }
        .items-table-section .text-right { text-align: right; }
        .items-table-section .item-description { width: 50%; }
        .items-table-section .item-qty, .items-table-section .item-price { width: 15%; }
        .items-table-section .item-subtotal { width: 20%; }


        /* --- Totals --- */
        .totals-section {
            margin-top: 10px; /* Reduced top margin as table has bottom margin */
            overflow: hidden; /* Clearfix */
            padding-bottom: 10px;
        }
        .totals-table {
            float: right;
            width: 45%; /* Slightly wider */
        }
        .totals-table table {
            width: 100%;
            border-collapse: collapse;
        }
        .totals-table td {
            padding: 6px 8px;
            border: none; /* Remove individual cell borders here */
        }
        .totals-table td:first-child {
            text-align: right;
            font-weight: bold;
            color: #555;
        }
        .totals-table td:last-child {
            text-align: right;
        }
        .totals-table .grand-total td {
            font-size: 1.3em;
            font-weight: bold;
            color: #3498db; /* Accent color */
            padding-top: 8px;
            border-top: 2px solid #3498db; /* Accent border */
        }

        /* --- Payment Details & Notes --- */
        .payment-notes-section {
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #eee;
            overflow: hidden; /* Clearfix */
        }
        .payment-details-box, .notes-box {
             margin-bottom: 15px;
        }
        .payment-details-box p, .notes-box p { margin: 3px 0; }
        .payment-details-box {
            float: left; width: 48%;
        }
        .notes-box {
            float: right; width: 48%;
        }


        /* --- Footer --- */
        .footer {
            font-size: 9px;
            color: #888;
            text-align: center;
            padding: 15px 0;
            border-top: 1px solid #eee;
            position: fixed; /* Keep fixed if desired, or remove for flow */
            bottom: -20px; /* Adjust to ensure it's within PDF margin if fixed */
            left: 25px;
            right: 25px;
            background-color: #fff; /* Ensure it has a background if overlapping */
        }
        .clearfix::after { content: ""; clear: both; display: table; }

        /* Helper class */
        .text-bold { font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">

        <div class="header-section">
            <div class="logo-container">
                <!-- Si tienes un logo, descomenta y ajusta la ruta -->
                <!-- <img src="{{ public_path('images/logo.png') }}" alt="Logo"> -->
                <span class="logo-placeholder">SU LOGO AQUÍ</span>
            </div>
            <div class="company-info-header">
                <h2>POWE-CORE</h2>
                <p>Calle Av, de Real Madrid, CP 08001</p>
                <p>Teléfono: +34 659 12 34 56 | Email: info@powercore.es</p>
                <p>NIF: B12345678</p>
            </div>
        </div>

        <div class="invoice-title-section">
            <h1>Factura</h1>
        </div>

        <div class="details-section clearfix">
            <div class="billing-details">
                <h3 class="section-subtitle">Facturar a:</h3>
                <p><span class="text-bold">{{ $info_cliente['nombre_facturacion'] ?? ($compra->user->name ?? 'N/D') }}</span></p>
                @if(!empty($info_cliente['direccion_facturacion']))
                    <p>{{ $info_cliente['direccion_facturacion'] }}</p>
                @endif
                <p>
                    @if(!empty($info_cliente['ciudad_facturacion'])){{ $info_cliente['ciudad_facturacion'] }}@endif @if(!empty($info_cliente['codigo_postal_facturacion'])) ({{ $info_cliente['codigo_postal_facturacion'] }})@endif
                </p>
                @if(!empty($info_cliente['pais_facturacion']))
                    <p>{{ $info_cliente['pais_facturacion'] }}</p>
                @endif
                <p>Email: {{ $info_cliente['email_facturacion'] ?? ($compra->user->email ?? 'N/D') }}</p>
                @if(!empty($info_cliente['telefono_facturacion']))
                    <p>Tel: {{ $info_cliente['telefono_facturacion'] }}</p>
                @endif
            </div>

            <div class="invoice-meta">
                <h3 class="section-subtitle">Detalles de Factura:</h3>
                <p><span class="text-bold">Número Factura:</span> {{ $factura->numero_factura }}</p>
                <p><span class="text-bold">Fecha Emisión:</span> {{ $factura->fecha_emision->format('d/m/Y') }}</p>
                <p><span class="text-bold">ID Compra:</span> #{{ $compra->id }}</p>
                @if(isset($metodo_envio) && !empty($metodo_envio))
                    <p><span class="text-bold">Método Envío:</span> {{ ucfirst(str_replace('_', ' ', $metodo_envio)) }}</p>
                @endif
            </div>
        </div>

        <div class="items-table-section">
            <table>
                <thead>
                    <tr>
                        <th class="item-description">Descripción</th>
                        <th class="item-qty text-right">Cantidad</th>
                        <th class="item-price text-right">Precio Unit.</th>
                        <th class="item-subtotal text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($compra->itemsAlmacen as $item)
                    <tr>
                        <td>{{ $item->nombre }} @if($item->sku) <br><small>(SKU: {{ $item->sku }})</small> @endif</td>
                        <td class="text-right">{{ $item->pivot->cantidad }}</td>
                        <td class="text-right">{{ number_format($item->pivot->precio_unitario_compra, 2, ',', '.') }} €</td>
                        <td class="text-right">{{ number_format($item->pivot->subtotal, 2, ',', '.') }} €</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align: center;">No hay artículos en esta compra.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="totals-section clearfix">
            <div class="totals-table">
                <table>
                    <tr>
                        <td>Subtotal:</td>
                        <td>{{ number_format($compra->total_compra, 2, ',', '.') }} €</td>
                    </tr>
                    <tr>
                        <td>Impuestos (IVA 0% Ejemplo):</td>
                        <td>0.00 €</td>
                    </tr>
                    @if(isset($coste_envio_variable) && $coste_envio_variable > 0) {{-- Assuming you might pass this --}}
                    <tr>
                        <td>Envío:</td>
                        <td>{{ number_format($coste_envio_variable, 2, ',', '.') }} €</td>
                    </tr>
                    @endif
                    <tr class="grand-total">
                        <td>TOTAL:</td>
                        <td>{{ number_format($factura->total_factura, 2, ',', '.') }} €</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="payment-notes-section clearfix">
            <div class="payment-details-box">
                <h3 class="section-subtitle">Detalles del Pago</h3>
                <p><span class="text-bold">Método de Pago:</span>
                    @if($compra->metodo_pago === 'simulado_tarjeta')
                        Tarjeta (Simulado)
                        @if(!empty($ultimos_digitos_tarjeta))
                            <span>- terminada en {{ $ultimos_digitos_tarjeta }}</span>
                        @endif
                    @else
                        {{ ucfirst(str_replace('_', ' ', $compra->metodo_pago)) }}
                    @endif
                </p>
                <p><span class="text-bold">Estado del Pago:</span> {{ ucfirst($factura->estado_pago) }}</p>
            </div>

            @if($factura->notas)
            <div class="notes-box">
                <h3 class="section-subtitle">Notas Adicionales</h3>
                <p>{{ $factura->notas }}</p>
            </div>
            @endif
        </div>

        <div class="footer">
            <p>Gracias por su compra. | POWER-CORE © {{ date('Y') }}. Todos los derechos reservados.</p>
            <p>Si tiene alguna pregunta sobre esta factura, contáctenos: info@powercore.es | +34 659 12 34 56</p>
        </div>
    </div>
</body>
</html>