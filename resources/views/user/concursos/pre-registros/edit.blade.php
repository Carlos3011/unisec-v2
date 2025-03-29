@extends('layouts.user')

@section('contenido')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Editar Pre-registro</h2>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('user.concursos.pre-registros.update', $preRegistro) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="concurso_id" class="block text-sm font-medium text-gray-700 mb-1">Concurso</label>
                <div class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-gray-100 rounded-md shadow-sm text-gray-700">
                    {{ $preRegistro->concurso->nombre }}
                </div>
                <input type="hidden" name="concurso_id" value="{{ $preRegistro->concurso_id }}">
            </div>

            <div>
                <label for="nombre_equipo" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Equipo</label>
                <input type="text" name="nombre_equipo" id="nombre_equipo" value="{{ old('nombre_equipo', $preRegistro->nombre_equipo) }}" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <div>
                <label for="integrantes" class="block text-sm font-medium text-gray-700 mb-1">Número de Integrantes</label>
                <input type="number" name="integrantes" id="integrantes" value="{{ old('integrantes', $preRegistro->integrantes) }}" required min="1"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <div>
                <label for="asesor" class="block text-sm font-medium text-gray-700 mb-1">Asesor (Opcional)</label>
                <input type="text" name="asesor" id="asesor" value="{{ old('asesor', $preRegistro->asesor) }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <div>
                <label for="institucion" class="block text-sm font-medium text-gray-700 mb-1">Institución (Opcional)</label>
                <input type="text" name="institucion" id="institucion" value="{{ old('institucion', $preRegistro->institucion) }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <div>
                <label for="comentarios" class="block text-sm font-medium text-gray-700 mb-1">Comentarios (Opcional)</label>
                <textarea name="comentarios" id="comentarios" rows="3"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('comentarios', $preRegistro->comentarios) }}</textarea>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('user.concursos.pre-registros.show', $preRegistro) }}"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Cancelar
                </a>
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Actualizar Pre-registro
                </button>
            </div>
        </form>
    </div>
</div>
@endsection