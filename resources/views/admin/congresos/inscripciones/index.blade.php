@extends('layouts.admin')

@section('contenido')
<div class="relative z-10">
    <div class="bg-gradient-to-br from-gray-900 to-black rounded-xl shadow-xl p-8 mb-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-white">Gestión de Inscripciones a Congresos</h1>
        </div>

        @if(session('success'))
            <div class="bg-green-500/20 text-green-500 px-4 py-3 rounded-lg mb-6" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Filtros y Búsqueda -->
        <form action="{{ route('admin.congresos.inscripciones.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por participante..." class="w-full bg-gray-800 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
            </div>
            <select name="tipo_participante" class="bg-gray-800 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                <option value="">Todos los tipos</option>
                <option value="ponente" {{ request('tipo_participante') === 'ponente' ? 'selected' : '' }}>Ponente</option>
                <option value="asistente" {{ request('tipo_participante') === 'asistente' ? 'selected' : '' }}>Asistente</option>
            </select>
            <select name="estado_pago" class="bg-gray-800 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                <option value="">Todos los estados de pago</option>
                <option value="pendiente" {{ request('estado_pago') === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="pagado" {{ request('estado_pago') === 'pagado' ? 'selected' : '' }}>Pagado</option>
                <option value="rechazado" {{ request('estado_pago') === 'rechazado' ? 'selected' : '' }}>Rechazado</option>
            </select>
        </form>

        <!-- Tabla de Inscripciones -->
        <div class="overflow-x-auto">
            <table class="w-full text-white">
                <thead class="bg-gray-800 text-gray-300">
                    <tr>
                        <th class="px-4 py-3 text-left">Participante</th>
                        <th class="px-4 py-3 text-left">Congreso</th>
                        <th class="px-4 py-3 text-center">Tipo</th>
                        <th class="px-4 py-3 text-center">Estado Artículo</th>
                        <th class="px-4 py-3 text-center">Estado Pago</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($inscripciones as $inscripcion)
                        <tr class="hover:bg-gray-800/50">
                            <td class="px-4 py-3">{{ $inscripcion->usuario->name }}</td>
                            <td class="px-4 py-3">{{ $inscripcion->congreso->nombre }}</td>
                            <td class="px-4 py-3 text-center">
                                <span class="px-3 py-1 rounded-full text-xs
                                    {{ $inscripcion->tipo_participante === 'ponente' ? 'bg-purple-500/20 text-purple-500' : 'bg-blue-500/20 text-blue-500' }}">
                                    {{ ucfirst($inscripcion->tipo_participante) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($inscripcion->articulo)
                                    <span class="px-3 py-1 rounded-full text-xs
                                        @switch($inscripcion->articulo->estado_articulo)
                                            @case('aceptado')
                                                bg-green-500/20 text-green-500
                                                @break
                                            @case('rechazado')
                                                bg-red-500/20 text-red-500
                                                @break
                                            @case('en_revision')
                                                bg-yellow-500/20 text-yellow-500
                                                @break
                                            @default
                                                bg-gray-500/20 text-gray-500
                                        @endswitch">
                                        {{ ucfirst(str_replace('_', ' ', $inscripcion->articulo->estado_articulo)) }}
                                    </span>
                                @else
                                    <span class="text-gray-400">N/A</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="px-3 py-1 rounded-full text-xs
                                    @switch($inscripcion->pagoInscripcion->estado_pago ?? 'pendiente')
                                        @case('pagado')
                                            bg-green-500/20 text-green-500
                                            @break
                                        @case('rechazado')
                                            bg-red-500/20 text-red-500
                                            @break
                                        @default
                                            bg-yellow-500/20 text-yellow-500
                                    @endswitch">
                                    {{ ucfirst($inscripcion->pagoInscripcion->estado_pago ?? 'pendiente') }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('admin.congresos.inscripciones.show', $inscripcion) }}" class="text-blue-400 hover:text-blue-300" title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button onclick="eliminarInscripcion('{{ $inscripcion->id }}')" class="text-red-400 hover:text-red-300" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-3 text-center text-gray-400">
                                No hay inscripciones disponibles
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

<script>
function eliminarInscripcion(id) {
    if (confirm('¿Estás seguro de eliminar esta inscripción?')) {
        fetch(`/admin/congresos-inscripciones/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                window.location.reload();
            }
        })
        .catch(error => console.error('Error:', error));
    }
}
</script>
@endsection