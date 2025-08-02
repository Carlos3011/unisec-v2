@extends('layouts.user')

@section('titulo', $convocatoria->congreso->nombre)

@section('contenido')
    <div class="min-h-screen py-12 relative overflow-hidden bg-gradient-to-b from-space-950 to-cosmic-900">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto bg-black/30 backdrop-blur-xl rounded-2xl overflow-hidden border border-white/10 relative transition-all duration-300 hover:border-white/20 hover:shadow-[0_0_30px_rgba(245,158,11,0.3)]">
                <!-- Navegación -->
                <div class="p-6">
                    <a href="{{route('user.congresos.index')}}" class="text-white/90 hover:text-white flex items-center gap-2 bg-white/5 px-4 py-2 rounded-lg w-fit transition-all duration-300 hover:bg-white/10">
                        <i class="fas fa-arrow-left"></i>
                        <span>Volver a Congresos</span>
                    </a>
                </div>
                <!-- Encabezado de la Convocatoria -->
                <div class="relative overflow-hidden mb-6">
                    @if($convocatoria->imagen_portada)
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent z-10"></div>
                        <img src="{{ asset($convocatoria->imagen_portada) }}" 
                            alt="{{ $convocatoria->congreso->nombre }}" 
                            class="w-full h-80 object-cover">
                    @endif

                    <div class="relative z-20 p-8">
                        <h1 class="text-5xl font-bold text-white mb-4 text-center drop-shadow-lg">{{ $convocatoria->congreso->nombre }}</h1>
                        
                        <!-- Información del Congreso -->
                        <div class="mb-8 grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="bg-gradient-to-r from-amber-500/20 to-orange-500/20 rounded-xl p-6 border border-amber-400/30 hover:border-amber-400/50 transition-all duration-300 transform hover:scale-105">
                                <div class="flex flex-col items-center text-center">
                                    <i class="fas fa-calendar-day text-amber-400 text-4xl mb-3"></i>
                                    <h3 class="text-xl font-semibold text-white mb-2">Fecha de Inicio</h3>
                                    <p class="text-3xl font-bold text-amber-400">{{ \Carbon\Carbon::parse($convocatoria->congreso->fecha_inicio)->format('d/m/Y') }}</p>
                                </div>
                            </div>
                            <div class="bg-gradient-to-r from-orange-500/20 to-red-500/20 rounded-xl p-6 border border-orange-400/30 hover:border-orange-400/50 transition-all duration-300 transform hover:scale-105">
                                <div class="flex flex-col items-center text-center">
                                    <i class="fas fa-calendar-check text-orange-400 text-4xl mb-3"></i>
                                    <h3 class="text-xl font-semibold text-white mb-2">Fecha de Fin</h3>
                                    <p class="text-3xl font-bold text-orange-400">{{ \Carbon\Carbon::parse($convocatoria->congreso->fecha_fin)->format('d/m/Y') }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex flex-wrap gap-4 text-sm text-white/90 justify-center">
                            <div class="flex items-center space-x-3 bg-white/5 px-4 py-2 rounded-lg transition-all duration-300 hover:bg-white/10">
                                <i class="fas fa-map-marker-alt text-amber-400 text-xl"></i>
                                <span class="text-lg font-medium">{{ $convocatoria->sede }}</span>
                            </div>
                            <div class="flex items-center space-x-3 bg-white/5 px-4 py-2 rounded-lg transition-all duration-300 hover:bg-white/10">
                                <i class="fas fa-users text-amber-400 text-xl"></i>
                                <span class="text-lg font-medium">{{ $convocatoria->dirigido_a }}</span>
                            </div>
                            @if($convocatoria->contacto_email)
                                <div class="flex items-center space-x-3 bg-white/5 px-4 py-2 rounded-lg transition-all duration-300 hover:bg-white/10">
                                    <i class="fas fa-envelope text-amber-400 text-xl"></i>
                                    <span class="text-lg font-medium">{{ $convocatoria->contacto_email }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="space-y-8 p-8">
                    <!-- Fechas Importantes -->
                    <div class="bg-gradient-to-r from-amber-500/10 to-orange-500/10 rounded-xl p-6 border border-amber-400/30 hover:border-amber-400/50 transition-all duration-300 transform hover:scale-[1.02] hover:shadow-[0_0_30px_rgba(245,158,11,0.2)]">
                        <h2 class="text-2xl font-semibold text-white mb-6 flex items-center">
                            <i class="fas fa-calendar-alt mr-3 text-amber-400 text-2xl"></i>Fechas Importantes
                        </h2>
                        <div class="grid gap-4">
                            @forelse($convocatoria->fechasImportantes as $fecha)
                                <div class="flex items-center justify-between text-white/90 bg-black/30 p-4 rounded-lg border border-white/10 hover:border-amber-400/30 transition-all duration-300">
                                    <span class="text-lg font-medium">{{ $fecha->titulo }}</span>
                                    <span class="text-amber-400 font-semibold">{{ $fecha->fecha->format('d/m/Y') }}</span>
                                </div>
                            @empty
                                <p class="text-white/60 text-center py-4">No hay fechas importantes registradas</p>
                            @endforelse
                        </div>
                    </div>

                    @if($convocatoria->requisitos)
                    <div class="bg-gradient-to-r from-amber-500/10 to-orange-500/10 rounded-xl p-6 border border-amber-400/30 hover:border-amber-400/50 transition-all duration-300 transform hover:scale-[1.02] hover:shadow-[0_0_30px_rgba(245,158,11,0.2)]">
                        <h2 class="text-2xl font-semibold text-white mb-6 flex items-center">
                            <i class="fas fa-clipboard-list mr-3 text-amber-400 text-2xl"></i>Requisitos
                        </h2>
                        <div class="prose prose-lg prose-invert max-w-none text-white/90 text-justify bg-black/30 p-6 rounded-lg border border-white/10">
                            {!! $convocatoria->requisitos !!}
                        </div>
                    </div>
                    @endif

                    @if(is_array($convocatoria->tematicas) && count($convocatoria->tematicas) > 0)
                        <div class="bg-gradient-to-r from-amber-500/10 to-orange-500/10 rounded-xl p-6 border border-amber-400/30 hover:border-amber-400/50 transition-all duration-300 transform hover:scale-[1.02] hover:shadow-[0_0_30px_rgba(245,158,11,0.2)]">
                            <h2 class="text-2xl font-semibold text-white mb-6 flex items-center">
                                <i class="fas fa-book mr-3 text-amber-400 text-2xl"></i>Temáticas
                            </h2>
                            <div class="space-y-6">
                                @foreach($convocatoria->tematicas as $tematica)
                                    <div class="bg-black/30 p-6 rounded-lg border border-white/10 prose prose-invert max-w-none">
                                        <h3 class="text-white text-xl font-bold">{{ $tematica['titulo'] ?? '' }}</h3>
                                        <p class="text-white/90 text-justify">{{ $tematica['descripcion'] ?? '' }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($convocatoria->criterios_evaluacion)
                    <div class="bg-gradient-to-r from-amber-500/10 to-orange-500/10 rounded-xl p-6 border border-amber-400/30 hover:border-amber-400/50 transition-all duration-300 transform hover:scale-[1.02] hover:shadow-[0_0_30px_rgba(245,158,11,0.2)]">
                        <h2 class="text-2xl font-semibold text-white mb-6 flex items-center">
                            <i class="fas fa-star mr-3 text-amber-400 text-2xl"></i>Criterios de Evaluación
                        </h2>
                        <div class="prose prose-lg prose-invert max-w-none text-white/90 text-justify bg-black/30 p-6 rounded-lg border border-white/10">
                            {!! $convocatoria->criterios_evaluacion !!}
                        </div>
                    </div>
                    @endif

                    @if($convocatoria->formato_articulo)
                    <div class="bg-gradient-to-r from-amber-500/10 to-orange-500/10 rounded-xl p-6 border border-amber-400/30 hover:border-amber-400/50 transition-all duration-300 transform hover:scale-[1.02] hover:shadow-[0_0_30px_rgba(245,158,11,0.2)]">
                        <h2 class="text-2xl font-semibold text-white mb-6 flex items-center">
                            <i class="fas fa-file-alt mr-3 text-amber-400 text-2xl"></i>Formato del Artículo
                        </h2>
                        <div class="prose prose-lg prose-invert max-w-none text-white/90 text-justify bg-black/30 p-6 rounded-lg border border-white/10">
                            {!! $convocatoria->formato_articulo !!}
                        </div>
                    </div>
                    @endif

                    @if($convocatoria->formato_extenso)
                    <div class="bg-gradient-to-r from-amber-500/10 to-orange-500/10 rounded-xl p-6 border border-amber-400/30 hover:border-amber-400/50 transition-all duration-300 transform hover:scale-[1.02] hover:shadow-[0_0_30px_rgba(245,158,11,0.2)]">
                        <h2 class="text-2xl font-semibold text-white mb-6 flex items-center">
                            <i class="fas fa-file-alt mr-3 text-amber-400 text-2xl"></i>Formato Extenso
                        </h2>
                        <div class="prose prose-lg prose-invert max-w-none text-white/90 text-justify bg-black/30 p-6 rounded-lg border border-white/10">
                            {!! $convocatoria->formato_extenso !!}
                        </div>
                    </div>
                    @endif

                    <!-- Documentos de la Convocatoria -->
                    <div class="bg-white/5 rounded-xl p-6 border border-white/10 transition-all duration-300 hover:bg-white/10 hover:border-white/20">
                        <h2 class="text-xl font-semibold text-white mb-4 flex items-center">
                            <i class="fas fa-file-pdf mr-2 text-amber-400"></i>Documentos de la Convocatoria
                        </h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @if($convocatoria->archivo_convocatoria)
                                <div class="bg-black/30 p-4 rounded-xl border border-white/10 hover:border-amber-400/50 transition-all duration-300">
                                    <div class="flex flex-col items-center text-center space-y-3">
                                        <i class="fas fa-file-pdf text-amber-400 text-3xl"></i>
                                        <span class="text-white/90 font-medium">Convocatoria</span>
                                        <a href="{{ asset($convocatoria->archivo_convocatoria) }}" class="inline-flex items-center px-4 py-2 bg-amber-500/20 text-amber-400 rounded-lg hover:bg-amber-500/30 transition-colors duration-200">
                                        <i class="fas fa-eye mr-2"></i>Visualizar
                                        </a>
                                    </div>
                                </div>
                            @endif

                            @if($convocatoria->archivo_articulo)
                                <div class="bg-black/30 p-4 rounded-xl border border-white/10 hover:border-amber-400/50 transition-all duration-300">
                                    <div class="flex flex-col items-center text-center space-y-3">
                                        <i class="fas fa-file-pdf text-amber-400 text-3xl"></i>
                                        <span class="text-white/90 font-medium">Formato de Artículo</span>
                                        <a href="{{ asset($convocatoria->archivo_articulo) }}" class="inline-flex items-center px-4 py-2 bg-amber-500/20 text-amber-400 rounded-lg hover:bg-amber-500/30 transition-colors duration-200">
                                            <i class="fas fa-eye mr-2"></i>Visualizar
                                        </a>
                                    </div>
                                </div>
                            @endif

                            @if($convocatoria->archivo_formato_extenso)
                                <div class="bg-black/30 p-4 rounded-xl border border-white/10 hover:border-amber-400/50 transition-all duration-300">
                                    <div class="flex flex-col items-center text-center space-y-3">
                                        <i class="fas fa-file-pdf text-amber-400 text-3xl"></i>
                                        <span class="text-white/90 font-medium">Formato Extenso</span>
                                        <a href="{{ route('user.congresos.convocatorias.download.formato-extenso', $convocatoria) }}" class="inline-flex items-center px-4 py-2 bg-amber-500/20 text-amber-400 rounded-lg hover:bg-amber-500/30 transition-colors duration-200">
                                            <i class="fas fa-download mr-2"></i>Descargar
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Información de Costos -->
                    @if($convocatoria->costo_inscripcion || $convocatoria->cuotas_inscripcion)
                    <div class="bg-gradient-to-r from-amber-500/10 to-orange-500/10 rounded-xl p-6 border border-amber-400/30 hover:border-amber-400/50 transition-all duration-300 transform hover:scale-[1.02] hover:shadow-[0_0_30px_rgba(245,158,11,0.2)]">
                        <h2 class="text-2xl font-semibold text-white mb-6 flex items-center">
                            <i class="fas fa-money-bill-wave mr-3 text-amber-400 text-2xl"></i>Costos de Inscripción
                        </h2>
                        <div class="space-y-4">
                            @if($convocatoria->costo_inscripcion)
                                <div class="bg-black/30 p-4 rounded-lg border border-white/10">
                                    <h3 class="text-xl font-semibold text-white mb-2">Costo General</h3>
                                    <p class="text-3xl font-bold text-amber-400">${{ number_format($convocatoria->costo_inscripcion, 2) }}</p>
                                </div>
                            @endif

                            @if($convocatoria->cuotas_inscripcion)
                                <div class="bg-black/30 p-4 rounded-lg border border-white/10">
                                    <h3 class="text-xl font-semibold text-white mb-2">Cuotas Disponibles</h3>
                                    <div class="space-y-2">
                                        @foreach($convocatoria->cuotas_inscripcion as $cuota)
                                            <div class="flex items-center justify-between text-white/90">
                                                <span class="text-lg">{{ $cuota['rol'] }}</span>
                                                <span class="text-amber-400 font-semibold">${{ number_format($cuota['monto'], 2) }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Botón de Inscripción con PayPal -->
        @auth
            @php
                $pagoConfirmado = \App\Models\PagoInscripcionCongreso::where('usuario_id', Auth::id())
                    ->where('congreso_id', $convocatoria->congreso->id)
                    ->where('estado_pago', 'pagado')
                    ->exists();
            @endphp
            <div class="fixed bottom-8 right-8 z-50">
                @php
                    $inscripcion = \App\Models\InscripcionCongreso::where('usuario_id', Auth::id())
                        ->where('congreso_id', $convocatoria->congreso->id)
                        ->first();
                @endphp

                @if($pagoConfirmado)
                    @if($inscripcion)
                        <a href="{{ route('user.congresos.inscripciones.show', $inscripcion->id) }}"
                           class="group flex items-center gap-3 px-6 py-3 bg-gradient-to-r from-emerald-600 to-green-600 rounded-xl text-white font-semibold shadow-lg hover:shadow-emerald-500/25 transition-all duration-300 hover:scale-105">
                            <i class="fas fa-eye text-2xl"></i>
                            <span>Ver Inscripción</span>
                        </a>
                    @else
                        <a href="{{ route('user.congresos.inscripciones.create', ['convocatoria' => $convocatoria->id]) }}"
                           class="group flex items-center gap-3 px-6 py-3 bg-gradient-to-r from-amber-600 to-orange-600 rounded-xl text-white font-semibold shadow-lg hover:shadow-amber-500/25 transition-all duration-300 hover:scale-105">
                            <i class="fas fa-user-plus text-2xl"></i>
                            <span>Completar Inscripción</span>
                        </a>
                    @endif
                @else
                @endif
            </div>
        @else
            <div class="fixed bottom-8 right-8 z-50">
                <a href="{{ route('login') }}" 
                   class="group flex items-center gap-3 px-6 py-3 bg-gradient-to-r from-gray-600 to-gray-700 rounded-xl text-white font-semibold shadow-lg hover:shadow-gray-500/25 transition-all duration-300 hover:scale-105">
                    <i class="fas fa-sign-in-alt text-2xl"></i>
                    <span>Iniciar Sesión para Inscribirse</span>
                </a>
            </div>
        @endauth
    </div>
@endsection