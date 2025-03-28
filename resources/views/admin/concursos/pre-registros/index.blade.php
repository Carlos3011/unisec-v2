@extends('layouts.admin')

@section('contenido')
<div class="relative z-10">
    <div class="bg-gradient-to-br from-gray-900 to-black rounded-xl shadow-xl p-8 mb-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-white">Gestión de Pre-registros</h1>
        </div>

        @if(session('success'))
            <div class="bg-green-500/20 text-green-500 px-4 py-3 rounded-lg mb-6" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Filtros y Búsqueda -->
        <form action="{{ route('admin.concursos.pre-registros.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div class="relative">
                <input type="text" name="search" value="{{ $search }}" placeholder="Buscar por equipo o usuario..." class="w-full bg-gray-800 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
            </div>
            <select name="estado" class="bg-gray-800 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                <option value="">Todos los estados</option>
                <option value="pendiente" {{ $estado === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="validado" {{ $estado === 'validado' ? 'selected' : '' }}>Validado</option>
                <option value="rechazado" {{ $estado === 'rechazado' ? 'selected' : '' }}>Rechazado</option>
            </select>
        </form>

        <!-- Tabla de Pre-registros -->
        <div class="overflow-x-auto">
            <table class="w-full text-white">
                <thead class="bg-gray-800 text-gray-300">
                    <tr>
                        <th class="px-4 py-3 text-left">Equipo</th>
                        <th class="px-4 py-3 text-left">Usuario</th>
                        <th class="px-4 py-3 text-left">Concurso</th>
                        <th class="px-4 py-3 text-center">Integrantes</th>
                        <th class="px-4 py-3 text-center">Estado</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($preRegistros as $preRegistro)
                        <tr class="hover:bg-gray-800/50">
                            <td class="px-4 py-3">{{ $preRegistro->nombre_equipo }}</td>
                            <td class="px-4 py-3">{{ $preRegistro->usuario->name }}</td>
                            <td class="px-4 py-3">{{ $preRegistro->concurso->titulo }}</td>
                            <td class="px-4 py-3 text-center">{{ $preRegistro->integrantes }}</td>
                            <td class="px-4 py-3 text-center">
                                <span class="px-3 py-1 rounded-full text-xs
                                    @switch($preRegistro->estado)
                                        @case('validado')
                                            bg-green-500/20 text-green-500
                                            @break
                                        @case('pendiente')
                                            bg-yellow-500/20 text-yellow-500
                                            @break
                                        @case('rechazado')
                                            bg-red-500/20 text-red-500
                                            @break
                                    @endswitch">
                                    {{ ucfirst($preRegistro->estado) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('admin.concursos.pre-registros.show', $preRegistro) }}" class="text-blue-400 hover:text-blue-300" title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.concursos.pre-registros.edit', $preRegistro) }}" class="text-blue-400 hover:text-blue-300" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="eliminarPreRegistro('{{ $preRegistro->id }}')" class="text-red-400 hover:text-red-300" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-3 text-center text-gray-400">
                                No hay pre-registros disponibles
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="mt-4">
            {{ $preRegistros->links() }}
        </div>
    </div>
</div>


<script>
function eliminarPreRegistro(id) {
    if (confirm('¿Estás seguro de eliminar este pre-registro?')) {
        fetch(`/admin/pre-registros/${id}`, {
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