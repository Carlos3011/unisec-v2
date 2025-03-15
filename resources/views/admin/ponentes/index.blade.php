@extends('layouts.admin')

@section('titulo', 'Panel de Ponentes')

@section('contenido')
<div class="relative z-10">
    <div class="bg-gradient-to-br from-gray-900 to-black rounded-xl shadow-xl p-8 mb-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-white">Gestión de Ponentes</h1>
            <a href="{{ route('admin.ponentes.create') }}" class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-2 rounded-lg shadow-lg transition-all flex items-center space-x-2">
                <i class="fas fa-plus"></i>
                <span>Nuevo Ponente</span>
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-500/20 text-green-500 px-4 py-3 rounded-lg mb-6" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Filtros y Búsqueda -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="relative">
                <input type="text" placeholder="Buscar ponentes..." class="w-full bg-gray-800 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
            </div>
            <select class="bg-gray-800 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                <option value="">Todas las especialidades</option>
                <option value="1">Diseño Espacial</option>
                <option value="2">Programación Satelital</option>
                <option value="3">Instrumentación</option>
            </select>
            <select class="bg-gray-800 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                <option value="">Estado</option>
                <option value="activo">Activo</option>
                <option value="inactivo">Inactivo</option>
            </select>
        </div>

        <!-- Tabla de Ponentes -->
        <div class="overflow-x-auto">
            <table class="w-full text-white">
                <thead class="bg-gray-800 text-gray-300">
                    <tr>
                        <th class="px-4 py-3 text-left">Nombre</th>
                        <th class="px-4 py-3 text-left">Especialidad</th>
                        <th class="px-4 py-3 text-left">Bio</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @foreach($ponentes as $ponente)
                        <tr class="hover:bg-gray-800/50">
                            <td class="px-4 py-3">{{ $ponente->nombre }}</td>
                            <td class="px-4 py-3">{{ $ponente->especialidad }}</td>
                            <td class="px-4 py-3">{{ Str::limit($ponente->bio, 100) }}</td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('admin.ponentes.edit', $ponente) }}" class="text-blue-400 hover:text-blue-300">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.ponentes.destroy', $ponente) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-300" onclick="return confirm('¿Estás seguro de que deseas eliminar este ponente?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        
    </div>
</div>
@endsection