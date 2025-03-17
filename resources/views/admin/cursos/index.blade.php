@extends('layouts.admin')

@section('contenido')
<div class="relative z-10">
    <div class="bg-gradient-to-br from-gray-900 to-black rounded-xl shadow-xl p-8 mb-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-white">Gestión de Cursos</h1>
            <a href="{{ route('admin.cursos.create') }}" class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-2 rounded-lg shadow-lg transition-all flex items-center space-x-2">
                <i class="fas fa-plus"></i>
                <span>Nuevo Curso</span>
            </a>
        </div>

        <!-- Filtros y Búsqueda -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="relative">
                <input type="text" placeholder="Buscar cursos..." class="w-full bg-gray-800 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
            </div>
            <select class="bg-gray-800 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                <option value="">Todas las categorías</option>
                @forelse($categorias ?? [] as $categoria)
                    <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                @empty
                    <option disabled>Aún no hay categorías registradas</option>
                @endforelse
            </select>
            <select class="bg-gray-800 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                <option value="">Estado</option>
                <option value="pendiente">Pendiente</option>
                <option value="activo">Activo</option>
                <option value="proximo">Próximo</option>
                <option value="inactivo">Inactivo</option>
            </select>
        </div>

        <!-- Tabla de Cursos -->
        <div class="overflow-x-auto">
            <table class="w-full text-white">
                <thead class="bg-gray-800 text-gray-300">
                    <tr>
                        <th class="px-4 py-3 text-left">Titulo</th>
                        <th class="px-4 py-3 text-left">Descripción</th>
                        <th class="px-4 py-3 text-left">Categoría</th>
                        <th class="px-4 py-3 text-left">Tema</th>
                        <th class="px-4 py-3 text-left">Ponente</th>
                        <th class="px-4 py-3 text-center">Costo</th>
                        <th class="px-4 py-3 text-center">Duración</th>
                        <th class="px-4 py-3 text-center">Estado</th>
                        <th class="px-4 py-3 text-center">Inscritos</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($cursos ?? [] as $curso)
                    <tr class="hover:bg-gray-800/50">
                        <td class="px-4 py-3">{{ $curso['nombre'] }}</td>
                        <td class="px-4 py-3">{{ Str::limit($curso['descripcion'], 50) }}</td>
                        <td class="px-4 py-3">{{ $curso['categoria'] }}</td>
                        <td class="px-4 py-3">{{ $curso['tema'] }}</td>
                        <td class="px-4 py-3">{{ $curso['ponente'] }}</td>
                        <td class="px-4 py-3 text-center">${{ number_format($curso['costo'], 2) }}</td>
                        <td class="px-4 py-3 text-center">{{ $curso['duracion'] }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="px-3 py-1 rounded-full text-xs
                                @switch($curso['estado'])
                                    @case('activo')
                                        bg-green-500/20 text-green-500
                                        @break
                                    @case('pendiente')
                                        bg-yellow-500/20 text-yellow-500
                                        @break
                                    @case('proximo')
                                        bg-blue-500/20 text-blue-500
                                        @break
                                    @default
                                        bg-gray-500/20 text-gray-500
                                @endswitch">
                                {{ ucfirst($curso['estado']) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">{{ $curso['inscritos_count'] }}</td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex justify-center space-x-2">
                                <a href="{{ route('admin.cursos.edit', $curso['id']) }}" class="text-blue-400 hover:text-blue-300">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.cursos.destroy', $curso['id']) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300" onclick="return confirm('¿Estás seguro de eliminar este curso?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-3 text-center text-gray-400">
                            No hay cursos registrados
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