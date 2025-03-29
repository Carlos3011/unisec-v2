@extends('layouts.user')

@section('contenido')
<div class="container mx-auto px-4 py-8">
    <div class="bg-gradient-to-br from-gray-900 to-black rounded-xl shadow-xl p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-white">Mis Pre-registros</h2>
            @if ($convocatoria)
                <a href="{{ route('user.concursos.pre-registros.create', ['convocatoria' => $convocatoria->id]) }}"
                    class="inline-flex items-center px-4 py-2 rounded-lg shadow-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                    <i class="fas fa-user-plus mr-2"></i>Nuevo Pre-registro
                </a>
            @endif
        </div>

        @if (session('success'))
            <div class="bg-green-600/20 border border-green-500/30 text-green-300 px-4 py-3 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if ($preRegistros->isEmpty())
            <div class="text-center py-8">
                <p class="text-gray-400">No tienes pre-registros actualmente.</p>
                <p class="text-gray-400 mt-2">¡Comienza creando uno nuevo!</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-700">
                    <thead class="bg-gray-800/50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Concurso</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Equipo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Integrantes</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-gray-800/30 divide-y divide-gray-700">
                        @foreach ($preRegistros as $preRegistro)
                            <tr class="hover:bg-gray-700/30 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-300">{{ $preRegistro->concurso->titulo }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-300">{{ $preRegistro->nombre_equipo }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-300">{{ $preRegistro->integrantes }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if($preRegistro->estado === 'validado') bg-green-900/50 text-green-300
                                        @elseif($preRegistro->estado === 'rechazado') bg-red-900/50 text-red-300
                                        @else bg-yellow-900/50 text-yellow-300
                                        @endif">
                                        {{ ucfirst($preRegistro->estado) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('user.concursos.pre-registros.show', $preRegistro) }}"
                                        class="text-blue-400 hover:text-blue-300 transition-colors mr-3">Ver</a>
                                    @if($preRegistro->estado === 'pendiente')
                                        <a href="{{ route('user.concursos.pre-registros.edit', $preRegistro) }}"
                                            class="text-yellow-400 hover:text-yellow-300 transition-colors mr-3">Editar</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4 text-gray-300">
                {{ $preRegistros->links() }}
            </div>
        @endif
    </div>
</div>
@endsection