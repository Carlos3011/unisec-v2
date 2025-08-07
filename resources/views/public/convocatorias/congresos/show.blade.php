@extends('layouts.public')

@section('titulo', $convocatoria->congreso->nombre)

@section('contenido')
<div class="min-h-screen py-12 relative overflow-hidden bg-gradient-to-b from-space-950 to-cosmic-900">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto bg-black/30 backdrop-blur-xl rounded-2xl overflow-hidden border border-white/10 relative transition-all duration-300 hover:border-white/20 hover:shadow-[0_0_30px_rgba(245,158,11,0.3)]">
            <!-- Navegación -->
            <div class="p-6">
                <a href="{{route('convocatorias.index')}}" class="text-white/90 hover:text-white flex items-center gap-2 bg-white/5 px-4 py-2 rounded-lg w-fit transition-all duration-300 hover:bg-white/10">
                    <i class="fas fa-arrow-left"></i>
                    <span>Volver a Convocatorias</span>
                </a>
            </div>

            <!-- Encabezado de la Convocatoria -->
            <div class="relative overflow-hidden mb-6">
                @if($convocatoria->imagen_portada)
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent z-10"></div>
                    <img src="{{ asset('system/public/'.$convocatoria->imagen_portada) }}" 
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
                @if($convocatoria->contacto_email)
                    <div class="bg-gradient-to-r from-amber-500/10 to-orange-500/10 rounded-xl p-6 border border-amber-400/30 hover:border-amber-400/50 transition-all duration-300 transform hover:scale-[1.02] hover:shadow-[0_0_30px_rgba(245,158,11,0.2)]">
                        <h2 class="text-2xl font-semibold text-white mb-6 flex items-center">
                            <i class="fas fa-envelope-open mr-3 text-amber-400 text-2xl"></i>Contáctanos
                        </h2>
                        <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                            <div class="prose prose-lg prose-invert max-w-none text-white/90 text-justify bg-black/30 p-6 rounded-lg border border-white/10 flex-1">
                                <p class="mb-4">Para la generación de las ligas de pago, te pedimos que nos escribas desde tu cuenta institucional a este correo.</p>
                                <a href="mailto:{{ $convocatoria->contacto_email }}" class="text-amber-400 hover:text-amber-300 transition-colors duration-300 flex items-center justify-center gap-2">
                                    <i class="fas fa-paper-plane"></i>
                                    {{ $convocatoria->contacto_email }}
                                </a>
                            </div>
                            <a href="mailto:{{ $convocatoria->contacto_email }}" aria-label="Contactar por correo electrónico"
                                class="group relative p-6 min-w-[220px] transition-all duration-500 hover:scale-[1.05] focus:outline-none focus:ring-2 focus:ring-amber-400 focus:ring-offset-2 focus:ring-offset-space-900 rounded-2xl">
                                <div class="absolute inset-0 rounded-2xl xl:rounded-3xl overflow-hidden">
                                    <div class="absolute inset-0 bg-gradient-to-br from-amber-600/90 to-orange-600/90"></div>
                                    <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-15"></div>
                                    <div class="absolute inset-0 bg-gradient-to-br from-amber-400/30 to-orange-500/30 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                </div>
                                <div class="relative flex flex-col items-center space-y-4 z-10">
                                    <div class="p-4 bg-gradient-to-br from-white/15 to-white/25 rounded-full border-2 border-white/30 group-hover:border-amber-300/60 transition-all shadow-lg shadow-amber-500/10 group-hover:shadow-amber-500/30">
                                        <i class="fas fa-envelope text-3xl text-amber-300 group-hover:text-amber-200 transition-colors"></i>
                                    </div>
                                    <span class="text-xl font-bold text-white group-hover:text-amber-100 transition-colors">Enviar correo</span>
                                    <span class="text-sm text-white/90 font-medium text-center">Respuesta rápida</span>
                                    <div class="absolute -bottom-2 h-1 w-16 bg-amber-400 rounded-full opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:translate-y-1"></div>
                                </div>
                                <div class="absolute inset-0 rounded-2xl border-2 border-white/20 group-hover:border-amber-300/40 transition-all duration-500"></div>
                                <div class="absolute inset-0 rounded-2xl shadow-lg opacity-0 group-hover:opacity-100 group-hover:shadow-[0_0_30px_-5px_rgba(245,158,11,0.4)] transition-all duration-500"></div>
                            </a>
                        </div>
                    </div>
                @endif  
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

                <div class="bg-gradient-to-r from-amber-500/10 to-orange-500/10 rounded-xl p-6 border border-amber-400/30 hover:border-amber-400/50 transition-all duration-300 transform hover:scale-[1.02] hover:shadow-[0_0_30px_rgba(245,158,11,0.2)]">
                    <h2 class="text-2xl font-semibold text-white mb-6 flex items-center">
                        <i class="fas fa-book mr-3 text-amber-400 text-2xl"></i>Temática 1 : Ingeniería Cosmonáutica UNISEC-MX
                    </h2>
                    <div class="space-y-6">
                         <!-- Temática 1 -->
                        <div class="bg-black/30 p-6 rounded-lg border border-white/10 prose prose-invert max-w-none">
                            <h3 class="text-white text-xl font-bold">Sistemas Cosmonáuticos</h3>
                            <ul class="text-white/90 text-justify list-disc list-inside">
                                <li>Sistema de suministro de energía</li>
                                <li>Sistema de gestión térmica</li>
                                <li>Sistema de computadora de abordo</li>
                                <li>Sistema de telemetría y comando</li>
                                <li>Sistema de control y estabilización</li>
                            </ul>
                        </div>

                        <!-- Temática 2 -->
                        <div class="bg-black/30 p-6 rounded-lg border border-white/10 prose prose-invert max-w-none">
                            <h3 class="text-white text-xl font-bold">Sistemas Aeronáuticos</h3>
                            <ul class="text-white/90 text-justify list-disc list-inside">
                                <li>Aerodinámica</li>
                                <li>Mecánica de fluidos</li>
                                <li>Estructuras aeronáuticas</li>
                                <li>Sistemas de propulsión</li>
                                <li>Electrónica y aviónica</li>
                            </ul>
                        </div>

                        <!-- Temática 3 -->
                        <div class="bg-black/30 p-6 rounded-lg border border-white/10 prose prose-invert max-w-none">
                            <h3 class="text-white text-xl font-bold">Propulsión (Cosmonáutica y Tecnologías Subsónicas e Hipersónicas)</h3>
                            <ul class="text-white/90 text-justify list-disc list-inside">
                                <li>Motores (scramjet y ramjet)</li>
                                <li>Propulsión híbrida y eléctrica</li>
                                <li>Combustibles sostenibles para aviación (y cohetes)</li>
                                <li>Cámaras de combustión sónica e hipersónicas</li>
                            </ul>
                        </div>

                        <!-- Temática 4 -->
                        <div class="bg-black/30 p-6 rounded-lg border border-white/10 prose prose-invert max-w-none">
                            <h3 class="text-white text-xl font-bold">Diseño y Simulación de Estructuras Aeroespaciales</h3>
                            <ul class="text-white/90 text-justify list-disc list-inside">
                                <li>Materiales compuestos y metamateriales</li>
                                <li>IA en simulaciones estructurales</li>
                                <li>Optimización y aligeramiento de estructuras</li>
                                <li>Estructuras aeronáuticas con algoritmos genéticos</li>
                                <li>CFD y aeroelasticidad</li>
                                <li>Gemelos digitales estructurales</li>
                            </ul>
                        </div>

                        <!-- Temática 5 -->
                        <div class="bg-black/30 p-6 rounded-lg border border-white/10 prose prose-invert max-w-none">
                            <h3 class="text-white text-xl font-bold">Historia de la Cosmonáutica y Legado de la Aviación Mexicana</h3>
                            <ul class="text-white/90 text-justify list-disc list-inside">
                                <li>Pioneros de la cosmonáutica</li>
                                <li>Pioneros de la aviación en México</li>
                                <li>Desarrollo de la industria aeronáutica nacional</li>
                                <li>Contribuciones de México a la aviación</li>
                            </ul>
                        </div>
                    </div>
                </div>

                @if(is_array($convocatoria->tematicas) && count($convocatoria->tematicas) > 0)
                    <div class="bg-gradient-to-r from-amber-500/10 to-orange-500/10 rounded-xl p-6 border border-amber-400/30 hover:border-amber-400/50 transition-all duration-300 transform hover:scale-[1.02] hover:shadow-[0_0_30px_rgba(245,158,11,0.2)]">
                        <h2 class="text-2xl font-semibold text-white mb-6 flex items-center">
                            <i class="fas fa-book mr-3 text-amber-400 text-2xl"></i>Temática 2
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
                                    <a href="{{ asset('system/public/'.$convocatoria->archivo_convocatoria) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-amber-500/20 text-amber-400 rounded-lg hover:bg-amber-500/30 transition-colors duration-200">

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
                                    <a href="{{ asset('system/public/'.$convocatoria->archivo_articulo) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-amber-500/20 text-amber-400 rounded-lg hover:bg-amber-500/30 transition-colors duration-200">

                                        <i class="fas fa-eye mr-2"></i>Visualizar
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

    <!-- Sección de Registro -->
    @guest
    <div class="max-w-4xl mx-auto mt-8 p-8 bg-black/30 backdrop-blur-xl rounded-2xl border border-white/10 hover:border-white/20 transition-all duration-300 hover:shadow-[0_0_30px_rgba(245,158,11,0.3)]">
        <div class="text-center space-y-6">
            <h2 class="text-3xl font-bold text-white">¿Listo para participar?</h2>
            <p class="text-xl text-white/80">Únete a este congreso y comparte tus investigaciones con la comunidad académica</p>
            <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-amber-600 to-orange-600 text-white text-lg font-semibold rounded-xl hover:from-amber-700 hover:to-orange-700 transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-[0_0_30px_rgba(245,158,11,0.5)]">
                <i class="fas fa-user-plus mr-3"></i>
                Regístrate para Participar
            </a>
        </div>
    </div>
    @endguest
</div>
@endsection