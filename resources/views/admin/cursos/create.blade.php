@extends('layouts.admin')

@section('titulo', 'Crear Nuevo Curso')

@section('contenido')
<div class="bg-gray-900 text-white p-6 rounded-lg shadow-lg max-w-4xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold">Crear Nuevo Curso</h1>
    </div>

    <form action="{{ route('admin.cursos.store') }}" method="POST" class="space-y-6">
        @csrf

        @if($errors->any())
            <div class="bg-red-500 text-white p-4 rounded-lg mb-6">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 gap-6">
            <div>
                <label for="titulo" class="block text-sm font-medium mb-2">Título del Curso</label>
                <input type="text" name="titulo" id="titulo" value="{{ old('titulo') }}" required
                    class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="categoria_id" class="block text-sm font-medium mb-2">Categoría</label>
                <select name="categoria_id" id="categoria_id" required
                    class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Seleccionar categoría</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                            {{ $categoria->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="descripcion" class="block text-sm font-medium mb-2">Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="4" required
                    class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('descripcion') }}</textarea>
            </div>

            <div>
                <label for="tema_id" class="block text-sm font-medium mb-2">Tema</label>
                <select name="tema_id" id="tema_id" required
                    class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Seleccionar tema</option>
                    @foreach($temas as $tema)
                        <option value="{{ $tema->id }}" {{ old('tema_id') == $tema->id ? 'selected' : '' }}>
                            {{ $tema->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="ponente_id" class="block text-sm font-medium mb-2">Ponente</label>
                <select name="ponente_id" id="ponente_id" required
                    class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Seleccionar ponente</option>
                    @foreach($ponentes as $ponente)
                        <option value="{{ $ponente->id }}" {{ old('ponente_id') == $ponente->id ? 'selected' : '' }}>
                            {{ $ponente->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="costo" class="block text-sm font-medium mb-2">Costo</label>
                <input type="number" name="costo" id="costo" value="{{ old('costo') }}" step="0.01" required
                    class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label for="fecha_inicio" class="block text-sm font-medium mb-2">Fecha de Inicio</label>
                    <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{ old('fecha_inicio') }}" required
                        class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="fecha_fin" class="block text-sm font-medium mb-2">Fecha de Fin</label>
                    <input type="date" name="fecha_fin" id="fecha_fin" value="{{ old('fecha_fin') }}" required
                        class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div>
                <label for="estado" class="block text-sm font-medium mb-2">Estado del Curso</label>
                <select name="estado" id="estado" required
                    class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="pendiente" {{ old('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="activo" {{ old('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                    <option value="inactivo" {{ old('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>
        </div>

        <div class="flex justify-end space-x-4">
            <a href="{{ route('admin.cursos.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                Cancelar
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Crear Curso
            </button>
        </div>
    </form>
</div>
@endsection