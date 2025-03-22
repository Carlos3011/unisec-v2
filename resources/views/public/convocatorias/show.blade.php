@extends('layouts.public')

@section('titulo', $convocatoria->nombre_evento)

@section('contenido')
<div class="min-h-screen  py-12 relative overflow-hidden">
    <!-- Efecto de estrellas animadas -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSIjRkZGIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxjaXJjbGUgY3g9IjUiIGN5PSI1IiByPSIxIi8+PC9nPjwvc3ZnPg==')] opacity-50 animate-twinkle"></div>
    </div>
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto bg-black/40 backdrop-blur-2xl rounded-3xl shadow-[0_0_50px_rgba(191,0,255,0.3)] overflow-hidden border border-white/20 relative">
            <!-- Efecto de brillo en los bordes -->
            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-blue-500/10 to-transparent blur-xl"></div>
            <!-- Encabezado -->
            <div class="relative overflow-hidden mb-8">
                @if($convocatoria->imagen_portada)
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent z-10"></div>
                    <img src="{{ asset('storage/' . $convocatoria->imagen_portada) }}" 
                         alt="{{ $convocatoria->nombre_evento }}" 
                         class="w-full h-80 object-cover">
                @endif
                <div class="relative z-20 p-8">
                    <h1 class="text-7xl font-bold text-white mb-4 text-center drop-shadow-lg">{{ $convocatoria->nombre_evento }}</h1>
                    <div class="flex flex-wrap gap-6 text-sm text-white/90">
                        <div class="flex items-center space-x-3 bg-white/10 backdrop-blur-sm px-4 py-2 rounded-xl">
                            <i class="fas fa-rocket text-blue-400 text-xl"></i>
                            <span class="text-lg font-medium">{{ $convocatoria->sede }}</span>
                        </div>
                        <div class="flex items-center space-x-3 bg-white/10 backdrop-blur-sm px-4 py-2 rounded-xl">
                            <i class="fas fa-users-gear text-purple-400 text-xl"></i>
                            <span class="text-lg font-medium">Máximo {{ $convocatoria->max_integrantes }} integrantes</span>
                        </div>
                        @if($convocatoria->asesor_requerido)
                            <div class="flex items-center space-x-3 bg-white/10 backdrop-blur-sm px-4 py-2 rounded-xl">
                                <i class="fas fa-user-astronaut text-blue-400 text-xl"></i>
                                <span class="text-lg font-medium">Requiere asesor</span>
                            </div>
                        @endif
                        @if($convocatoria->contacto_email)
                            <div class="flex items-center space-x-3 bg-white/10 backdrop-blur-sm px-4 py-2 rounded-xl">
                                <i class="fas fa-envelope text-purple-400 text-xl"></i>
                                <span class="text-lg font-medium">{{ $convocatoria->contacto_email }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Fechas importantes -->
            <div class="space-y-6 p-8">
            <div class="bg-white/10 backdrop-blur-2xl rounded-2xl p-6 border border-white/20 hover:border-blue-400/50 hover:shadow-[0_0_30px_rgba(191,0,255,0.3)] transition-all duration-300 transform hover:-translate-y-1">
                    <h2 class="text-xl font-semibold text-white mb-4 flex items-center">
                        <i class="fas fa-meteor text-blue-400 mr-2"></i>Fechas Importantes
                    </h2>
                    @if($convocatoria->fechasImportantes->isNotEmpty())
                        <ul class="space-y-3">
                            @foreach($convocatoria->fechasImportantes as $fecha)
                                <li class="flex items-center text-white/90">
                                    <i class="fas fa-star text-purple-400 mr-2"></i>
                                    <div>
                                        <span class="font-medium">{{ $fecha->titulo }}</span>
                                        <br>
                                        <span class="text-sm text-white/70">{{ \Carbon\Carbon::parse($fecha->fecha)->format('d/m/Y') }}</span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-white/50">No hay fechas importantes registradas</p>
                    @endif
            </div>
            </div>

            <!-- Información Principal -->
            <div class="p-8 relative max-w-3xl mx-auto">
                <!-- Documentos con efecto hover mejorado -->
                <div class="bg-white/10 backdrop-blur-xl rounded-2xl p-6 border border-white/20 hover:border-blue-400/50 hover:shadow-[0_0_30px_rgba(191,0,255,0.3)] transition-all duration-300 transform hover:-translate-y-1">
                    <h2 class="text-xl font-semibold text-white mb-4 flex items-center">
                        <i class="fas fa-satellite text-blue-400 mr-2"></i>Documentos
                    </h2>
                    <ul class="space-y-3">
                        @if($convocatoria->archivo_convocatoria)
                            <li>
                                <a href="{{ asset('storage/' . $convocatoria->archivo_convocatoria) }}" target="_blank" 
                                   class="flex items-center text-red-400 hover:text-blue-300 transition-colors duration-200">
                                    <i class="fas fa-file-pdf mr-2"></i>
                                    <span>Convocatoria Completa</span>
                                </a>
                            </li>
                        @endif
                        @if($convocatoria->archivo_pdr)
                            <li>
                                <a href="{{ asset('storage/' . $convocatoria->archivo_pdr) }}" target="_blank"
                                   class="flex items-center text-blue-400 hover:text-blue-800">
                                    <i class="fas fa-file-pdf mr-2"></i>
                                    <span>PDR</span>
                                </a>
                            </li>
                        @endif
                        @if($convocatoria->archivo_cdr)
                            <li>
                                <a href="{{ asset('storage/' . $convocatoria->archivo_cdr) }}" target="_blank"
                                   class="flex items-center text-green-400 hover:text-blue-800">
                                    <i class="fas fa-file-pdf mr-2"></i>
                                    <span>CDR</span>
                                </a>
                            </li>
                        @endif
                        @if($convocatoria->archivo_pfr)
                            <li>
                                <a href="{{ asset('storage/' . $convocatoria->archivo_pfr) }}" target="_blank"
                                   class="flex items-center text-purple-400 hover:text-blue-800">
                                    <i class="fas fa-file-pdf mr-2"></i>
                                    <span>PFR</span>
                                </a>
                            </li>
                        @endif
                        @if($convocatoria->archivo_articulo)
                            <li>
                                <a href="{{ asset('storage/' . $convocatoria->archivo_articulo) }}" target="_blank"
                                   class="flex items-center text-yellow-400 hover:text-blue-800">
                                    <i class="fas fa-file-pdf mr-2"></i>
                                    <span>Artículo</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>

            <!-- Detalles -->
            <div class="space-y-6 p-8">
                <!-- Dirigido a -->
                <div class="bg-white/10 backdrop-blur-2xl rounded-2xl p-6 border border-white/20 hover:border-blue-400/50 hover:shadow-[0_0_30px_rgba(191,0,255,0.3)] transition-all duration-300 transform hover:-translate-y-1">
                    <h2 class="text-xl font-semibold text-white mb-4 flex items-center">
                        <i class="fas fa-user-astronaut text-blue-400 mr-2"></i>Dirigido a
                    </h2>
                    <p class="text-white/90">{{ $convocatoria->dirigido_a }}</p>
                </div>

                <!-- Requisitos -->
                <div class="bg-white/10 backdrop-blur-2xl rounded-2xl p-6 border border-white/20 hover:border-blue-400/50 hover:shadow-[0_0_30px_rgba(191,0,255,0.3)] transition-all duration-300 transform hover:-translate-y-1">
                    <h2 class="text-xl font-semibold text-white mb-4 flex items-center">
                        <i class="fas fa-clipboard-list text-purple-400 mr-2"></i>Requisitos
                    </h2>
                    <div class="prose max-w-none text-white/80">
                        {!! nl2br(e($convocatoria->requisitos)) !!}
                    </div>
                </div>

                <!-- Etapas de la Misión -->
                <div class="bg-white/10 backdrop-blur-2xl rounded-2xl p-6 border border-white/20 hover:border-blue-400/50 hover:shadow-[0_0_30px_rgba(191,0,255,0.3)] transition-all duration-300 transform hover:-translate-y-1">
                    <h2 class="text-xl font-semibold text-white mb-4 flex items-center">
                        <i class="fas fa-space-shuttle text-blue-400 mr-2"></i>Etapas de la Misión
                    </h2>
                    <div class="prose max-w-none text-white/80">
                        {!! nl2br(e($convocatoria->etapas_mision)) !!}
                    </div>
                </div>

                <!-- Pruebas Requeridas -->
                <div class="bg-white/10 backdrop-blur-2xl rounded-2xl p-6 border border-white/20 hover:border-blue-400/50 hover:shadow-[0_0_30px_rgba(191,0,255,0.3)] transition-all duration-300 transform hover:-translate-y-1">
                    <h2 class="text-xl font-semibold text-white mb-4 flex items-center">
                        <i class="fas fa-vial text-purple-400 mr-2"></i>Pruebas Requeridas
                    </h2>
                    <div class="prose max-w-none text-white/80">
                        {!! nl2br(e($convocatoria->pruebas_requeridas)) !!}
                    </div>
                </div>

                <!-- Documentación Requerida -->
                <div class="bg-white/10 backdrop-blur-2xl rounded-2xl p-6 border border-white/20 hover:border-blue-400/50 hover:shadow-[0_0_30px_rgba(191,0,255,0.3)] transition-all duration-300 transform hover:-translate-y-1">
                    <h2 class="text-xl font-semibold text-white mb-4 flex items-center">
                        <i class="fas fa-file-alt text-blue-400 mr-2"></i>Documentación Requerida
                    </h2>
                    <div class="prose max-w-none text-white/80">
                        {!! nl2br(e($convocatoria->documentacion_requerida)) !!}
                    </div>
                </div>

                <!-- Criterios de Evaluación -->
                <div class="bg-white/10 backdrop-blur-2xl rounded-2xl p-6 border border-white/20 hover:border-blue-400/50 hover:shadow-[0_0_30px_rgba(191,0,255,0.3)] transition-all duration-300 transform hover:-translate-y-1">
                    <h2 class="text-xl font-semibold text-white mb-4 flex items-center">
                        <i class="fas fa-star-half-alt text-purple-400 mr-2"></i>Criterios de Evaluación
                    </h2>
                    <div class="prose max-w-none text-white/80">
                        {!! nl2br(e($convocatoria->criterios_evaluacion)) !!}
                    </div>
                </div>

                @if($convocatoria->premiacion)
                    <!-- Premiación -->
                    <div class="bg-white/10 backdrop-blur-2xl rounded-2xl p-6 border border-white/20 hover:border-blue-400/50 hover:shadow-[0_0_30px_rgba(191,0,255,0.3)] transition-all duration-300 transform hover:-translate-y-1">
                        <h2 class="text-xl font-semibold text-white mb-4 flex items-center">
                            <i class="fas fa-trophy text-blue-400 mr-2"></i>Premiación
                        </h2>
                        <div class="prose max-w-none text-white/80">
                            {!! nl2br(e($convocatoria->premiacion)) !!}
                        </div>
                    </div>
                @endif

                @if($convocatoria->penalizaciones)
                    <!-- Penalizaciones -->
                    <div class="bg-white/10 backdrop-blur-2xl rounded-2xl p-6 border border-white/20 hover:border-blue-400/50 hover:shadow-[0_0_30px_rgba(191,0,255,0.3)] transition-all duration-300 transform hover:-translate-y-1">
                        <h2 class="text-xl font-semibold text-white mb-4 flex items-center">
                            <i class="fas fa-exclamation-triangle text-purple-400 mr-2"></i>Penalizaciones
                        </h2>
                        <div class="prose max-w-none text-white/80">
                            {!! nl2br(e($convocatoria->penalizaciones)) !!}
                        </div>
                    </div>
                @endif
            </div>

            <!-- Galería de Imágenes -->
            @if($convocatoria->imagenes->isNotEmpty())
                <div class="mt-8 p-8">
                    <h2 class="text-2xl font-semibold text-white mb-6 flex items-center">
                        <i class="fas fa-images text-blue-400 mr-2"></i>Galería
                    </h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                        @foreach($convocatoria->imagenes as $imagen)
                            <div class="relative aspect-w-16 aspect-h-9 group overflow-hidden rounded-xl">
                                <img src="{{ asset('storage/' . $imagen->imagen) }}" 
                                     alt="Imagen de la convocatoria"
                                     class="object-cover w-full h-full transform group-hover:scale-110 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Botón Volver -->
            <div class="mt-8 text-center p-8">
                <a href="{{ route('convocatorias') }}" class="inline-flex items-center px-6 py-3 bg-purple-600 text-white rounded-full hover:bg-purple-500 transition-colors duration-200 group">
                    <i class="fas fa-rocket mr-2 transform group-hover:-translate-x-1 transition-transform duration-200"></i>
                    Volver a Convocatorias
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Botón de Inscripción Flotante -->
<div class="fixed sm:bottom-8 sm:right-8 bottom-4 right-4 z-50 w-full sm:w-auto px-4 sm:px-0">
    <a href="#" class="group relative inline-flex items-center w-full sm:w-auto justify-center px-4 sm:px-8 py-3 sm:py-4 bg-blue-600/30 backdrop-blur-xl text-white rounded-full overflow-hidden border border-white/20 hover:bg-blue-500/40 hover:border-blue-400/50 hover:shadow-[0_0_30px_rgba(191,0,255,0.3)] transition-all duration-300 animate-pulse-slow">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-600/20 via-purple-500/20 to-blue-600/20 animate-shimmer"></div>
        <i class="fas fa-rocket mr-2 sm:mr-3 text-sm sm:text-base transform group-hover:rotate-12 transition-transform duration-300"></i>
        <span class="font-semibold tracking-wide text-sm sm:text-base">Inscribirse a la Misión</span>
    </a>
</div>

<style>
@keyframes pulse-slow {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}
.animate-pulse-slow {
    animation: pulse-slow 3s infinite;
}
@keyframes shimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}
.animate-shimmer {
    animation: shimmer 3s infinite;
}
</style>
@endsection
@endofphp