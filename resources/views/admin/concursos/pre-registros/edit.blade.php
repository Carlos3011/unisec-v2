@extends('layouts.admin')

@section('contenido')
<div class="relative z-10">
    <div class="bg-gradient-to-br from-gray-900 to-black rounded-xl shadow-xl p-8 mb-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-white">Editar Pre-registro</h1>
            <a href="{{ route('admin.concursos.pre-registros.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg shadow-lg transition-all flex items-center space-x-2">
                <i class="fas fa-arrow-left"></i>
                <span>Volver</span>
            </a>
        </div>

        <form action="{{ route('admin.concursos.pre-registros.update', $preRegistro) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            @if($errors->any())
                <div class="bg-red-500/20 text-red-500 px-4 py-3 rounded-lg mb-6" role="alert">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Información del Equipo -->
                <div class="bg-gray-800/50 rounded-xl p-6 space-y-4">
                    <h2 class="text-xl font-semibold text-white mb-4">Información del Equipo</h2>
                    
                    <div>
                        <label for="nombre_equipo" class="block text-sm font-medium text-gray-400 mb-1">Nombre del Equipo</label>
                        <input type="text" name="nombre_equipo" id="nombre_equipo" value="{{ old('nombre_equipo', $preRegistro->nombre_equipo) }}" 
                               class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>

                    <div>
                        <label for="integrantes" class="block text-sm font-medium text-gray-400 mb-1">Número de Integrantes</label>
                        <input type="number" name="integrantes" id="integrantes" value="{{ old('integrantes', $preRegistro->integrantes) }}" 
                               class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>

                    <div>
                        <label for="asesor" class="block text-sm font-medium text-gray-400 mb-1">Asesor</label>
                        <input type="text" name="asesor" id="asesor" value="{{ old('asesor', $preRegistro->asesor) }}" 
                               class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>

                    <div>
                        <label for="institucion" class="block text-sm font-medium text-gray-400 mb-1">Institución</label>
                        <input type="text" name="institucion" id="institucion" value="{{ old('institucion', $preRegistro->institucion) }}" 
                               class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>
                </div>

                <!-- Información del Concurso y Estado -->
                <div class="bg-gray-800/50 rounded-xl p-6 space-y-4">
                    <h2 class="text-xl font-semibold text-white mb-4">Información del Concurso</h2>

                    <div>
                        <label for="concurso_id" class="block text-sm font-medium text-gray-400 mb-1">Concurso</label>
                        <select name="concurso_id" id="concurso_id" 
                                class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                            @foreach($concursos as $concurso)
                                <option value="{{ $concurso->id }}" {{ old('concurso_id', $preRegistro->concurso_id) == $concurso->id ? 'selected' : '' }}>
                                    {{ $concurso->titulo }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="estado" class="block text-sm font-medium text-gray-400 mb-1">Estado del Pre-registro</label>
                        <select name="estado" id="estado" 
                                class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                            <option value="pendiente" {{ old('estado', $preRegistro->estado) === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="validado" {{ old('estado', $preRegistro->estado) === 'validado' ? 'selected' : '' }}>Validado</option>
                            <option value="rechazado" {{ old('estado', $preRegistro->estado) === 'rechazado' ? 'selected' : '' }}>Rechazado</option>
                        </select>
                    </div>

                    <div>
                        <label for="estado_pdr" class="block text-sm font-medium text-gray-400 mb-1">Estado PDR</label>
                        <select name="estado_pdr" id="estado_pdr" 
                                class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                            <option value="pendiente" {{ old('estado_pdr', $preRegistro->estado_pdr) === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="aprobado" {{ old('estado_pdr', $preRegistro->estado_pdr) === 'aprobado' ? 'selected' : '' }}>Aprobado</option>
                            <option value="rechazado" {{ old('estado_pdr', $preRegistro->estado_pdr) === 'rechazado' ? 'selected' : '' }}>Rechazado</option>
                        </select>
                    </div>

                    <div>
                        <label for="comentarios_evaluacion" class="block text-sm font-medium text-gray-400 mb-1">Comentarios de Evaluación</label>
                        <textarea name="comentarios_evaluacion" id="comentarios_evaluacion" rows="4" 
                                  class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">{{ old('comentarios_evaluacion', $preRegistro->comentarios_evaluacion) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="flex justify-end space-x-4 mt-6">
                <button type="submit" class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-2 rounded-lg shadow-lg transition-all flex items-center space-x-2">
                    <i class="fas fa-save"></i>
                    <span>Guardar Cambios</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection