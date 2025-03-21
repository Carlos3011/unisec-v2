@extends('layouts.admin')

@section('contenido')
<div class="bg-gray-800 bg-opacity-50 p-6 rounded-lg shadow-lg">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-white">{{ $convocatoria->titulo }}</h1>
        <div class="space-x-2">
            <a href="{{ route('admin.convocatorias.edit', $convocatoria) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200">
                <i class="fas fa-edit mr-2"></i> Editar
            </a>
            <a href="{{ route('admin.convocatorias.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i> Volver
            </a>
        </div>
    </div>

    <div x-data="{ activeTab: 'info' }" class="space-y-6">
    <div class="border-b border-gray-600">
        <nav class="flex space-x-4" aria-label="Tabs">
            <button @click="activeTab = 'info'" :class="{ 'text-blue-400 border-blue-400': activeTab === 'info', 'text-gray-400 hover:text-gray-300 border-transparent': activeTab !== 'info' }" class="pb-3 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                <i class="fas fa-info-circle mr-2"></i> Información General
            </button>
            <button @click="activeTab = 'archivos'" :class="{ 'text-blue-400 border-blue-400': activeTab === 'archivos', 'text-gray-400 hover:text-gray-300 border-transparent': activeTab !== 'archivos' }" class="pb-3 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                <i class="fas fa-folder-open mr-2"></i> Archivos
            </button>
            <button @click="activeTab = 'fechas'" :class="{ 'text-blue-400 border-blue-400': activeTab === 'fechas', 'text-gray-400 hover:text-gray-300 border-transparent': activeTab !== 'fechas' }" class="pb-3 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                <i class="fas fa-calendar-alt mr-2"></i> Fechas Importantes
            </button>
        </nav>
    </div>

    <div x-show="activeTab === 'info'" x-transition.opacity class="bg-gray-700 p-6 rounded-lg">
        <h2 class="text-xl font-semibold text-white mb-4">Información General</h2>
                <div class="space-y-4">
                    <div>
                        <h3 class="text-sm font-medium text-gray-400">Descripción</h3>
                        <p class="text-white mt-1">{{ $convocatoria->descripcion }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-400">Tipo de Evento</h3>
                        <p class="text-white mt-1">{{ ucfirst($convocatoria->evento_type) }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-400">ID del Evento</h3>
                        <p class="text-white mt-1">{{ $convocatoria->evento_id }}</p>
                    </div>
                </div>
    </div>

    <div x-show="activeTab === 'archivos'" x-transition.opacity class="bg-gray-700 p-6 rounded-lg">
        <h2 class="text-xl font-semibold text-white mb-4">Archivos</h2>
        <div class="space-y-4">
            @if($convocatoria->imagen)
                <div>
                    <h3 class="text-sm font-medium text-gray-400">Imagen</h3>
                    <img src="{{ Storage::url($convocatoria->imagen) }}" alt="Imagen de la convocatoria" class="mt-2 max-w-full h-auto rounded-lg">
                </div>
            @endif
            <div>
                <h3 class="text-sm font-medium text-gray-400">Documento PDF</h3>
                <a href="{{ Storage::url($convocatoria->archivo_pdf) }}" target="_blank" class="inline-flex items-center mt-2 text-blue-400 hover:text-blue-300">
                    <i class="fas fa-file-pdf mr-2"></i> Ver PDF de la Convocatoria
                </a>
            </div>
        </div>
    </div>

    <div x-show="activeTab === 'fechas'" x-transition.opacity class="bg-gray-700 p-6 rounded-lg" x-transition.opacity class="bg-gray-700 p-6 rounded-lg">
        <h2 class="text-xl font-semibold text-white mb-4">Fechas Importantes</h2>
            <div class="space-y-4">
                @forelse($convocatoria->fechasImportantes as $fecha)
                    <div class="bg-gray-600 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-white">{{ $fecha->titulo }}</h3>
                        <p class="text-gray-300 mt-1">{{ $fecha->fecha->format('d/m/Y') }}</p>
                    </div>
                @empty
                    <p class="text-gray-400">No hay fechas importantes registradas</p>
                @endforelse
            </div>
        </div>
    </div>
</div>


@endsection