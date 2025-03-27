@extends('layouts.public')

@section('titulo', 'Blog')

@section('contenido')
<!-- HERO -->
<section class="relative bg-gradient-to-br from-cosmic-300 via-space-700 to-cosmic-900 py-24 overflow-hidden" data-aos="fade-down" data-aos-duration="1000">
    <!-- Imagen de fondo semitransparente -->
    <div class="absolute inset-0">
        <img src="{{ asset('images/sistema-solar.webp') }}" alt="Blog Hero" class="w-full h-full object-cover opacity-30">
    </div>
    <div class="relative container mx-auto px-6 text-center">
        <h1 class="text-6xl font-bold text-white mb-4 drop-shadow-lg">Blog de UNISEC</h1>
        <p class="text-xl text-white max-w-2xl mx-auto">
            Últimas noticias y artículos de interés sobre exploración espacial, tecnología y avances en la industria aeroespacial
        </p>
    </div>
</section>

<!-- SECCIÓN DE ARTÍCULOS -->
<section class="py-24">
    <div class="container mx-auto px-6 lg:px-8">
        <div class="grid gap-12 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($noticias as $noticia)
                <article class="bg-gray-800 rounded-2xl overflow-hidden shadow-lg transform transition duration-300 hover:scale-105 hover:shadow-[0_0_30px_rgba(59,130,246,0.5)] hover:ring-2 hover:ring-blue-500/50">
                    @if($noticia->imagen)
                        <img src="{{ asset('storage/' . $noticia->imagen) }}" alt="{{ $noticia->titulo }}" class="w-full h-48 object-cover">
                    @else
                        <img src="{{ asset('images/exoplanetas.jpg') }}" alt="Imagen por defecto" class="w-full h-48 object-cover">
                    @endif
                    <div class="p-6">
                        <h2 class="text-2xl font-bold text-white mb-2 text-justify">{{ $noticia->titulo }}</h2>
                        <p class="text-gray-300 mb-4 text-justify">
                            {{ Str::limit($noticia->descripcion, 150) }}
                        </p>
                        <div class="flex justify-between items-center text-sm text-gray-400 mb-4">
                            <span>{{ $noticia->fecha_publicacion->format('d/m/Y') }}</span>
                            <span class="bg-primary px-2 py-1 rounded text-white">{{ $noticia->seccionNoticia->titulo }}</span>
                        </div>
                        <a href="{{ route('noticias.show', $noticia->id) }}" class="text-primary font-semibold hover:underline hover:text-primary transition-colors duration-200">Leer más</a>
                    </div>
                </article>
            @empty
                <div class="col-span-3 text-center py-8">
                    <p class="text-gray-300 text-xl">No hay noticias disponibles en este momento.</p>
                </div>
            @endforelse
        </div>

        <!-- PAGINACIÓN (OPCIONAL) -->
        <div class="mt-16 flex justify-center">
            <nav class="inline-flex">
                <a href="#" class="px-4 py-2 mx-1 bg-gray-700 text-white rounded hover:bg-gray-600 transition-colors">Anterior</a>
                <a href="#" class="px-4 py-2 mx-1 bg-primary text-white rounded hover:bg-primary/80 transition-colors">1</a>
                <a href="#" class="px-4 py-2 mx-1 bg-gray-700 text-white rounded hover:bg-gray-600 transition-colors">2</a>
                <a href="#" class="px-4 py-2 mx-1 bg-gray-700 text-white rounded hover:bg-gray-600 transition-colors">3</a>
                <a href="#" class="px-4 py-2 mx-1 bg-gray-700 text-white rounded hover:bg-gray-600 transition-colors">Siguiente</a>
            </nav>
        </div>
    </div>
</section>
@endsection
