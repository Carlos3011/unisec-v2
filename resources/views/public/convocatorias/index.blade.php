@extends('layouts.public')

@section('titulo', 'Convocatorias')

@section('contenido')
<div class="container mx-auto px-4 sm:px-6 py-16 min-h-screen" x-data="{ stagger: 0 }">
    <div class="relative mb-12 text-center">
        <h1 class="text-5xl font-black bg-gradient-to-r from-blue-400 to-purple-300 bg-clip-text text-transparent mb-2 relative z-10 tracking-tight">Convocatorias Disponibles</h1>
        <p class="text-blue-200 text-lg">Explora las oportunidades en ingeniería aeroespacial</p>
    </div>

    @if($convocatorias->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 100)">
            @foreach($convocatorias as $convocatoria)
                <div class="bg-gradient-to-br from-gray-900/90 via-gray-800/95 to-gray-900/90 backdrop-blur-xl rounded-2xl overflow-hidden hover:shadow-[0_8px_30px_rgb(59,130,246,0.15)] border border-blue-500/20 transition-all duration-500 ease-out relative group hover:-translate-y-1 hover:border-blue-400/30"
                     x-show="loaded"
                     x-transition:enter="transition-opacity duration-500 ease-out delay-100"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100">
                    <div class="absolute top-4 right-4 z-20">
                        @if($convocatoria->asesor_requerido)
                            <span class="bg-gradient-to-r from-amber-400/90 to-yellow-500/90 text-white text-xs px-4 py-1.5 rounded-full backdrop-blur-sm shadow-lg font-medium">
                                <i class="fas fa-user-tie mr-2"></i>Asesor Requerido
                            </span>
                        @endif
                    </div>

                    @if($convocatoria->imagen_portada)
                        <div class="relative h-56 overflow-hidden" x-data="{ imageLoaded: false }" x-init="setTimeout(() => imageLoaded = true, 500)">
                            <div class="absolute inset-0 bg-gradient-to-br from-gray-700 to-gray-800/60 animate-pulse" x-show="!imageLoaded"></div>
                            <img src="{{ asset('storage/' . $convocatoria->imagen_portada) }}" 
                                 alt="{{ $convocatoria->nombre_evento }}" 
                                 class="w-full h-56 object-cover transform group-hover:scale-105 transition-transform duration-700 ease-out">
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/50 to-transparent opacity-90"></div>
                        </div>
                    @else
                        <div class="w-full h-56 bg-gradient-to-br from-gray-800 to-gray-900 flex items-center justify-center bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiPjxkZWZzPjxwYXR0ZXJuIGlkPSJzdGFycyIgeD0iMCIgeT0iMCIgd2lkdGg9IjIwIiBoZWlnaHQ9IjIwIiBwYXR0ZXJuVW5pdHM9InVzZXJTcGFjZU9uVXNlIj48cmVjdCB4PSIwIiB5PSIwIiB3aWR0aD0iMSIgaGVpZ2h0PSIxIiBmaWxsPSIjZmZmIiBvcGFjaXR5PSIwLjEiLz48L3BhdHRlcm4+PC9kZWZzPjxyZWN0IHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjc3RhcnMpIi8+PC9zdmc+')]">
                            <i class="fas fa-rocket text-5xl text-blue-400/40 group-hover:text-blue-400/60 transition-all duration-300 transform group-hover:scale-110"></i>
                        </div>
                    @endif

                    <div class="p-8 text-white space-y-6">
                        <h2 class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400">{{ $convocatoria->concurso->titulo }}</h2>
                        
                        <div class="space-y-3">
                            <div class="flex items-center text-sm text-gray-300 bg-white/5 rounded-lg p-3 backdrop-blur-sm hover:bg-white/10 transition-colors duration-300">
                                <i class="fas fa-map-marker-alt text-blue-400 mr-3 text-base"></i>
                                <span>{{ $convocatoria->sede }}</span>
                            </div>

                            <div class="flex items-center text-sm text-gray-300 bg-white/5 rounded-lg p-3 backdrop-blur-sm hover:bg-white/10 transition-colors duration-300">
                                <i class="fas fa-users text-blue-400 mr-3 text-base"></i>
                                <span>{{ $convocatoria->dirigido_a }}</span>
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-4">
                            <div class="text-sm text-blue-300 bg-blue-500/10 px-4 py-2 rounded-lg backdrop-blur-sm border border-blue-500/20 hover:bg-blue-500/20 transition-all duration-300">
                                <i class="fas fa-users-cog mr-2"></i>
                                <span>Máx. {{ $convocatoria->max_integrantes }} integrantes</span>
                            </div>
                            @if($convocatoria->archivo_convocatoria)
                                <a href="{{ asset('storage/' . $convocatoria->archivo_convocatoria) }}" target="_blank" 
                                   class="text-sm text-red-300 bg-red-500/10 px-4 py-2 rounded-lg backdrop-blur-sm border border-red-500/20 hover:bg-red-500/20 transition-all duration-300 inline-flex items-center">
                                    <i class="fas fa-file-pdf mr-2"></i>
                                    <span>Convocatoria Completa</span>
                                </a>
                            @endif
                        </div>

                        @if($convocatoria->fechasImportantes->isNotEmpty())
                            <div class="border-t border-blue-500/20 pt-4 mt-4">
                                <h3 class="text-lg font-semibold text-blue-300 mb-4 flex items-center">
                                    <i class="fas fa-calendar-check text-blue-400 mr-2"></i>Fechas Importantes
                                </h3>
                                <div class="space-y-3 max-h-32 overflow-y-auto scrollbar-thin scrollbar-thumb-blue-500/20 scrollbar-track-blue-500/5 pr-2">
                                    @foreach($convocatoria->fechasImportantes->take(3) as $fecha)
                                        <div class="flex items-center text-sm text-gray-300 bg-white/5 rounded-lg p-3 backdrop-blur-sm hover:bg-white/10 transition-colors duration-300 border border-transparent hover:border-blue-500/20">
                                            <i class="fas fa-calendar-alt mr-3 text-blue-400"></i>
                                            <span class="font-medium text-blue-200">{{ $fecha->titulo }}:</span>
                                            <span class="ml-2">{{ \Carbon\Carbon::parse($fecha->fecha)->format('d/m/Y') }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <a href="{{ route('convocatorias.show', $convocatoria) }}" 
                           class="mt-6 inline-flex items-center w-full justify-center px-6 py-3 bg-gradient-to-r from-blue-600/90 to-blue-700/90 text-white rounded-lg hover:from-blue-500/90 hover:to-blue-600/90 transform transition-all duration-300 backdrop-blur-sm font-medium shadow-lg shadow-blue-500/20 group">
                            <i class="fas fa-info-circle mr-2 group-hover:rotate-12 transition-transform duration-300"></i>Ver Detalles
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12">
            <div class="bg-gray-800/50 backdrop-blur-sm rounded-lg p-8 max-w-2xl mx-auto border border-blue-500/30">
                <i class="fas fa-folder-open text-5xl text-gray-400 mb-4"></i>
                <h2 class="text-2xl font-semibold text-blue-300 mb-2">No hay convocatorias disponibles</h2>
                <p class="text-gray-300">En este momento no hay convocatorias abiertas. Por favor, vuelve a consultar más tarde.</p>
            </div>
        </div>
    @endif
</div>
@endsection