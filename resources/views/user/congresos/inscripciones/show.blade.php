@extends('layouts.user')

@section('titulo', 'Detalles de la Inscripción')

@section('contenido')
<div class="min-h-screen py-12 relative overflow-hidden bg-gradient-to-b from-space-950 to-cosmic-900">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto bg-black/30 backdrop-blur-xl rounded-2xl overflow-hidden border border-white/10 relative transition-all duration-300 hover:border-white/20 hover:shadow-[0_0_30px_rgba(147,51,234,0.3)]">
            <!-- Navegación -->
            <div class="p-6 flex justify-between items-center">
                <a href="{{ route('user.congresos.inscripciones.index') }}" class="text-white/90 hover:text-white flex items-center gap-2 bg-white/5 px-4 py-2 rounded-lg w-fit transition-all duration-300 hover:bg-white/10">
                    <i class="fas fa-arrow-left"></i>
                    <span>Volver a Inscripciones</span>
                </a>
                @can('update', $inscripcion)
                <a href="{{ route('user.congresos.inscripciones.edit', $inscripcion) }}" 
                   class="bg-blue-500/20 hover:bg-blue-500/30 text-blue-400 hover:text-blue-300 px-4 py-2 rounded-lg transition-all flex items-center space-x-2 border border-blue-500/30">
                    <i class="fas fa-edit"></i>
                    <span>Editar</span>
                </a>
                @endcan
            </div>

            <!-- Encabezado -->
            <div class="relative p-8 border-b border-white/10 bg-gradient-to-r from-purple-500/5 via-blue-500/5 to-indigo-500/5">
                <div class="absolute inset-0 bg-white/5 backdrop-blur-sm rounded-lg"></div>
                <h1 class="text-4xl font-bold text-white mb-8 text-center drop-shadow-lg relative">
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-purple-400 to-blue-400">Detalles de la Inscripción</span>
                </h1>
                <div class="flex flex-wrap gap-6 justify-center relative">
                    <div class="flex items-center space-x-3 bg-white/5 px-6 py-3 rounded-xl transition-all duration-300 hover:bg-white/10 backdrop-blur-sm border border-white/10 hover:border-white/20 hover:transform hover:scale-105">
                        <i class="far fa-calendar text-blue-400 text-2xl"></i>
                        <span class="text-lg font-medium text-white/90">{{ $inscripcion->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="flex items-center space-x-3 bg-white/5 px-6 py-3 rounded-xl transition-all duration-300 hover:bg-white/10 backdrop-blur-sm border border-white/10 hover:border-white/20 hover:transform hover:scale-105">
                        <i class="far fa-flag text-purple-400 text-2xl"></i>
                        <span class="text-lg font-medium text-white/90">{{ $inscripcion->congreso->nombre }}</span>
                    </div>
                    <div class="flex items-center space-x-3 px-6 py-3 rounded-xl transition-all duration-300 backdrop-blur-sm border hover:transform hover:scale-105
                        @switch($inscripcion->estado)
                            @case('validado')
                                bg-green-500/10 border-green-500/30 hover:bg-green-500/20 hover:border-green-500/50
                                @break
                            @case('pendiente')
                                bg-yellow-500/10 border-yellow-500/30 hover:bg-yellow-500/20 hover:border-yellow-500/50
                                @break
                            @case('rechazado')
                                bg-red-500/10 border-red-500/30 hover:bg-red-500/20 hover:border-red-500/50
                                @break
                        @endswitch">
                        <i class="far fa-check-circle text-2xl
                            @switch($inscripcion->estado)
                                @case('validado')
                                    text-green-400
                                    @break
                                @case('pendiente')
                                    text-yellow-400
                                    @break
                                @case('rechazado')
                                    text-red-400
                                    @break
                            @endswitch"></i>
                        <span class="text-lg font-medium
                            @switch($inscripcion->estado)
                                @case('validado')
                                    text-green-400
                                    @break
                                @case('pendiente')
                                    text-yellow-400
                                    @break
                                @case('rechazado')
                                    text-red-400
                                    @break
                            @endswitch">
                            {{ ucfirst($inscripcion->estado) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Contenido Principal -->
            <div class="space-y-8 p-8">
                <!-- Información del Participante -->
                <div class="bg-black/20 rounded-xl p-8 border border-white/10 transition-all duration-300 hover:bg-black/30 hover:border-white/20 backdrop-blur-xl shadow-lg hover:shadow-[0_0_30px_rgba(147,51,234,0.2)]">
                    <h2 class="text-2xl font-semibold text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-violet-400 mb-8 flex items-center gap-3">
                        <div class="p-2 rounded-lg bg-purple-500/10 border border-purple-500/20 group-hover:bg-violet-500/10 group-hover:border-violet-500/20 transition-all duration-300">
                            <i class="fas fa-user text-purple-400 group-hover:text-violet-400 transition-colors duration-300"></i>
                        </div>
                        Información del Participante
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-6">
                            <div class="bg-white/5 p-6 rounded-xl border border-white/10 hover:border-purple-500/30 transition-all duration-300 hover:shadow-[0_0_20px_rgba(147,51,234,0.1)] transform hover:scale-[1.02]">
                                <div class="flex items-center gap-3">
                                    <span class="w-10 h-10 flex items-center justify-center rounded-full bg-gradient-to-br from-purple-500/20 to-violet-500/20 text-purple-400 border border-purple-500/30 shadow-inner">
                                        <i class="fas fa-user text-lg"></i>
                                    </span>
                                    <div>
                                        <label class="text-gray-400 text-sm font-medium block mb-1 group-hover:text-purple-400 transition-colors">Nombre del Participante</label>
                                        <p class="text-white text-lg font-semibold">{{ $inscripcion->usuario->name }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-white/5 p-6 rounded-xl border border-white/10 hover:border-purple-500/30 transition-all duration-300 hover:shadow-[0_0_20px_rgba(147,51,234,0.1)] transform hover:scale-[1.02]">
                                <div class="flex items-center gap-3">
                                    <span class="w-10 h-10 flex items-center justify-center rounded-full bg-gradient-to-br from-purple-500/20 to-violet-500/20 text-purple-400 border border-purple-500/30 shadow-inner">
                                        <i class="fas fa-user-tag text-lg"></i>
                                    </span>
                                    <div>
                                        <label class="text-gray-400 text-sm font-medium block mb-1 group-hover:text-purple-400 transition-colors">Tipo de Participante</label>
                                        <p class="text-white text-lg font-semibold">{{ ucfirst($inscripcion->tipo_participante) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-6">
                            <div class="bg-white/5 p-6 rounded-xl border border-white/10 hover:border-purple-500/30 transition-all duration-300 hover:shadow-[0_0_20px_rgba(147,51,234,0.1)] transform hover:scale-[1.02]">
                                <div class="flex items-center gap-3">
                                    <span class="w-10 h-10 flex items-center justify-center rounded-full bg-gradient-to-br from-purple-500/20 to-violet-500/20 text-purple-400 border border-purple-500/30 shadow-inner">
                                        <i class="fas fa-university text-lg"></i>
                                    </span>
                                    <div>
                                        <label class="text-gray-400 text-sm font-medium block mb-1 group-hover:text-purple-400 transition-colors">Institución</label>
                                        <p class="text-white text-lg font-semibold">{{ $inscripcion->institucion }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-white/5 p-6 rounded-xl border border-white/10 hover:border-purple-500/30 transition-all duration-300 hover:shadow-[0_0_20px_rgba(147,51,234,0.1)] transform hover:scale-[1.02]">
                                <div class="flex items-center gap-3">
                                    <span class="w-10 h-10 flex items-center justify-center rounded-full bg-gradient-to-br from-purple-500/20 to-violet-500/20 text-purple-400 border border-purple-500/30 shadow-inner">
                                        <i class="fas fa-graduation-cap text-lg"></i>
                                    </span>
                                    <div>
                                        <label class="text-gray-400 text-sm font-medium block mb-1 group-hover:text-purple-400 transition-colors">Congreso</label>
                                        <p class="text-white text-lg font-semibold">{{ $inscripcion->congreso->nombre }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Estados -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Estado del Artículo -->
                    <div class="bg-black/20 rounded-xl p-8 border border-white/10 transition-all duration-300 hover:bg-black/30 hover:border-white/20 backdrop-blur-xl shadow-lg hover:shadow-[0_0_30px_rgba(147,51,234,0.2)]">
                        <h2 class="text-2xl font-semibold text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-emerald-400 mb-8 flex items-center gap-3">
                            <div class="p-2 rounded-lg bg-green-500/10 border border-green-500/20 group-hover:bg-emerald-500/10 group-hover:border-emerald-500/20 transition-all duration-300">
                                <i class="fas fa-file-alt text-green-400 group-hover:text-emerald-400 transition-colors duration-300"></i>
                            </div>
                            Estado del Artículo
                        </h2>
                        @if($inscripcion->articulo)
                            <div class="flex items-center justify-center">
                                <span class="px-4 py-2 rounded-full text-sm font-medium
                                    @switch($inscripcion->articulo->estado_articulo)
                                        @case('aceptado')
                                            bg-green-500/20 text-green-500 border border-green-500/30
                                            @break
                                        @case('rechazado')
                                            bg-red-500/20 text-red-500 border border-red-500/30
                                            @break
                                        @case('en_revision')
                                            bg-yellow-500/20 text-yellow-500 border border-yellow-500/30
                                            @break
                                        @default
                                            bg-gray-500/20 text-gray-500 border border-gray-500/30
                                    @endswitch">
                                    {{ ucfirst(str_replace('_', ' ', $inscripcion->articulo->estado_articulo)) }}
                                </span>
                            </div>
                        @else
                            <div class="text-center text-gray-400">
                                No hay artículo registrado
                            </div>
                        @endif
                    </div>

                    <!-- Estado del Pago -->
                    <div class="bg-black/20 rounded-xl p-8 border border-white/10 transition-all duration-300 hover:bg-black/30 hover:border-white/20 backdrop-blur-xl shadow-lg hover:shadow-[0_0_30px_rgba(147,51,234,0.2)]">
                        <h2 class="text-2xl font-semibold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-400 mb-8 flex items-center gap-3">
                            <div class="p-2 rounded-lg bg-blue-500/10 border border-blue-500/20 group-hover:bg-indigo-500/10 group-hover:border-indigo-500/20 transition-all duration-300">
                                <i class="fas fa-credit-card text-blue-400 group-hover:text-indigo-400 transition-colors duration-300"></i>
                            </div>
                            Estado del Pago
                        </h2>
                        <div class="flex flex-col items-center gap-4">
                            <span class="px-4 py-2 rounded-full text-sm font-medium
                                @switch($inscripcion->pagoInscripcion->estado_pago ?? 'pendiente')
                                    @case('pagado')
                                        bg-green-500/20 text-green-500 border border-green-500/30
                                        @break
                                    @case('rechazado')
                                        bg-red-500/20 text-red-500 border border-red-500/30
                                        @break
                                    @default
                                        bg-yellow-500/20 text-yellow-500 border border-yellow-500/30
                                @endswitch">
                                {{ ucfirst($inscripcion->pagoInscripcion->estado_pago ?? 'pendiente') }}
                            </span>
                            @if($inscripcion->pagoInscripcion && $inscripcion->pagoInscripcion->estado_pago === 'pagado')
                                <a href="{{ route('user.congresos.inscripciones.factura', $inscripcion) }}" 
                                   class="inline-flex items-center gap-2 px-4 py-2 bg-blue-500/20 hover:bg-blue-500/30 text-blue-400 hover:text-blue-300 rounded-lg transition-all duration-300 border border-blue-500/30 hover:border-blue-500/50">
                                    <i class="fas fa-file-invoice"></i>
                                    <span>Descargar Ticket</span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                @if($inscripcion->articulo)
                    <!-- Información del Artículo -->
                    <div class="bg-black/20 rounded-xl p-8 border border-white/10 transition-all duration-300 hover:bg-black/30 hover:border-white/20 backdrop-blur-xl shadow-lg hover:shadow-[0_0_30px_rgba(147,51,234,0.2)]">
                        <h2 class="text-2xl font-semibold text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-emerald-400 mb-8 flex items-center gap-3">
                            <div class="p-2 rounded-lg bg-green-500/10 border border-green-500/20 group-hover:bg-emerald-500/10 group-hover:border-emerald-500/20 transition-all duration-300">
                                <i class="fas fa-file-alt text-green-400 group-hover:text-emerald-400 transition-colors duration-300"></i>
                            </div>
                            Información del Artículo
                        </h2>
                        <div class="space-y-6">
                            <div class="bg-white/5 p-6 rounded-xl border border-white/10 hover:border-green-500/30 transition-all duration-300 hover:shadow-[0_0_20px_rgba(74,222,128,0.1)] transform hover:scale-[1.02]">
                                <div class="flex items-center gap-3">
                                    <span class="w-10 h-10 flex items-center justify-center rounded-full bg-gradient-to-br from-green-500/20 to-emerald-500/20 text-green-400 border border-green-500/30 shadow-inner">
                                        <i class="fas fa-heading text-lg"></i>
                                    </span>
                                    <div>
                                        <label class="text-gray-400 text-sm font-medium block mb-1 group-hover:text-green-400 transition-colors">Título del Artículo</label>
                                        <p class="text-white text-lg">{{ $inscripcion->articulo->titulo }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="bg-white/5 p-6 rounded-xl border border-white/10 hover:border-green-500/30 transition-all duration-300 hover:shadow-[0_0_20px_rgba(74,222,128,0.1)] transform hover:scale-[1.02]">
                                    <div class="flex items-center gap-3">
                                        <span class="w-10 h-10 flex items-center justify-center rounded-full bg-gradient-to-br from-green-500/20 to-emerald-500/20 text-green-400 border border-green-500/30 shadow-inner">
                                            <i class="fas fa-file-alt text-lg"></i>
                                        </span>
                                        <div>
                                            <label class="text-gray-400 text-sm font-medium block mb-1 group-hover:text-green-400 transition-colors">Estado del Artículo</label>
                                            <span class="px-3 py-1 inline-flex items-center gap-1.5 text-xs font-medium rounded-full
                                                @if($inscripcion->articulo->estado_articulo === 'aceptado') bg-green-500/20 text-green-300 border border-green-500/30
                                                @elseif($inscripcion->articulo->estado_articulo === 'rechazado') bg-red-500/20 text-red-300 border border-red-500/30
                                                @else bg-yellow-500/20 text-yellow-300 border border-yellow-500/30
                                                @endif">
                                                <span class="w-1.5 h-1.5 rounded-full
                                                    @if($inscripcion->articulo->estado_articulo === 'aceptado') bg-green-400
                                                    @elseif($inscripcion->articulo->estado_articulo === 'rechazado') bg-red-400
                                                    @else bg-yellow-400
                                                    @endif"></span>
                                                {{ ucfirst($inscripcion->articulo->estado_articulo) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-white/5 p-6 rounded-xl border border-white/10 hover:border-green-500/30 transition-all duration-300 hover:shadow-[0_0_20px_rgba(74,222,128,0.1)] transform hover:scale-[1.02]">
                                    <div class="flex items-center gap-3">
                                        <span class="w-10 h-10 flex items-center justify-center rounded-full bg-gradient-to-br from-green-500/20 to-emerald-500/20 text-green-400 border border-green-500/30 shadow-inner">
                                            <i class="fas fa-file-alt text-lg"></i>
                                        </span>
                                        <div>
                                            <label class="text-gray-400 text-sm font-medium block mb-1 group-hover:text-green-400 transition-colors">Estado del Extenso</label>
                                            <span class="px-3 py-1 inline-flex items-center gap-1.5 text-xs font-medium rounded-full
                                                @if($inscripcion->articulo->estado_extenso === 'aceptado') bg-green-500/20 text-green-300 border border-green-500/30
                                                @elseif($inscripcion->articulo->estado_extenso === 'rechazado') bg-red-500/20 text-red-300 border border-red-500/30
                                                @elseif($inscripcion->articulo->estado_extenso === 'en_revision') bg-blue-500/20 text-blue-300 border border-blue-500/30
                                                @else bg-yellow-500/20 text-yellow-300 border border-yellow-500/30
                                                @endif">
                                                <span class="w-1.5 h-1.5 rounded-full
                                                    @if($inscripcion->articulo->estado_extenso === 'aceptado') bg-green-400
                                                    @elseif($inscripcion->articulo->estado_extenso === 'rechazado') bg-red-400
                                                    @elseif($inscripcion->articulo->estado_extenso === 'en_revision') bg-blue-400
                                                    @else bg-yellow-400
                                                    @endif"></span>
                                                {{ ucfirst($inscripcion->articulo->estado_extenso) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Autores del Artículo -->
                            <div class="bg-white/5 p-6 rounded-xl border border-white/10 hover:border-green-500/30 transition-all duration-300 hover:shadow-[0_0_20px_rgba(74,222,128,0.1)] transform hover:scale-[1.02]">
                                <h3 class="text-lg font-medium text-white mb-4 flex items-center gap-2">
                                    <i class="fas fa-users text-green-400"></i>
                                    Autores del Artículo
                                </h3>
                                <div class="space-y-4">
                                    @foreach(json_decode($inscripcion->articulo->autores_data, true) as $autor)
                                        <div class="bg-white/5 p-4 rounded-lg border border-white/10">
                                            <p class="text-white font-medium">{{ $autor['nombre'] }}</p>
                                            <p class="text-gray-400">{{ $autor['correo'] }}</p>
                                            <p class="text-gray-400">{{ $autor['institucion'] }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Archivos del Artículo -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="bg-white/5 p-6 rounded-xl border border-white/10 hover:border-green-500/30 transition-all duration-300 hover:shadow-[0_0_20px_rgba(74,222,128,0.1)] transform hover:scale-[1.02]">
                                    <div class="flex items-center gap-3">
                                        <span class="w-10 h-10 flex items-center justify-center rounded-full bg-gradient-to-br from-green-500/20 to-emerald-500/20 text-green-400 border border-green-500/30 shadow-inner">
                                            <i class="fas fa-file-pdf text-lg"></i>
                                        </span>
                                        <div>
                                            <label class="text-gray-400 text-sm font-medium block mb-1 group-hover:text-green-400 transition-colors">Artículo</label>
                                            @if($inscripcion->articulo->archivo_articulo)
                                                <a href="{{ asset($inscripcion->articulo->archivo_articulo) }}" 
                                                   target="_blank"
                                                   class="text-green-400 hover:text-green-300 transition-colors flex items-center gap-2">
                                                    <i class="fas fa-eye"></i>
                                                    <span>Ver Artículo</span>
                                                </a>
                                            @else
                                                <p class="text-gray-400">No hay archivo disponible</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-white/5 p-6 rounded-xl border border-white/10 hover:border-green-500/30 transition-all duration-300 hover:shadow-[0_0_20px_rgba(74,222,128,0.1)] transform hover:scale-[1.02]">
                                    <div class="flex items-center gap-3">
                                        <span class="w-10 h-10 flex items-center justify-center rounded-full bg-gradient-to-br from-green-500/20 to-emerald-500/20 text-green-400 border border-green-500/30 shadow-inner">
                                            <i class="fas fa-file-pdf text-lg"></i>
                                        </span>
                                        <div>
                                            <label class="text-gray-400 text-sm font-medium block mb-1 group-hover:text-green-400 transition-colors">Artículo Extenso</label>
                                            @if($inscripcion->articulo->archivo_extenso)
                                                <a href="{{ asset($inscripcion->articulo->archivo_extenso) }}" 
                                                   target="_blank"
                                                   class="text-green-400 hover:text-green-300 transition-colors flex items-center gap-2">
                                                    <i class="fas fa-eye"></i>
                                                    <span>Ver Extenso</span>
                                                </a>
                                            @else
                                                <p class="text-gray-400">No hay archivo disponible</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection