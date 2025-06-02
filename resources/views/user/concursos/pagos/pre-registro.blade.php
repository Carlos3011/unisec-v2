@extends('layouts.user')

@section('titulo', 'Pago de Pre-registro')

@section('contenido')
<div class="min-h-screen py-12 relative overflow-hidden">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto bg-white/60 rounded-2xl overflow-hidden shadow-xl relative">
            <!-- Header con logo y navegación -->
            <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                <a href="{{ route('user.concursos.convocatorias.show', $convocatoria) }}" class="text-white hover:text-gray-800 flex items-center gap-2 transition-colors">
                    <i class="fas fa-arrow-left"></i>
                    <span>Volver a la Convocatoria</span>
                </a>
                <img src="{{ asset('images/logo.png') }}" alt="UNISEC-MX" class="h-8">
            </div>

            <div class="p-8">
                <!-- Información del comerciante -->
                <div class="flex items-center mb-8 bg-gray-50 p-4 rounded-lg">
                    <div class="flex-shrink-0 mr-4">
                        <i class="fas fa-shield-check text-4xl text-blue-600"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">UNISEC-MX</h2>
                        <p class="text-gray-600">CHIHUAHUA, CHIH, MÉXICO</p>
                    </div>
                </div>

                <!-- Detalles del pago -->
                <div class="bg-white/60 border border-gray-200 rounded-xl p-6 mb-8 shadow-sm">
                    <h1 class="text-2xl font-bold text-gray-800 mb-6">Pago de Pre-registro</h1>
                    
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-gray-600">Concepto</span>
                            <span class="text-gray-800 font-medium">{{ $convocatoria->concurso->titulo }}</span>
                        </div>
                        <div class="flex justify-between items-center py-3">
                            <span class="text-gray-600">Total a pagar</span>
                            <span class="text-2xl font-bold text-blue-600">${{ number_format($convocatoria->costo_pre_registro, 2) }} MXN</span>
                        </div>
                    </div>

                    <!-- Opciones de pago -->
                    <div class="space-y-4">
                        <div id="paypal-button-container" class="w-full"></div>
                        
                        <div class="relative">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-200"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-2 bg-white/60 text-gray-500">o paga mediante</span>
                            </div>
                        </div>

                        <a href="{{ route('user.concursos.pagos-terceros.create') }}" 
                           class="w-full py-3 px-4 bg-white/60 border border-gray-300 text-gray-700 font-semibold rounded-lg text-center hover:bg-gray-50 transition-all duration-300 flex items-center justify-center gap-2 shadow-sm">
                            <i class="fas fa-university text-blue-600"></i>
                            <span>Transferencia Bancaria</span>
                        </a>
                    </div>
                </div>

                <!-- Información de seguridad y términos -->
                <div class="flex items-center justify-center gap-6 text-sm text-gray-500">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-lock text-green-500"></i>
                        <span>Pago Seguro</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-shield-alt text-blue-500"></i>
                        <span>Protección al Comprador</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
        </div>
    </div>
</div>

<script src="https://www.paypal.com/sdk/js?client-id={{ config('paypal.sandbox.client_id') }}&currency={{ config('paypal.currency') }}"></script>
<script>
    paypal.Buttons({
        createOrder: async function(data, actions) {
            try {
                const response = await fetch('{{ url("user/concursos/pagos/create-order") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        convocatoria_id: {{ $convocatoria->id }}
                    })
                });
                const orderData = await response.json();
                window.pagoId = orderData.id;
                
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: orderData.amount,
                            currency_code: '{{ config('paypal.currency') }}'
                        },
                        description: 'Pre-registro para {{ $convocatoria->concurso->titulo }}'
                    }]
                });
            } catch (error) {
                console.error('Error al crear la orden:', error);
                alert('Error al iniciar el proceso de pago. Por favor, inténtalo de nuevo.');
                throw error;
            }
        },
        onApprove: async function(data, actions) {
            try {
                const details = await actions.order.capture();
                const response = await fetch('{{ url("user/concursos/pagos/capture-order") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        pago_id: window.pagoId,
                        orderID: data.orderID,
                        paymentID: details.id,
                        details: details
                    })
                });

                const result = await response.json();
                if (result.success) {
                    window.location.href = '{{ route("user.concursos.pre-registros.create", "") }}/' + result.convocatoria_id;
                } else {
                    throw new Error(result.message || 'Error al procesar el pago');
                }
            } catch (error) {
                console.error('Error al capturar el pago:', error);
                alert('Error al procesar el pago. Por favor, contacta al soporte.');
            }
        },
        onError: function(err) {
            console.error('Error en el pago:', err);
            alert('Hubo un error al procesar el pago. Por favor, inténtalo de nuevo.');
        }
    }).render('#paypal-button-container');
</script>

@endsection