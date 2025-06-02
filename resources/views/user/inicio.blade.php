@extends('layouts.user')

@section('titulo', 'Inicio')

@section('contenido')
    <!-- Panel de Bienvenida -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div
            class="bg-gradient-to-br from-cosmic-900/80 to-space-900/80 backdrop-blur-lg rounded-3xl shadow-[0_0_30px_rgba(0,0,0,0.3)] p-8 border border-white/5 hover:border-white/10 transition-all duration-500 group">
            <div class="flex items-center justify-between">
                <div class="transform transition-all duration-500 group-hover:translate-x-2">
                    <h1 class="text-4xl font-light text-white mb-3 tracking-wider">Bienvenido, <span
                            class="font-semibold bg-clip-text text-transparent bg-gradient-to-r from-secondary to-primary">{{ Auth::user()->name }}</span>
                    </h1>
                    <div class="text-gray-300 text-lg">Tu portal para explorar el universo y la tecnología espacial</div>
                </div>
                <div class="hidden sm:block transform transition-all duration-500 group-hover:-translate-x-2">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-20 w-auto filter brightness-110">
                </div>
            </div>
        </div>
    </div>

    <!-- Accesos Rápidos -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            <!-- Tarjeta de Validación de Código -->
            <a href="{{ route('user.concursos.pagos-terceros.validar') }}"
                class="group bg-space-900/40 backdrop-blur-md rounded-2xl p-6 border border-white/5 hover:border-emerald-500/50 transition-all duration-500 hover:-translate-y-1 hover:shadow-[0_0_20px_rgba(16,185,129,0.2)]">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-emerald-500/10 rounded-xl group-hover:scale-110 transition-transform duration-500">
                        <i class="fas fa-key text-2xl text-emerald-500/80 group-hover:text-emerald-500 transition-colors"></i>
                    </div>
                    <span class="text-gray-300 group-hover:text-white transition-colors duration-500">Validar</span>
                </div>
                <h3 class="text-xl font-light text-white mb-2 tracking-wide">Validar Código</h3>
                <p class="text-gray-300 group-hover:text-gray-200 transition-colors duration-500">Valida tu código de pago</p>
            </a>

            <!-- Tarjeta de Eventos -->
            <a href="{{ route('user.eventos') }}"
                class="group bg-space-900/40 backdrop-blur-md rounded-2xl p-6 border border-white/5 hover:border-secondary/50 transition-all duration-500 hover:-translate-y-1 hover:shadow-[0_0_20px_rgba(99,102,241,0.2)]">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-secondary/10 rounded-xl group-hover:scale-110 transition-transform duration-500">
                        <i
                            class="fas fa-calendar-alt text-2xl text-secondary/80 group-hover:text-secondary transition-colors"></i>
                    </div>
                    <span class="text-gray-300 group-hover:text-white transition-colors duration-500">Ver todos</span>
                </div>
                <h3 class="text-xl font-light text-white mb-2 tracking-wide">Mis Eventos</h3>
                <p class="text-gray-300 group-hover:text-gray-200 transition-colors duration-500">Gestiona tus inscripciones
                    y horarios</p>
            </a>

            <!-- Tarjeta de Certificados -->
            <a href="{{ route('user.certificados') }}"
                class="group bg-space-900/40 backdrop-blur-md rounded-2xl p-6 border border-white/5 hover:border-primary/50 transition-all duration-500 hover:-translate-y-1 hover:shadow-[0_0_20px_rgba(59,130,246,0.2)]">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-primary/10 rounded-xl group-hover:scale-110 transition-transform duration-500">
                        <i
                            class="fas fa-certificate text-2xl text-primary/80 group-hover:text-primary transition-colors"></i>
                    </div>
                    <span class="text-gray-300 group-hover:text-white transition-colors duration-500">Ver todos</span>
                </div>
                <h3 class="text-xl font-light text-white mb-2 tracking-wide">Certificados</h3>
                <p class="text-gray-300 group-hover:text-gray-200 transition-colors duration-500">Accede a tus
                    certificaciones</p>
            </a>

            <!-- Tarjeta de Pagos -->
            <a href="{{ route('user.concursos.pagos-terceros.index') }}"
                class="group bg-space-900/40 backdrop-blur-md rounded-2xl p-6 border border-white/5 hover:border-accent-500/50 transition-all duration-500 hover:-translate-y-1 hover:shadow-[0_0_20px_rgba(236,72,153,0.2)]">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-accent-500/10 rounded-xl group-hover:scale-110 transition-transform duration-500">
                        <i
                            class="fas fa-credit-card text-2xl text-accent-500/80 group-hover:text-accent-500 transition-colors"></i>
                    </div>
                    <span class="text-gray-300 group-hover:text-white transition-colors duration-500">Ver todos</span>
                </div>
                <h3 class="text-xl font-light text-white mb-2 tracking-wide">Pagos</h3>
                <p class="text-gray-300 group-hover:text-gray-200 transition-colors duration-500">Revisa tu historial de
                    pagos</p>
            </a>

            <!-- Tarjeta de Soporte -->
            <a href="{{ route('user.soporte') }}"
                class="group bg-space-900/40 backdrop-blur-md rounded-2xl p-6 border border-white/5 hover:border-cyan-500/50 transition-all duration-500 hover:-translate-y-1 hover:shadow-[0_0_20px_rgba(34,211,238,0.2)]">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-cyan-500/10 rounded-xl group-hover:scale-110 transition-transform duration-500">
                        <i class="fas fa-headset text-2xl text-cyan-500/80 group-hover:text-cyan-500 transition-colors"></i>
                    </div>
                    <span class="text-gray-300 group-hover:text-white transition-colors duration-500">Ver todos</span>
                </div>
                <h3 class="text-xl font-light text-white mb-2 tracking-wide">Soporte</h3>
                <p class="text-gray-300 group-hover:text-gray-200 transition-colors duration-500">Accede a tus
                    certificaciones</p>
            </a>
        </div>
    </div>

    <!-- Sección de Concursos Activos -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div
            class="bg-gradient-to-br from-space-900/80 to-cosmic-900/80 backdrop-blur-lg rounded-3xl p-8 border border-white/5 hover:border-white/10 transition-all duration-500">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl font-light text-white tracking-wider">Concursos Disponibles</h2>
                <a href="{{ route('user.concursos.index') }}"
                    class="text-primary/90 hover:text-primary transition-colors duration-500 flex items-center group">
                    Ver todos
                    <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($concursos as $concurso)
                    @if($concurso->estado === 'activo' && $concurso->convocatorias->count() > 0)
                        @foreach($concurso->convocatorias->take(2) as $convocatoria)
                            <div
                                class="bg-black/20 backdrop-blur-lg rounded-2xl p-6 border border-white/5 group hover:border-primary/30 transition-all duration-500 hover:shadow-[0_0_30px_rgba(59,130,246,0.1)]">
                                <div class="flex items-start justify-between mb-4">
                                    <h3
                                        class="text-xl font-light text-white tracking-wide group-hover:text-primary/90 transition-colors duration-500">
                                        {{ $concurso->titulo }}
                                    </h3>
                                    <span class="px-3 py-1 text-xs font-medium rounded-full bg-green-500/20 text-green-400">
                                        <i class="fas fa-check-circle mr-1"></i>Activo
                                    </span>
                                </div>
                                <div class="space-y-3 mb-6">
                                    <div class="flex items-center text-sm text-gray-300">
                                        <i class="fas fa-map-marker-alt w-5 text-gray-400"></i>
                                        <span>{{ $convocatoria->sede }}</span>
                                    </div>
                                    <div class="flex items-center text-sm text-gray-300">
                                        <i class="fas fa-users w-5 text-gray-400"></i>
                                        <span>{{ $convocatoria->dirigido_a }}</span>
                                    </div>
                                    @if($convocatoria->fechasImportantes->count() > 0)
                                        <div class="flex items-center text-sm text-gray-300">
                                            <i class="fas fa-calendar w-5 text-gray-400"></i>
                                            <span>Próxima fecha: {{ $convocatoria->fechasImportantes->sortBy('fecha')->first()->titulo }} -
                                                {{ $convocatoria->fechasImportantes->sortBy('fecha')->first()->fecha->format('d/m/Y') }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ route('user.concursos.convocatorias.show', $convocatoria) }}"
                                        class="inline-flex items-center justify-center px-4 py-2 bg-primary/10 text-primary/90 rounded-xl hover:bg-primary/20 transition-all duration-500">
                                        <i class="fas fa-info-circle mr-2"></i>Ver detalles
                                    </a>
                                    @php
                                        $pagoConfirmado = \App\Models\PagoPreRegistro::where('usuario_id', Auth::id())
                                            ->where('concurso_id', $concurso->id)
                                            ->where('estado_pago', 'pagado')
                                            ->exists();
                                    @endphp
                                    @php
                                        $tienePreRegistro = \App\Models\PreRegistroConcurso::where('usuario_id', Auth::id())
                                            ->where('concurso_id', $concurso->id)
                                            ->exists();
                                    @endphp

                                    @if($pagoConfirmado)
                                        @if($tienePreRegistro)
                                            <a href="{{ route('user.concursos.convocatorias.show', $convocatoria) }}"
                                            class="inline-flex items-center justify-center px-4 py-2 bg-green-500/20 text-green-400 rounded-xl hover:bg-green-500/30 transition-all duration-500">
                                                <i class="fas fa-eye mr-2"></i>Ver Pre-registro
                                            </a>
                                        @else
                                            <a href="{{ route('user.concursos.pre-registros.create', ['convocatoria' => $convocatoria->id]) }}" 
                                            class="inline-flex items-center justify-center px-4 py-2 bg-blue-500/20 text-blue-400 rounded-xl hover:bg-blue-500/30 transition-all duration-500">
                                                <i class="fas fa-user-plus mr-2"></i>Pre-registrarse
                                            </a>
                                        @endif
                                    @else
                                        <a href="{{ route('user.concursos.pagos.pre-registro', $convocatoria) }}" 
                                           class="inline-flex items-center justify-center px-4 py-2 bg-yellow-500/20 text-yellow-400 rounded-xl hover:bg-yellow-500/30 transition-all duration-500">
                                            <i class="fas fa-credit-card mr-2"></i>Realizar Pago
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endif
                @empty
                    <div class="col-span-full p-8 text-center">
                        <i class="fas fa-trophy text-4xl text-gray-600 mb-4"></i>
                        <p class="text-gray-400">No hay concursos activos en este momento</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Sección de Exploración Espacial -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div
            class="bg-gradient-to-br from-space-900/80 to-cosmic-900/80 backdrop-blur-lg rounded-3xl p-8 border border-white/5 hover:border-white/10 transition-all duration-500">
            <h2 class="text-2xl font-light text-white mb-8 tracking-wider">Exploración Espacial</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Sistema Solar Interactivo -->
                <div
                    class="bg-black/20 backdrop-blur-lg rounded-2xl p-6 border border-white/5 group hover:border-secondary/30 transition-all duration-500 hover:shadow-[0_0_30px_rgba(99,102,241,0.1)]">
                    <h3
                        class="text-xl font-light text-white mb-4 tracking-wide group-hover:text-secondary/90 transition-colors duration-500">
                        Sistema Solar Interactivo</h3>
                    <p class="text-gray-300 mb-6 group-hover:text-gray-200 transition-colors duration-500">Explora nuestro
                        sistema solar en 3D y aprende sobre los planetas</p>
                    <a href="{{ route('user.espacio')  }}"
                        class="inline-flex items-center px-6 py-2.5 bg-secondary/10 hover:bg-secondary/20 text-secondary rounded-xl transition-all duration-500 group-hover:translate-x-1">
                        <i class="fas fa-globe-americas mr-2 group-hover:animate-pulse"></i>
                        Explorar ahora
                    </a>
                </div>

                <!-- Últimas Noticias Espaciales -->
                <div
                    class="bg-black/20 backdrop-blur-lg rounded-2xl p-6 border border-white/5 group hover:border-primary/30 transition-all duration-500 hover:shadow-[0_0_30px_rgba(59,130,246,0.1)]">
                    <h3
                        class="text-xl font-light text-white mb-4 tracking-wide group-hover:text-primary/90 transition-colors duration-500">
                        Últimas Noticias Espaciales</h3>
                    <div class="space-y-4">
                        @forelse($noticias as $noticia)
                            <a href="{{ route('noticias.show', $noticia->id) }}" class="block group/news">
                                <div
                                    class="flex items-center space-x-4 p-2 rounded-xl hover:bg-white/5 transition-colors duration-300">
                                    <div class="flex-shrink-0 w-16 h-16 bg-black/40 rounded-xl overflow-hidden">
                                        @if($noticia->imagen)
                                            <img src="{{ asset( $noticia->imagen) }}" alt="{{ $noticia->titulo }}"
                                                class="w-full h-full object-cover group-hover/news:scale-110 transition-transform duration-500">
                                        @else
                                            <img src="{{ asset('images/exoplanetas.jpg') }}" alt="Imagen por defecto"
                                                class="w-full h-full object-cover group-hover/news:scale-110 transition-transform duration-500">
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="text-white/90 group-hover/news:text-primary transition-colors duration-500">
                                            {{ Str::limit($noticia->titulo, 80) }}
                                        </h4>
                                        <p class="text-gray-300 text-sm">{{ $noticia->fecha_publicacion->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="text-center py-4">
                                <p class="text-gray-300">No hay noticias disponibles</p>
                            </div>
                        @endforelse
                    </div>
                    <a href="{{ route('user.noticias') }}"
                        class="inline-flex items-center mt-6 text-primary/90 hover:text-primary transition-colors duration-500 group-hover:translate-x-1">
                        Ver todas las noticias
                        <i class="fas fa-arrow-right ml-2 group-hover:animate-pulse"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection