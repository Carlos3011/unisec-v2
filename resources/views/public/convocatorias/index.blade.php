@extends('layouts.public')

@section('titulo', 'Convocatorias')

@section('contenido')
<div class="container mx-auto px-4 py-12 min-h-screen">
    <div class="relative mb-12 text-center">
        <div class="absolute inset-0 flex items-center justify-center opacity-10">
            <i class="fas fa-satellite text-8xl text-blue-200 transform rotate-45"></i>
        </div>
        <h1 class="text-4xl font-bold text-white mb-2 relative z-10">Convocatorias Disponibles</h1>
        <p class="text-blue-200 text-lg">Explora las oportunidades en ingeniería aeroespacial</p>
    </div>

    @if($convocatorias->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($convocatorias as $convocatoria)
                <div class="bg-gray-800/50 backdrop-blur-sm rounded-lg overflow-hidden hover:shadow-[0_0_15px_rgba(59,130,246,0.5)] hover:scale-[1.02] transition-all duration-300 border border-blue-500/30 relative group">
                    <div class="absolute top-4 right-4 z-20">
                        @if($convocatoria->asesor_requerido)
                            <span class="bg-yellow-500/80 text-white text-xs px-2 py-1 rounded-full backdrop-blur-sm">
                                <i class="fas fa-user-tie mr-1"></i>Asesor Requerido
                            </span>
                        @endif
                    </div>

                    @if($convocatoria->imagen_portada)
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ asset('storage/' . $convocatoria->imagen_portada) }}" 
                                 alt="{{ $convocatoria->nombre_evento }}" 
                                 class="w-full h-48 object-cover transform group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 to-transparent"></div>
                        </div>
                    @else
                        <div class="w-full h-48 bg-gray-900 flex items-center justify-center bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiPjxkZWZzPjxwYXR0ZXJuIGlkPSJzdGFycyIgeD0iMCIgeT0iMCIgd2lkdGg9IjIwIiBoZWlnaHQ9IjIwIiBwYXR0ZXJuVW5pdHM9InVzZXJTcGFjZU9uVXNlIj48cmVjdCB4PSIwIiB5PSIwIiB3aWR0aD0iMSIgaGVpZ2h0PSIxIiBmaWxsPSIjZmZmIiBvcGFjaXR5PSIwLjEiLz48L3BhdHRlcm4+PC9kZWZzPjxyZWN0IHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjc3RhcnMpIi8+PC9zdmc+')]">
                            <i class="fas fa-rocket text-4xl text-gray-400 transform -rotate-45"></i>
                        </div>
                    @endif

                    <div class="p-6 text-white">
                        <h2 class="text-xl font-semibold text-blue-300 mb-2">{{ $convocatoria->nombre_evento }}</h2>
                        
                        <div class="flex items-center text-sm text-gray-300 mb-3">
                            <i class="fas fa-map-marker-alt text-blue-400 mr-2"></i>
                            <span>{{ $convocatoria->sede }}</span>
                        </div>

                        <div class="flex items-center text-sm text-gray-300 mb-4">
                            <i class="fas fa-users text-blue-400 mr-2"></i>
                            <span>{{ $convocatoria->dirigido_a }}</span>
                        </div>

                        @if($convocatoria->fechasImportantes->isNotEmpty())
                            <div class="border-t border-blue-500/30 pt-4 mt-4">
                                <h3 class="text-lg font-semibold text-blue-200 mb-2">Fechas Importantes</h3>
                                <div class="space-y-2 max-h-24 overflow-y-auto scrollbar-thin scrollbar-thumb-blue-500/50 scrollbar-track-gray-800/50">
                                    @foreach($convocatoria->fechasImportantes->take(3) as $fecha)
                                        <div class="flex items-center text-sm text-gray-300">
                                            <i class="fas fa-calendar-alt mr-2 text-blue-500"></i>
                                            <span class="font-medium">{{ $fecha->titulo }}:</span>
                                            <span class="ml-2">{{ \Carbon\Carbon::parse($fecha->fecha)->format('d/m/Y') }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="mt-6 flex flex-wrap justify-between items-center gap-4">
                            <div class="flex items-center space-x-4">
                                <div class="text-sm text-blue-200">
                                    <i class="fas fa-users-cog mr-1"></i>
                                    <span>Máx. {{ $convocatoria->max_integrantes }}</span>
                                </div>
                                @if($convocatoria->contacto_email)
                                    <div class="text-sm text-blue-200">
                                        <i class="fas fa-envelope mr-1"></i>
                                        <span>Contacto disponible</span>
                                    </div>
                                @endif
                            </div>
                            <a href="{{ route('convocatorias.show', $convocatoria) }}" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600/80 text-white rounded-lg hover:bg-blue-500 hover:scale-105 transform transition-all duration-200 backdrop-blur-sm">
                                <i class="fas fa-info-circle mr-2"></i>Ver Detalles
                            </a>
                        </div>
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