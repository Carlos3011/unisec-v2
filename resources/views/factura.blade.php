<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura #{{ $datos['id'] }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --color-primary: #1e40af;
            --color-secondary: #2563eb;
            --color-accent: #60a5fa;
        }

        @media print {
            body { 
                -webkit-print-color-adjust: exact; 
                padding: 0 !important;
            }
            .no-print, .header img, .footer {
                display: none !important;
            }
            .container {
                box-shadow: none;
                padding: 20px !important;
            }
        }

        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 40px;
            color: #1a1a1a;
            background: linear-gradient(to bottom right, #f8fafc, #e2e8f0);
            line-height: 1.6;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            padding: 30px 0;
            background: linear-gradient(to right, var(--color-primary), var(--color-secondary));
            color: white;
            border-radius: 8px;
            position: relative;
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url("{{ asset('images/logo.png') }}") no-repeat 95% 50%/auto 60%;
            opacity: 0.1;
        }

        .header h1 {
            margin: 0;
            font-size: 2.8em;
            font-weight: 800;
            letter-spacing: -1px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header p {
            font-size: 1.1em;
            margin: 8px 0 0;
            opacity: 0.9;
        }

        .factura-info {
            margin-bottom: 40px;
            padding: 25px;
            background: #f8fafc;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .factura-info h2 {
            color: var(--color-primary);
            margin: 0 0 20px;
            font-size: 1.6em;
            font-weight: 700;
            position: relative;
            padding-bottom: 10px;
        }

        .factura-info h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: var(--color-accent);
        }

        .detalles-pago {
            margin-bottom: 40px;
        }

        .detalles-pago h2 {
            color: var(--color-primary);
            margin: 0 0 25px;
            font-size: 1.6em;
            font-weight: 700;
            padding-bottom: 12px;
            border-bottom: 2px solid var(--color-accent);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
            background: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        th {
            background: var(--color-primary);
            color: white;
            font-weight: 600;
            font-size: 0.95em;
            letter-spacing: 0.3px;
        }

        tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .total {
            text-align: right;
            font-size: 1.4em;
            margin: 35px 0;
            padding: 25px;
            background: var(--color-primary);
            border-radius: 8px;
            color: white;
        }

        .total strong {
            font-weight: 700;
            margin-left: 15px;
        }

        .footer {
            margin-top: 60px;
            text-align: center;
            font-size: 0.95em;
            color: #64748b;
            padding-top: 30px;
            border-top: 2px solid #e2e8f0;
        }

        .watermark {
            position: absolute;
            opacity: 0.05;
            font-size: 6em;
            font-weight: 800;
            color: var(--color-primary);
            transform: rotate(-30deg);
            pointer-events: none;
            z-index: -1;
            top: 30%;
            left: 10%;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="watermark">UNISEC</div>
            <h1 class="mb-2">FACTURA</h1>
            <p class="text-lg">#{{ $datos['id'] }}</p>
            <p class="text-sm opacity-80">{{ $datos['fecha_pago'] }}</p>
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
    </div>
</body>
</html>