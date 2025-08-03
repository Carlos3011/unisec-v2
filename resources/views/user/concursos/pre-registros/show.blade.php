@extends('layouts.user')

@section('titulo', 'Detalles del Pre-registro')

@section('contenido')
<div class="min-h-screen py-12 relative overflow-hidden bg-gradient-to-b from-space-950 to-cosmic-900">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto bg-black/30 backdrop-blur-xl rounded-2xl overflow-hidden border border-white/10 relative transition-all duration-300 hover:border-white/20 hover:shadow-[0_0_30px_rgba(147,51,234,0.3)]">
            <!-- Navegación -->
            <div class="p-6 flex justify-between items-center">
                <a href="{{ route('user.concursos.pre-registros.index') }}" class="text-white/90 hover:text-white flex items-center gap-2 bg-white/5 px-4 py-2 rounded-lg w-fit transition-all duration-300 hover:bg-white/10">
                    <i class="fas fa-arrow-left"></i>
                    <span>Volver a Pre-registros</span>
                </a>
                @can('update', $preRegistro)
                <a href="{{ route('user.concursos.pre-registros.edit', $preRegistro) }}" 
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
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-purple-400 to-blue-400">Detalles del Pre-registro</span>
                </h1>
                <div class="flex flex-wrap gap-6 justify-center relative">
                    <div class="flex items-center space-x-3 bg-white/5 px-6 py-3 rounded-xl transition-all duration-300 hover:bg-white/10 backdrop-blur-sm border border-white/10 hover:border-white/20 hover:transform hover:scale-105">
                        <i class="far fa-calendar text-blue-400 text-2xl"></i>
                        <span class="text-lg font-medium text-white/90">{{ $preRegistro->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="flex items-center space-x-3 bg-white/5 px-6 py-3 rounded-xl transition-all duration-300 hover:bg-white/10 backdrop-blur-sm border border-white/10 hover:border-white/20 hover:transform hover:scale-105">
                        <i class="far fa-flag text-purple-400 text-2xl"></i>
                        <span class="text-lg font-medium text-white/90">{{ $preRegistro->concurso->titulo }}</span>
                    </div>
                    <div class="flex items-center space-x-3 px-6 py-3 rounded-xl transition-all duration-300 backdrop-blur-sm border hover:transform hover:scale-105
                        @switch($preRegistro->estado_pdr)
                            @case('aprobado')
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
                            @switch($preRegistro->estado_pdr)
                                @case('aprobado')
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
                            @switch($preRegistro->estado_pdr)
                                @case('aprobado')
                                    text-green-400
                                    @break
                                @case('pendiente')
                                    text-yellow-400
                                    @break
                                @case('rechazado')
                                    text-red-400
                                    @break
                            @endswitch">
                            {{ ucfirst($preRegistro->estado_pdr) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Contenido Principal -->
            <div class="space-y-8 p-8">
                <!-- Información del Equipo -->
                <div class="bg-black/20 rounded-xl p-8 border border-white/10 transition-all duration-300 hover:bg-black/30 hover:border-white/20 backdrop-blur-xl shadow-lg hover:shadow-[0_0_30px_rgba(147,51,234,0.2)]">
                    <h2 class="text-2xl font-semibold text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-violet-400 mb-8 flex items-center gap-3">
                        <div class="p-2 rounded-lg bg-purple-500/10 border border-purple-500/20 group-hover:bg-violet-500/10 group-hover:border-violet-500/20 transition-all duration-300">
                            <i class="fas fa-users text-purple-400 group-hover:text-violet-400 transition-colors duration-300"></i>
                        </div>
                        Información del Equipo
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-6">
                            <div class="bg-white/5 p-6 rounded-xl border border-white/10 hover:border-purple-500/30 transition-all duration-300 hover:shadow-[0_0_20px_rgba(147,51,234,0.1)] transform hover:scale-[1.02]">
                                <div class="flex items-center gap-3">
                                    <span class="w-10 h-10 flex items-center justify-center rounded-full bg-gradient-to-br from-purple-500/20 to-violet-500/20 text-purple-400 border border-purple-500/30 shadow-inner">
                                        <i class="fas fa-users-cog text-lg"></i>
                                    </span>
                                    <div>
                                        <label class="text-gray-400 text-sm font-medium block mb-1 group-hover:text-purple-400 transition-colors">Nombre del Equipo</label>
                                        <p class="text-white text-lg font-semibold">{{ $preRegistro->nombre_equipo }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-white/5 p-6 rounded-xl border border-white/10 hover:border-purple-500/30 transition-all duration-300 hover:shadow-[0_0_20px_rgba(147,51,234,0.1)] transform hover:scale-[1.02]">
                                <div class="flex items-center gap-3">
                                    <span class="w-10 h-10 flex items-center justify-center rounded-full bg-gradient-to-br from-purple-500/20 to-violet-500/20 text-purple-400 border border-purple-500/30 shadow-inner">
                                        <i class="fas fa-users text-lg"></i>
                                    </span>
                                    <div>
                                        <label class="text-gray-400 text-sm font-medium block mb-1 group-hover:text-purple-400 transition-colors">Número de Integrantes</label>
                                        <p class="text-white text-lg font-semibold">{{ $preRegistro->integrantes }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-6">
                            <div class="bg-white/5 p-6 rounded-xl border border-white/10 hover:border-purple-500/30 transition-all duration-300 hover:shadow-[0_0_20px_rgba(147,51,234,0.1)] transform hover:scale-[1.02]">
                                <div class="flex items-center gap-3">
                                    <span class="w-10 h-10 flex items-center justify-center rounded-full bg-gradient-to-br from-purple-500/20 to-violet-500/20 text-purple-400 border border-purple-500/30 shadow-inner">
                                        <i class="fas fa-chalkboard-teacher text-lg"></i>
                                    </span>
                                    <div>
                                        <label class="text-gray-400 text-sm font-medium block mb-1 group-hover:text-purple-400 transition-colors">Asesor</label>
                                        <p class="text-white text-lg font-semibold">{{ $preRegistro->asesor ?: 'No especificado' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-white/5 p-6 rounded-xl border border-white/10 hover:border-purple-500/30 transition-all duration-300 hover:shadow-[0_0_20px_rgba(147,51,234,0.1)] transform hover:scale-[1.02]">
                                <div class="flex items-center gap-3">
                                    <span class="w-10 h-10 flex items-center justify-center rounded-full bg-gradient-to-br from-purple-500/20 to-violet-500/20 text-purple-400 border border-purple-500/30 shadow-inner">
                                        <i class="fas fa-university text-lg"></i>
                                    </span>
                                    <div>
                                        <label class="text-gray-400 text-sm font-medium block mb-1 group-hover:text-purple-400 transition-colors">Institución</label>
                                        <p class="text-white text-lg font-semibold">{{ $preRegistro->institucion ?: 'No especificada' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Integrantes del Equipo -->
                <div class="bg-black/20 rounded-xl p-8 border border-white/10 transition-all duration-300 hover:bg-black/30 hover:border-white/20 backdrop-blur-xl shadow-lg hover:shadow-[0_0_30px_rgba(147,51,234,0.2)]">
                    <h2 class="text-2xl font-semibold text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-emerald-400 mb-8 flex items-center gap-3">
                        <div class="p-2 rounded-lg bg-green-500/10 border border-green-500/20 group-hover:bg-emerald-500/10 group-hover:border-emerald-500/20 transition-all duration-300">
                            <i class="fas fa-users text-green-400 group-hover:text-emerald-400 transition-colors duration-300"></i>
                        </div>
                        Integrantes del Equipo
                    </h2>
                    <div class="space-y-6">
                        @foreach($preRegistro->integrantes_data ?? [] as $index => $integrante)
                            <div class="bg-white/5 p-6 rounded-xl border border-white/10 hover:border-green-500/30 transition-all duration-300 hover:shadow-[0_0_20px_rgba(74,222,128,0.1)] transform hover:scale-[1.02]">
                                <div class="flex justify-between items-center cursor-pointer" onclick="toggleIntegrante('integrante-{{ $index }}')">
                                    <h3 class="text-white font-medium flex items-center gap-3">
                                        <span class="w-10 h-10 flex items-center justify-center rounded-full bg-gradient-to-br from-green-500/20 to-emerald-500/20 text-green-400 border border-green-500/30 shadow-inner">
                                            {{ $index + 1 }}
                                        </span>
                                        <span class="text-lg">Integrante {{ $index + 1 }}</span>
                                    </h3>
                                    <button type="button" class="text-green-400 hover:text-emerald-400 transition-colors p-2 hover:bg-white/5 rounded-lg">
                                        <i id="icon-integrante-{{ $index }}" class="fas fa-chevron-up transform transition-transform duration-300"></i>
                                    </button>
                                </div>
                                <div id="content-integrante-{{ $index }}" class="space-y-6 mt-6 transition-all duration-300 overflow-hidden" style="max-height: 0px;">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="bg-gradient-to-r from-white/5 to-green-500/5 p-4 rounded-xl border border-white/10 hover:border-green-500/30 transition-all duration-300 group">
                                            <label class="text-gray-400 text-sm font-medium block mb-2 group-hover:text-green-400 transition-colors flex items-center gap-2">
                                                <i class="fas fa-user text-green-400"></i>
                                                Nombre Completo
                                            </label>
                                            <p class="text-white text-lg">{{ $integrante['nombre_completo'] ?? 'No especificado' }}</p>
                                        </div>
                                        <div class="bg-gradient-to-r from-white/5 to-green-500/5 p-4 rounded-xl border border-white/10 hover:border-green-500/30 transition-all duration-300 group">
                                            <label class="text-gray-400 text-sm font-medium block mb-2 group-hover:text-green-400 transition-colors flex items-center gap-2">
                                                <i class="fas fa-id-card text-green-400"></i>
                                                Matrícula
                                            </label>
                                            <p class="text-white text-lg">{{ $integrante['matricula'] ?? 'No especificada' }}</p>
                                        </div>
                                        <div class="bg-gradient-to-r from-white/5 to-green-500/5 p-4 rounded-xl border border-white/10 hover:border-green-500/30 transition-all duration-300 group">
                                            <label class="text-gray-400 text-sm font-medium block mb-2 group-hover:text-green-400 transition-colors flex items-center gap-2">
                                                <i class="fas fa-graduation-cap text-green-400"></i>
                                                Carrera
                                            </label>
                                            <p class="text-white text-lg">{{ $integrante['carrera'] ?? 'No especificada' }}</p>
                                        </div>
                                        <div class="bg-gradient-to-r from-white/5 to-green-500/5 p-4 rounded-xl border border-white/10 hover:border-green-500/30 transition-all duration-300 group">
                                            <label class="text-gray-400 text-sm font-medium block mb-2 group-hover:text-green-400 transition-colors flex items-center gap-2">
                                                <i class="fas fa-envelope text-green-400"></i>
                                                Correo Institucional
                                            </label>
                                            <p class="text-white text-lg">{{ $integrante['correo_institucional'] ?? 'No especificado' }}</p>
                                        </div>
                                        <div class="bg-gradient-to-r from-white/5 to-green-500/5 p-4 rounded-xl border border-white/10 hover:border-green-500/30 transition-all duration-300 group">
                                            <label class="text-gray-400 text-sm font-medium block mb-2 group-hover:text-green-400 transition-colors flex items-center gap-2">
                                                <i class="fas fa-calendar-alt text-green-400"></i>
                                                Periodo Académico
                                            </label>
                                            <p class="text-white text-lg">{{ $integrante['periodo_academico'] ?? 'No especificado' }}</p>
                                        </div>
                                        <div class="bg-gradient-to-r from-white/5 to-green-500/5 p-4 rounded-xl border border-white/10 hover:border-green-500/30 transition-all duration-300 group">
                                            <label class="text-gray-400 text-sm font-medium block mb-2 group-hover:text-green-400 transition-colors flex items-center gap-2">
                                                <i class="fas fa-clock text-green-400"></i>
                                                Tipo de Periodo
                                            </label>
                                            <p class="text-white text-lg">{{ ucfirst($integrante['tipo_periodo'] ?? 'No especificado') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Estado del PDR -->
                <div class="mt-6 flex justify-center">
                    @if($preRegistro->archivo_pdr)
                        <div class="group relative inline-block">
                            <a href="{{ route('user.concursos.pre-registros.download-pdr', $preRegistro) }}" 
                               class="flex items-center gap-3 px-6 py-3 bg-gradient-to-r from-blue-500/20 to-purple-500/20 rounded-xl border border-blue-500/30 hover:border-purple-500/50 transition-all duration-300 transform hover:scale-105 hover:shadow-[0_0_15px_rgba(147,51,234,0.2)]">
                                <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-blue-500/20 text-blue-400 group-hover:text-purple-400 transition-colors">
                                    <i class="fas fa-file-download text-xl"></i>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-white font-medium">Archivo PDR</span>
                                    <span class="text-blue-400 text-sm group-hover:text-purple-400 transition-colors">Haz clic para descargar</span>
                                </div>
                            </a>
                        </div>
                    @else
                        <div class="flex items-center gap-3 px-6 py-3 bg-red-500/10 rounded-xl border border-red-500/30">
                            <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-red-500/20 text-red-400">
                                <i class="fas fa-exclamation-circle text-xl"></i>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-white font-medium">Sin archivo PDR</span>
                                <span class="text-red-400 text-sm">No se ha subido ningún archivo</span>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Comentarios de Evaluación -->
                <div class="bg-white/5 rounded-xl p-6 border border-white/10 transition-all duration-300 hover:bg-white/10 hover:border-white/20 backdrop-blur-sm">
                    <h2 class="text-2xl font-semibold text-white mb-6 flex items-center gap-3">
                        <i class="fas fa-comments text-purple-400"></i>
                        Comentarios de Evaluación
                    </h2>
                    <div class="bg-white/5 p-4 rounded-lg border border-white/10">
                        @if($preRegistro->comentarios_pdr)
                            <p class="text-white/90 whitespace-pre-line text-lg">{{ $preRegistro->comentarios_pdr }}</p>
                        @else
                            <p class="text-gray-400 text-lg italic flex items-center gap-2">
                                <i class="fas fa-info-circle"></i>
                                El pre-registro aún no ha sido evaluado
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleIntegrante(id) {
    const content = document.getElementById(`content-${id}`);
    const icon = document.getElementById(`icon-${id}`);
    
    if (content.style.maxHeight !== '0px') {
        content.style.maxHeight = '0px';
        icon.style.transform = 'rotate(0deg)';
    } else {
        content.style.maxHeight = content.scrollHeight + 'px';
        icon.style.transform = 'rotate(180deg)';
    }
}

// Inicializar el estado de los paneles al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    const integrantes = document.querySelectorAll('[id^="content-integrante-"]');
    const icons = document.querySelectorAll('[id^="icon-integrante-"]');
    
    // Expandir el primer panel, colapsar los demás
    integrantes.forEach((content, index) => {
        const icon = icons[index];
        if (index === 0) {
            content.style.maxHeight = content.scrollHeight + 'px';
            icon.style.transform = 'rotate(180deg)';
        } else {
            content.style.maxHeight = '0px';
            icon.style.transform = 'rotate(0deg)';
        }
    });
});
</script>

@endsection