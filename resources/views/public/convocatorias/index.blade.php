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
                <div class="bg-gradient-to-br from-gray-800/80 to-gray-900/80 backdrop-blur-sm rounded-xl overflow-hidden hover:shadow-[0_0_35px_rgba(191,0,255,0.4),0_0_50px_rgba(99,102,241,0.6)] hover:scale-[1.02] transition-all duration-300 border border-blue-500/30 relative group transform hover:-translate-y-1">
                    <div class="absolute top-4 right-4 z-20">
                        @if($convocatoria->asesor_requerido)
                            <span class="bg-gradient-to-r from-yellow-500/90 to-amber-500/90 text-white text-xs px-3 py-1.5 rounded-full backdrop-blur-sm shadow-lg">
                                <i class="fas fa-user-tie mr-1.5"></i>Asesor Requerido
                            </span>
                        @endif
                    </div>

                    @if($convocatoria->imagen_portada)
                        <div class="relative h-56 overflow-hidden">
                            <img src="{{ asset('storage/' . $convocatoria->imagen_portada) }}" 
                                 alt="{{ $convocatoria->nombre_evento }}" 
                                 class="w-full h-56 object-cover transform group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900/90 via-gray-900/50 to-transparent"></div>
                        </div>
                    @else
                        <div class="w-full h-56 bg-gradient-to-br from-gray-800 to-gray-900 flex items-center justify-center bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiPjxkZWZzPjxwYXR0ZXJuIGlkPSJzdGFycyIgeD0iMCIgeT0iMCIgd2lkdGg9IjIwIiBoZWlnaHQ9IjIwIiBwYXR0ZXJuVW5pdHM9InVzZXJTcGFjZU9uVXNlIj48cmVjdCB4PSIwIiB5PSIwIiB3aWR0aD0iMSIgaGVpZ2h0PSIxIiBmaWxsPSIjZmZmIiBvcGFjaXR5PSIwLjEiLz48L3BhdHRlcm4+PC9kZWZzPjxyZWN0IHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjc3RhcnMpIi8+PC9zdmc+')]">
                            <i class="fas fa-rocket text-5xl text-blue-400/80 transform -rotate-45 group-hover:scale-110 transition-transform duration-300"></i>
                        </div>
                    @endif

                    <div class="p-8 text-white">
                        <h2 class="text-2xl font-bold text-blue-300 mb-3 group-hover:text-blue-200 transition-colors duration-300">{{ $convocatoria->nombre_evento }}</h2>
                        
                        <div class="space-y-3 mb-6">
                            <div class="flex items-center text-sm text-gray-300 bg-gray-800/50 rounded-lg p-2.5">
                                <i class="fas fa-map-marker-alt text-blue-400 mr-3 text-base"></i>
                                <span>{{ $convocatoria->sede }}</span>
                            </div>

                            <div class="flex items-center text-sm text-gray-300 bg-gray-800/50 rounded-lg p-2.5">
                                <i class="fas fa-users text-blue-400 mr-3 text-base"></i>
                                <span>{{ $convocatoria->dirigido_a }}</span>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="flex flex-wrap gap-3">
                                <div class="flex items-center justify-between gap-3">
                                    <div class="text-sm text-blue-200 bg-blue-500/10 px-3 py-2 rounded-lg backdrop-blur-sm">
                                        <i class="fas fa-users-cog mr-2"></i>
                                        <span>Máx. {{ $convocatoria->max_integrantes }} integrantes</span>
                                    </div>
                                    @if($convocatoria->archivo_convocatoria)
                                        <a href="{{ asset('storage/' . $convocatoria->archivo_convocatoria) }}" target="_blank" class="text-sm text-red-300 bg-red-500/10 px-3 py-2 rounded-lg backdrop-blur-sm hover:bg-red-500/20 transition-all duration-200">
                                            <i class="fas fa-file-pdf mr-2"></i>
                                            <span>Convocatoria Completa</span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if($convocatoria->fechasImportantes->isNotEmpty())
                            <div class="border-t border-blue-500/30 pt-4 mt-4">
                                <h3 class="text-lg font-semibold text-blue-200 mb-3 flex items-center">
                                    <i class="fas fa-calendar-check text-blue-400 mr-2"></i>Fechas Importantes
                                </h3>
                                <div class="space-y-2.5 max-h-28 overflow-y-auto scrollbar-thin scrollbar-thumb-blue-500/50 scrollbar-track-gray-800/50 pr-2">
                                    @foreach($convocatoria->fechasImportantes->take(3) as $fecha)
                                        <div class="flex items-center text-sm text-gray-300 bg-gray-800/50 rounded-lg p-2.5 hover:bg-gray-700/50 transition-colors duration-200">
                                            <i class="fas fa-calendar-alt mr-3 text-blue-400"></i>
                                            <span class="font-medium text-blue-200">{{ $fecha->titulo }}:</span>
                                            <span class="ml-2">{{ \Carbon\Carbon::parse($fecha->fecha)->format('d/m/Y') }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                                <a href="{{ route('convocatorias.show', $convocatoria) }}" 
                                   class="mt-4 inline-flex items-center w-full justify-center px-6 py-3 bg-gradient-to-r from-blue-600/90 to-blue-500/90 text-white rounded-lg hover:from-blue-500/90 hover:to-blue-400/90 hover:scale-[1.02] transform transition-all duration-200 backdrop-blur-sm font-medium shadow-lg shadow-blue-500/20">
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