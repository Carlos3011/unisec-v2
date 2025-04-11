@extends('layouts.admin')

@section('titulo', 'Panel de Pagos y Facturacion')

@section('contenido')
    <div class="p-6 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-lg shadow-md overflow-hidden border-l-4 border-blue-500 hover:shadow-lg transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-blue-600 uppercase">Total Pagos</p>
                            <p class="mt-2 text-2xl font-bold text-gray-800">${{ number_format($pagos->sum('monto'), 2) }}</p>
                        </div>
                        <div class="bg-blue-100 rounded-full p-3">
                            <i class="fas fa-dollar-sign text-xl text-blue-500"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md overflow-hidden border-l-4 border-green-500 hover:shadow-lg transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-green-600 uppercase">Pagos Completados</p>
                            <p class="mt-2 text-2xl font-bold text-gray-800">{{ $pagos->where('estado', 'completado')->count() }}</p>
                        </div>
                        <div class="bg-green-100 rounded-full p-3">
                            <i class="fas fa-check-circle text-xl text-green-500"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md overflow-hidden border-l-4 border-yellow-500 hover:shadow-lg transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-yellow-600 uppercase">Pagos Pendientes</p>
                            <p class="mt-2 text-2xl font-bold text-gray-800">{{ $pagos->where('estado', 'pendiente')->count() }}</p>
                        </div>
                        <div class="bg-yellow-100 rounded-full p-3">
                            <i class="fas fa-clock text-xl text-yellow-500"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md overflow-hidden border-l-4 border-cyan-500 hover:shadow-lg transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-cyan-600 uppercase">Total Transacciones</p>
                            <p class="mt-2 text-2xl font-bold text-gray-800">{{ $pagos->count() }}</p>
                        </div>
                        <div class="bg-cyan-100 rounded-full p-3">
                            <i class="fas fa-list text-xl text-cyan-500"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden mt-6">
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4 flex justify-between items-center">
            <h3 class="text-white text-lg font-semibold flex items-center">
                <i class="fas fa-credit-card mr-2"></i>Transacciones PayPal
            </h3>
            <div class="flex space-x-3">
                <div class="relative">
                    <button class="bg-white text-gray-700 px-4 py-2 rounded-lg flex items-center hover:bg-gray-50 transition-colors duration-200" type="button" id="filterDropdown" data-bs-toggle="dropdown">
                        <i class="fas fa-filter mr-2"></i>Filtrar
                    </button>
                    <ul class="dropdown-menu mt-2 bg-white rounded-lg shadow-lg py-2">
                        <li><a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" href="?estado=todos">Todos</a></li>
                        <li><a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" href="?estado=completado">Completados</a></li>
                        <li><a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" href="?estado=pendiente">Pendientes</a></li>
                        <li><a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" href="?estado=aprobado">Aprobados</a></li>
                    </ul>
                </div>
                <button onclick="window.print()" class="bg-white text-gray-700 px-4 py-2 rounded-lg flex items-center hover:bg-gray-50 transition-colors duration-200">
                    <i class="fas fa-print mr-2"></i>Imprimir
                </button>
            </div>
        </div>
        
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuario</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PayPal ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Monto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($pagos as $pago)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pago->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pago->usuario->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $pago->paypal_id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">${{ number_format($pago->monto, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $pago->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ 
                                    $pago->estado == 'pendiente' ? 'bg-yellow-100 text-yellow-800' : 
                                    ($pago->estado == 'aprobado' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800')
                                }}">
                                    {{ ucfirst($pago->estado) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <button class="text-blue-600 hover:text-blue-900 transition-colors duration-200" data-bs-toggle="modal" data-bs-target="#detallePago{{ $pago->id }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="text-indigo-600 hover:text-indigo-900 transition-colors duration-200" onclick="actualizarEstado('{{ $pago->id }}')">
                                    <i class="fas fa-sync"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <div class="mt-6">
                    {{ $pagos->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
