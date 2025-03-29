@extends('layouts.user')

@section('titulo', 'Concursos Activos')

@section('contenido')
<div class="bg-gray-800 bg-opacity-50 p-6 rounded-lg shadow-lg">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-white flex items-center">
            <i class="fas fa-trophy mr-3 text-blue-400"></i>Concursos Activos
        </h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($concursos as $concurso)
            @if($concurso->estado === 'activo' && $concurso->convocatorias->count() > 0)
                @foreach($concurso->convocatorias as $convocatoria)
                    <div class="bg-gradient-to-br from-blue-900 to-blue-950 rounded-lg overflow-hidden transition-all duration-300 shadow-xl">
                        <div class="p-6 space-y-4">
                            <div class="flex items-start justify-between">
                                <h3 class="text-xl font-semibold text-white">{{ $concurso->titulo }}</h3>
                                <span class="px-3 py-1 text-xs font-medium rounded-full bg-green-500/20 text-green-400">
                                    <i class="fas fa-check-circle mr-1"></i>Activo
                                </span>
                            </div>
                            
                            <div class="space-y-3">
                                <div class="flex items-center text-sm text-gray-300">
                                    <i class="fas fa-map-marker-alt w-5 text-gray-400"></i>
                                    <span>{{ $convocatoria->sede }}</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-300">
                                    <i class="fas fa-users w-5 text-gray-400"></i>
                                    <span>{{ $convocatoria->dirigido_a }}</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-300">
                                    <i class="fas fa-user-friends w-5 text-gray-400"></i>
                                    <span>Máx. {{ $convocatoria->max_integrantes }} integrantes</span>
                                </div>
                                @if($convocatoria->fechasImportantes->count() > 0)
                                    <div class="flex items-center text-sm text-gray-300">
                                        <i class="fas fa-calendar w-5 text-gray-400"></i>
                                        <span>Próxima fecha: {{ $convocatoria->fechasImportantes->sortBy('fecha')->first()->titulo }} - {{ $convocatoria->fechasImportantes->sortBy('fecha')->first()->fecha->format('d/m/Y') }}</span>
                                    </div>
                                @endif
                            </div>

                            <div class="pt-4 space-y-2">
                                <a href="{{ route('user.concursos.convocatorias.show', $convocatoria) }}" class="inline-flex items-center px-4 py-3 bg-blue-600/10 text-blue-300 rounded-lg text-sm hover:bg-blue-600/20 transition-all w-full justify-center">
                                    <i class="fas fa-info-circle mr-2"></i>Ver detalles
                                </a>
                                @php
                                    $existingPreRegistro = \App\Models\PreRegistroConcurso::where('usuario_id', Auth::id())
                                        ->where('concurso_id', $concurso->id)
                                        ->whereNull('deleted_at')
                                        ->first();
                                @endphp
                                @if($existingPreRegistro)
                                    <a href="{{ route('user.concursos.pre-registros.show', $existingPreRegistro) }}" class="inline-flex items-center px-4 py-3 bg-blue-600/10 text-blue-300 rounded-lg text-sm hover:bg-blue-600/20 transition-all w-full justify-center">
                                        <i class="fas fa-eye mr-2"></i>Ver Pre-registro
                                    </a>
                                @else
                                    <a href="{{ route('user.concursos.pre-registros.create', ['convocatoria' => $convocatoria->id]) }}" class="inline-flex items-center px-4 py-3 bg-blue-600/10 text-blue-300 rounded-lg text-sm hover:bg-blue-600/20 transition-all w-full justify-center">
                                        <i class="fas fa-user-plus mr-2"></i>Pre-registro
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        @empty
            <div class="col-span-full p-8 text-center">
                <i class="fas fa-folder-open text-4xl text-gray-600 mb-4"></i>
                <p class="text-gray-400">No hay concursos activos en este momento</p>
            </div>
        @endforelse
    </div>
</div>
@endsection