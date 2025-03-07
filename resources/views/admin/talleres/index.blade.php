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
                        <th class="px-4 py-3 text-left">Nombre del Taller</th>
                        <th class="px-4 py-3 text-left">Categoría</th>
                        <th class="px-4 py-3 text-center">Duración</th>
                        <th class="px-4 py-3 text-center">Estado</th>
                        <th class="px-4 py-3 text-center">Inscritos</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($talleres ?? [] as $taller)
                    <tr class="hover:bg-gray-800/50">
                        <td class="px-4 py-3">{{ $taller->nombre }}</td>
                        <td class="px-4 py-3">{{ $taller->categoria }}</td>
                        <td class="px-4 py-3 text-center">{{ $taller->duracion }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="px-3 py-1 rounded-full text-xs {{ $taller->estado == 'activo' ? 'bg-green-500/20 text-green-500' : 'bg-gray-500/20 text-gray-500' }}">
                                {{ ucfirst($taller->estado) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">{{ $taller->inscritos_count }}</td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex justify-center space-x-2">
                                <a href="{{ route('admin.talleres.edit', $taller) }}" class="text-blue-400 hover:text-blue-300">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.talleres.destroy', $taller) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300" onclick="return confirm('¿Estás seguro de eliminar este taller?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-3 text-center text-gray-400">
                            No hay talleres registrados
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