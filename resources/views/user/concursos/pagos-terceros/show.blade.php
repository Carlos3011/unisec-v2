@extends('layouts.user')

@section('contenido')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('user.concursos.pagos-terceros.index') }}" class="text-blue-500 hover:text-blue-600">
            <i class="fas fa-arrow-left mr-2"></i>Volver a la lista
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-2xl font-bold text-gray-800">Detalles del Pago</h2>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-semibold mb-4">Información del Concurso</h3>
                    <div class="space-y-3">
                        <p><span class="font-medium">Concurso:</span> {{ $pago->concurso->nombre }}</p>
                        <p><span class="font-medium">Estado del pago:</span>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($pago->estado_pago == 'validado')
                                    bg-green-100 text-green-800
                                @elseif($pago->estado_pago == 'rechazado')
                                    bg-red-100 text-red-800
                                @else
                                    bg-yellow-100 text-yellow-800
                                @endif">
                                {{ ucfirst($pago->estado_pago) }}
                            </span>
                        </p>
                        <p><span class="font-medium">Fecha de registro:</span> {{ $pago->created_at->format('d/m/Y H:i') }}</p>
                        <p><span class="font-medium">Monto total:</span> ${{ number_format($pago->monto_total, 2) }}</p>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-4">Información del Tercero</h3>
                    <div class="space-y-3">
                        <p><span class="font-medium">Tipo:</span> {{ ucfirst(str_replace('_', ' ', $pago->tipo_tercero)) }}</p>
                        <p><span class="font-medium">Nombre:</span> {{ $pago->nombre_tercero }}</p>
                        <p><span class="font-medium">RFC:</span> {{ $pago->rfc_tercero }}</p>
                        <p><span class="font-medium">Contacto:</span> {{ $pago->contacto_tercero }}</p>
                        <p><span class="font-medium">Correo:</span> {{ $pago->correo_tercero }}</p>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <h3 class="text-lg font-semibold mb-4">Detalles de Cobertura</h3>
                    <div class="space-y-3">
                        <p><span class="font-medium">Cubre pre-registro:</span> 
                            <span class="{{ $pago->cubre_pre_registro ? 'text-green-600' : 'text-red-600' }}">
                                {{ $pago->cubre_pre_registro ? 'Sí' : 'No' }}
                            </span>
                        </p>
                        <p><span class="font-medium">Cubre inscripción:</span>
                            <span class="{{ $pago->cubre_inscripcion ? 'text-green-600' : 'text-red-600' }}">
                                {{ $pago->cubre_inscripcion ? 'Sí' : 'No' }}
                            </span>
                        </p>
                        <p><span class="font-medium">Número de pagos:</span> {{ $pago->numero_pagos }}</p>
                        <p><span class="font-medium">Código de validación:</span> {{ $pago->codigo_validacion_unico }}</p>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <h3 class="text-lg font-semibold mb-4">Comprobante de Pago</h3>
                    <div class="border rounded-lg p-4">
                        @if($pago->comprobante_pago)
                            <a href="{{ Storage::url($pago->comprobante_pago) }}" target="_blank" class="text-blue-500 hover:text-blue-600">
                                <i class="fas fa-download mr-2"></i>Ver comprobante
                            </a>
                        @else
                            <p class="text-gray-500">No hay comprobante disponible</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection