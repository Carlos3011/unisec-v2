@extends('layouts.user')

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
                   class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow-lg transition-all flex items-center space-x-2">
                    <i class="fas fa-edit"></i>
                    <span>Editar</span>
                </a>
                @endcan
            </div>

            <!-- Encabezado -->
            <div class="relative p-8 border-b border-white/10">
                <h1 class="text-5xl font-bold text-white mb-6 text-center drop-shadow-lg">Detalles del Pre-registro</h1>
                <div class="flex flex-wrap gap-4 justify-center">
                    <div class="flex items-center space-x-3 bg-white/5 px-4 py-2 rounded-lg transition-all duration-300 hover:bg-white/10">
                        <i class="far fa-calendar text-blue-400 text-xl"></i>
                        <span class="text-lg font-medium text-white/90">{{ $preRegistro->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="flex items-center space-x-3 bg-white/5 px-4 py-2 rounded-lg transition-all duration-300 hover:bg-white/10">
                        <i class="far fa-flag text-purple-400 text-xl"></i>
                        <span class="text-lg font-medium text-white/90">{{ $preRegistro->concurso->titulo }}</span>
                    </div>
                    <div class="flex items-center space-x-3 bg-white/5 px-4 py-2 rounded-lg transition-all duration-300 hover:bg-white/10">
                        <i class="far fa-check-circle text-blue-400 text-xl"></i>
                        <span class="px-3 py-1 rounded-full text-sm inline-block
                            @switch($preRegistro->estado)
                                @case('validado')
                                    bg-green-500/20 text-green-500
                                    @break
                                @case('pendiente')
                                    bg-yellow-500/20 text-yellow-500
                                    @break
                                @case('rechazado')
                                    bg-red-500/20 text-red-500
                                    @break
                            @endswitch">
                            {{ ucfirst($preRegistro->estado) }}
                        </span>
                    </div>
                </div>


            </div>

            <!-- Contenido Principal -->
            <div class="space-y-8 p-8">
                <!-- Información del Equipo -->
                <div class="bg-white/5 rounded-xl p-6 border border-white/10 transition-all duration-300 hover:bg-white/10 hover:border-white/20">
                    <h2 class="text-2xl font-semibold text-white mb-6 flex items-center gap-3">
                        <i class="fas fa-users text-blue-400"></i>
                        Información del Equipo
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div class="bg-white/5 p-4 rounded-lg">
                                <label class="text-gray-400 text-sm block mb-1">Nombre del Equipo</label>
                                <p class="text-white text-lg">{{ $preRegistro->nombre_equipo }}</p>
                            </div>
                            <div class="bg-white/5 p-4 rounded-lg">
                                <label class="text-gray-400 text-sm block mb-1">Número de Integrantes</label>
                                <p class="text-white text-lg">{{ $preRegistro->integrantes }}</p>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div class="bg-white/5 p-4 rounded-lg">
                                <label class="text-gray-400 text-sm block mb-1">Asesor</label>
                                <p class="text-white text-lg">{{ $preRegistro->asesor ?: 'No especificado' }}</p>
                            </div>
                            <div class="bg-white/5 p-4 rounded-lg">
                                <label class="text-gray-400 text-sm block mb-1">Institución</label>
                                <p class="text-white text-lg">{{ $preRegistro->institucion ?: 'No especificada' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Comentarios -->
                <div class="bg-white/5 rounded-xl p-6 border border-white/10 transition-all duration-300 hover:bg-white/10 hover:border-white/20">
                    <h2 class="text-2xl font-semibold text-white mb-6 flex items-center gap-3">
                        <i class="fas fa-comments text-purple-400"></i>
                        Comentarios
                    </h2>
                    <div class="bg-white/5 p-4 rounded-lg">
                        <p class="text-white/90 whitespace-pre-line text-lg">{{ $preRegistro->comentarios ?: 'Sin comentarios' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection