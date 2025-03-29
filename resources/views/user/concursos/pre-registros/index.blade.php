@extends('layouts.user')

@section('contenido')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Mis Pre-registros</h2>
            @if ($convocatoria)
                <a href="{{ route('user.concursos.pre-registros.create', ['convocatoria' => $convocatoria->id]) }}"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fas fa-user-plus mr-2"></i>Nuevo Pre-registro
                </a>
            @endif
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if ($preRegistros->isEmpty())
            <div class="text-center py-8">
                <p class="text-gray-500">No tienes pre-registros actualmente.</p>
                <p class="text-gray-500 mt-2">¡Comienza creando uno nuevo!</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Concurso</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Equipo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Integrantes</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($preRegistros as $preRegistro)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $preRegistro->concurso->nombre }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $preRegistro->nombre_equipo }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $preRegistro->integrantes }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if($preRegistro->estado === 'validado') bg-green-100 text-green-800
                                        @elseif($preRegistro->estado === 'rechazado') bg-red-100 text-red-800
                                        @else bg-yellow-100 text-yellow-800
                                        @endif">
                                        {{ ucfirst($preRegistro->estado) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('user.concursos.pre-registros.show', $preRegistro) }}"
                                        class="text-indigo-600 hover:text-indigo-900 mr-3">Ver</a>
                                    @if($preRegistro->estado === 'pendiente')
                                        <a href="{{ route('user.concursos.pre-registros.edit', $preRegistro) }}"
                                            class="text-yellow-600 hover:text-yellow-900 mr-3">Editar</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $preRegistros->links() }}
            </div>
        @endif
    </div>
</div>
@endsection