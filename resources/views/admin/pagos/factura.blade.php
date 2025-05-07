<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura - {{ config('app.name') }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #ddd;
            padding: 30px;
            border-radius: 8px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #6B46C1;
            padding-bottom: 20px;
        }
        .logo {
            max-width: 200px;
            margin-bottom: 15px;
        }
        .factura-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .factura-info div {
            flex: 1;
        }
        .detalles {
            margin: 30px 0;
            border: 1px solid #eee;
            padding: 20px;
            border-radius: 4px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f8f9fa;
            font-weight: 600;
        }
        .total {
            text-align: right;
            font-size: 1.2em;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid #6B46C1;
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
    <div class="container">
        <div class="header">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">
            <h1>FACTURA</h1>
        </div>

        <div class="factura-info">
            <div>
                <h3>Datos del Cliente</h3>
                <p><strong>Nombre:</strong> {{ $pago->preRegistro->user->name }}</p>
                <p><strong>Email:</strong> {{ $pago->preRegistro->user->email }}</p>
            </div>
            <div style="text-align: right;">
                <p><strong>Factura No:</strong> {{ str_pad($pago->id, 6, '0', STR_PAD_LEFT) }}</p>
                <p><strong>Fecha:</strong> {{ $pago->created_at->format('d/m/Y') }}</p>
                <p><strong>Estado:</strong> {{ ucfirst($pago->estado) }}</p>
            </div>
        </div>

        <div class="detalles">
            <h3>Detalles del Pago</h3>
            <table>
                <thead>
                    <tr>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Pre-registro: {{ $pago->preRegistro->convocatoria->titulo }}</td>
                        <td>1</td>
                        <td>${{ number_format($pago->monto, 2) }}</td>
                        <td>${{ number_format($pago->monto, 2) }}</td>
                    </tr>
                </tbody>
            </table>

            <div class="total">
                <p><strong>Total Pagado:</strong> ${{ number_format($pago->monto, 2) }}</p>
            </div>
        </div>

        <div class="footer">
            <p><strong>Método de Pago:</strong> {{ $pago->metodo_pago }}</p>
            <p><strong>Referencia de Transacción:</strong> {{ $pago->referencia_transaccion }}</p>
            <p>Esta factura fue generada automáticamente por el sistema.</p>
            <p>{{ config('app.name') }} - {{ date('Y') }}</p>
        </div>
    </div>
</body>
</html>