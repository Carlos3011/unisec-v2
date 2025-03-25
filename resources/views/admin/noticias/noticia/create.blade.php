@extends('layouts.admin')

@section('titulo', 'Crear Nueva Noticia')

@section('contenido')

<div class="bg-gradient-to-br from-gray-900 to-black rounded-xl shadow-xl p-8 max-w-6xl mx-auto">
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-white">Crear Nueva Noticia</h1>
            <div class="flex space-x-4">
                <a href="{{ route('admin.noticias.noticia.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition-all flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"></path>
                    </svg>
                    Volver
                </a>
            </div>
        </div>
    </div>

    @if($errors->any())
        <div class="bg-red-500 text-white p-4 rounded-lg mb-6 animate-shake">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.noticias.noticia.store') }}" id="noticiaForm" class="space-y-6" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-2 gap-6">
            <div class="col-span-2">
                <label for="titulo" class="block text-sm font-medium text-gray-300 mb-2">Título</label>
                <input type="text" name="titulo" id="titulo" value="{{ old('titulo') }}" required
                    class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-500 @error('titulo') border-red-500 @enderror"
                    placeholder="Ingrese el título de la noticia">
                <div class="text-sm text-gray-400 mt-1">El título debe ser conciso y descriptivo</div>
            </div>

            <div>
                <label for="seccion_id" class="block text-sm font-medium text-gray-300 mb-2">Sección</label>
                <select name="seccion_id" id="seccion_id" required
                    class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-500 @error('seccion_id') border-red-500 @enderror">
                    <option value="">Selecciona una sección</option>
                    @foreach($secciones as $seccion)
                        <option value="{{ $seccion->id }}" {{ old('seccion_id') == $seccion->id ? 'selected' : '' }}>
                            {{ $seccion->titulo }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="fecha_publicacion" class="block text-sm font-medium text-gray-300 mb-2">Fecha de Publicación</label>
                <input type="date" name="fecha_publicacion" id="fecha_publicacion" value="{{ old('fecha_publicacion') }}" required
                    class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-500 @error('fecha_publicacion') border-red-500 @enderror">
            </div>

            <div class="col-span-2">
                <label for="descripcion" class="block text-sm font-medium text-gray-300 mb-2">Descripción Corta</label>
                <textarea name="descripcion" id="descripcion" rows="2" required
                    class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-500 @error('descripcion') border-red-500 @enderror"
                    placeholder="Breve descripción que aparecerá en la vista previa de la noticia">{{ old('descripcion') }}</textarea>
                <div class="text-sm text-gray-400 mt-1">Máximo 200 caracteres</div>
            </div>

            <div>
                <label for="autor_noticia" class="block text-sm font-medium text-gray-300 mb-2">Autor de la Noticia</label>
                <input type="text" name="autor_noticia" id="autor_noticia" value="{{ old('autor_noticia') }}" required
                    class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-500 @error('autor_noticia') border-red-500 @enderror"
                    placeholder="Nombre del autor">
            </div>

            <div class="col-span-2">
                <label for="contenido" class="block text-sm font-medium text-gray-300 mb-2">Contenido</label>
                <textarea name="contenido" id="contenido" rows="15" required class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-500 @error('contenido') border-red-500 @enderror" placeholder="Escribe el contenido de la noticia aquí">{{ old('contenido') }}</textarea>
                <div class="text-sm text-gray-400 mt-1">Escribe el contenido de la noticia. El formato se aplicará automáticamente en la vista pública.</div>
            </div>

            <div class="col-span-2 grid grid-cols-2 gap-6">
                <div>
                    <label for="imagen" class="block text-sm font-medium text-gray-300 mb-2">Imagen Destacada</label>
                    <div class="flex items-center space-x-4">
                        <div class="flex-1">
                            <input type="file" name="imagen" id="imagen" accept="image/*"
                                class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-500 @error('imagen') border-red-500 @enderror"
                                onchange="previewImage(event)">
                        </div>
                        <div id="imagePreview" class="hidden w-32 h-32 bg-gray-700 rounded-lg overflow-hidden">
                            <img src="#" alt="Vista previa" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label for="descripcion_imagen" class="block text-sm font-medium text-gray-300 mb-2">Descripción de la Imagen</label>
                        <input type="text" name="descripcion_imagen" id="descripcion_imagen" value="{{ old('descripcion_imagen') }}" required
                            class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-500 @error('descripcion_imagen') border-red-500 @enderror"
                            placeholder="Describe la imagen">
                    </div>

                    <div>
                        <label for="autor_imagen" class="block text-sm font-medium text-gray-300 mb-2">Autor de la Imagen</label>
                        <input type="text" name="autor_imagen" id="autor_imagen" value="{{ old('autor_imagen') }}" required
                            class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-500 @error('autor_imagen') border-red-500 @enderror"
                            placeholder="Nombre del fotógrafo o fuente">
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-between items-center pt-6 border-t border-gray-700">
            <div class="flex space-x-4">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-all flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Publicar Noticia
                </button>
            </div>
        </div>
    </form>
</div>
<script>
    // Previsualización de imagen
    function previewImage(event) {
        const preview = document.getElementById('imagePreview');
        const image = preview.querySelector('img');
        const file = event.target.files[0];

        if (file) {
            preview.classList.remove('hidden');
            const reader = new FileReader();
            reader.onload = function(e) {
                image.src = e.target.result;
            }
            reader.readAsDataURL(file);
        } else {
            preview.classList.add('hidden');
        }
    }
</script>


@endsection