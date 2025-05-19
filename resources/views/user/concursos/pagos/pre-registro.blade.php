@extends('layouts.user')

@section('titulo', 'Pago de Pre-registro')

@section('contenido')
<div class="min-h-screen py-12 relative overflow-hidden bg-gradient-to-b from-space-950 to-cosmic-900">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto bg-black/30 backdrop-blur-xl rounded-2xl overflow-hidden border border-white/10 relative transition-all duration-300 hover:border-white/20 hover:shadow-[0_0_30px_rgba(147,51,234,0.3)]">
            <div class="p-6">
                <a href="{{ route('user.concursos.convocatorias.show', $convocatoria) }}" class="text-white/90 hover:text-white flex items-center gap-2 bg-white/5 px-4 py-2 rounded-lg w-fit transition-all duration-300 hover:bg-white/10">
                    <i class="fas fa-arrow-left"></i>
                    <span>Volver a la Convocatoria</span>
                </a>
            </div>

            <div class="p-8">
                <h1 class="text-3xl font-bold text-white mb-6 text-center">Pago de Pre-registro</h1>
                
                <div class="bg-gradient-to-r from-blue-500/20 to-purple-500/20 rounded-xl p-6 border border-blue-400/30 mb-8">
                    <div class="text-center">
                        <p class="text-white/90 mb-4">Monto a pagar:</p>
                        <p class="text-4xl font-bold text-blue-400">${{ number_format($convocatoria->costo_pre_registro, 2) }} MXN</p>
                    </div>
                </div>

                <div class="flex flex-col gap-4 mb-6">
                    <div id="paypal-button-container"></div>
                    
                    <a href="{{ route('user.concursos.pagos-terceros.create') }}" 
                       class="w-full py-3 px-4 bg-gradient-to-r from-emerald-600 to-green-600 text-white font-semibold rounded-lg text-center hover:from-emerald-700 hover:to-green-700 transition-all duration-300 transform hover:scale-105 flex items-center justify-center gap-2">
                        <i class="fas fa-university"></i>
                        <span>Pagar por Transferencia Bancaria</span>
                    </a>
                </div>

                <div class="text-center text-white/60 text-sm">
                    <p>Al realizar el pago, aceptas nuestros términos y condiciones.</p>
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