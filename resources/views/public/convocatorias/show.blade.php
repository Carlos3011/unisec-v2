@extends('layouts.public')

@section('titulo', $convocatoria->nombre_evento)

@section('contenido')
<div class="min-h-screen py-12 relative overflow-hidden bg-gradient-to-b from-space-950 to-cosmic-900">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto bg-black/30 backdrop-blur-xl rounded-2xl overflow-hidden border border-white/10 relative transition-all duration-300 hover:border-white/20">
            <!-- Efecto de brillo en los bordes -->
            
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
                    <div class="flex flex-wrap gap-4 text-sm text-white/90">
                        <div class="flex items-center space-x-3 bg-white/5 px-4 py-2 rounded-lg transition-all duration-300 hover:bg-white/10">
                            <i class="fas fa-rocket text-blue-400 text-xl"></i>
                            <span class="text-lg font-medium">{{ $convocatoria->sede }}</span>
                        </div>
                        <div class="flex items-center space-x-3 bg-white/5 px-4 py-2 rounded-lg transition-all duration-300 hover:bg-white/10">
                            <i class="fas fa-users-gear text-purple-400 text-xl"></i>
                            <span class="text-lg font-medium">Máximo {{ $convocatoria->max_integrantes }} integrantes</span>
                        </div>
                        @if($convocatoria->asesor_requerido)
                            <div class="flex items-center space-x-3 bg-white/5 px-4 py-2 rounded-lg transition-all duration-300 hover:bg-white/10">
                                <i class="fas fa-user-astronaut text-blue-400 text-xl"></i>
                                <span class="text-lg font-medium">Requiere asesor</span>
                            </div>
                        @endif
                        @if($convocatoria->contacto_email)
                            <div class="flex items-center space-x-3 bg-white/5 px-4 py-2 rounded-lg transition-all duration-300 hover:bg-white/10">
                                <i class="fas fa-envelope text-purple-400 text-xl"></i>
                                <span class="text-lg font-medium">{{ $convocatoria->contacto_email }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Fechas importantes -->
            <div class="space-y-8 p-8">
                <div class="bg-white/5 rounded-xl p-6 border border-white/10 transition-all duration-300 hover:bg-white/10 hover:border-white/20">
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
                        <i class="fas fa-satellite text-blue-400 mr-2"></i>Documentos de la Misión
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @if($convocatoria->archivo_convocatoria)
                            <div class="group relative bg-white/5 rounded-lg p-4 border border-white/10 transition-all duration-300 hover:bg-white/10" x-data="{ tooltip: false }" @mouseenter="tooltip = true" @mouseleave="tooltip = false">
                                <div class="absolute -top-2 -right-2 bg-red-400/20 text-red-400 text-xs px-2 py-1 rounded-full">Principal</div>
                                <div class="flex flex-col items-center text-center space-y-3">
                                    <i class="fas fa-file-pdf text-red-400 text-3xl group-hover:scale-110 transition-transform duration-300"></i>
                                    <span class="text-white/90 font-medium">Convocatoria</span>
                                    <a href="{{ asset('storage/' . $convocatoria->archivo_convocatoria) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-red-500/20 text-red-400 rounded-lg hover:bg-red-500/30 transition-colors duration-200">
                                        <i class="fas fa-download mr-2"></i>Descargar
                                    </a>
                                </div>
                                <div x-show="tooltip" class="absolute -top-12 left-1/2 transform -translate-x-1/2 bg-black/80 text-white text-sm px-3 py-1 rounded-lg z-10">Documento principal con toda la información</div>
                            </div>
                        @endif
                
                        @if($convocatoria->archivo_pdr)
                            <div class="group relative bg-white/5 rounded-xl p-4 border border-white/10 hover:border-blue-400/50 hover:bg-white/10 transition-all duration-300 transform hover:-translate-y-1" x-data="{ tooltip: false }" @mouseenter="tooltip = true" @mouseleave="tooltip = false">
                                <div class="absolute -top-2 -right-2 bg-blue-400/20 text-blue-400 text-xs px-2 py-1 rounded-full">Fase 1</div>
                                <div class="flex flex-col items-center text-center space-y-3">
                                    <i class="fas fa-file-pdf text-blue-400 text-3xl group-hover:scale-110 transition-transform duration-300"></i>
                                    <span class="text-white/90 font-medium">PDR</span>
                                    <a href="{{ asset('storage/' . $convocatoria->archivo_pdr) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-500/20 text-blue-400 rounded-lg hover:bg-blue-500/30 transition-colors duration-200">
                                        <i class="fas fa-download mr-2"></i>Descargar
                                    </a>
                                </div>
                                <div x-show="tooltip" class="absolute -top-12 left-1/2 transform -translate-x-1/2 bg-black/80 text-white text-sm px-3 py-1 rounded-lg z-10">Preliminary Design Review</div>
                            </div>
                        @endif
                
                        @if($convocatoria->archivo_cdr)
                            <div class="group relative bg-white/5 rounded-xl p-4 border border-white/10 hover:border-green-400/50 hover:bg-white/10 transition-all duration-300 transform hover:-translate-y-1" x-data="{ tooltip: false }" @mouseenter="tooltip = true" @mouseleave="tooltip = false">
                                <div class="absolute -top-2 -right-2 bg-green-400/20 text-green-400 text-xs px-2 py-1 rounded-full">Fase 2</div>
                                <div class="flex flex-col items-center text-center space-y-3">
                                    <i class="fas fa-file-pdf text-green-400 text-3xl group-hover:scale-110 transition-transform duration-300"></i>
                                    <span class="text-white/90 font-medium">CDR</span>
                                    <a href="{{ asset('storage/' . $convocatoria->archivo_cdr) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-green-500/20 text-green-400 rounded-lg hover:bg-green-500/30 transition-colors duration-200">
                                        <i class="fas fa-download mr-2"></i>Descargar
                                    </a>
                                </div>
                                <div x-show="tooltip" class="absolute -top-12 left-1/2 transform -translate-x-1/2 bg-black/80 text-white text-sm px-3 py-1 rounded-lg z-10">Critical Design Review</div>
                            </div>
                        @endif
                
                        @if($convocatoria->archivo_pfr)
                            <div class="group relative bg-white/5 rounded-xl p-4 border border-white/10 hover:border-purple-400/50 hover:bg-white/10 transition-all duration-300 transform hover:-translate-y-1" x-data="{ tooltip: false }" @mouseenter="tooltip = true" @mouseleave="tooltip = false">
                                <div class="absolute -top-2 -right-2 bg-purple-400/20 text-purple-400 text-xs px-2 py-1 rounded-full">Fase 3</div>
                                <div class="flex flex-col items-center text-center space-y-3">
                                    <i class="fas fa-file-pdf text-purple-400 text-3xl group-hover:scale-110 transition-transform duration-300"></i>
                                    <span class="text-white/90 font-medium">PFR</span>
                                    <a href="{{ asset('storage/' . $convocatoria->archivo_pfr) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-purple-500/20 text-purple-400 rounded-lg hover:bg-purple-500/30 transition-colors duration-200">
                                        <i class="fas fa-download mr-2"></i>Descargar
                                    </a>
                                </div>
                                <div x-show="tooltip" class="absolute -top-12 left-1/2 transform -translate-x-1/2 bg-black/80 text-white text-sm px-3 py-1 rounded-lg z-10">Post Flight Review</div>
                            </div>
                        @endif
                
                        @if($convocatoria->archivo_articulo)
                            <div class="group relative bg-white/5 rounded-xl p-4 border border-white/10 hover:border-yellow-400/50 hover:bg-white/10 transition-all duration-300 transform hover:-translate-y-1" x-data="{ tooltip: false }" @mouseenter="tooltip = true" @mouseleave="tooltip = false">
                                <div class="absolute -top-2 -right-2 bg-yellow-400/20 text-yellow-400 text-xs px-2 py-1 rounded-full">Extra</div>
                                <div class="flex flex-col items-center text-center space-y-3">
                                    <i class="fas fa-file-pdf text-yellow-400 text-3xl group-hover:scale-110 transition-transform duration-300"></i>
                                    <span class="text-white/90 font-medium">Artículo</span>
                                    <a href="{{ asset('storage/' . $convocatoria->archivo_articulo) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-yellow-500/20 text-yellow-400 rounded-lg hover:bg-yellow-500/30 transition-colors duration-200">
                                        <i class="fas fa-download mr-2"></i>Descargar
                                    </a>
                                </div>
                                <div x-show="tooltip" class="absolute -top-12 left-1/2 transform -translate-x-1/2 bg-black/80 text-white text-sm px-3 py-1 rounded-lg z-10">Artículo científico del proyecto</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Detalles -->
            <div class="space-y-6 p-8">
                <!-- Dirigido a -->
                <div class="bg-white/5 rounded-xl p-6 border border-white/10 transition-all duration-300 hover:bg-white/10 hover:border-white/20">
                    <h2 class="text-xl font-semibold text-white mb-4 flex items-center">
                        <i class="fas fa-user-astronaut text-blue-400 mr-2"></i>Dirigido a
                    </h2>
                    <p class="text-white/90">{{ $convocatoria->dirigido_a }}</p>
                </div>

                <!-- Requisitos -->
                <div class="bg-white/5 rounded-xl p-6 border border-white/10 transition-all duration-300 hover:bg-white/10 hover:border-white/20">
                    <h2 class="text-xl font-semibold text-white mb-4 flex items-center">
                        <i class="fas fa-clipboard-list text-purple-400 mr-2"></i>Requisitos
                    </h2>
                    <div class="prose max-w-none text-white/80">
                        {!! nl2br(e($convocatoria->requisitos)) !!}
                    </div>
                </div>

                <!-- Etapas de la Misión -->
                <div class="bg-white/5 rounded-xl p-6 border border-white/10 transition-all duration-300 hover:bg-white/10 hover:border-white/20">
                    <h2 class="text-xl font-semibold text-white mb-4 flex items-center">
                        <i class="fas fa-space-shuttle text-blue-400 mr-2"></i>Etapas de la Misión
                    </h2>
                    <div class="prose max-w-none text-white/80">
                        {!! nl2br(e($convocatoria->etapas_mision)) !!}
                    </div>
                </div>

                <!-- Pruebas Requeridas -->
                <div class="bg-white/5 rounded-xl p-6 border border-white/10 transition-all duration-300 hover:bg-white/10 hover:border-white/20">
                    <h2 class="text-xl font-semibold text-white mb-4 flex items-center">
                        <i class="fas fa-vial text-purple-400 mr-2"></i>Pruebas Requeridas
                    </h2>
                    <div class="prose max-w-none text-white/80">
                        {!! nl2br(e($convocatoria->pruebas_requeridas)) !!}
                    </div>
                </div>

                <!-- Documentación Requerida -->
                <div class="bg-white/5 rounded-xl p-6 border border-white/10 transition-all duration-300 hover:bg-white/10 hover:border-white/20">
                    <h2 class="text-xl font-semibold text-white mb-4 flex items-center">
                        <i class="fas fa-file-alt text-blue-400 mr-2"></i>Documentación Requerida
                    </h2>
                    <div class="prose max-w-none text-white/80">
                        {!! nl2br(e($convocatoria->documentacion_requerida)) !!}
                    </div>
                </div>

                <!-- Criterios de Evaluación -->
                <div class="bg-white/5 rounded-xl p-6 border border-white/10 transition-all duration-300 hover:bg-white/10 hover:border-white/20">
                    <h2 class="text-xl font-semibold text-white mb-4 flex items-center">
                        <i class="fas fa-star-half-alt text-purple-400 mr-2"></i>Criterios de Evaluación
                    </h2>
                    <div class="prose max-w-none text-white/80">
                        {!! nl2br(e($convocatoria->criterios_evaluacion)) !!}
                    </div>
                </div>

                @if($convocatoria->premiacion)
                    <!-- Premiación -->
                    <div class="bg-white/5 rounded-xl p-6 border border-white/10 transition-all duration-300 hover:bg-white/10 hover:border-white/20">
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
                    <div class="bg-white/5 rounded-xl p-6 border border-white/10 transition-all duration-300 hover:bg-white/10 hover:border-white/20">
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
                <a href="{{ route('convocatorias') }}" class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-cosmic-900 via-purple-600 to-cosmic-900 text-white rounded-xl shadow-lg hover:shadow-2xl overflow-hidden transition-all duration-500 transform hover:scale-[1.02] hover:-translate-y-1 group relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-cosmic-800/30 via-purple-500/30 to-cosmic-800/30 animate-pulse opacity-0 group-hover:opacity-75 transition-opacity duration-500"></div>
                    <i class="fas fa-arrow-left mr-3 text-blue-300 group-hover:text-blue-200 transform group-hover:-translate-x-1 transition-all duration-300 ease-out"></i>
                    <span class="font-medium tracking-wide">Volver a Convocatorias</span>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Botón de Inscripción -->
<div class="mt-8 text-center">
    <a href="#" class="group relative inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-cosmic-900 via-primary-600 to-cosmic-900 text-white rounded-xl shadow-lg hover:shadow-2xl overflow-hidden transition-all duration-500 transform hover:scale-[1.02] hover:-translate-y-1">
        <div class="absolute inset-0 bg-gradient-to-r from-cosmic-800/30 via-primary-500/30 to-cosmic-800/30 animate-pulse opacity-75"></div>
        <i class="fas fa-rocket mr-3 text-base transform group-hover:rotate-12 transition-transform duration-500 text-cyan-300"></i>
        <span class="font-bold tracking-wider text-base">Inscribirse a la Misión</span>
    </a>
</div>


@endsection