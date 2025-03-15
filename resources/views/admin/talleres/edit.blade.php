@extends('layouts.admin')

@section('titulo', 'Editar Taller')

@section('contenido')
<div class="bg-gradient-to-br from-gray-900 via-gray-800 to-black rounded-2xl shadow-2xl p-8 max-w-4xl mx-auto">
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-400 via-blue-500 to-blue-600 bg-clip-text text-transparent tracking-tight">Editar Taller</h1>
            <a href="{{ route('admin.talleres.index') }}" class="px-4 py-2 bg-gray-600/80 text-white rounded-xl hover:bg-gray-700 transform hover:scale-105 transition-all duration-200 flex items-center gap-2 backdrop-blur-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Volver
            </a>
        </div>
    </div>

    <form action="{{ route('admin.talleres.update', $taller) }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')

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
            <!-- Información Básica -->
            <div class="space-y-6">
                <h2 class="text-xl font-semibold text-white pl-3 border-l-4 border-blue-500 mb-4"><span class="bg-gradient-to-r from-blue-500 to-blue-600 bg-clip-text text-transparent">Información Básica</span></h2>
                
                <div class="space-y-2">
                    <label for="titulo" class="block text-sm font-medium text-white">Título del Taller <span class="text-red-500">*</span></label>
                    <input type="text" name="titulo" id="titulo" value="{{ old('titulo', $taller->titulo) }}" required
                        class="w-full px-4 py-3 bg-gray-800/70 border border-gray-700/50 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500/50 transition-all duration-200 placeholder-gray-500 text-white">
                </div>

                <div class="space-y-2">
                    <label for="descripcion" class="block text-sm font-medium text-white">Descripción <span class="text-red-500">*</span></label>
                    <textarea name="descripcion" id="descripcion" rows="4" required
                        class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-white">{{ old('descripcion', $taller->descripcion) }}</textarea>
                </div>
            </div>

            <!-- Clasificación -->
            <div class="space-y-6">
                <h2 class="text-xl font-semibold text-white pl-3 border-l-4 border-purple-500 mb-4"><span class="bg-gradient-to-r from-purple-500 to-purple-600 bg-clip-text text-transparent">Clasificación</span></h2>
                
                <div class="space-y-2">
                    <label for="categoria_id" class="block text-sm font-medium text-white">Categoría <span class="text-red-500">*</span></label>
                    <select name="categoria_id" id="categoria_id" required
                        class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-white">
                        <option value="">Seleccionar categoría</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}" {{ old('categoria_id', $taller->categoria_id) == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-2">
                    <label for="tema_id" class="block text-sm font-medium text-white">Tema <span class="text-red-500">*</span></label>
                    <select name="tema_id" id="tema_id" required
                        class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-white">
                        <option value="">Seleccionar tema</option>
                        @foreach($temas as $tema)
                            <option value="{{ $tema->id }}" {{ old('tema_id', $taller->tema_id) == $tema->id ? 'selected' : '' }}>
                                {{ $tema->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Detalles del Taller -->
            <div class="space-y-6">
                <h2 class="text-xl font-semibold text-white pl-3 border-l-4 border-green-500 mb-4"><span class="bg-gradient-to-r from-green-500 to-green-600 bg-clip-text text-transparent">Detalles del Taller</span></h2>
                
                <div class="space-y-2">
                    <label for="ponente_id" class="block text-sm font-medium text-white">Ponente <span class="text-red-500">*</span></label>
                    <select name="ponente_id" id="ponente_id" required
                        class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-white">
                        <option value="">Seleccionar ponente</option>
                        @foreach($ponentes as $ponente)
                            <option value="{{ $ponente->id }}" {{ old('ponente_id', $taller->ponente_id) == $ponente->id ? 'selected' : '' }}>
                                {{ $ponente->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label for="costo" class="block text-sm font-medium text-white">Costo (MXN) <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-gray-400">$</span>
                            <input type="number" name="costo" id="costo" value="{{ old('costo', $taller->costo) }}" step="0.01" required min="0"
                                class="w-full pl-8 pr-4 py-2.5 bg-gray-800/50 border border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-white">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="fecha" class="block text-sm font-medium text-white">Fecha <span class="text-red-500">*</span></label>
                        <input type="date" name="fecha" id="fecha" value="{{ old('fecha', $taller->fecha->format('Y-m-d')) }}" required
                            class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-white">
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end space-x-4 pt-8 mt-8 border-t-2 border-gray-800">
            <a href="{{ route('admin.talleres.index') }}" class="px-6 py-3 bg-gray-600/80 text-white rounded-xl hover:bg-gray-700 transform hover:scale-[1.02] transition-all duration-300 flex items-center gap-2 backdrop-blur-sm">
                Cancelar
            </a>
            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl hover:from-blue-600 hover:to-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-900 transform hover:scale-[1.02] transition-all duration-300 shadow-lg">
                Actualizar Taller
            </button>
        </div>
    </form>
</div>
@endsection