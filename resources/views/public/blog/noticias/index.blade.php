@extends('layouts.public')

@section('titulo', 'Blog')

@section('contenido')
<!-- HERO -->
<section class="relative bg-gradient-to-br from-cosmic-300 via-space-700 to-cosmic-900 py-24 overflow-hidden" data-aos="fade-down" data-aos-duration="1000">
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

<section class="py-24 bg-gradient-to-b from-space-950 to-cosmic-900">
    <div class="container mx-auto px-6 lg:px-8">
        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($noticias as $noticia)
                <article class="group bg-black/30 backdrop-blur-xl rounded-2xl overflow-hidden border border-white/10 shadow-lg transform transition-all duration-500 hover:scale-[1.02] hover:border-white/20 hover:shadow-[0_0_40px_rgba(59,130,246,0.3)]">
                    <div class="relative overflow-hidden aspect-video">
                        @if($noticia->imagen)
                            <img src="{{ asset( $noticia->imagen) }}" alt="{{ $noticia->titulo }}" class="w-full h-full object-cover transform transition-transform duration-500 group-hover:scale-110">
                        @else
                            <img src="{{ asset('images/exoplanetas.jpg') }}" alt="Imagen por defecto" class="w-full h-full object-cover transform transition-transform duration-500 group-hover:scale-110">
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    </div>
                    <div class="p-8">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm text-gray-400">{{ $noticia->fecha_publicacion->format('d M, Y') }}</span>
                            <span class="px-3 py-1 text-sm bg-primary/20 text-primary rounded-full border border-primary/30">{{ $noticia->seccionNoticia->titulo }}</span>
                        </div>
                        <h2 class="text-2xl font-bold text-white mb-4 line-clamp-2 group-hover:text-primary transition-colors duration-300">{{ $noticia->titulo }}</h2>
                        <p class="text-gray-300 mb-6 line-clamp-3">
                            {{ Str::limit($noticia->descripcion, 150) }}
                        </p>
                        <a href="{{ route('noticias.show', $noticia->id) }}" class="inline-flex items-center text-primary font-medium hover:text-white transition-colors duration-300">
                            Leer más
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 transform transition-transform duration-300 group-hover:translate-x-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
                </article>
            @empty
                <div class="col-span-3 text-center py-16 bg-black/30 backdrop-blur-xl rounded-2xl border border-white/10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15" />
                    </svg>
                    <p class="text-xl text-gray-300">No hay noticias disponibles en este momento.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
