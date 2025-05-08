@extends('layouts.admin')

@section('contenido')
<div class="container px-6 mx-auto grid">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center my-6 gap-4">
        <div class="flex items-center">
            <div class="bg-purple-100 dark:bg-purple-800 p-3 rounded-lg mr-4">
                <i class="fas fa-receipt text-2xl text-purple-600 dark:text-purple-200"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Detalle del Pago</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">ID: #{{ $datosPago['id'] }}</p>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <span class="px-4 py-2 text-sm font-semibold rounded-lg shadow-sm {{ $datosPago['estado_pago'] === 'pagado' ? 'bg-green-50 text-green-700 border-2 border-green-200 dark:bg-green-900 dark:text-green-100' : 'bg-orange-50 text-orange-700 border-2 border-orange-200 dark:bg-orange-900 dark:text-orange-100' }}">
                <i class="fas {{ $datosPago['estado_pago'] === 'pagado' ? 'fa-check-circle' : 'fa-clock' }} mr-1"></i>
                {{ ucfirst($datosPago['estado_pago']) }}
            </span>
            @if($datosPago['estado_pago'] === 'pagado')
            <a href="{{ route('admin.pagos.factura', $datosPago['id']) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-purple-600 rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors duration-150 shadow-sm">
                <i class="fas fa-file-invoice mr-2"></i>
                Generar Factura
            </a>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Información del Pago -->
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 px-6 py-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Detalles de la Transacción</h3>
            </div>
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-purple-100 dark:bg-purple-800">
                                <i class="fas fa-dollar-sign text-purple-600 dark:text-purple-200"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Monto Total</p>
                                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">${{ number_format($datosPago['monto'], 2) }}</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-purple-100 dark:bg-purple-800">
                                <i class="fas fa-credit-card text-purple-600 dark:text-purple-200"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Método de Pago</p>
                                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $datosPago['metodo_pago'] }}</p>
                            </div>
                        </div>
                        @if($datosPago['payee']['merchant_id'])
                        <div class="flex items-center">
                            <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-purple-100 dark:bg-purple-800">
                                <i class="fas fa-id-card text-purple-600 dark:text-purple-200"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">ID del Comerciante</p>
                                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $datosPago['payee']['merchant_id'] }}</p>
                            </div>
                        </div>
                        @endif
                        @if($datosPago['description'])
                        <div class="flex items-center">
                            <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-purple-100 dark:bg-purple-800">
                                <i class="fas fa-file-alt text-purple-600 dark:text-purple-200"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Descripción</p>
                                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $datosPago['description'] }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-purple-100 dark:bg-purple-800">
                                <i class="fas fa-calendar text-purple-600 dark:text-purple-200"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de Pago</p>
                                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $datosPago['fecha_pago'] }}</p>
                            </div>
                        </div>
                        @if($datosPago['referencia_paypal'])
                        <div class="flex items-center">
                            <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-purple-100 dark:bg-purple-800">
                                <i class="fas fa-fingerprint text-purple-600 dark:text-purple-200"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Referencia PayPal</p>
                                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $datosPago['referencia_paypal'] }}</p>
                            </div>
                        </div>
                        @endif
                        @if($datosPago['payee']['email_address'])
                        <div class="flex items-center">
                            <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-purple-100 dark:bg-purple-800">
                                <i class="fas fa-envelope text-purple-600 dark:text-purple-200"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Email del Comerciante</p>
                                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $datosPago['payee']['email_address'] }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Información de Envío -->
                @if($datosPago['shipping']['name'] || isset($datosPago['shipping']['address']))
                <div class="mt-8">
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Información de Envío</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @if($datosPago['shipping']['name'])
                        <div class="flex items-center">
                            <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-purple-100 dark:bg-purple-800">
                                <i class="fas fa-user text-purple-600 dark:text-purple-200"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Nombre del Pagador</p>
                                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $datosPago['shipping']['name'] }}</p>
                            </div>
                        </div>
                        @endif
                        @if(isset($datosPago['shipping']['address']))
                        <div class="flex items-center">
                            <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-purple-100 dark:bg-purple-800">
                                <i class="fas fa-map-marker-alt text-purple-600 dark:text-purple-200"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Dirección de Envío</p>
                                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $datosPago['shipping']['address']['address_line_1'] }}
                                    @if($datosPago['shipping']['address']['address_line_2'])
                                    <br>{{ $datosPago['shipping']['address']['address_line_2'] }}
                                    @endif
                                    <br>{{ $datosPago['shipping']['address']['admin_area_2'] }}, {{ $datosPago['shipping']['address']['admin_area_1'] }}
                                    <br>{{ $datosPago['shipping']['address']['postal_code'] }}, {{ $datosPago['shipping']['address']['country_code'] }}
                                </p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Información Adicional -->
                @if($datosPago['soft_descriptor'])
                <div class="mt-8">
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Información Adicional</h4>
                    <div class="flex items-center">
                        <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-purple-100 dark:bg-purple-800">
                            <i class="fas fa-info-circle text-purple-600 dark:text-purple-200"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Descriptor</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $datosPago['soft_descriptor'] }}</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Información del Usuario y Convocatoria -->
        <div class="space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden border border-gray-200 dark:border-gray-700">
                <div class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 px-6 py-4">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Información del Usuario</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center">
                        <div class="w-10 h-10 flex items-center justify-center rounded-full bg-purple-100 dark:bg-purple-800">
                            <i class="fas fa-user-circle text-xl text-purple-600 dark:text-purple-200"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Nombre</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $datosPago['usuario'] }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="w-10 h-10 flex items-center justify-center rounded-full bg-purple-100 dark:bg-purple-800">
                            <i class="fa-solid fa-envelope text-xl text-purple-600 dark:text-purple-200"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Nombre</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{  $datosPago['payee']['email_address']}}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden border border-gray-200 dark:border-gray-700">
                <div class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 px-6 py-4">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Información de la Convocatoria</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center">
                        <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-purple-100 dark:bg-purple-800">
                            <i class="fas fa-file-alt text-purple-600 dark:text-purple-200"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Título</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $datosPago['concurso'] }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-purple-100 dark:bg-purple-800">
                            <i class="fas fa-calendar-check text-purple-600 dark:text-purple-200"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de Pre-registro</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $datosPago['fecha_pago'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Botón de Regreso -->
    <div class="flex justify-start">
        <a href="{{ route('admin.pagos.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors duration-150 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-600">
            <i class="fas fa-arrow-left mr-2"></i>
            Volver a la lista
        </a>
    </div>
</div>
@endsection