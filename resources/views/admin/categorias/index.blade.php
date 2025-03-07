@extends('layouts.admin')

@section('contenido')
<div class="relative z-10">
    <div class="bg-gradient-to-br from-gray-900 to-black rounded-xl shadow-xl p-8 mb-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-white">Gestión de Categorías</h1>
            <button onclick="document.getElementById('createCategoryModal').classList.remove('hidden')" class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-2 rounded-lg shadow-lg transition-all flex items-center space-x-2">
                <i class="fas fa-plus"></i>
                <span>Nueva Categoría</span>
            </button>
        </div>

        <!-- Tabla de Categorías -->
        <div class="overflow-x-auto">
            <table class="w-full text-white">
                <thead class="bg-gray-800 text-gray-300">
                    <tr>
                        <th class="px-4 py-3 text-left">Nombre</th>
                        <th class="px-4 py-3 text-left">Descripción</th>
                        <th class="px-4 py-3 text-center">Cursos</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($categorias ?? [] as $categoria)
                    <tr class="hover:bg-gray-800/50">
                        <td class="px-4 py-3">{{ $categoria->nombre }}</td>
                        <td class="px-4 py-3">{{ $categoria->descripcion }}</td>
                        <td class="px-4 py-3 text-center">{{ $categoria->cursos_count ?? 0 }}</td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex justify-center space-x-2">
                                <button onclick="editCategory({{ $categoria->id }}, '{{ $categoria->nombre }}', '{{ $categoria->descripcion }}')" class="text-blue-400 hover:text-blue-300">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.categorias.destroy', $categoria) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300" onclick="return confirm('¿Estás seguro de eliminar esta categoría?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-3 text-center text-gray-400">
                            No hay categorías registradas
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Crear Categoría -->
<div id="createCategoryModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-gray-800 rounded-lg p-8 max-w-md w-full mx-4">
        <h2 class="text-2xl font-bold text-white mb-6">Nueva Categoría</h2>
        <form action="{{ route('admin.categorias.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="nombre" class="block text-gray-300 mb-2">Nombre</label>
                    <input type="text" name="nombre" id="nombre" required class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                </div>
                <div>
                    <label for="descripcion" class="block text-gray-300 mb-2">Descripción</label>
                    <textarea name="descripcion" id="descripcion" rows="3" class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500"></textarea>
                </div>
            </div>
            <div class="flex justify-end space-x-3 mt-6">
                <button type="button" onclick="document.getElementById('createCategoryModal').classList.add('hidden')" class="px-4 py-2 text-gray-300 hover:text-white">
                    Cancelar
                </button>
                <button type="submit" class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-2 rounded-lg shadow-lg transition-all">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Editar Categoría -->
<div id="editCategoryModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-gray-800 rounded-lg p-8 max-w-md w-full mx-4">
        <h2 class="text-2xl font-bold text-white mb-6">Editar Categoría</h2>
        <form id="editCategoryForm" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div>
                    <label for="edit_nombre" class="block text-gray-300 mb-2">Nombre</label>
                    <input type="text" name="nombre" id="edit_nombre" required class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                </div>
                <div>
                    <label for="edit_descripcion" class="block text-gray-300 mb-2">Descripción</label>
                    <textarea name="descripcion" id="edit_descripcion" rows="3" class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500"></textarea>
                </div>
            </div>
            <div class="flex justify-end space-x-3 mt-6">
                <button type="button" onclick="document.getElementById('editCategoryModal').classList.add('hidden')" class="px-4 py-2 text-gray-300 hover:text-white">
                    Cancelar
                </button>
                <button type="submit" class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-2 rounded-lg shadow-lg transition-all">
                    Actualizar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function editCategory(id, nombre, descripcion) {
    document.getElementById('editCategoryForm').action = `/admin/categorias/${id}`;
    document.getElementById('edit_nombre').value = nombre;
    document.getElementById('edit_descripcion').value = descripcion;
    document.getElementById('editCategoryModal').classList.remove('hidden');
}
</script>
@endsection