@extends('layouts.admin')

@section('contenido')
<div class="bg-gray-800 bg-opacity-50 p-6 rounded-lg shadow-lg">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-white flex items-center">
            <i class="fa-solid fa-graduation-cap mr-3 text-blue-400"></i>{{ $convocatoria->congreso->nombre }}
        </h1>
        <div class="space-x-2">
            <a href="{{ route('admin.congresos.convocatorias.edit', $convocatoria) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600/20 text-yellow-400 rounded-lg font-semibold text-xs uppercase tracking-widest hover:bg-yellow-600/30 transition-all duration-150">
                <i class="fas fa-edit mr-2"></i> Editar
            </a>
            <a href="{{ route('admin.congresos.convocatorias.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 transition-all duration-150">
                <i class="fas fa-arrow-left mr-2"></i> Volver
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-gray-700/50 p-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
            @if($convocatoria->imagen_portada)
                <img src="{{ asset($convocatoria->imagen_portada) }}" class="w-full h-64 object-cover rounded-lg mb-4" alt="Imagen de portada">
            @endif
        </div>
        <div class="bg-gray-700/50 p-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
            <h3 class="text-xl font-semibold text-white mb-4 flex items-center">
                <i class="fas fa-info-circle mr-2 text-blue-400"></i>Información General
            </h3>
            <dl class="space-y-3">
                <div class="grid grid-cols-3 gap-4 items-center">
                    <dt class="text-gray-400 font-medium">Sede</dt>
                    <dd class="col-span-2 text-white">{{ $convocatoria->sede }}</dd>
                </div>
                <div class="grid grid-cols-3 gap-4 items-center">
                    <dt class="text-gray-400 font-medium">Dirigido a</dt>
                    <dd class="col-span-2 text-white">{{ $convocatoria->dirigido_a }}</dd>
                </div>
                <div class="grid grid-cols-3 gap-4 items-center">
                    <dt class="text-gray-400 font-medium">Email de Contacto</dt>
                    <dd class="col-span-2 text-white">{{ $convocatoria->contacto_email ?? 'No especificado' }}</dd>
                </div>
                <div class="grid grid-cols-3 gap-4 items-center">
                    <dt class="text-gray-400 font-medium">Cuotas de Inscripción</dt>
                    <dd class="col-span-2">
                        @if($convocatoria->cuotas_inscripcion && count($convocatoria->cuotas_inscripcion) > 0)
                            <div class="space-y-2">
                                @foreach($convocatoria->cuotas_inscripcion as $cuota)
                                    <div class="flex justify-between items-center bg-gray-800/30 p-2 rounded">
                                        <span class="text-gray-300">{{ $cuota['rol'] }}</span>
                                        <span class="text-white font-medium">${{ number_format($cuota['monto'], 2) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <span class="text-white">Gratuito</span>
                        @endif
                    </dd>
                </div>
            </dl>
        </div>
    </div>

    <div class="bg-gray-700/50 p-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 mb-6">
        <h3 class="text-xl font-semibold text-white mb-4 flex items-center">
            <i class="fas fa-list-check mr-2 text-blue-400"></i>Requisitos
        </h3>
        <div class="text-gray-300 prose prose-invert max-w-none">
            {!! nl2br(e($convocatoria->requisitos)) !!}
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-gray-700/50 p-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
            <h3 class="text-xl font-semibold text-white mb-4 flex items-center">
                <i class="fas fa-lightbulb mr-2 text-blue-400"></i>Temáticas
            </h3>
            <div class="space-y-4">
                @foreach($convocatoria->tematicas as $tematica)
                    <div class="bg-gray-800/50 p-4 rounded-lg">
                        <h4 class="text-lg font-semibold text-white mb-2">{{ $tematica['titulo'] }}</h4>
                        <p class="text-gray-300">{{ $tematica['descripcion'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="bg-gray-700/50 p-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
            <h3 class="text-xl font-semibold text-white mb-4 flex items-center">
                <i class="fas fa-star mr-2 text-blue-400"></i>Criterios de Evaluación
            </h3>
            <div class="text-gray-300 prose prose-invert max-w-none">
                {!! nl2br(e($convocatoria->criterios_evaluacion)) !!}
            </div>
        </div>
    </div>

    <div class="bg-gray-700/50 p-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 mb-6">
        <h3 class="text-xl font-semibold text-white mb-4 flex items-center">
            <i class="fas fa-calendar mr-2 text-blue-400"></i>Fechas Importantes
        </h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-600">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Evento</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Fecha</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-600">
                    @foreach($convocatoria->fechasImportantes as $fecha)
                        <tr class="hover:bg-gray-600/30 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $fecha->titulo }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $fecha->fecha->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-gray-700/50 p-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 mb-6">
        <h3 class="text-xl font-semibold text-white mb-4 flex items-center">
            <i class="fas fa-file-pdf mr-2 text-blue-400"></i>Documentos
        </h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @if($convocatoria->archivo_convocatoria)
                <div class="bg-black/30 p-4 rounded-xl border border-white/10 hover:border-red-400/50 transition-all duration-300">
                    <div class="flex flex-col items-center text-center space-y-3">
                        <i class="fas fa-file-pdf text-red-400 text-3xl"></i>
                        <span class="text-white/90 font-medium">Convocatoria</span>
                        <a href="{{ asset($convocatoria->archivo_convocatoria) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-red-500/20 text-red-400 rounded-lg hover:bg-red-500/30 transition-colors duration-200">
                            <i class="fas fa-eye mr-2"></i>Visualizar
                        </a>
                    </div>
                </div>
            @endif

            @if($convocatoria->archivo_articulo)
                <div class="bg-black/30 p-4 rounded-xl border border-white/10 hover:border-blue-400/50 transition-all duration-300">
                    <div class="flex flex-col items-center text-center space-y-3">
                        <i class="fas fa-file-pdf text-blue-400 text-3xl"></i>
                        <span class="text-white/90 font-medium">Formato de Artículo</span>
                        <a href="{{ asset($convocatoria->archivo_articulo) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-500/20 text-blue-400 rounded-lg hover:bg-blue-500/30 transition-colors duration-200">
                            <i class="fas fa-eye mr-2"></i>Visualizar
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection