@extends('layouts.admin')

@section('contenido')
<div class="container px-6 mx-auto grid min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Encabezado y Estado -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center my-8 gap-6">
        <div class="flex items-center bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 w-full md:w-auto">
            <div class="bg-purple-100 dark:bg-purple-800 p-4 rounded-xl mr-4">
                <i class="fas fa-receipt text-2xl text-purple-600 dark:text-purple-200"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Detalle del Pago</h2>
                <div class="flex items-center mt-1 space-x-2">
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">ID:</span>
                    <span class="text-sm font-bold text-purple-600 dark:text-purple-400">#{{ $datosPago['id'] }}</span>
                </div>
            </div>
        </div>
        <div class="flex flex-col sm:flex-row items-center gap-4 bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 w-full md:w-auto">
            <div class="flex items-center justify-center w-full sm:w-auto">
                <span class="px-4 py-2 text-sm font-semibold rounded-xl shadow-sm
                    @if($datosPago['estado_pago'] === 'pagado')
                        bg-green-50 text-green-700 border-2 border-green-200 dark:bg-green-900 dark:text-green-100
                    @elseif($datosPago['estado_pago'] === 'rechazado')
                        bg-red-50 text-red-700 border-2 border-red-200 dark:bg-red-900 dark:text-red-100
                    @else
                        bg-orange-50 text-orange-700 border-2 border-orange-200 dark:bg-orange-900 dark:text-orange-100
                    @endif w-full sm:w-auto text-center">
                    <i class="fas {{ $datosPago['estado_pago'] === 'pagado' ? 'fa-check-circle' : ($datosPago['estado_pago'] === 'rechazado' ? 'fa-times-circle' : 'fa-clock') }} mr-2"></i>
                    {{ ucfirst($datosPago['estado_pago']) }}
                </span>
            </div>
            @if($datosPago['estado_pago'] === 'pagado')
            <a href="{{ route('admin.congresos.pagos.factura', $datosPago['id']) }}" class="inline-flex items-center justify-center px-6 py-2 text-sm font-medium text-white bg-purple-600 rounded-xl hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all duration-150 shadow-sm w-full sm:w-auto">
                <i class="fas fa-file-invoice mr-2"></i>
                Generar Factura
            </a>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Información del Pago -->
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:shadow-lg">
            <div class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 px-6 py-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Detalles de la Transacción</h3>
            </div>
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Columna 1 -->
                    <div class="space-y-4">
                        <div class="flex items-center group hover:bg-gray-50 dark:hover:bg-gray-700 p-3 rounded-xl transition-all duration-300">
                            <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-purple-100 dark:bg-purple-800 transform transition-transform duration-300 group-hover:scale-110">
                                <i class="fas fa-dollar-sign text-xl text-purple-600 dark:text-purple-200"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Monto Total</p>
                                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">${{ number_format($datosPago['monto'], 2) }}</p>
                            </div>
                        </div>

                        <div class="flex items-center group hover:bg-gray-50 dark:hover:bg-gray-700 p-3 rounded-xl transition-all duration-300">
                            <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-purple-100 dark:bg-purple-800 transform transition-transform duration-300 group-hover:scale-110">
                                <i class="fas fa-credit-card text-xl text-purple-600 dark:text-purple-200"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Método de Pago</p>
                                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $datosPago['metodo_pago'] }}</p>
                            </div>
                        </div>

                        @if($datosPago['referencia_paypal'])
                        <div class="flex items-center group hover:bg-gray-50 dark:hover:bg-gray-700 p-3 rounded-xl transition-all duration-300">
                            <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-purple-100 dark:bg-purple-800 transform transition-transform duration-300 group-hover:scale-110">
                                <i class="fab fa-paypal text-xl text-purple-600 dark:text-purple-200"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Referencia PayPal</p>
                                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $datosPago['referencia_paypal'] }}</p>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Columna 2 -->
                    <div class="space-y-4">
                        <div class="flex items-center group hover:bg-gray-50 dark:hover:bg-gray-700 p-3 rounded-xl transition-all duration-300">
                            <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-purple-100 dark:bg-purple-800 transform transition-transform duration-300 group-hover:scale-110">
                                <i class="fas fa-calendar text-xl text-purple-600 dark:text-purple-200"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de Pago</p>
                                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $datosPago['fecha_pago'] }}</p>
                            </div>
                        </div>

                        <div class="flex items-center group hover:bg-gray-50 dark:hover:bg-gray-700 p-3 rounded-xl transition-all duration-300">
                            <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-purple-100 dark:bg-purple-800 transform transition-transform duration-300 group-hover:scale-110">
                                <i class="fas fa-university text-xl text-purple-600 dark:text-purple-200"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Congreso</p>
                                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $datosPago['congreso'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información del Usuario -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:shadow-lg">
            <div class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 px-6 py-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Información del Usuario</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-center group hover:bg-gray-50 dark:hover:bg-gray-700 p-3 rounded-xl transition-all duration-300">
                    <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-purple-100 dark:bg-purple-800 transform transition-transform duration-300 group-hover:scale-110">
                        <i class="fas fa-user-circle text-xl text-purple-600 dark:text-purple-200"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Nombre</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $datosPago['usuario'] }}</p>
                    </div>
                </div>

                <div class="flex items-center group hover:bg-gray-50 dark:hover:bg-gray-700 p-3 rounded-xl transition-all duration-300">
                    <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-purple-100 dark:bg-purple-800 transform transition-transform duration-300 group-hover:scale-110">
                        <i class="fas fa-envelope text-xl text-purple-600 dark:text-purple-200"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $datosPago['email'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($datosPago['articulo'])
    <!-- Información del Artículo -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:shadow-lg mb-8">
        <div class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 px-6 py-4">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Información del Artículo</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div class="flex items-center group hover:bg-gray-50 dark:hover:bg-gray-700 p-3 rounded-xl transition-all duration-300">
                        <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-purple-100 dark:bg-purple-800 transform transition-transform duration-300 group-hover:scale-110">
                            <i class="fas fa-file-alt text-xl text-purple-600 dark:text-purple-200"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Estado del Artículo</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ ucfirst($datosPago['articulo']['estado_articulo']) }}</p>
                        </div>
                    </div>

                    @if($datosPago['articulo']['comentarios_articulo'])
                    <div class="mt-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Comentarios del Artículo</p>
                        <p class="mt-2 text-gray-700 dark:text-gray-300">{{ $datosPago['articulo']['comentarios_articulo'] }}</p>
                    </div>
                    @endif
                </div>

                <div class="space-y-4">
                    <div class="flex items-center group hover:bg-gray-50 dark:hover:bg-gray-700 p-3 rounded-xl transition-all duration-300">
                        <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-purple-100 dark:bg-purple-800 transform transition-transform duration-300 group-hover:scale-110">
                            <i class="fas fa-file-pdf text-xl text-purple-600 dark:text-purple-200"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Estado del Extenso</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ ucfirst($datosPago['articulo']['estado_extenso']) }}</p>
                        </div>
                    </div>

                    @if($datosPago['articulo']['comentarios_extenso'])
                    <div class="mt-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Comentarios del Extenso</p>
                        <p class="mt-2 text-gray-700 dark:text-gray-300">{{ $datosPago['articulo']['comentarios_extenso'] }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection