@extends('layouts.admin')

@section('titulo', 'Gestión de Noticias')

@section('contenido')
<div class="bg-gradient-to-br from-gray-900 to-black rounded-xl shadow-xl p-8 max-w-7xl mx-auto">
    <div class="mb-6">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <h1 class="text-3xl font-bold text-white">Gestión de Noticias</h1>
            <a href="{{ route('admin.noticias.noticia.create') }}" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all flex items-center justify-center md:justify-start gap-2 w-full md:w-auto">
                <i class="fas fa-plus"></i>
                <span>Nueva Noticia</span>
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-500/20 text-green-500 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filtros y Búsqueda -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="relative">
            <input type="text" id="searchInput" placeholder="Buscar noticias..." class="w-full bg-gray-800/50 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
        </div>
        <select id="sectionFilter" class="bg-gray-800/50 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Todas las secciones</option>
            @foreach($noticias->pluck('seccion.titulo')->unique() as $seccion)
                <option value="{{ $seccion }}">{{ $seccion }}</option>
            @endforeach
        </select>
    </div>

    <!-- Grid de Noticias -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($noticias as $noticia)
            <div class="bg-gray-800/30 rounded-xl overflow-hidden hover:shadow-lg transition-all hover:transform hover:scale-[1.02]">
                <div class="aspect-video overflow-hidden bg-gray-900">
                    <img src="{{ Storage::url('noticias/' . $noticia->imagen) }}" alt="{{ $noticia->titulo }}" class="w-full h-full object-cover">
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <span class="text-gray-400 text-sm">{{ $noticia->created_at->format('d/m/Y') }}</span>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2 line-clamp-2">{{ $noticia->titulo }}</h3>
                    <p class="text-gray-400 text-sm mb-4 line-clamp-3">{{ $noticia->descripcion }}</p>
                    <div class="flex items-center justify-between text-sm text-gray-400 mb-4">
                        <span class="flex items-center gap-2">
                            <i class="fas fa-user"></i>
                            {{ $noticia->autor_noticia }}
                        </span>
                        <span class="bg-blue-500/20 text-blue-400 px-3 py-1 rounded-full">
                            {{ $noticia->seccion->titulo }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center pt-4 border-t border-gray-700">
                        <a href="{{ route('admin.noticias.noticia.edit', $noticia) }}" class="text-blue-400 hover:text-blue-300 flex items-center gap-2">
                            <i class="fas fa-edit"></i>
                            <span>Editar</span>
                        </a>
                        <form action="{{ route('admin.noticias.noticia.destroy', $noticia) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-400 hover:text-red-300 flex items-center gap-2" onclick="return confirm('¿Estás seguro de que deseas eliminar esta noticia?')">
                                <i class="fas fa-trash"></i>
                                <span>Eliminar</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <div class="text-gray-400">
                    <i class="fas fa-newspaper text-4xl mb-4"></i>
                    <p class="text-lg">No hay noticias registradas</p>
                </div>
            </div>
        @endforelse
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const sectionFilter = document.getElementById('sectionFilter');
    const cards = document.querySelectorAll('.grid > div');

    function filterCards() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedSection = sectionFilter.value.toLowerCase();
        const selectedStatus = statusFilter.value;

        cards.forEach(card => {
            const title = card.querySelector('h3').textContent.toLowerCase();
            const section = card.querySelector('.text-blue-400').textContent.toLowerCase();
            const status = card.querySelector('.rounded-full').textContent.trim().toLowerCase() === 'activo' ? '1' : '0';

            const matchesSearch = title.includes(searchTerm);
            const matchesSection = !selectedSection || section.includes(selectedSection);

            card.style.display = matchesSearch && matchesSection && matchesStatus ? 'block' : 'none';
        });
    }

    searchInput.addEventListener('input', filterCards);
    sectionFilter.addEventListener('change', filterCards);
    statusFilter.addEventListener('change', filterCards);
});
</script>
@endsection