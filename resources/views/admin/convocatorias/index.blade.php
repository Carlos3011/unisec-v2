@extends('layouts.admin')

@section('contenido')
<div class="bg-gray-900 p-8 rounded-xl shadow-lg max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 space-y-4 md:space-y-0">
        <h1 class="text-2xl font-light text-white">Gestión de Convocatorias</h1>
        <div class="flex flex-col md:flex-row gap-4 w-full md:w-auto">
            <form method="GET" action="{{ route('admin.convocatorias.index') }}" class="relative w-full md:w-64">
                <input type="text" name="search" placeholder="Buscar..." value="{{ request('search') }}" class="w-full h-10 pl-10 pr-4 rounded-lg bg-gray-800 border-0 text-gray-300 placeholder-gray-500 focus:ring-2 focus:ring-blue-500 transition-all duration-200">
                <button type="submit" class="absolute left-3 top-3 text-gray-500">
                    <i class="fas fa-search"></i>
                </button>
            </form>
            <a href="{{ route('admin.convocatorias.create') }}" class="flex items-center justify-center h-10 px-4 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition-all duration-200">
                <i class="fas fa-plus text-sm mr-2"></i>Nueva Convocatoria
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-lg bg-green-500/10 border border-green-500/20 text-green-400" x-data="{ show: true }" x-show="show" x-transition>
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-3"></i>
                <span>{{ session('success') }}</span>
                <button @click="show = false" class="ml-auto text-green-400 hover:text-green-300">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif

    <div class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($convocatorias as $convocatoria)
                <div class="bg-gradient-to-br from-gray-800 to-blue-900 rounded-lg overflow-hidden hover:ring-2 transition-all duration-300 shadow-xl border-l-4 border-blue-500/50">
                    <div class="p-6 space-y-4">
                        <div class="flex items-start justify-between">
                            <h3 class="text-lg font-medium text-white">{{ $convocatoria->nombre_evento }}</h3>
                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-yellow-500/20 text-yellow-400 border border-yellow-500/30 shadow-lg">
                                <i class="fas fa-trophy mr-1"></i>
                                Concurso
                            </span>
                        </div>
                        
                        <div x-data="{ expanded: false }" class="relative">
                            <div class="space-y-2">
                                <div class="flex items-center text-sm text-gray-300">
                                    <i class="fas fa-map-marker-alt w-5 text-gray-500"></i>
                                    <span>{{ $convocatoria->sede }}</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-300">
                                    <i class="fas fa-users w-5 text-gray-500"></i>
                                    <span>{{ $convocatoria->dirigido_a }}</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-300">
                                    <i class="fas fa-user-friends w-5 text-gray-500"></i>
                                    <span>Máx. {{ $convocatoria->max_integrantes }} integrantes</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="px-6 py-4 bg-gray-800/50 border-t border-gray-700 flex justify-end space-x-2">
                        <a href="{{ route('admin.convocatorias.show', $convocatoria) }}" class="p-2 text-gray-400 hover:text-blue-400 transition-colors" title="Ver detalles">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.convocatorias.edit', $convocatoria) }}" class="p-2 text-gray-400 hover:text-yellow-400 transition-colors" title="Editar">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button data-id="{{ $convocatoria->id }}" class="btn-eliminar p-2 text-gray-400 hover:text-red-400 transition-colors" title="Eliminar">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full p-8 text-center">
                    <i class="fas fa-folder-open text-4xl text-gray-600 mb-4"></i>
                    @if(request('search'))
                        <p class="text-gray-400">No se encontraron convocatorias con "{{ request('search') }}"</p>
                        <a href="{{ route('admin.convocatorias.index') }}" class="inline-block mt-4 text-blue-400 hover:text-blue-300">Ver todas las convocatorias</a>
                    @else
                        <p class="text-gray-400">No hay convocatorias registradas</p>
                        <a href="{{ route('admin.convocatorias.create') }}" class="inline-block mt-4 text-blue-400 hover:text-blue-300">Crear nueva convocatoria</a>
                    @endif
                </div>
            @endforelse
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.btn-eliminar').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                Swal.fire({
                    title: '¿Eliminar convocatoria?',
                    text: 'Esta acción no se puede deshacer',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`{{ route('admin.convocatorias.destroy', '') }}/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                return response.text().then(text => { throw new Error(text) });
                            }
                            return response.json();
                        })
                        .then(data => {
                            Swal.fire({
                                title: 'Eliminado!',
                                text: 'La convocatoria ha sido eliminada.',
                                icon: 'success'
                            }).then(() => window.location.reload());
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                title: 'Error!',
                                text: error.message || 'Error en la solicitud',
                                icon: 'error'
                            });
                        });
                    }
                });
            });
        });
    });
</script>
@endsection