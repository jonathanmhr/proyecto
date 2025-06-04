<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Factura {{ $factura->numero_factura }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color:rgb(195, 7, 7); /* Un verde azulado oscuro y sofisticado */
            --secondary-color:rgb(237, 70, 70); /* Un tono más claro del primario para acentos suaves */
            --text-color: #333333;
            --light-gray: #f8f9fa;
            --border-color: #dee2e6;
            --header-bg-color: #f1f3f5;
        }

        body {
            font-family: 'Lato', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #FFFFFF; /* Fondo blanco para el PDF */
            color: var(--text-color);
            font-size: 12px; /* AUMENTADO: Tamaño base para el PDF */
            line-height: 1.6; /* AUMENTADO: para mejor legibilidad con fuentes más grandes */
        }

        .invoice-container {
            width: 100%;
            max-width: 750px; /* Ancho estándar A4 menos márgenes */
            margin: 20px auto;
            padding: 25px;
            background-color: #FFFFFF;
            /* box-shadow: 0 0 15px rgba(0,0,0,0.05); Opcional si se ve en HTML */
        }

        /* --- Cabecera --- */
        .invoice-header {
            display: table; /* Para que las celdas de la tabla ocupen el ancho */
            width: 100%;
            margin-bottom: 30px;
        }
        .header-section {
            display: table-cell;
            vertical-align: top;
        }
        .logo-container {
            width: 110px; /* Ajusta al tamaño de tu logo */
            padding-right: 20px;
        }
        .logo-container img {
            max-width: 100%;
            max-height: 70px; /* AUMENTADO */
        }
        .company-info h2 {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.8em; /* AUMENTADO (relativo al body) */
            font-weight: 700;
            color: var(--primary-color);
            margin: 0 0 5px 0;
        }
        .company-info p {
            margin: 3px 0;
            font-size: 1em; /* AUMENTADO (relativo al body) */
            color: #555;
        }
        .invoice-title-section {
            text-align: right;
        }
        .invoice-title-section h1 {
            font-family: 'Montserrat', sans-serif;
            font-size: 2.6em; /* AUMENTADO (relativo al body) */
            font-weight: 700;
            color: var(--primary-color);
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .invoice-title-section p {
            margin: 4px 0;
            font-size: 1em; /* AUMENTADO (relativo al body) */
        }
        .invoice-title-section .label {
            font-weight: 600;
            color: var(--text-color);
        }

        /* --- Detalles de Facturación (Cliente y Emisor) --- */
        .billing-details {
            display: table;
            width: 100%;
            margin-bottom: 30px;
            border-collapse: separate;
            border-spacing: 20px 0; /* Espacio horizontal entre columnas */
        }
        .billing-column {
            display: table-cell;
            width: 48%; /* Aproximadamente mitad y mitad con espacio */
            vertical-align: top;
            padding: 15px;
            background-color: var(--light-gray);
            border-radius: 5px;
        }
        .billing-column h3 {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.3em; /* AUMENTADO (relativo al body) */
            font-weight: 600;
            color: var(--primary-color);
            margin-top: 0;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid var(--secondary-color);
        }
        .billing-column p {
            margin: 5px 0;
            font-size: 1em; /* AUMENTADO (relativo al body) */
            color: #444;
        }
        .billing-column .strong { font-weight: 700; }

        /* --- Tabla de Artículos --- */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        .items-table th, .items-table td {
            padding: 12px 14px; /* AUMENTADO padding */
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }
        .items-table thead th {
            background-color: var(--header-bg-color);
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            color: var(--primary-color);
            text-transform: uppercase;
            font-size: 0.95em; /* AUMENTADO (relativo al body) */
            letter-spacing: 0.5px;
        }
        .items-table tbody tr:last-child td {
            border-bottom: none; /* Sin borde inferior en la última fila */
        }
        .items-table tbody td {
            font-size: 1em; /* AUMENTADO (relativo al body) */
            color: #333;
        }
        .items-table .item-description small {
            font-size: 0.9em; /* Relativo al td, ahora un poco más grande */
            color: #777;
        }
        .items-table .text-right { text-align: right; }
        .items-table .text-center { text-align: center; }

        /* --- Resumen de Totales --- */
        .totals-summary {
            width: 45%; /* Ajusta el ancho según prefieras */
            margin-left: auto; /* Alinea a la derecha */
            margin-bottom: 25px;
        }
        .totals-summary table {
            width: 100%;
            border-collapse: collapse;
        }
        .totals-summary td {
            padding: 9px 0; /* AUMENTADO padding */
            font-size: 1.05em; /* AUMENTADO (relativo al body) */
        }
        .totals-summary td:first-child {
            text-align: right;
            color: #555;
            padding-right: 15px;
        }
        .totals-summary td:last-child {
            text-align: right;
            font-weight: 700;
            color: var(--text-color);
        }
        .totals-summary .grand-total td {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.4em; /* AUMENTADO (relativo al body) */
            font-weight: 700;
            color: #FFFFFF;
            background-color: var(--primary-color);
            padding: 12px 14px; /* AUMENTADO padding */
            border-radius: 3px; /* Redondeo sutil si el generador PDF lo soporta */
        }
        .totals-summary .grand-total td:first-child {
             color: #FFFFFF; /* Asegura que el texto "TOTAL" sea blanco */
        }


        /* --- Información de Pago y Notas --- */
        .payment-notes-section {
            margin-bottom: 30px;
            padding-top: 15px;
            border-top: 1px solid var(--border-color);
        }
        .payment-notes-section h4 {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.2em; /* AUMENTADO (relativo al body) */
            font-weight: 600;
            color: var(--primary-color);
            margin-top: 0;
            margin-bottom: 8px;
        }
        .payment-notes-section p {
            margin: 6px 0;
            font-size: 1em; /* AUMENTADO (relativo al body) */
            color: #444;
        }
        .payment-notes-section .label {
            font-weight: 600;
        }

        /* --- Pie de Página --- */
        .invoice-footer {
            text-align: center;
            padding-top: 20px;
            margin-top: 20px;
            border-top: 2px solid var(--primary-color);
            font-size: 0.9em; /* AUMENTADO (relativo al body) */
            color: #777;
        }
        .invoice-footer p {
            margin: 5px 0;
        }

    </style>
</head>
<body>
    <div class="invoice-container">
        <header class="invoice-header">
            <div class="header-section logo-company-info">
                <div class="company-info" style="display:inline-block; vertical-align: middle; padding-left: {{ true ? '15px' : '0' }};">
                    <h2>POWERCORE</h2>
                    <p>Av. de America 34, Ciudad, CP</p>
                    <p>Tel: +34 648 23 42 24 | Email: info@powercore.es</p>
                    <p>NIF: B12345678</p>
                </div>
            </div>
            <div class="header-section invoice-title-section">
                <h1>Factura</h1>
                <p><span class="label">Nº Factura:</span> {{ $factura->numero_factura }}</p>
                <p><span class="label">Fecha Emisión:</span> {{ $factura->fecha_emision->format('d/m/Y') }}</p>
                <p><span class="label">ID Compra:</span> #{{ $compra->id }}</p>
                 @if(isset($metodo_envio) && !empty($metodo_envio))
                    <p><span class="label">Método Envío:</span> {{ ucfirst(str_replace('_', ' ', $metodo_envio)) }}</p>
                @endif
            </div>
        </header>

        <section class="billing-details">
            <div class="billing-column">
                <h3>Facturar a:</h3>
                <p><span class="strong">{{ $info_cliente['nombre_facturacion'] ?? ($compra->user->name ?? 'N/D') }}</span></p>
                @if(!empty($info_cliente['direccion_facturacion']))
                    <p>{{ $info_cliente['direccion_facturacion'] }}</p>
                @endif
                <p>
                    @if(!empty($info_cliente['ciudad_facturacion'])){{ $info_cliente['ciudad_facturacion'] }}@endif @if(!empty($info_cliente['codigo_postal_facturacion'])) ({{ $info_cliente['codigo_postal_facturacion'] }})@endif
                </p>
                @if(!empty($info_cliente['pais_facturacion']))
                    <p>{{ $info_cliente['pais_facturacion'] }}</p>
                @endif
                <p><span class="label">Email:</span> {{ $info_cliente['email_facturacion'] ?? ($compra->user->email ?? 'N/D') }}</p>
                @if(!empty($info_cliente['telefono_facturacion']))
                    <p><span class="label">Tel:</span> {{ $info_cliente['telefono_facturacion'] }}</p>
                @endif
            </div>
            <div class="billing-column">
                <h3>Emitido por:</h3>
                <p><span class="strong">POWERCORE</span></p>
                <p>Av. de America 34</p>
                <p>Madrid, 28000</p>
                <p>España</p>
                <p><span class="label">NIF:</span> B12345678</p>
                <p><span class="label">Email:</span> info@powercore.es</p>
            </div>
        </section>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Descripción</th>
                    <th class="text-center">Cantidad</th>
                    <th class="text-right">Precio Unit.</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($compra->itemsAlmacen as $item)
                <tr>
                    <td class="item-description">
                        {{ $item->nombre }}
                        @if($item->sku) <br><small>(SKU: {{ $item->sku }})</small> @endif
                    </td>
                    <td class="text-center">{{ $item->pivot->cantidad }}</td>
                    <td class="text-right">{{ number_format($item->pivot->precio_unitario_compra, 2, ',', '.') }} €</td>
                    <td class="text-right">{{ number_format($item->pivot->subtotal, 2, ',', '.') }} €</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center; padding: 30px 0;">No hay artículos en esta compra.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="totals-summary">
            <table>
                <tr>
                    <td>Subtotal:</td>
                    <td>{{ number_format($compra->total_compra, 2, ',', '.') }} €</td>
                </tr>
                <tr>
                    <td>Impuestos :</td>
                    <td>0.00 €</td>
                </tr>
                @if(isset($coste_envio_variable) && $coste_envio_variable > 0)
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

        <section class="payment-notes-section">
            <h4>Detalles del Pago</h4>
            <p><span class="label">Método:</span>
                @if($compra->metodo_pago === 'simulado_tarjeta')
                    Tarjeta (Simulado)
                    @if(!empty($ultimos_digitos_tarjeta))
                        <span>- terminada en {{ $ultimos_digitos_tarjeta }}</span>
                    @endif
                @else
                    {{ ucfirst(str_replace('_', ' ', $compra->metodo_pago)) }}
                @endif
            </p>
            <p><span class="label">Estado:</span> {{ ucfirst($factura->estado_pago) }}</p>

            @if($factura->notas)
            <h4 style="margin-top: 15px;">Notas Adicionales</h4>
            <p>{{ $factura->notas }}</p>
            @endif
        </section>

        <footer class="invoice-footer">
            <p>Gracias por su compra. | POWERCORE © {{ date('Y') }}.</p>
        </footer>

    </div>
</body>
</html>