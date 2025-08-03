@extends('layouts.admin')

@section('contenido')
<div class="relative z-10">
    <div class="bg-gradient-to-br from-gray-900 to-black rounded-xl shadow-xl p-6 md:p-8 mb-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-white mb-2">Gestión de Pre-registros</h1>
                <p class="text-gray-400 text-sm">Administra y supervisa todos los pre-registros de concursos</p>
            </div>
            <div class="flex items-center space-x-2 text-sm text-gray-300">
                <i class="fas fa-users"></i>
                <span>{{ $preRegistros->total() }} registros</span>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-500/20 text-green-500 px-4 py-3 rounded-lg mb-6" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Filtros y Búsqueda -->
        <div class="bg-gray-800/50 rounded-lg p-4 mb-6">
            <form action="{{ route('admin.concursos.pre-registros.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="relative">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Buscar</label>
                    <input type="text" name="search" value="{{ $search }}" placeholder="Equipo, usuario o concurso..." class="w-full bg-gray-700 text-white rounded-lg px-4 py-3 pl-10 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200">
                    <i class="fas fa-search absolute left-3 top-11 text-gray-400"></i>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Estado</label>
                    <select name="estado" class="w-full bg-gray-700 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200">
                        <option value="">Todos los estados</option>
                        <option value="pendiente" {{ $estado === 'pendiente' ? 'selected' : '' }}>🟡 Pendiente</option>
                        <option value="aprobado" {{ $estado === 'aprobado' ? 'selected' : '' }}>🟢 Aprobado</option>
                        <option value="rechazado" {{ $estado === 'rechazado' ? 'selected' : '' }}>🔴 Rechazado</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition-all duration-200 flex items-center justify-center space-x-2">
                        <i class="fas fa-filter"></i>
                        <span>Filtrar</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Tabla de Pre-registros -->
        <div class="bg-gray-800/30 rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-white">
                    <thead class="bg-gray-800">
                        <tr>
                            <th class="px-6 py-4 text-left font-semibold text-gray-200">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-users text-blue-400"></i>
                                    <span>Equipo</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left font-semibold text-gray-200">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-user text-green-400"></i>
                                    <span>Usuario</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left font-semibold text-gray-200">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-trophy text-yellow-400"></i>
                                    <span>Concurso</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-center font-semibold text-gray-200">
                                <div class="flex items-center justify-center space-x-2">
                                    <i class="fas fa-hashtag text-purple-400"></i>
                                    <span>Integrantes</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-center font-semibold text-gray-200">
                                <div class="flex items-center justify-center space-x-2">
                                    <i class="fas fa-flag text-orange-400"></i>
                                    <span>Estado</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-center font-semibold text-gray-200">
                                <div class="flex items-center justify-center space-x-2">
                                    <i class="fas fa-cogs text-gray-400"></i>
                                    <span>Acciones</span>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700/50">
                        @forelse($preRegistros as $preRegistro)
                            <tr class="hover:bg-gray-700/30 transition-all duration-200">
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                                            <i class="fas fa-users text-white text-sm"></i>
                                        </div>
                                        <div>
                                            <div class="font-medium text-white">{{ $preRegistro->nombre_equipo }}</div>
                                            <div class="text-sm text-gray-400">ID: #{{ $preRegistro->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center">
                                            <i class="fas fa-user text-white text-xs"></i>
                                        </div>
                                        <div>
                                            <div class="font-medium text-white">{{ $preRegistro->usuario->name }}</div>
                                            <div class="text-sm text-gray-400">{{ $preRegistro->usuario->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-white">{{ $preRegistro->concurso->titulo }}</div>
                                    <div class="text-sm text-gray-400">{{ Str::limit($preRegistro->concurso->descripcion, 50) }}</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center justify-center w-8 h-8 bg-purple-600 text-white rounded-full font-bold text-sm">
                                        {{ $preRegistro->integrantes }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-3 py-2 rounded-full text-sm font-medium
                                        @switch($preRegistro->estado_pdr)
                                            @case('aprobado')
                                                bg-green-500/20 text-green-400 border border-green-500/30
                                                @break
                                            @case('pendiente')
                                                bg-yellow-500/20 text-yellow-400 border border-yellow-500/30
                                                @break
                                            @case('rechazado')
                                                bg-red-500/20 text-red-400 border border-red-500/30
                                                @break
                                        @endswitch">
                                        @switch($preRegistro->estado_pdr)
                                            @case('aprobado')
                                                <i class="fas fa-check-circle mr-1"></i>
                                                @break
                                            @case('pendiente')
                                                <i class="fas fa-clock mr-1"></i>
                                                @break
                                            @case('rechazado')
                                                <i class="fas fa-times-circle mr-1"></i>
                                                @break
                                        @endswitch
                                        {{ ucfirst($preRegistro->estado_pdr) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center space-x-1">
                                        <a href="{{ route('admin.concursos.pre-registros.show', $preRegistro) }}" 
                                           class="inline-flex items-center justify-center w-8 h-8 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-all duration-200" 
                                           title="Ver detalles">
                                            <i class="fas fa-eye text-xs"></i>
                                        </a>
                                        <!-- <a href="{{ route('admin.concursos.pre-registros.edit', $preRegistro) }}" 
                                           class="inline-flex items-center justify-center w-8 h-8 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg transition-all duration-200" 
                                           title="Editar">
                                            <i class="fas fa-edit text-xs"></i>
                                        </a> -->
                                        <button onclick="eliminarPreRegistro('{{ $preRegistro->id }}')" 
                                                class="inline-flex items-center justify-center w-8 h-8 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-all duration-200" 
                                                title="Eliminar">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center space-y-3">
                                        <div class="w-16 h-16 bg-gray-700 rounded-full flex items-center justify-center">
                                            <i class="fas fa-inbox text-gray-400 text-2xl"></i>
                                        </div>
                                        <div class="text-gray-400 font-medium">No hay pre-registros disponibles</div>
                                        <div class="text-gray-500 text-sm">Los pre-registros aparecerán aquí cuando se creen</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Paginación -->
        <div class="mt-6 flex flex-col sm:flex-row justify-between items-center space-y-3 sm:space-y-0">
            <div class="text-sm text-gray-400">
                Mostrando {{ $preRegistros->firstItem() ?? 0 }} a {{ $preRegistros->lastItem() ?? 0 }} de {{ $preRegistros->total() }} resultados
            </div>
            <div class="pagination-wrapper">
                {{ $preRegistros->links() }}
            </div>
        </div>
    </div>
</div>

<style>
.pagination-wrapper .pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    space-x: 0.25rem;
}

.pagination-wrapper .pagination .page-link {
    @apply px-3 py-2 text-sm font-medium text-gray-300 bg-gray-700 border border-gray-600 rounded-lg hover:bg-gray-600 hover:text-white transition-all duration-200;
}

.pagination-wrapper .pagination .page-item.active .page-link {
    @apply bg-blue-600 text-white border-blue-600;
}

.pagination-wrapper .pagination .page-item.disabled .page-link {
    @apply text-gray-500 bg-gray-800 cursor-not-allowed;
}
</style>


<script>
function eliminarPreRegistro(id) {
    Swal.fire({
        title: '¿Eliminar Pre-registro?',
        text: '¿Estás seguro de eliminar este pre-registro? Esta acción no se puede deshacer.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
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
                    Swal.fire({
                        icon: 'success',
                        title: '¡Eliminado!',
                        text: 'El pre-registro ha sido eliminado correctamente',
                        confirmButtonColor: '#10b981'
                    }).then(() => {
                        window.location.reload();
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al eliminar el pre-registro',
                    confirmButtonColor: '#ef4444'
                });
            });
        }
    });
}
</script>
@endsection