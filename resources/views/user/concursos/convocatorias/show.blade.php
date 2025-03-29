@extends('layouts.user')

@section('titulo', $convocatoria->concurso->titulo)

@section('contenido')
<div class="min-h-screen py-12 relative overflow-hidden bg-gradient-to-b from-space-950 to-cosmic-900">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto bg-black/30 backdrop-blur-xl rounded-2xl overflow-hidden border border-white/10 relative transition-all duration-300 hover:border-white/20 hover:shadow-[0_0_30px_rgba(147,51,234,0.3)]">
            <!-- Navegación -->
            <div class="p-6">
                <a href="{{ route('user.concursos.index') }}" class="text-white/90 hover:text-white flex items-center gap-2 bg-white/5 px-4 py-2 rounded-lg w-fit transition-all duration-300 hover:bg-white/10">
                    <i class="fas fa-arrow-left"></i>
                    <span>Volver a Concursos</span>
                </a>
            </div>
            <!-- Encabezado de la Convocatoria -->
            <div class="relative overflow-hidden mb-6">
                @if($convocatoria->imagen_portada)
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent z-10"></div>
                    <img src="{{ Storage::url($convocatoria->imagen_portada) }}" 
                         alt="{{ $convocatoria->concurso->titulo }}" 
                         class="w-full h-80 object-cover">
                @endif

                <div class="relative z-20 p-8">
                    <h1 class="text-5xl font-bold text-white mb-4 text-center drop-shadow-lg">{{ $convocatoria->concurso->titulo }}</h1>
                    <div class="flex flex-wrap gap-4 text-sm text-white/90 justify-center">
                        <div class="flex items-center space-x-3 bg-white/5 px-4 py-2 rounded-lg transition-all duration-300 hover:bg-white/10">
                            <i class="fas fa-map-marker-alt text-blue-400 text-xl"></i>
                            <span class="text-lg font-medium">{{ $convocatoria->sede }}</span>
                        </div>
                        <div class="flex items-center space-x-3 bg-white/5 px-4 py-2 rounded-lg transition-all duration-300 hover:bg-white/10">
                            <i class="fas fa-users text-purple-400 text-xl"></i>
                            <span class="text-lg font-medium">{{ $convocatoria->dirigido_a }}</span>
                        </div>
                        <div class="flex items-center space-x-3 bg-white/5 px-4 py-2 rounded-lg transition-all duration-300 hover:bg-white/10">
                            <i class="fas fa-user-friends text-blue-400 text-xl"></i>
                            <span class="text-lg font-medium">Máximo {{ $convocatoria->max_integrantes }} integrantes</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Fechas Importantes -->
            <div class="space-y-8 p-8">
                <div class="bg-white/5 rounded-xl p-6 border border-white/10 transition-all duration-300 hover:bg-white/10 hover:border-white/20">
                    <h2 class="text-xl font-semibold text-white mb-4 flex items-center">
                        <i class="fas fa-calendar-alt mr-2 text-blue-400"></i>Fechas Importantes
                    </h2>
                    <div class="grid gap-4">
                        @forelse($convocatoria->fechasImportantes as $fecha)
                            <div class="flex items-center justify-between text-white/90 border-b border-white/10 pb-2">
                                <span>{{ $fecha->titulo }}</span>
                                <span class="text-blue-400">{{ $fecha->fecha->format('d/m/Y') }}</span>
                            </div>
                        @empty
                            <p class="text-white/60 text-center">No hay fechas importantes registradas</p>
                        @endforelse
                    </div>
                </div>

                @if($convocatoria->requisitos)
                <div class="bg-white/5 rounded-xl p-6 border border-white/10 transition-all duration-300 hover:bg-white/10 hover:border-white/20">
                    <h2 class="text-xl font-semibold text-white mb-4 flex items-center">
                        <i class="fas fa-clipboard-list mr-2 text-blue-400"></i>Requisitos
                    </h2>
                    <div class="prose prose-lg prose-invert max-w-none text-white/90 text-justify">
                        {!! $convocatoria->requisitos !!}
                    </div>
                </div>
                @endif

                <!-- Documentos de la Convocatoria -->
                <div class="bg-white/5 rounded-xl p-6 border border-white/10 transition-all duration-300 hover:bg-white/10 hover:border-white/20">
                    <h2 class="text-xl font-semibold text-white mb-4 flex items-center">
                        <i class="fas fa-file-pdf mr-2 text-blue-400"></i>Documentos
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @if($convocatoria->archivo_convocatoria)
                        <div class="bg-black/30 p-4 rounded-xl border border-white/10 hover:border-red-400/50 transition-all duration-300">
                            <div class="flex flex-col items-center text-center space-y-3">
                                <i class="fas fa-file-pdf text-red-400 text-3xl"></i>
                                <span class="text-white/90 font-medium">Convocatoria</span>
                                <a href="{{ Storage::url($convocatoria->archivo_convocatoria) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-red-500/20 text-red-400 rounded-lg hover:bg-red-500/30 transition-colors duration-200">
                                    <i class="fas fa-eye mr-2"></i>Visualizar
                                </a>
                            </div>
                        </div>
            @endif

            @if($convocatoria->archivo_pdr)
                        <div class="bg-black/30 p-4 rounded-xl border border-white/10 hover:border-blue-400/50 transition-all duration-300">
                            <div class="flex flex-col items-center text-center space-y-3">
                                <i class="fas fa-file-pdf text-blue-400 text-3xl"></i>
                                <span class="text-white/90 font-medium">PDR</span>
                                <a href="{{ Storage::url($convocatoria->archivo_pdr) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-500/20 text-blue-400 rounded-lg hover:bg-blue-500/30 transition-colors duration-200">
                                    <i class="fas fa-eye mr-2"></i>Visualizar
                                </a>
                            </div>
                        </div>
            @endif

            @if($convocatoria->archivo_cdr)
                        <div class="bg-black/30 p-4 rounded-xl border border-white/10 hover:border-green-400/50 transition-all duration-300">
                            <div class="flex flex-col items-center text-center space-y-3">
                                <i class="fas fa-file-pdf text-green-400 text-3xl"></i>
                                <span class="text-white/90 font-medium">CDR</span>
                                <a href="{{ Storage::url($convocatoria->archivo_cdr) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-green-500/20 text-green-400 rounded-lg hover:bg-green-500/30 transition-colors duration-200">
                                    <i class="fas fa-eye mr-2"></i>Visualizar
                                </a>
                            </div>
                        </div>
            @endif

            @if($convocatoria->archivo_pfr)
                        <div class="bg-black/30 p-4 rounded-xl border border-white/10 hover:border-purple-400/50 transition-all duration-300">
                            <div class="flex flex-col items-center text-center space-y-3">
                                <i class="fas fa-file-pdf text-purple-400 text-3xl"></i>
                                <span class="text-white/90 font-medium">PFR</span>
                                <a href="{{ Storage::url($convocatoria->archivo_pfr) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-purple-500/20 text-purple-400 rounded-lg hover:bg-purple-500/30 transition-colors duration-200">
                                    <i class="fas fa-eye mr-2"></i>Visualizar
                                </a>
                            </div>
                        </div>
            @endif

            @if($convocatoria->archivo_articulo)
                        <div class="bg-black/30 p-4 rounded-xl border border-white/10 hover:border-yellow-400/50 transition-all duration-300">
                            <div class="flex flex-col items-center text-center space-y-3">
                                <i class="fas fa-file-pdf text-yellow-400 text-3xl"></i>
                                <span class="text-white/90 font-medium">Artículo</span>
                                <a href="{{ Storage::url($convocatoria->archivo_articulo) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-yellow-500/20 text-yellow-400 rounded-lg hover:bg-yellow-500/30 transition-colors duration-200">
                                    <i class="fas fa-eye mr-2"></i>Visualizar
                                </a>
                            </div>
                        </div>
            @endif
                    </div>
                </div>

                @php
                    $existingPreRegistro = \App\Models\PreRegistroConcurso::where('usuario_id', Auth::id())
                        ->where('concurso_id', $convocatoria->concurso->id)
                        ->whereNull('deleted_at')
                        ->first();
                @endphp

                <div class="flex justify-center space-x-4 mt-8">
                    @if($existingPreRegistro)
                        <a href="{{ route('user.concursos.pre-registros.show', $existingPreRegistro) }}" class="inline-flex items-center px-6 py-3 bg-blue-600/80 text-white rounded-lg text-sm hover:bg-blue-600 transition-all">
                            <i class="fas fa-eye mr-2"></i>Ver Pre-registro
                        </a>
                    @else
                        <a href="{{ route('user.concursos.pre-registros.create', ['convocatoria' => $convocatoria->id]) }}" class="inline-flex items-center px-6 py-3 bg-blue-600/80 text-white rounded-lg text-sm hover:bg-blue-600 transition-all">
                            <i class="fas fa-user-plus mr-2"></i>Pre-registrarse
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection