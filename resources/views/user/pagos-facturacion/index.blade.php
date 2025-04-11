@extends('layouts.user')

@section('titulo', 'Pagos')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pagos.css') }}">
@endpush

@section('contenido')
    <div class="container mx-auto px-4 py-8">
        <div class="payment-container">
            <h1 class="text-3xl font-bold text-white mb-6 text-center">Panel de Pagos</h1>
            
            <div class="payment-amount">
                ${{ number_format($pagosPendientes, 2) }} USD
            </div>
            
            <p class="payment-description">
                Para completar tu pago, por favor utiliza el botón de PayPal a continuación.
                Podrás pagar con tu cuenta de PayPal o con tarjeta de crédito/débito.
            </p>

            <div class="payment-button-container">
                <div id="paypal-button-container"></div>
                <div id="card-form-container" style="display: none;">
                    <form id="card-form">
                        <div id="card-number" class="card-field"></div>
                        <div id="card-expiry" class="card-field"></div>
                        <div id="card-cvv" class="card-field"></div>
                        <button type="submit" class="pay-button">Pagar con Tarjeta</button>
                    </form>
                </div>
            </div>

            @if(session('status'))
                <div class="payment-status {{ session('status') == 'pending' ? 'status-pending' : (session('status') == 'completed' ? 'status-completed' : 'status-cancelled') }}">
                    {{ session('message') }}
                </div>
            @endif
        </div>
    </div>

    <!-- Scripts de PayPal -->
    <script src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_SANDBOX_CLIENT_ID') }}&currency={{ env('PAYPAL_CURRENCY', 'USD') }}&components=buttons,hosted-fields"></script>
    <style>
        .card-field {
            height: 40px;
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background: white;
        }
        .pay-button {
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            background-color: #0070ba;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .pay-button:hover {
            background-color: #005ea6;
        }
    </style>
    <script>
        let currentPaymentId = null;
        let cardFields;

        // Inicializar campos de tarjeta
        paypal.HostedFields.render({
            createOrder: function() {
                return fetch('/payment/create-order', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        amount: {{ $pagosPendientes }}
                    })
                })
                .then(res => res.json())
                .then(data => {
                    currentPaymentId = data.id;
                    return data.id;
                });
            },
            styles: {
                'input': {
                    'font-size': '16px',
                    'font-family': 'Arial',
                    'color': '#3a3a3a'
                },
                'input.invalid': {
                    'color': 'red'
                },
                'input.valid': {
                    'color': 'green'
                }
            },
            fields: {
                number: {
                    selector: '#card-number',
                    placeholder: 'Número de tarjeta'
                },
                cvv: {
                    selector: '#card-cvv',
                    placeholder: 'CVV'
                },
                expirationDate: {
                    selector: '#card-expiry',
                    placeholder: 'MM/YY'
                }
            }
        }).then(function(hostedFields) {
            cardFields = hostedFields;
            document.getElementById('card-form-container').style.display = 'block';

            document.querySelector('#card-form').addEventListener('submit', function(event) {
                event.preventDefault();
                hostedFields.submit().then(function(payload) {
                    return fetch('/payment/capture-order', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            orderID: payload.orderId,
                            paypalTransactionId: payload.orderId,
                            pagoId: currentPaymentId
                        })
                    });
                }).then(function(res) {
                    return res.json();
                }).then(function(data) {
                    if (data.status === 'success') {
                        window.location.reload();
                    }
                }).catch(function(err) {
                    alert('Error al procesar el pago: ' + err.message);
                });
            });
        });

        // Configuración de PayPal Buttons
paypal.Buttons({
            createOrder: function(data, actions) {
                // Primero crear el registro de pago en nuestra base de datos
                return fetch('/payment/create-order', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        amount: {{ $pagosPendientes }}
                    })
                })
                .then(response => response.json())
                .then(data => {
                    currentPaymentId = data.id;
                    return actions.order.create({
                        intent: 'CAPTURE',
                        application_context: {
                            shipping_preference: 'NO_SHIPPING',
                            user_action: 'PAY_NOW'
                        },
                        purchase_units: [{
                            amount: {
                                value: data.amount
                            }
                        }]
                    });
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    // Actualizar el estado del pago en nuestra base de datos
                    return fetch('/payment/capture-order', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            orderID: data.orderID,
                            paypalTransactionId: details.id,
                            pagoId: currentPaymentId
                        })
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (result.status === 'success') {
                            window.location.reload();
                        } else {
                            alert('Hubo un error al procesar el pago. Por favor, contacte al soporte.');
                        }
                    });
                });
            },
            onCancel: function(data) {
                if (currentPaymentId) {
                    fetch('/payment/cancel-order', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            pagoId: currentPaymentId
                        })
                    });
                }
            },
            onError: function(err) {
                alert('Ocurrió un error durante el proceso de pago. Por favor, intente nuevamente.');
                console.error('PayPal Error:', err);
            }
        }).render('#paypal-button-container');
    </script>
@endsection