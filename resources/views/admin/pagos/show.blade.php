@extends('layouts.admin')

@section('contenido')
<div class="container px-6 mx-auto min-h-screen bg-gradient-to-br from-gray-50 via-purple-50 to-indigo-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
    <!-- Encabezado Principal con Animación -->
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center my-8 gap-6">
        <div class="flex items-center bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm p-6 rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 w-full lg:w-auto transform hover:scale-[1.02] transition-all duration-300 hover:shadow-xl">
            <div class="bg-gradient-to-br from-purple-500 to-indigo-600 p-4 rounded-2xl mr-5 shadow-lg">
                <i class="fas fa-receipt text-2xl text-white drop-shadow-sm"></i>
            </div>
            <div>
                <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 dark:from-gray-100 dark:to-gray-300 bg-clip-text text-transparent">
                    Detalle del Pago
                </h1>
                <div class="flex items-center mt-2 space-x-3">
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">ID:</span>
                    <span class="text-sm font-bold bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent">
                        #{{ $datosPago['id'] }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Estado y Acciones -->
        <div class="flex flex-col sm:flex-row items-center gap-4 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm p-6 rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 w-full lg:w-auto">
            <div class="relative">
                <span class="px-6 py-3 text-sm font-semibold rounded-2xl shadow-lg transform hover:scale-105 transition-all duration-300 {{ $datosPago['estado_pago'] === 'pagado' ? 'bg-gradient-to-r from-green-500 to-emerald-600 text-white shadow-green-200 dark:shadow-green-900' : 'bg-gradient-to-r from-orange-500 to-amber-600 text-white shadow-orange-200 dark:shadow-orange-900' }} flex items-center space-x-2">
                    <i class="fas {{ $datosPago['estado_pago'] === 'pagado' ? 'fa-check-circle' : 'fa-clock' }}"></i>
                    <span>{{ ucfirst($datosPago['estado_pago']) }}</span>
                </span>
                @if($datosPago['estado_pago'] === 'pagado')
                <div class="absolute -top-1 -right-1 w-4 h-4 bg-green-400 rounded-full animate-pulse"></div>
                @endif
            </div>
            
            @if($datosPago['estado_pago'] === 'pagado')
            <a href="{{ route('admin.pagos.factura', $datosPago['id']) }}" class="inline-flex items-center justify-center px-6 py-2 text-sm font-medium text-white bg-purple-600 rounded-xl hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all duration-150 shadow-sm w-full sm:w-auto">
                <i class="fas fa-file-invoice mr-2"></i>
                Generar Factura
            </a>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 mb-8">
        <!-- Panel Principal de Transacción -->
        <div class="xl:col-span-2 bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-3xl shadow-xl overflow-hidden border border-gray-200/50 dark:border-gray-700/50 transform hover:shadow-2xl transition-all duration-500">
            <div class="border-b border-gray-200/50 dark:border-gray-700/50 bg-gradient-to-r from-purple-500/10 to-indigo-500/10 dark:from-purple-800/20 dark:to-indigo-800/20 px-8 py-6">
                <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 flex items-center">
                    <div class="w-2 h-8 bg-gradient-to-b from-purple-500 to-indigo-600 rounded-full mr-4"></div>
                    Detalles de la Transacción
                </h3>
            </div>
            
            <div class="p-8 space-y-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="space-y-6">
                        <!-- Monto Total -->
                        <div class="group flex items-center p-4 rounded-2xl hover:bg-purple-50/50 dark:hover:bg-purple-900/20 transition-all duration-300 cursor-pointer">
                            <div class="w-14 h-14 flex items-center justify-center rounded-2xl bg-gradient-to-br from-green-400 to-emerald-500 shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-dollar-sign text-white text-lg"></i>
                            </div>
                            <div class="ml-5">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Monto Total</p>
                                <p class="text-2xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">
                                    ${{ number_format($datosPago['monto'], 2) }}
                                </p>
                            </div>
                        </div>

                        <!-- Método de Pago -->
                        <div class="group flex items-center p-4 rounded-2xl hover:bg-blue-50/50 dark:hover:bg-blue-900/20 transition-all duration-300 cursor-pointer">
                            <div class="w-14 h-14 flex items-center justify-center rounded-2xl bg-gradient-to-br from-blue-400 to-cyan-500 shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-credit-card text-white text-lg"></i>
                            </div>
                            <div class="ml-5">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Método de Pago</p>
                                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $datosPago['metodo_pago'] }}</p>
                            </div>
                        </div>

                        @if($datosPago['payee']['merchant_id'])
                        <!-- ID del Comerciante -->
                        <div class="group flex items-center p-4 rounded-2xl hover:bg-indigo-50/50 dark:hover:bg-indigo-900/20 transition-all duration-300 cursor-pointer">
                            <div class="w-14 h-14 flex items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-400 to-purple-500 shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-id-card text-white text-lg"></i>
                            </div>
                            <div class="ml-5">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">ID del Comerciante</p>
                                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100 font-mono bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded-lg">
                                    {{ $datosPago['payee']['merchant_id'] }}
                                </p>
                            </div>
                        </div>
                        @endif

                        @if($datosPago['description'])
                        <!-- Descripción -->
                        <div class="group flex items-center p-4 rounded-2xl hover:bg-amber-50/50 dark:hover:bg-amber-900/20 transition-all duration-300 cursor-pointer">
                            <div class="w-14 h-14 flex items-center justify-center rounded-2xl bg-gradient-to-br from-amber-400 to-orange-500 shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-file-alt text-white text-lg"></i>
                            </div>
                            <div class="ml-5">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Descripción</p>
                                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $datosPago['description'] }}</p>
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="space-y-6">
                        <!-- Fecha de Pago -->
                        <div class="group flex items-center p-4 rounded-2xl hover:bg-pink-50/50 dark:hover:bg-pink-900/20 transition-all duration-300 cursor-pointer">
                            <div class="w-14 h-14 flex items-center justify-center rounded-2xl bg-gradient-to-br from-pink-400 to-rose-500 shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-calendar text-white text-lg"></i>
                            </div>
                            <div class="ml-5">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Fecha de Pago</p>
                                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $datosPago['fecha_pago'] }}</p>
                            </div>
                        </div>

                        @if($datosPago['referencia_paypal'])
                        <!-- Referencia PayPal -->
                        <div class="group flex items-center p-4 rounded-2xl hover:bg-violet-50/50 dark:hover:bg-violet-900/20 transition-all duration-300 cursor-pointer">
                            <div class="w-14 h-14 flex items-center justify-center rounded-2xl bg-gradient-to-br from-violet-400 to-purple-500 shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-fingerprint text-white text-lg"></i>
                            </div>
                            <div class="ml-5">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Referencia PayPal</p>
                                <p class="text-sm font-mono bg-gray-100 dark:bg-gray-700 px-3 py-2 rounded-lg text-gray-900 dark:text-gray-100 break-all">
                                    {{ $datosPago['referencia_paypal'] }}
                                </p>
                            </div>
                        </div>
                        @endif

                        @if($datosPago['payee']['email_address'])
                        <!-- Email del Comerciante -->
                        <div class="group flex items-center p-4 rounded-2xl hover:bg-teal-50/50 dark:hover:bg-teal-900/20 transition-all duration-300 cursor-pointer">
                            <div class="w-14 h-14 flex items-center justify-center rounded-2xl bg-gradient-to-br from-teal-400 to-cyan-500 shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-envelope text-white text-lg"></i>
                            </div>
                            <div class="ml-5">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Email del Comerciante</p>
                                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100 break-all">{{ $datosPago['payee']['email_address'] }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Información de Envío -->
                @if($datosPago['shipping']['name'] || isset($datosPago['shipping']['address']))
                <div class="mt-10 p-6 bg-gradient-to-r from-blue-50/50 to-indigo-50/50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-2xl border border-blue-200/30 dark:border-blue-700/30">
                    <h4 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-6 flex items-center">
                        <i class="fas fa-shipping-fast text-blue-600 mr-3"></i>
                        Información del Pagador
                    </h4>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        @if($datosPago['shipping']['name'])
                        <div class="flex items-center p-4 bg-white/50 dark:bg-gray-800/50 rounded-2xl">
                            <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-gradient-to-br from-blue-400 to-indigo-500 shadow-md">
                                <i class="fas fa-user text-white"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Nombre del Pagador</p>
                                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $datosPago['shipping']['name'] }}</p>
                            </div>
                        </div>
                        @endif

                        @if(isset($datosPago['shipping']['address']))
                        <div class="flex items-start p-4 bg-white/50 dark:bg-gray-800/50 rounded-2xl">
                            <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-gradient-to-br from-green-400 to-emerald-500 shadow-md mt-1">
                                <i class="fas fa-map-marker-alt text-white"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Dirección de Envío</p>
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100 leading-relaxed">
                                    <div>{{ $datosPago['shipping']['address']['address_line_1'] }}</div>
                                    @if($datosPago['shipping']['address']['address_line_2'])
                                    <div>{{ $datosPago['shipping']['address']['address_line_2'] }}</div>
                                    @endif
                                    <div>{{ $datosPago['shipping']['address']['admin_area_2'] }}, {{ $datosPago['shipping']['address']['admin_area_1'] }}</div>
                                    <div>{{ $datosPago['shipping']['address']['postal_code'] }}, {{ $datosPago['shipping']['address']['country_code'] }}</div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Información Adicional -->
                @if($datosPago['soft_descriptor'])
                <div class="mt-8 p-6 bg-gradient-to-r from-amber-50/50 to-orange-50/50 dark:from-amber-900/20 dark:to-orange-900/20 rounded-2xl border border-amber-200/30 dark:border-amber-700/30">
                    <h4 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4 flex items-center">
                        <i class="fas fa-info-circle text-amber-600 mr-3"></i>
                        Información Adicional
                    </h4>
                    <div class="flex items-center p-4 bg-white/50 dark:bg-gray-800/50 rounded-2xl">
                        <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 shadow-md">
                            <i class="fas fa-tag text-white"></i>
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

        <!-- Sidebar - Información del Usuario y Convocatoria -->
        <div class="space-y-8">
            <!-- Información del Usuario -->
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-3xl shadow-xl overflow-hidden border border-gray-200/50 dark:border-gray-700/50 transform hover:shadow-2xl transition-all duration-500 group">
                <div class="border-b border-gray-200/50 dark:border-gray-700/50 bg-gradient-to-r from-emerald-500/10 to-teal-500/10 dark:from-emerald-800/20 dark:to-teal-800/20 px-6 py-5">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 flex items-center">
                        <div class="w-2 h-6 bg-gradient-to-b from-emerald-500 to-teal-600 rounded-full mr-3"></div>
                        Usuario
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="group flex items-center p-4 rounded-2xl hover:bg-emerald-50/50 dark:hover:bg-emerald-900/20 transition-all duration-300 cursor-pointer">
                        <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-gradient-to-br from-emerald-400 to-teal-500 shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-user-circle text-white"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Nombre</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $datosPago['usuario'] }}</p>
                        </div>
                    </div>
                    <div class="group flex items-center p-4 rounded-2xl hover:bg-blue-50/50 dark:hover:bg-blue-900/20 transition-all duration-300 cursor-pointer">
                        <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-gradient-to-br from-blue-400 to-indigo-500 shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-envelope text-white"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Email</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-gray-100 break-all">{{ $datosPago['email'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información de la Convocatoria -->
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-3xl shadow-xl overflow-hidden border border-gray-200/50 dark:border-gray-700/50 transform hover:shadow-2xl transition-all duration-500">
                <div class="border-b border-gray-200/50 dark:border-gray-700/50 bg-gradient-to-r from-purple-500/10 to-indigo-500/10 dark:from-purple-800/20 dark:to-indigo-800/20 px-6 py-5">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 flex items-center">
                        <div class="w-2 h-6 bg-gradient-to-b from-purple-500 to-indigo-600 rounded-full mr-3"></div>
                        Convocatoria
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="group flex items-center p-4 rounded-2xl hover:bg-purple-50/50 dark:hover:bg-purple-900/20 transition-all duration-300 cursor-pointer">
                        <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-gradient-to-br from-purple-400 to-indigo-500 shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-file-alt text-white"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Título</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-gray-100 leading-tight">{{ $datosPago['concurso'] }}</p>
                        </div>
                    </div>
                    <div class="group flex items-center p-4 rounded-2xl hover:bg-indigo-50/50 dark:hover:bg-indigo-900/20 transition-all duration-300 cursor-pointer">
                        <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-gradient-to-br from-indigo-400 to-purple-500 shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-calendar-check text-white"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Fecha de Pre-registro</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $datosPago['fecha_pago'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Botón de Regreso Mejorado -->
    <div class="flex justify-start mt-8 mb-8">
        <a href="{{ route('admin.pagos.index') }}" class="group relative inline-flex items-center px-8 py-4 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm border-2 border-gray-300/50 dark:border-gray-600/50 rounded-2xl hover:bg-white dark:hover:bg-gray-700 hover:border-purple-500 hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-purple-500/50 transition-all duration-300 transform hover:scale-105 active:scale-95 shadow-lg">
            <div class="absolute inset-0 bg-gradient-to-r from-purple-600/10 to-indigo-600/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <i class="fas fa-arrow-left mr-3 transform transition-transform duration-300 group-hover:-translate-x-1 relative z-10"></i>
            <span class="relative z-10">Volver a la lista</span>
        </a>
    </div>
</div>
@endsection