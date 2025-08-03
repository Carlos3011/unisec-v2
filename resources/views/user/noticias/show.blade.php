@extends('layouts.user')

@section('titulo', $noticia->titulo)

@section('contenido')
    <div class="min-h-screen py-12 relative overflow-hidden bg-gradient-to-b from-space-950 to-cosmic-900">
        <div class="container mx-auto px-4">
            <div
                class="max-w-4xl mx-auto bg-black/30 backdrop-blur-xl rounded-2xl overflow-hidden border border-white/10 relative transition-all duration-300 hover:border-white/20 hover:shadow-[0_0_30px_rgba(147,51,234,0.3)]">
                <!-- Navegación -->
                <div class="p-6">
                    <a href="{{ route('blog') }}"
                        class="text-white/90 hover:text-white flex items-center gap-2 bg-white/5 px-4 py-2 rounded-lg w-fit transition-all duration-300 hover:bg-white/10">
                        <i class="fas fa-arrow-left"></i>
                        <span>Volver a Noticias</span>
                    </a>
                </div>

                <!-- Encabezado de la Noticia -->
                <div class="relative overflow-hidden mb-6">
                    @if($noticia->imagen)
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent z-10"></div>
                        <img src="{{ asset( $noticia->imagen) }}" alt="{{ $noticia->titulo }}"
                            class="w-full h-80 object-cover">

                        <!-- Información de la Imagen -->
                        @if($noticia->descripcion_imagen || $noticia->autor_imagen)
                            <div class="relative z-20 px-8 py-4 bg-black/30 backdrop-blur-sm border-t border-white/10">
                                @if($noticia->descripcion_imagen)
                                    <p class="text-white/90 text-sm mb-1 text-justify"><span class="font-medium">Descripción:</span>
                                        {{ $noticia->descripcion_imagen }}</p>
                                @endif
                                @if($noticia->autor_imagen)
                                    <p class="text-white/90 text-sm"><span class="font-medium">Créditos:</span>
                                        {{ $noticia->autor_imagen }}</p>
                                @endif
                            </div>
                        @endif
                    @endif

                    <div class="relative z-20 p-8">
                        <h1 class="text-5xl font-bold text-white mb-4 text-center drop-shadow-lg">{{ $noticia->titulo }}
                        </h1>
                        <div class="flex flex-wrap gap-4 text-sm text-white/90 justify-center">
                            <div
                                class="flex items-center space-x-3 bg-white/5 px-4 py-2 rounded-lg transition-all duration-300 hover:bg-white/10">
                                <i class="far fa-calendar text-blue-400 text-xl"></i>
                                <span class="text-lg font-medium">{{ $noticia->fecha_publicacion->format('d/m/Y') }}</span>
                            </div>
                            <div
                                class="flex items-center space-x-3 bg-white/5 px-4 py-2 rounded-lg transition-all duration-300 hover:bg-white/10">
                                <i class="far fa-folder text-purple-400 text-xl"></i>
                                <span class="text-lg font-medium">{{ $noticia->seccionNoticia->titulo }}</span>
                            </div>
                            <div
                                class="flex items-center space-x-3 bg-white/5 px-4 py-2 rounded-lg transition-all duration-300 hover:bg-white/10">
                                <i class="far fa-user text-blue-400 text-xl"></i>
                                <span class="text-lg font-medium">{{ $noticia->autor_noticia }}</span>
                            </div>
                        </div>

                        <p class="text-white/90 text-lg mt-6 text-center">{{ $noticia->descripcion }}</p>
                    </div>
                </div>

                <!-- Contenido Principal -->
                <div class="space-y-8 p-8">
                    <div
                        class="bg-white/5 rounded-xl p-6 border border-white/10 transition-all duration-300 hover:bg-white/10 hover:border-white/20">
                        <div class="prose prose-lg prose-invert max-w-none text-white/90 text-justify">
                            {!! nl2br(e($noticia->contenido)) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection