@extends('layouts.admin')

@section('contenido')
<div class="bg-gray-800 bg-opacity-50 p-6 rounded-lg shadow-lg">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-white flex items-center">
            <i class="fas fa-bullhorn mr-3 text-blue-400"></i>{{ $convocatoria->nombre_evento }}
        </h1>
        <div class="space-x-2">
            <a href="{{ route('admin.convocatorias.edit', $convocatoria) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600/20 text-yellow-400 rounded-lg font-semibold text-xs uppercase tracking-widest hover:bg-yellow-600/30 transition-all duration-150">
                <i class="fas fa-edit mr-2"></i> Editar
            </a>
            <a href="{{ route('admin.convocatorias.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 transition-all duration-150">
                <i class="fas fa-arrow-left mr-2"></i> Volver
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-gray-700/50 p-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
            @if($convocatoria->imagen_portada)
                <img src="{{ Storage::url($convocatoria->imagen_portada) }}" class="w-full h-64 object-cover rounded-lg mb-4" alt="Imagen de portada">
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
                    <dt class="text-gray-400 font-medium">Máx. Integrantes</dt>
                    <dd class="col-span-2 text-white">{{ $convocatoria->max_integrantes }}</dd>
                </div>
                <div class="grid grid-cols-3 gap-4 items-center">
                    <dt class="text-gray-400 font-medium">Asesor Requerido</dt>
                    <dd class="col-span-2 text-white">{{ $convocatoria->asesor_requerido ? 'Sí' : 'No' }}</dd>
                </div>
                <div class="grid grid-cols-3 gap-4 items-center">
                    <dt class="text-gray-400 font-medium">Email de Contacto</dt>
                    <dd class="col-span-2 text-white">{{ $convocatoria->contacto_email ?? 'No especificado' }}</dd>
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
                <i class="fas fa-tasks mr-2 text-blue-400"></i>Etapas de la Misión
            </h3>
            <div class="text-gray-300 prose prose-invert max-w-none">
                {!! nl2br(e($convocatoria->etapas_mision)) !!}
            </div>
        </div>
        <div class="bg-gray-700/50 p-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
            <h3 class="text-xl font-semibold text-white mb-4 flex items-center">
                <i class="fas fa-vial mr-2 text-blue-400"></i>Pruebas Requeridas
            </h3>
            <div class="text-gray-300 prose prose-invert max-w-none">
                {!! nl2br(e($convocatoria->pruebas_requeridas)) !!}
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-gray-700/50 p-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
            <h3 class="text-xl font-semibold text-white mb-4 flex items-center">
                <i class="fas fa-star mr-2 text-blue-400"></i>Criterios de Evaluación
            </h3>
            <div class="text-gray-300 prose prose-invert max-w-none">
                {!! nl2br(e($convocatoria->criterios_evaluacion)) !!}
            </div>
        </div>
        <div class="bg-gray-700/50 p-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
            <h3 class="text-xl font-semibold text-white mb-4 flex items-center">
                <i class="fas fa-trophy mr-2 text-blue-400"></i>Premiación
            </h3>
            <div class="text-gray-300 prose prose-invert max-w-none">
                {!! nl2br(e($convocatoria->premiacion ?? 'No especificado')) !!}
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
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-white">{{ $fecha->titulo }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-white">{{ $fecha->fecha->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @if($convocatoria->imagenes->count() > 0)
        <div class="bg-gray-700/50 p-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 mb-6">
            <h3 class="text-xl font-semibold text-white mb-4 flex items-center">
                <i class="fas fa-images mr-2 text-blue-400"></i>Imágenes Adicionales
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($convocatoria->imagenes as $imagen)
                    <div class="relative group">
                        <img src="{{ Storage::url($imagen->imagen) }}" class="w-full h-48 object-cover rounded-lg transition-transform duration-300 group-hover:scale-105" alt="Imagen adicional">
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <div class="bg-gray-700/50 p-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
        <h3 class="text-xl font-semibold text-white mb-4 flex items-center">
            <i class="fas fa-file-alt mr-2 text-blue-400"></i>Documentos
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @if($convocatoria->archivo_pdf)
                <a href="{{ Storage::url($convocatoria->archivo_pdf) }}" class="flex items-center p-4 bg-gray-600/50 rounded-lg hover:bg-gray-600/70 transition-all group" target="_blank">
                    <i class="fas fa-file-pdf text-red-400 text-2xl mr-3 group-hover:scale-110 transition-transform"></i>
                    <span class="text-white">Documento General PDF</span>
                </a>
            @endif
            @if($convocatoria->archivo_pdr)
                <a href="{{ Storage::url($convocatoria->archivo_pdr) }}" class="flex items-center p-4 bg-gray-600/50 rounded-lg hover:bg-gray-600/70 transition-all group" target="_blank">
                    <i class="fas fa-file text-blue-400 text-2xl mr-3 group-hover:scale-110 transition-transform"></i>
                    <span class="text-white">Documento PDR</span>
                </a>
            @endif
            @if($convocatoria->archivo_cdr)
                <a href="{{ Storage::url($convocatoria->archivo_cdr) }}" class="flex items-center p-4 bg-gray-600/50 rounded-lg hover:bg-gray-600/70 transition-all group" target="_blank">
                    <i class="fas fa-file text-green-400 text-2xl mr-3 group-hover:scale-110 transition-transform"></i>
                    <span class="text-white">Documento CDR</span>
                </a>
            @endif
            @if($convocatoria->archivo_pfr)
                <a href="{{ Storage::url($convocatoria->archivo_pfr) }}" class="flex items-center p-4 bg-gray-600/50 rounded-lg hover:bg-gray-600/70 transition-all group" target="_blank">
                    <i class="fas fa-file text-purple-400 text-2xl mr-3 group-hover:scale-110 transition-transform"></i>
                    <span class="text-white">Documento PFR</span>
                </a>
            @endif
        </div>
    </div>
</div>
@endsection