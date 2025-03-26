@extends('layouts.admin')

@section('titulo', 'Gestión de Secciones')

@section('contenido')
<div class="bg-gray-900 p-8 rounded-xl shadow-lg max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-white">Gestión de Secciones</h1>
            <a href="{{ route('admin.noticias.secciones.create') }}" class="bg-blue-500 hover:bg-purple-600 text-white px-6 py-2 rounded-lg shadow-lg transition-all flex items-center space-x-2">
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
                <input type="text" id="searchInput" placeholder="Buscar secciones..." class="w-full bg-gray-800 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
            </div>
        </div>
        
        <!-- Tabla de Secciones Activas -->
        <div class="overflow-x-auto">
            <h2 class="text-xl font-semibold text-white mb-4">Secciones Activas</h2>
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
                            <td colspan="5" class="px-4 py-3 text-center">
                                <div class="flex flex-col items-center justify-center py-12">
                                    <div class="text-gray-400 mb-4">
                                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                                        </svg>
                                    </div>
                                    <p class="text-gray-400 text-lg mb-4">No hay secciones registradas</p>
                                    <a href="{{ route('admin.noticias.secciones.create') }}" class="bg-blue-500 hover:bg-purple-600 text-white px-6 py-2 rounded-lg shadow-lg transition-all flex items-center space-x-2">
                                        <i class="fas fa-plus"></i>
                                        <span>Crear nueva seccion</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Tabla de Secciones Eliminadas -->
        <div class="overflow-x-auto mt-8">
            <h2 class="text-xl font-semibold text-white mb-4">Secciones Eliminadas</h2>
            <table class="w-full text-white">
                <thead class="bg-gray-800 text-gray-300">
                    <tr>
                        <th class="px-4 py-3 text-left">ID</th>
                        <th class="px-4 py-3 text-left">Título</th>
                        <th class="px-4 py-3 text-center">Noticias</th>
                        <th class="px-4 py-3 text-center">Fecha de Eliminación</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($seccionesEliminadas as $seccion)
                        <tr class="hover:bg-gray-800/50">
                            <td class="px-4 py-3">{{ $seccion->id }}</td>
                            <td class="px-4 py-3">{{ $seccion->titulo }}</td>
                            <td class="px-4 py-3 text-center">
                                <span class="px-2 py-1 rounded-full bg-blue-500/20 text-blue-500">
                                    {{ $seccion->noticias_count }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center text-gray-400">
                                {{ $seccion->deleted_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex justify-center space-x-2">
                                    <form action="{{ route('admin.noticias.secciones.restore', $seccion->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="button" class="text-green-400 hover:text-green-300 restore-seccion" data-id="{{ $seccion->id }}">
                                            <i class="fas fa-undo"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-3 text-center text-gray-400">
                                No hay secciones eliminadas
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Búsqueda existente
        const searchInput = document.getElementById('searchInput');
        const tableRows = document.querySelectorAll('tbody tr');
        const noResultsRow = document.querySelector('tbody tr td[colspan="5"]')?.parentElement;
        let typingTimer;

        searchInput.addEventListener('input', function() {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(() => {
                const searchTerm = this.value.toLowerCase().trim();
                let hasResults = false;

                tableRows.forEach(row => {
                    if (row === noResultsRow) return;
                    
                    const title = row.querySelector('td:nth-child(2)')?.textContent.toLowerCase();
                    if (title && title.includes(searchTerm)) {
                        row.style.display = '';
                        hasResults = true;
                    } else {
                        row.style.display = 'none';
                    }
                });

                if (noResultsRow) {
                    noResultsRow.style.display = hasResults ? 'none' : '';
                }
            }, 300);
        });

        // Restaurar sección
        const restoreBtns = document.querySelectorAll('.restore-seccion');
        
        restoreBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const seccionId = this.dataset.id;
                const form = this.closest('form');
                
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: 'Esta acción restaurará la sección',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#10B981',
                    cancelButtonColor: '#6B7280',
                    confirmButtonText: 'Sí, restaurar',
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const tableRows = document.querySelectorAll('tbody tr');
        const noResultsRow = document.querySelector('tbody tr td[colspan="5"]')?.parentElement;
        let typingTimer;

        searchInput.addEventListener('input', function() {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(() => {
                const searchTerm = this.value.toLowerCase().trim();
                let hasResults = false;

                tableRows.forEach(row => {
                    if (row === noResultsRow) return;
                    
                    const title = row.querySelector('td:nth-child(2)')?.textContent.toLowerCase();
                    if (title && title.includes(searchTerm)) {
                        row.style.display = '';
                        hasResults = true;
                    } else {
                        row.style.display = 'none';
                    }
                });

                if (noResultsRow) {
                    noResultsRow.style.display = hasResults ? 'none' : '';
                }
            }, 300);
        });
    });
</script>
@endsection