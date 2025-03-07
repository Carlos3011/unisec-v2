@extends('layouts.admin')

@section('contenido')
<div class="relative z-10">
    <div class="bg-gradient-to-br from-gray-900 to-black rounded-xl shadow-xl p-8 mb-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-white">Gestión de Ponencias</h1>
            <a href="{{ route('admin.ponencias.create') }}" class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-2 rounded-lg shadow-lg transition-all flex items-center space-x-2">
                <i class="fas fa-plus"></i>
                <span>Nueva Ponencia</span>
            </a>
        </div>

        <!-- Filtros y Búsqueda -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="relative">
                <input type="text" placeholder="Buscar ponencias..." class="w-full bg-gray-800 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
            </div>
            <select class="bg-gray-800 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                <option value="">Todas las categorías</option>
                <option value="1">Investigación Espacial</option>
                <option value="2">Innovación Tecnológica</option>
                <option value="3">Exploración Espacial</option>
            </select>
            <select class="bg-gray-800 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                <option value="">Estado</option>
                <option value="activo">Activo</option>
                <option value="inactivo">Inactivo</option>
                <option value="proximo">Próximo</option>
            </select>
        </div>

        <!-- Tabla de Ponencias -->
        <div class="overflow-x-auto">
            <table class="w-full text-white">
                <thead class="bg-gray-800 text-gray-300">
                    <tr>
                        <th class="px-4 py-3 text-left">Título de la Ponencia</th>
                        <th class="px-4 py-3 text-left">Ponente</th>
                        <th class="px-4 py-3 text-center">Fecha</th>
                        <th class="px-4 py-3 text-center">Estado</th>
                        <th class="px-4 py-3 text-center">Asistentes</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($ponencias ?? [] as $ponencia)
                    <tr class="hover:bg-gray-800/50">
                        <td class="px-4 py-3">{{ $ponencia->titulo }}</td>
                        <td class="px-4 py-3">{{ $ponencia->ponente }}</td>
                        <td class="px-4 py-3 text-center">{{ $ponencia->fecha }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="px-3 py-1 rounded-full text-xs {{ $ponencia->estado == 'activo' ? 'bg-green-500/20 text-green-500' : 'bg-gray-500/20 text-gray-500' }}">
                                {{ ucfirst($ponencia->estado) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">{{ $ponencia->asistentes_count }}</td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex justify-center space-x-2">
                                <a href="{{ route('admin.ponencias.edit', $ponencia) }}" class="text-blue-400 hover:text-blue-300">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.ponencias.destroy', $ponencia) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300" onclick="return confirm('¿Estás seguro de eliminar esta ponencia?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-3 text-center text-gray-400">
                            No hay ponencias registradas
                        </td>
                    </tr>
                    @endforelse
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