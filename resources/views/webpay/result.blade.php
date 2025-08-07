@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-6 text-center">
        <div class="text-blue-500 mb-4">
            <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Resultado del Pago</h2>
        <p class="text-gray-600 mb-6">Tu transacción ha sido procesada por WebPay.</p>
        <div class="space-y-3">
            <a href="{{ route('user.inicio') }}" class="inline-block bg-blue-500 text-white font-semibold px-6 py-2 rounded hover:bg-blue-600 transition-colors">
                Volver al Inicio
            </a>
            <p class="text-sm text-gray-500">Revisa tu correo electrónico para más detalles de la transacción.</p>
        </div>
    </div>
</div>
@endsection