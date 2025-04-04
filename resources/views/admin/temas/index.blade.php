@extends('layouts.admin')

@section('titulo', 'Gestión de Temas')

@section('contenido')
<div class="relative z-10">
    <div class="bg-gradient-to-br from-gray-900 to-black rounded-xl shadow-xl p-8 mb-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-white">Gestión de Temas</h1>
            <a href="{{ route('admin.temas.create') }}" class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-2 rounded-lg shadow-lg transition-all flex items-center space-x-2">
                <i class="fas fa-plus"></i>
                <span>Nuevo Tema</span>
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-500/20 text-green-500 px-4 py-3 rounded-lg mb-6" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Filtros y Búsqueda -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div class="relative">
                <input type="text" placeholder="Buscar temas..." class="w-full bg-gray-800 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
            </div>
            <select class="bg-gray-800 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                <option value="">Estado</option>
                <option value="activo">Activo</option>
                <option value="inactivo">Inactivo</option>
            </select>
        </div>

        <!-- Tabla de Temas -->
        <div class="overflow-x-auto">
            <table class="w-full text-white">
                <thead class="bg-gray-800 text-gray-300">
                    <tr>
                        <th class="px-4 py-3 text-left">Nombre</th>
                        <th class="px-4 py-3 text-left">Descripción</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($temas as $tema)
                        <tr class="hover:bg-gray-800/50">
                            <td class="px-4 py-3">{{ $tema->nombre }}</td>
                            <td class="px-4 py-3">{{ $tema->descripcion }}</td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('admin.temas.edit', $tema) }}" class="text-blue-400 hover:text-blue-300">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.temas.destroy', $tema) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-300" onclick="return confirm('¿Está seguro de que desea eliminar este tema?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-3 text-center text-gray-400">
                                No hay temas registrados
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        
    </div>
</div>
@endsection