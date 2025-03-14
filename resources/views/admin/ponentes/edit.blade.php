@extends('layouts.admin')

@section('titulo', 'Editar Ponente')

@section('contenido')
    <div class="container mx-auto px-4 py-8">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-white">Editar Ponente</h1>
            <a href="{{ route('admin.ponentes.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Volver
            </a>
        </div>

        <div class="bg-gray-800 shadow-md rounded-lg p-6">
            <form action="{{ route('admin.ponentes.update', $ponente) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="nombre" class="block text-gray-300 text-sm font-bold mb-2">Nombre</label>
                    <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $ponente->nombre) }}"
                        class="w-full bg-gray-700 border border-gray-600 rounded py-2 px-3 text-gray-300 focus:outline-none focus:border-blue-500"
                        required>
                    @error('nombre')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="especialidad" class="block text-gray-300 text-sm font-bold mb-2">Especialidad</label>
                    <input type="text" name="especialidad" id="especialidad" value="{{ old('especialidad', $ponente->especialidad) }}"
                        class="w-full bg-gray-700 border border-gray-600 rounded py-2 px-3 text-gray-300 focus:outline-none focus:border-blue-500"
                        required>
                    @error('especialidad')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="bio" class="block text-gray-300 text-sm font-bold mb-2">Biografía</label>
                    <textarea name="bio" id="bio" rows="4"
                        class="w-full bg-gray-700 border border-gray-600 rounded py-2 px-3 text-gray-300 focus:outline-none focus:border-blue-500"
                        required>{{ old('bio', $ponente->bio) }}</textarea>
                    @error('bio')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Actualizar Ponente
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection