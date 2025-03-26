@extends('layouts.admin')

@section('titulo', 'Crear Nueva Sección')

@section('contenido')
<div class="bg-gradient-to-br from-gray-900 to-black rounded-xl shadow-xl p-8 max-w-4xl mx-auto">
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-white">Crear Nueva Sección</h1>
            <a href="{{ route('admin.noticias.secciones.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition-all">
                Volver
            </a>
        </div>
    </div>

    @if($errors->any())
        <div class="bg-red-500 text-white p-4 rounded-lg mb-6">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.noticias.secciones.store') }}" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 gap-6">
            <div>
                <label for="titulo" class="block text-sm font-medium text-gray-300 mb-2">Título</label>
                <input type="text" name="titulo" id="titulo" value="{{ old('titulo') }}" required
                    class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-500 @error('titulo') border-red-500 @enderror">
                @error('titulo')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex justify-end space-x-4">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-purple-700 transition-all">
                Crear Sección
            </button>
        </div>
    </form>
</div>
@endsection