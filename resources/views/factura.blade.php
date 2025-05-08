<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura #{{ $datos['id'] }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #2c3e50;
            margin: 0;
            padding: 10px 0;
        }
        .factura-info {
            margin-bottom: 20px;
        }
        .factura-info p {
            margin: 5px 0;
        }
        .detalles-pago {
            margin-bottom: 20px;
        }
        .detalles-pago h2 {
            color: #2c3e50;
            border-bottom: 2px solid #eee;
            padding-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f8f9fa;
        }
        .total {
            text-align: right;
            font-size: 1.2em;
            margin-top: 20px;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 0.9em;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>FACTURA</h1>
        <p>Factura #{{ $datos['id'] }}</p>
        <p>Fecha: {{ $datos['fecha_pago'] }}</p>
    </div>

    <div class="factura-info">
        <h2>Información del Cliente</h2>
        <p><strong>Nombre:</strong> {{ $datos['usuario'] }}</p>
        <p><strong>Email:</strong> {{ $datos['email'] }}</p>
        @if(isset($datos['shipping']['address']))
        <p><strong>Dirección:</strong><br>
            {{ $datos['shipping']['address']['address_line_1'] ?? '' }}<br>
            {{ $datos['shipping']['address']['address_line_2'] ?? '' }}<br>
            {{ $datos['shipping']['address']['admin_area_2'] ?? '' }}, 
            {{ $datos['shipping']['address']['admin_area_1'] ?? '' }}<br>
            {{ $datos['shipping']['address']['postal_code'] ?? '' }}
            {{ $datos['shipping']['address']['country_code'] ?? '' }}
        </p>
        @endif
    </div>

    <div class="detalles-pago">
        <h2>Detalles del Pago</h2>
        <table>
            <tr>
                <th>Descripción</th>
                <th>Referencia</th>
                <th>Estado</th>
                <th>Monto</th>
            </tr>
            <tr>
                <td>{{ $datos['concurso'] }}</td>
                <td>{{ $datos['referencia_paypal'] }}</td>
                <td>{{ ucfirst($datos['estado_pago']) }}</td>
                <td>${{ number_format($datos['monto'], 2) }}</td>
            </tr>
        </table>

        <div class="total">
            <p><strong>Total Pagado:</strong> ${{ number_format($datos['monto'], 2) }}</p>
        </div>
    </div>

    <div class="detalles-pago">
        <h2>Información de la Transacción</h2>
        <p><strong>Método de Pago:</strong> {{ ucfirst($datos['metodo_pago']) }}</p>
        <p><strong>ID de Orden PayPal:</strong> {{ $datos['paypal_order_id'] }}</p>
        <p><strong>Estado PayPal:</strong> {{ $datos['paypal_status'] }}</p>
        <p><strong>Fecha de Creación:</strong> {{ $datos['create_time'] }}</p>
        @if(isset($datos['payment_capture']))
        <p><strong>ID de Captura:</strong> {{ $datos['payment_capture']['id'] }}</p>
        <p><strong>Estado de Captura:</strong> {{ $datos['payment_capture']['status'] }}</p>
        @endif
    </div>

    <div class="footer">
        <p>Esta factura fue generada automáticamente y es válida sin firma ni sello.</p>
        <p>Para cualquier consulta, por favor conserve este documento.</p>
    </div>
</body>
</html>