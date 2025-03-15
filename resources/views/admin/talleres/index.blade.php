@extends('layouts.admin')

@section('contenido')
<div class="relative z-10">
    <div class="bg-gradient-to-br from-gray-900 to-black rounded-xl shadow-xl p-8 mb-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-white">Gestión de Talleres</h1>
            <a href="{{ route('admin.talleres.create') }}" class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-2 rounded-lg shadow-lg transition-all flex items-center space-x-2">
                <i class="fas fa-plus"></i>
                <span>Nuevo Taller</span>
            </a>
        </div>

        <!-- Filtros y Búsqueda -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="relative">
                <input type="text" placeholder="Buscar talleres..." class="w-full bg-gray-800 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
            </div>
            <select class="bg-gray-800 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                <option value="">Todas las categorías</option>
                <option value="1">Diseño Aeroespacial</option>
                <option value="2">Programación Satelital</option>
                <option value="3">Instrumentación</option>
            </select>
            <select class="bg-gray-800 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                <option value="">Estado</option>
                <option value="activo">Activo</option>
                <option value="inactivo">Inactivo</option>
                <option value="proximo">Próximo</option>
            </select>
        </div>

        <!-- Tabla de Talleres -->
        <div class="overflow-x-auto">
            <table class="w-full text-white">
                <thead class="bg-gray-800 text-gray-300">
                    <tr>
                        <th class="px-4 py-3 text-left">Título</th>
                        <th class="px-4 py-3 text-left">Descripción</th>
                        <th class="px-4 py-3 text-left">Categoría</th>
                        <th class="px-4 py-3 text-left">Tema</th>
                        <th class="px-4 py-3 text-left">Ponente</th>
                        <th class="px-4 py-3 text-left">Costo</th>
                        <th class="px-4 py-3 text-left">Fecha</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @foreach($talleres as $taller)
                        <tr class="hover:bg-gray-800/50">
                            <td class="px-4 py-3">{{ $taller->titulo }}</td>
                            <td class="px-4 py-3">{{ Str::limit($taller->descripcion, 50) }}</td>
                            <td class="px-4 py-3">{{ $taller->categoria->nombre }}</td>
                            <td class="px-4 py-3">{{ $taller->tema->nombre }}</td>
                            <td class="px-4 py-3">{{ $taller->ponente->nombre }}</td>
                            <td class="px-4 py-3">${{ number_format($taller->costo, 2) }}</td>
                            <td class="px-4 py-3">{{ $taller->fecha->format('d/m/Y') }}</td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex justify-center space-x-2">
                                    <!-- Acciones -->
                                    <a href="{{ route('admin.talleres.edit', $taller->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-md transition-colors">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.talleres.destroy', $taller->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-md transition-colors" onclick="return confirm('¿Estás seguro de eliminar este taller?')">
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

        <!-- Paginación -->
        <div class="mt-6">
            {{-- Aquí irá la paginación de Laravel --}}
        </div>
    </div>
</div>
@endsection