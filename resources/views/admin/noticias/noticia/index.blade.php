@extends('layouts.admin')

@section('titulo', 'Gestión de Noticias')

@section('contenido')
<div class="container mx-auto px-4 sm:px-6 py-8">
    <div class="relative mb-8 text-center">
        <h1 class="text-4xl font-black bg-gradient-to-r from-blue-400 to-purple-300 bg-clip-text text-transparent mb-2 relative z-10 tracking-tight">Gestión de Noticias</h1>
        <p class="text-blue-200 text-lg">Administra y publica noticias relevantes</p>
    </div>

    <div class="flex justify-end mb-6">
        <a href="{{ route('admin.noticias.noticia.create') }}" class="px-6 py-3 bg-blue-600/90 text-white rounded-lg hover:bg-blue-500/90 transition-all flex items-center gap-2 backdrop-blur-sm font-medium shadow-lg shadow-blue-500/20">
            <i class="fas fa-plus"></i>
            <span>Nueva Noticia</span>
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-500/20 text-green-500 px-4 py-3 rounded-lg mb-6 backdrop-blur-sm border border-green-500/30">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        </div>
    @endif

    <!-- Filtros y Búsqueda -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8 max-w-2xl">
        <div class="relative">
            <input type="text" id="searchInput" placeholder="Buscar noticias..." 
                   class="w-full bg-gray-800/50 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500/50 border border-gray-700/50 placeholder-gray-400">
            <i class="fas fa-search absolute right-3 top-3.5 text-gray-400"></i>
        </div>
        <select id="sectionFilter" 
                class="bg-gray-800/50 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500/50 border border-gray-700/50">
            <option value="">Todas las secciones</option>
            @foreach($noticias->pluck('seccionNoticia.titulo')->unique() as $seccion)
                <option value="{{ $seccion }}">{{ $seccion }}</option>
            @endforeach
        </select>
    </div>

    <!-- Grid de Noticias -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 100)">
        @forelse($noticias as $noticia)
            <div class="bg-gradient-to-br from-gray-800/80 to-gray-900/90 backdrop-blur-lg rounded-2xl overflow-hidden hover:shadow-md hover:border-purple-400/60 transition-all duration-500 ease-out border border-purple-500/40 relative group"
                 x-show="loaded"
                 x-transition:enter="transition-opacity duration-500 ease-out delay-100"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100">
                
                <div class="relative h-56 overflow-hidden bg-gray-800/50" x-data="{ imageLoaded: false }" x-init="setTimeout(() => imageLoaded = true, 500)">
                    <div class="absolute inset-0 skeleton-loading" x-show="!imageLoaded">
                        <div class="w-full h-full bg-gradient-to-br from-gray-700 to-gray-800/60 animate-pulse"></div>
                    </div>
                    @if($noticia->imagen)
                        <img src="{{ asset($noticia->imagen) }}" 
                             alt="{{ $noticia->titulo }}" 
                             class="w-full h-56 object-cover transform group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/90 via-gray-900/50 to-transparent"></div>
                    @else
                        <div class="w-full h-56 bg-gradient-to-br from-gray-800 to-gray-900 flex items-center justify-center">
                            <i class="fas fa-newspaper text-4xl text-gray-400/60"></i>
                        </div>
                    @endif
                </div>

                <div class="p-8 text-white">
                    <div class="flex items-center gap-3 text-sm text-gray-300 mb-4">
                        <div class="flex items-center gap-2 bg-gray-800/30 rounded-md px-3 py-1.5">
                            <i class="fas fa-calendar text-blue-400"></i>
                            <span>{{ \Carbon\Carbon::parse($noticia->fecha_publicacion)->format('d/m/Y') }}</span>
                        </div>
                        <div class="bg-blue-500/10 text-blue-300 px-3 py-1.5 rounded-md backdrop-blur-sm">
                            {{ $noticia->seccionNoticia ? $noticia->seccionNoticia->titulo : 'Sin sección' }}
                        </div>
                    </div>

                    <h3 class="text-2xl font-bold text-white-300 mb-3 line-clamp-2">{{ $noticia->titulo }}</h3>
                    <p class="text-gray-300 mb-6 line-clamp-3">{{ $noticia->descripcion }}</p>

                    <div class="space-y-4">
                        <div class="flex items-center text-sm text-gray-300 bg-gray-800/30 rounded-md p-2">
                            <i class="fas fa-user text-blue-400 mr-3"></i>
                            <span>{{ $noticia->autor_noticia }}</span>
                        </div>

                        <div class="flex justify-between items-center pt-4 border-t border-blue-500/30">
                            <a href="{{ route('admin.noticias.noticia.edit', $noticia) }}" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600/90 text-white rounded-lg hover:bg-blue-500/90 transition-all duration-200 backdrop-blur-sm">
                                <i class="fas fa-edit mr-2"></i>
                                <span>Editar</span>
                            </a>
                            <form action="{{ route('admin.noticias.noticia.destroy', $noticia) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="inline-flex items-center px-4 py-2 bg-red-600/90 text-white rounded-lg hover:bg-red-500/90 transition-all duration-200 backdrop-blur-sm"
                                        onclick="return confirm('¿Estás seguro de que deseas eliminar esta noticia?')">
                                    <i class="fas fa-trash mr-2"></i>
                                    <span>Eliminar</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <div class="bg-gray-800/50 backdrop-blur-sm rounded-lg p-8 max-w-2xl mx-auto border border-blue-500/30">
                    <i class="fas fa-newspaper text-5xl text-gray-400 mb-4"></i>
                    <h2 class="text-2xl font-semibold text-blue-300 mb-2">No hay noticias registradas</h2>
                    <p class="text-gray-300">Comienza creando una nueva noticia usando el botón "Nueva Noticia".</p>
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