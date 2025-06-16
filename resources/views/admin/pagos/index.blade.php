@extends('layouts.admin')

@section('contenido')
<div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Gestión de Pagos Concursos
    </h2>

    <!-- Filtros -->
    <div class="mb-6 p-4 bg-white dark:bg-gray-800 rounded-lg shadow-xs">
        <form action="{{ route('admin.pagos.index') }}" method="GET" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm text-gray-700 dark:text-gray-400 mb-2">Estado del Pago</label>
                <select name="estado_pago" class="block w-full mt-1 text-sm rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300">
                    <option value="">Todos</option>
                    <option value="pendiente" {{ request('estado_pago') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="pagado" {{ request('estado_pago') == 'pagado' ? 'selected' : '' }}>Pagado</option>
                    <option value="rechazado" {{ request('estado_pago') == 'rechazado' ? 'selected' : '' }}>Rechazado</option>
                </select>
            </div>
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm text-gray-700 dark:text-gray-400 mb-2">Fecha Inicio</label>
                <input type="date" name="fecha_inicio" value="{{ request('fecha_inicio') }}" class="block w-full mt-1 text-sm rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300">
            </div>
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm text-gray-700 dark:text-gray-400 mb-2">Fecha Fin</label>
                <input type="date" name="fecha_fin" value="{{ request('fecha_fin') }}" class="block w-full mt-1 text-sm rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300">
            </div>
            <div class="flex items-end">
                <button type="submit" class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                    <i class="fas fa-filter mr-2"></i>Filtrar
                </button>
            </div>
        </form>
    </div>

    <!-- Tabla de Pagos -->
    <div class="w-full overflow-hidden rounded-lg shadow-xs bg-white dark:bg-gray-800">
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">ID</th>
                        <th class="px-4 py-3">Usuario</th>
                        <th class="px-4 py-3">Convocatoria</th>
                        <th class="px-4 py-3">Monto</th>
                        <th class="px-4 py-3">Estado</th>
                        <th class="px-4 py-3">Fecha</th>
                        <th class="px-4 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @foreach($pagos as $pago)
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3">{{ $pago['id'] }}</td>
                        <td class="px-4 py-3 text-sm">{{ $pago['usuario'] }}</td>
                        <td class="px-4 py-3 text-sm">{{ $pago['concurso'] }}</td>
                        <td class="px-4 py-3 text-sm">${{ number_format($pago['monto'], 2) }}</td>
                        <td class="px-4 py-3 text-sm">
                            <span class="px-2 py-1 font-semibold leading-tight rounded-full
                                @if($pago['estado_pago'] === 'pagado')
                                    text-green-700 bg-green-100 dark:bg-green-700 dark:text-green-100
                                @elseif($pago['estado_pago'] === 'rechazado')
                                    text-red-700 bg-red-100 dark:bg-red-700 dark:text-red-100
                                @else
                                    text-orange-700 bg-orange-100 dark:bg-orange-700 dark:text-orange-100
                                @endif">
                                {{ ucfirst($pago['estado_pago']) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm">{{ $pago['fecha_pago'] }}</td>
                        <td class="px-4 py-3 text-sm">
                            <div class="flex items-center space-x-4">
                                <a href="{{ route('admin.pagos.show', $pago['id']) }}" class="text-purple-600 hover:text-purple-900 dark:text-purple-400 dark:hover:text-purple-300 transition-colors duration-150">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if($pago['estado_pago'] === 'pagado')
                                <a href="{{ route('admin.pagos.factura', $pago['id']) }}" class="text-purple-600 hover:text-purple-900 dark:text-purple-400 dark:hover:text-purple-300 transition-colors duration-150">
                                    <i class="fas fa-file-invoice"></i>
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Botón Exportar -->
    <!-- <div class="mt-6">
        <a href="{{ route('admin.pagos.exportar') }}" class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple inline-flex items-center">
            <i class="fas fa-download mr-2"></i>
            Exportar Pagos
        </a>
    </div> -->
</div>
@endsection