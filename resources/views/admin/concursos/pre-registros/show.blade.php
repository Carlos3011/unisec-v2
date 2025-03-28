@extends('layouts.admin')

@section('contenido')
<div class="relative z-10">
    <div class="bg-gradient-to-br from-gray-900 to-black rounded-xl shadow-xl p-8 mb-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-white">Detalles del Pre-registro</h1>
            <div class="flex space-x-2">
                <a href="{{ route('admin.concursos.pre-registros.edit', $preRegistro) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow-lg transition-all flex items-center space-x-2">
                    <i class="fas fa-edit"></i>
                    <span>Editar</span>
                </a>
                <a href="{{ route('admin.concursos.pre-registros.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg shadow-lg transition-all flex items-center space-x-2">
                    <i class="fas fa-arrow-left"></i>
                    <span>Volver</span>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Información del Equipo -->
            <div class="bg-gray-800/50 rounded-xl p-6">
                <h2 class="text-xl font-semibold text-white mb-4">Información del Equipo</h2>
                <div class="space-y-4">
                    <div>
                        <label class="text-gray-400 text-sm">Nombre del Equipo</label>
                        <p class="text-white">{{ $preRegistro->nombre_equipo }}</p>
                    </div>
                    <div>
                        <label class="text-gray-400 text-sm">Número de Integrantes</label>
                        <p class="text-white">{{ $preRegistro->integrantes }}</p>
                    </div>
                    <div>
                        <label class="text-gray-400 text-sm">Asesor</label>
                        <p class="text-white">{{ $preRegistro->asesor ?: 'No especificado' }}</p>
                    </div>
                    <div>
                        <label class="text-gray-400 text-sm">Institución</label>
                        <p class="text-white">{{ $preRegistro->institucion ?: 'No especificada' }}</p>
                    </div>
                </div>
            </div>

            <!-- Información del Concurso y Estado -->
            <div class="bg-gray-800/50 rounded-xl p-6">
                <h2 class="text-xl font-semibold text-white mb-4">Información del Concurso</h2>
                <div class="space-y-4">
                    <div>
                        <label class="text-gray-400 text-sm">Concurso</label>
                        <p class="text-white">{{ $preRegistro->concurso->titulo }}</p>
                    </div>
                    <div>
                        <label class="text-gray-400 text-sm">Estado del Pre-registro</label>
                        <div class="mt-1">
                            <span class="px-3 py-1 rounded-full text-xs inline-block
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
                        </div>
                    </div>
                    <div>
                        <label class="text-gray-400 text-sm">Fecha de Pre-registro</label>
                        <p class="text-white">{{ $preRegistro->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Información del Usuario -->
            <div class="bg-gray-800/50 rounded-xl p-6">
                <h2 class="text-xl font-semibold text-white mb-4">Información del Usuario</h2>
                <div class="space-y-4">
                    <div>
                        <label class="text-gray-400 text-sm">Nombre</label>
                        <p class="text-white">{{ $preRegistro->usuario->name }}</p>
                    </div>
                    <div>
                        <label class="text-gray-400 text-sm">Email</label>
                        <p class="text-white">{{ $preRegistro->usuario->email }}</p>
                    </div>
                </div>
            </div>

            <!-- Comentarios -->
            <div class="bg-gray-800/50 rounded-xl p-6">
                <h2 class="text-xl font-semibold text-white mb-4">Comentarios</h2>
                <div class="space-y-4">
                    <p class="text-white whitespace-pre-line">{{ $preRegistro->comentarios ?: 'Sin comentarios' }}</p>
                </div>
            </div>
        </div>

        <!-- Acciones de Estado -->
        <div class="mt-8 flex justify-end space-x-4">
            <button onclick="actualizarEstado('{{ $preRegistro->id }}', 'validado')" 
                    class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg transition-all"
                    {{ $preRegistro->estado === 'validado' ? 'disabled' : '' }}>
                <i class="fas fa-check mr-2"></i>Validar
            </button>
            <button onclick="actualizarEstado('{{ $preRegistro->id }}', 'rechazado')"
                    class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-all"
                    {{ $preRegistro->estado === 'rechazado' ? 'disabled' : '' }}>
                <i class="fas fa-times mr-2"></i>Rechazar
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
function actualizarEstado(id, estado) {
    if (confirm(`¿Estás seguro de ${estado === 'validado' ? 'validar' : 'rechazar'} este pre-registro?`)) {
        fetch(`/admin/pre-registros/${id}/estado`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ estado: estado })
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
@endpush
@endsection