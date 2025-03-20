@extends('layouts.admin')

@section('contenido')
<div class="bg-gray-900 p-8 rounded-xl shadow-lg max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 space-y-4 md:space-y-0">
        <h1 class="text-2xl font-light text-white">Gestión de Convocatorias</h1>
        <div class="flex flex-col md:flex-row gap-4 w-full md:w-auto">
            <div class="relative w-full md:w-64">
                <input x-model="search" type="text" placeholder="Buscar..." class="w-full h-10 pl-10 pr-4 rounded-lg bg-gray-800 border-0 text-gray-300 placeholder-gray-500 focus:ring-2 focus:ring-blue-500 transition-all duration-200">
                <i class="fas fa-search absolute left-3 top-3 text-gray-500"></i>
            </div>
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
                <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-lg overflow-hidden hover:ring-2 transition-all duration-300 shadow-xl" :class="{
                    'hover:ring-green-500/50 border-l-4 border-green-500/50': '{{ $convocatoria->evento_type }}' === 'congreso',
                    'hover:ring-blue-500/50 border-l-4 border-blue-500/50': '{{ $convocatoria->evento_type }}' === 'curso',
                    'hover:ring-purple-500/50 border-l-4 border-purple-500/50': '{{ $convocatoria->evento_type }}' === 'concurso'
                }">
                    <div class="p-6 space-y-4">
                        <div class="flex items-start justify-between">
                            <h3 class="text-lg font-medium text-white">{{ $convocatoria->titulo }}</h3>
                            <span class="px-3 py-1 text-xs font-medium rounded-full shadow-lg" :class="{
                                'bg-green-500/20 text-green-400 border border-green-500/30': '{{ $convocatoria->evento_type }}' === 'congreso',
                                'bg-blue-500/20 text-blue-400 border border-blue-500/30': '{{ $convocatoria->evento_type }}' === 'curso',
                                'bg-purple-500/20 text-purple-400 border border-purple-500/30': '{{ $convocatoria->evento_type }}' === 'concurso'
                            }">
                                <i class="fas mr-1" :class="{
                                    'fa-users': '{{ $convocatoria->evento_type }}' === 'congreso',
                                    'fa-graduation-cap': '{{ $convocatoria->evento_type }}' === 'curso',
                                    'fa-trophy': '{{ $convocatoria->evento_type }}' === 'concurso'
                                }"></i>
                                {{ ucfirst($convocatoria->evento_type) }}
                            </span>
                        </div>
                        
                        <div x-data="{ expanded: false }" class="relative">
                            <p class="text-white text-sm" :class="{ 'line-clamp-2': !expanded }">{{ $convocatoria->descripcion }}</p>
                            <button @click="expanded = !expanded" class="text-xs text-blue-400 hover:text-blue-300 mt-1 focus:outline-none transition-colors duration-200">
                                <span x-text="expanded ? 'Ver menos' : 'Ver más'"></span>
                                <i class="fas" :class="{ 'fa-chevron-down': !expanded, 'fa-chevron-up': expanded }"></i>
                            </button>
                        </div>

                        @if($convocatoria->fechasImportantes->count() > 0)
                            <div x-data="{ open: false }" class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <h4 class="text-xs font-medium text-white uppercase tracking-wider">Fechas Importantes</h4>
                                    <button @click="open = !open" class="text-xs text-blue-400 hover:text-blue-300 focus:outline-none transition-colors duration-200">
                                        <span x-text="open ? 'Ver menos' : 'Ver todas'"></span>
                                        <i class="fas" :class="{ 'fa-chevron-down': !open, 'fa-chevron-up': open }"></i>
                                    </button>
                                </div>
                                <div class="space-y-2" x-show="!open">
                                    @foreach($convocatoria->fechasImportantes->take(2) as $fecha)
                                        <div class="flex items-center justify-between text-sm p-2 rounded bg-gray-700/50 hover:bg-gray-700/70 transition-colors duration-200">
                                            <span class="text-gray-300">{{ $fecha->titulo }}</span>
                                            <span class="text-gray-400">{{ $fecha->fecha->format('d/m/Y') }}</span>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="space-y-2" x-show="open" x-transition>
                                    @foreach($convocatoria->fechasImportantes as $fecha)
                                        <div class="flex items-center justify-between text-sm p-2 rounded bg-gray-700/50 hover:bg-gray-700/70 transition-colors duration-200">
                                            <span class="text-gray-300">{{ $fecha->titulo }}</span>
                                            <span class="text-gray-400">{{ $fecha->fecha->format('d/m/Y') }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="px-6 py-4 bg-gray-800/50 border-t border-gray-700 flex justify-end space-x-2">
                        <a href="{{ route('admin.convocatorias.show', $convocatoria) }}" class="p-2 text-gray-400 hover:text-blue-400 transition-colors" title="Ver detalles">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.convocatorias.edit', $convocatoria) }}" class="p-2 text-gray-400 hover:text-yellow-400 transition-colors" title="Editar">
                            <i class="fas fa-edit"></i>
                        </a>
                        @if($convocatoria->archivo_pdf)
                            <a href="{{ Storage::url($convocatoria->archivo_pdf) }}" target="_blank" class="p-2 text-gray-400 hover:text-blue-400 transition-colors" title="Vista Previa PDF">
                                <i class="fas fa-file-pdf"></i>
                            </a>
                        @else
                            <button class="p-2 text-gray-400 cursor-not-allowed" title="No hay PDF disponible">
                                <i class="fas fa-file-pdf"></i>
                            </button>
                        @endif
                        <button data-id="{{ $convocatoria->id }}" class="btn-eliminar p-2 text-gray-400 hover:text-red-400 transition-colors" title="Eliminar">
                            <i class="fas fa-trash"></i>
                        </button>
                        
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                document.querySelectorAll('.btn-eliminar').forEach(btn => {
                                    btn.addEventListener('click', function() {
                                        const id = this.dataset.id;
                                        confirmDelete(id);
                                    });
                                });

                                window.confirmDelete = function(id) {
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
                                };
                            });
                        </script>
                    </div>
                </div>
            @empty
                <div class="col-span-full p-8 text-center">
                    <i class="fas fa-folder-open text-4xl text-gray-600 mb-4"></i>
                    <p class="text-gray-400">No hay convocatorias registradas</p>
                    <a href="{{ route('admin.convocatorias.create') }}" class="inline-block mt-4 text-blue-400 hover:text-blue-300">Crear nueva convocatoria</a>
                </div>
            @endforelse
        </div>

        
    </div>
</div>

@endsection