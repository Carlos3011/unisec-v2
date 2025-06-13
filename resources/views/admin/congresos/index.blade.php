@extends('layouts.admin')
@php
use Carbon\Carbon;
@endphp

@section('contenido')
<div class="relative z-10">
    <div class="bg-gradient-to-br from-gray-900 to-black rounded-xl shadow-xl p-8 mb-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-white">Gestión de Congresos</h1>
            <a href="{{ route('admin.congresos.create') }}" class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-2 rounded-lg shadow-lg transition-all flex items-center space-x-2">
                <i class="fas fa-plus"></i>
                <span>Nuevo Congreso</span>
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
                <input type="text" name="search" placeholder="Buscar congresos..." class="w-full bg-gray-800 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
            </div>
            <select name="estado" class="bg-gray-800 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                <option value="">Estado</option>
                <option value="activo">Activo</option>
                <option value="pendiente">Pendiente</option>
                <option value="inactivo">Inactivo</option>
            </select>
        </div>

        <!-- Tabla de Congresos -->
        <div class="overflow-x-auto">
            <table class="w-full text-white">
                <thead class="bg-gray-800 text-gray-300">
                    <tr>
                        <th class="px-4 py-3 text-left">Nombre</th>
                        <th class="px-4 py-3 text-left">Descripción</th>
                        <th class="px-4 py-3 text-center">Fecha Inicio</th>
                        <th class="px-4 py-3 text-center">Fecha Fin</th>
                        <th class="px-4 py-3 text-center">Estado</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($congresos ?? [] as $congreso)
                        <tr class="hover:bg-gray-800/50">
                            <td class="px-4 py-3">{{ $congreso->nombre }}</td>
                            <td class="px-4 py-3">{{ Str::limit($congreso->descripcion, 50) }}</td>
                            <td class="px-4 py-3 text-center">{{ Carbon::parse($congreso->fecha_inicio)->format('d/m/Y') }}</td>
                            <td class="px-4 py-3 text-center">{{ Carbon::parse($congreso->fecha_fin)->format('d/m/Y') }}</td>
                            <td class="px-4 py-3 text-center">
                                <span class="px-3 py-1 rounded-full text-xs
                                    @switch($congreso->estado)
                                        @case('activo')
                                            bg-green-500/20 text-green-500
                                            @break
                                        @case('pendiente')
                                            bg-yellow-500/20 text-yellow-500
                                            @break
                                        @case('inactivo')
                                            bg-gray-500/20 text-gray-500
                                            @break
                                        @default
                                            bg-gray-500/20 text-gray-500
                                    @endswitch">
                                    {{ ucfirst($congreso->estado) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('admin.congresos.edit', $congreso) }}" class="text-blue-400 hover:text-blue-300">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.congresos.destroy', $congreso) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-300" onclick="return confirm('¿Estás seguro de eliminar este congreso?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-3 text-center text-gray-400">
                                No hay congresos registrados
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection