@extends('layouts.admin')

@section('titulo', 'Gestión de Secciones')

@section('contenido')
<div class="relative z-10">
    <div class="bg-gradient-to-br from-gray-900 to-black rounded-xl shadow-xl p-8 mb-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-white">Gestión de Secciones</h1>
            <a href="{{ route('admin.noticias.secciones.create') }}" class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-2 rounded-lg shadow-lg transition-all flex items-center space-x-2">
                <i class="fas fa-plus"></i>
                <span>Nueva Sección</span>
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-500/20 text-green-500 px-4 py-3 rounded-lg mb-6" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Filtros y Búsqueda -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div class="relative">
                <input type="text" placeholder="Buscar secciones..." class="w-full bg-gray-800 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
            </div>
        </div>

        <!-- Tabla de Secciones -->
        <div class="overflow-x-auto">
            <table class="w-full text-white">
                <thead class="bg-gray-800 text-gray-300">
                    <tr>
                        <th class="px-4 py-3 text-left">ID</th>
                        <th class="px-4 py-3 text-left">Título</th>
                        <th class="px-4 py-3 text-center">Noticias</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($secciones as $seccion)
                        <tr class="hover:bg-gray-800/50">
                            <td class="px-4 py-3">{{ $seccion->id }}</td>
                            <td class="px-4 py-3">{{ $seccion->titulo }}</td>
                            <td class="px-4 py-3 text-center">
                                <span class="px-2 py-1 rounded-full bg-blue-500/20 text-blue-500">
                                    {{ $seccion->noticias_count }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('admin.noticias.secciones.edit', $seccion) }}" class="text-blue-400 hover:text-blue-300">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.noticias.secciones.destroy', $seccion) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="text-red-400 hover:text-red-300 delete-seccion" data-id="{{ $seccion->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>

                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            const deleteBtns = document.querySelectorAll('.delete-seccion');
                                            
                                            deleteBtns.forEach(btn => {
                                                btn.addEventListener('click', function() {
                                                    const seccionId = this.dataset.id;
                                                    const form = this.closest('form');
                                                    
                                                    Swal.fire({
                                                        title: '¿Estás seguro?',
                                                        text: 'Esta acción eliminará la sección permanentemente',
                                                        icon: 'warning',
                                                        showCancelButton: true,
                                                        confirmButtonColor: '#EF4444',
                                                        cancelButtonColor: '#6B7280',
                                                        confirmButtonText: 'Sí, eliminar',
                                                        cancelButtonText: 'Cancelar'
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            form.submit();
                                                        }
                                                    });
                                                });
                                            });
                                        });
                                    </script>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-3 text-center text-gray-400">
                                No hay secciones registradas
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection