@extends('layouts.admin')

@section('contenido')
<div class="relative z-10">
    <div class="bg-gradient-to-br from-gray-900 to-black rounded-xl shadow-xl p-8 mb-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-white">Detalles de la Inscripción</h1>
            <div class="flex space-x-2">
                <a href="{{ route('admin.congresos.inscripciones.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg shadow-lg transition-all flex items-center space-x-2">
                    <i class="fas fa-arrow-left"></i>
                    <span>Volver</span>
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-500/20 text-green-500 px-4 py-3 rounded-lg mb-6" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-500/20 text-red-500 px-4 py-3 rounded-lg mb-6" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Información del Participante -->
            <div class="bg-gray-800/50 rounded-xl p-6">
                <h2 class="text-xl font-semibold text-white mb-4">Información del Participante</h2>
                <div class="space-y-4">
                    <div>
                        <label class="text-gray-400 text-sm">Nombre</label>
                        <p class="text-white">{{ $inscripcion->usuario->name }}</p>
                    </div>
                    <div>
                        <label class="text-gray-400 text-sm">Email</label>
                        <p class="text-white">{{ $inscripcion->usuario->email }}</p>
                    </div>
                    <div>
                        <label class="text-gray-400 text-sm">Tipo de Participante</label>
                        <p class="text-white">{{ ucfirst($inscripcion->tipo_participante) }}</p>
                    </div>
                </div>
            </div>

            <!-- Información del Congreso -->
            <div class="bg-gray-800/50 rounded-xl p-6">
                <h2 class="text-xl font-semibold text-white mb-4">Información del Congreso</h2>
                <div class="space-y-4">
                    <div>
                        <label class="text-gray-400 text-sm">Congreso</label>
                        <p class="text-white">{{ $inscripcion->congreso->titulo }}</p>
                    </div>
                    <div>
                        <label class="text-gray-400 text-sm">Convocatoria</label>
                        <p class="text-white">{{ $inscripcion->convocatoria->titulo }}</p>
                    </div>
                    <div>
                        <label class="text-gray-400 text-sm">Fecha de Inscripción</label>
                        <p class="text-white">{{ $inscripcion->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Información del Artículo -->
            @if($inscripcion->articulo)
            <div class="bg-gray-800/50 rounded-xl p-6">
                <h2 class="text-xl font-semibold text-white mb-4">Información del Artículo</h2>
                <div class="space-y-4">
                    <div>
                        <label class="text-gray-400 text-sm">Estado del Artículo</label>
                        <div class="mt-1">
                            <span class="px-3 py-1 rounded-full text-xs inline-block
                                @switch($inscripcion->articulo->estado_articulo)
                                    @case('aceptado')
                                        bg-green-500/20 text-green-500
                                        @break
                                    @case('rechazado')
                                        bg-red-500/20 text-red-500
                                        @break
                                    @case('en_revision')
                                        bg-yellow-500/20 text-yellow-500
                                        @break
                                    @default
                                        bg-gray-500/20 text-gray-500
                                @endswitch">
                                {{ ucfirst(str_replace('_', ' ', $inscripcion->articulo->estado_articulo)) }}
                            </span>
                        </div>
                    </div>
                    <div>
                        <label class="text-gray-400 text-sm">Estado del Extenso</label>
                        <div class="mt-1">
                            <span class="px-3 py-1 rounded-full text-xs inline-block
                                @switch($inscripcion->articulo->estado_extenso)
                                    @case('aceptado')
                                        bg-green-500/20 text-green-500
                                        @break
                                    @case('rechazado')
                                        bg-red-500/20 text-red-500
                                        @break
                                    @case('en_revision')
                                        bg-yellow-500/20 text-yellow-500
                                        @break
                                    @default
                                        bg-gray-500/20 text-gray-500
                                @endswitch">
                                {{ ucfirst(str_replace('_', ' ', $inscripcion->articulo->estado_extenso)) }}
                            </span>
                        </div>
                    </div>
                    <div>
                        <label class="text-gray-400 text-sm">Comentarios del Artículo</label>
                        <p class="text-white">{{ $inscripcion->articulo->comentarios_articulo ?: 'Sin comentarios' }}</p>
                    </div>
                    <div>
                        <label class="text-gray-400 text-sm">Comentarios del Extenso</label>
                        <p class="text-white">{{ $inscripcion->articulo->comentarios_extenso ?: 'Sin comentarios' }}</p>
                    </div>
                </div>

                <!-- Formulario de Evaluación de Artículo -->
                <form action="{{ route('admin.congresos.inscripciones.evaluar-articulo', $inscripcion) }}" method="POST" class="mt-6 space-y-4">
                    @csrf
                    <div>
                        <label for="estado_articulo" class="block text-sm font-medium text-gray-400 mb-2">Estado del Artículo</label>
                        <select name="estado_articulo" id="estado_articulo" class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                            <option value="pendiente" {{ $inscripcion->articulo->estado_articulo === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="en_revision" {{ $inscripcion->articulo->estado_articulo === 'en_revision' ? 'selected' : '' }}>En Revisión</option>
                            <option value="aceptado" {{ $inscripcion->articulo->estado_articulo === 'aceptado' ? 'selected' : '' }}>Aceptado</option>
                            <option value="rechazado" {{ $inscripcion->articulo->estado_articulo === 'rechazado' ? 'selected' : '' }}>Rechazado</option>
                        </select>
                    </div>
                    <div>
                        <label for="comentarios_articulo" class="block text-sm font-medium text-gray-400 mb-2">Comentarios del Artículo</label>
                        <textarea name="comentarios_articulo" id="comentarios_articulo" rows="3" class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">{{ $inscripcion->articulo->comentarios_articulo }}</textarea>
                    </div>
                    <button type="submit" class="w-full px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-all">
                        Actualizar Evaluación del Artículo
                    </button>
                </form>

                <!-- Formulario de Evaluación de Extenso -->
                <form action="{{ route('admin.congresos.inscripciones.evaluar-extenso', $inscripcion) }}" method="POST" class="mt-6 space-y-4">
                    @csrf
                    <div>
                        <label for="estado_extenso" class="block text-sm font-medium text-gray-400 mb-2">Estado del Extenso</label>
                        <select name="estado_extenso" id="estado_extenso" class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                            <option value="pendiente" {{ $inscripcion->articulo->estado_extenso === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="en_revision" {{ $inscripcion->articulo->estado_extenso === 'en_revision' ? 'selected' : '' }}>En Revisión</option>
                            <option value="aceptado" {{ $inscripcion->articulo->estado_extenso === 'aceptado' ? 'selected' : '' }}>Aceptado</option>
                            <option value="rechazado" {{ $inscripcion->articulo->estado_extenso === 'rechazado' ? 'selected' : '' }}>Rechazado</option>
                        </select>
                    </div>
                    <div>
                        <label for="comentarios_extenso" class="block text-sm font-medium text-gray-400 mb-2">Comentarios del Extenso</label>
                        <textarea name="comentarios_extenso" id="comentarios_extenso" rows="3" class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">{{ $inscripcion->articulo->comentarios_extenso }}</textarea>
                    </div>
                    <button type="submit" class="w-full px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-all">
                        Actualizar Evaluación del Extenso
                    </button>
                </form>
            </div>
            @endif

            <!-- Información del Pago -->
            <div class="bg-gray-800/50 rounded-xl p-6">
                <h2 class="text-xl font-semibold text-white mb-4">Información del Pago</h2>
                <div class="space-y-4">
                    <div>
                        <label class="text-gray-400 text-sm">Estado del Pago</label>
                        <div class="mt-1">
                            <span class="px-3 py-1 rounded-full text-xs inline-block
                                @switch($inscripcion->pagoInscripcion->estado_pago ?? 'pendiente')
                                    @case('pagado')
                                        bg-green-500/20 text-green-500
                                        @break
                                    @case('rechazado')
                                        bg-red-500/20 text-red-500
                                        @break
                                    @default
                                        bg-yellow-500/20 text-yellow-500
                                @endswitch">
                                {{ ucfirst($inscripcion->pagoInscripcion->estado_pago ?? 'pendiente') }}
                            </span>
                        </div>
                    </div>
                    @if($inscripcion->pagoInscripcion)
                        <div>
                            <label class="text-gray-400 text-sm">Fecha de Pago</label>
                            <p class="text-white">{{ $inscripcion->pagoInscripcion->fecha_pago ? $inscripcion->pagoInscripcion->fecha_pago->format('d/m/Y H:i') : 'No registrada' }}</p>
                        </div>
                        <div>
                            <label class="text-gray-400 text-sm">Detalles de la Transacción</label>
                            <p class="text-white">{{ $inscripcion->pagoInscripcion->detalles_transaccion ?: 'Sin detalles' }}</p>
                        </div>
                    @endif

                    <!-- Formulario de Actualización de Estado de Pago -->
                    <form action="{{ route('admin.congresos.inscripciones.actualizar-pago', $inscripcion) }}" method="POST" class="mt-6 space-y-4">
                        @csrf
                        <div>
                            <label for="estado_pago" class="block text-sm font-medium text-gray-400 mb-2">Estado del Pago</label>
                            <select name="estado_pago" id="estado_pago" class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                                <option value="pendiente" {{ ($inscripcion->pagoInscripcion->estado_pago ?? 'pendiente') === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="pagado" {{ ($inscripcion->pagoInscripcion->estado_pago ?? '') === 'pagado' ? 'selected' : '' }}>Pagado</option>
                                <option value="rechazado" {{ ($inscripcion->pagoInscripcion->estado_pago ?? '') === 'rechazado' ? 'selected' : '' }}>Rechazado</option>
                            </select>
                        </div>
                        <div>
                            <label for="detalles_transaccion" class="block text-sm font-medium text-gray-400 mb-2">Detalles de la Transacción</label>
                            <textarea name="detalles_transaccion" id="detalles_transaccion" rows="3" class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">{{ $inscripcion->pagoInscripcion->detalles_transaccion ?? '' }}</textarea>
                        </div>
                        <button type="submit" class="w-full px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-all">
                            Actualizar Estado del Pago
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection