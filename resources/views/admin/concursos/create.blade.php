@extends('layouts.admin')

@section('titulo', 'Crear Nuevo Concurso')

@section('contenido')
<div class="bg-gradient-to-br from-gray-900 via-gray-800 to-black rounded-2xl shadow-2xl p-8 max-w-4xl mx-auto">
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-400 via-blue-500 to-blue-600 bg-clip-text text-transparent tracking-tight">Crear Nuevo Concurso</h1>
            <a href="{{ route('admin.concursos.index') }}" class="px-4 py-2 bg-gray-600/80 text-white rounded-xl hover:bg-gray-700 transform hover:scale-105 transition-all duration-200 flex items-center gap-2 backdrop-blur-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Volver
            </a>
        </div>
    </div>

    <form action="{{ route('admin.concursos.store') }}" method="POST" class="space-y-8">
        @csrf

        @if($errors->any())
            <div class="bg-red-500/20 text-red-500 px-4 py-3 rounded-lg mb-6">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="space-y-6">
            
            <div class="space-y-2">
                <label for="titulo" class="block text-sm font-medium text-white">Título del Concurso <span class="text-red-500">*</span></label>
                <input type="text" name="titulo" id="titulo" value="{{ old('titulo') }}" required
                    class="w-full px-4 py-3 bg-gray-800/70 border border-gray-700/50 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500/50 transition-all duration-200 placeholder-gray-500 text-white">
            </div>

            <div class="space-y-2">
                <label for="reglas" class="block text-sm font-medium text-white">Reglas <span class="text-red-500">*</span></label>
                <textarea name="reglas" id="reglas" rows="4" required
                    class="w-full px-4 py-3 bg-gray-800/70 border border-gray-700/50 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500/50 transition-all duration-200 placeholder-gray-500 text-white">{{ old('reglas') }}</textarea>
            </div>

            <div class="space-y-2">
                <label for="premios" class="block text-sm font-medium text-white">Premios <span class="text-red-500">*</span></label>
                <textarea name="premios" id="premios" rows="4" required
                    class="w-full px-4 py-3 bg-gray-800/70 border border-gray-700/50 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500/50 transition-all duration-200 placeholder-gray-500 text-white">{{ old('premios') }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="categoria_id" class="block text-sm font-medium text-white">Categoría <span class="text-red-500">*</span></label>
                    <select name="categoria_id" id="categoria_id" required
                        class="w-full px-4 py-3 bg-gray-800/70 border border-gray-700/50 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500/50 transition-all duration-200 text-white">
                        <option value="">Seleccionar categoría</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-2">
                    <label for="tema_id" class="block text-sm font-medium text-white">Tema <span class="text-red-500">*</span></label>
                    <select name="tema_id" id="tema_id" required
                        class="w-full px-4 py-3 bg-gray-800/70 border border-gray-700/50 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500/50 transition-all duration-200 text-white">
                        <option value="">Seleccionar tema</option>
                        @foreach($temas as $tema)
                            <option value="{{ $tema->id }}" {{ old('tema_id') == $tema->id ? 'selected' : '' }}>
                                {{ $tema->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="fecha_inicio" class="block text-sm font-medium text-white">Fecha de Inicio <span class="text-red-500">*</span></label>
                    <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{ old('fecha_inicio') }}" required
                        class="w-full px-4 py-3 bg-gray-800/70 border border-gray-700/50 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500/50 transition-all duration-200 text-white">
                </div>

                <div class="space-y-2">
                    <label for="fecha_fin" class="block text-sm font-medium text-white">Fecha de Fin <span class="text-red-500">*</span></label>
                    <input type="date" name="fecha_fin" id="fecha_fin" value="{{ old('fecha_fin') }}" required
                        class="w-full px-4 py-3 bg-gray-800/70 border border-gray-700/50 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500/50 transition-all duration-200 text-white">
                </div>
            </div>

            <div class="space-y-2">
                <label for="estado" class="block text-sm font-medium text-white">Estado <span class="text-red-500">*</span></label>
                <select name="estado" id="estado" required
                    class="w-full px-4 py-3 bg-gray-800/70 border border-gray-700/50 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500/50 transition-all duration-200 text-white">
                    <option value="pendiente" {{ old('estado', 'pendiente') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="activo" {{ old('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                    <option value="inactivo" {{ old('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>
        </div>

        <div class="flex justify-end space-x-4 pt-6">
            <a href="{{ route('admin.concursos.index') }}" 
                class="px-6 py-3 bg-gray-600/80 text-white rounded-xl hover:bg-gray-700 transform hover:scale-105 transition-all duration-200 flex items-center gap-2">
                Cancelar
            </a>
            <button type="submit" 
                class="px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl hover:from-blue-600 hover:to-blue-700 transform hover:scale-105 transition-all duration-200 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Crear Concurso
            </button>
        </div>
    </form>
</div>
@endsection