@extends('layouts.admin')

@section('titulo', 'Crear Nueva Noticia')

@section('contenido')

<div class="bg-gradient-to-br from-gray-900 to-black rounded-xl shadow-xl p-8 max-w-6xl mx-auto" x-data="{
    currentTab: 'general',
    progress: 20,
    tabs: {
        general: true,
        multimedia: false,
        contenido: false
    },
    updateProgress() {
        const completedTabs = Object.values(this.tabs).filter(Boolean).length;
        this.progress = (completedTabs / Object.keys(this.tabs).length) * 100;
    }
}">
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-white flex items-center">
                <i class="fas fa-newspaper mr-3 text-blue-400"></i>Crear Nueva Noticia
            </h1>
            <a href="{{ route('admin.noticias.noticia.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 transition-all">
                <i class="fas fa-arrow-left mr-2"></i> Volver
            </a>
        </div>
    </div>

    <!-- Barra de Progreso -->
    <div class="w-full bg-gray-700 rounded-full h-2.5 mb-6">
        <div class="bg-blue-500 h-2.5 rounded-full transition-all duration-300" x-bind:style="'width: ' + progress + '%'"></div>
    </div>

    <!-- Navegación de Pestañas -->
    <nav class="flex space-x-4 mb-6 border-b border-gray-700 pb-4">
        <button type="button" @click="currentTab = 'general'" :class="{'text-blue-500 border-b-2 border-blue-500 -mb-4 pb-4': currentTab === 'general'}" class="text-gray-300 hover:text-white transition-all">
            <i class="fas fa-info-circle mr-2"></i>General
        </button>
        <button type="button" @click="currentTab = 'multimedia'" :class="{'text-blue-500 border-b-2 border-blue-500 -mb-4 pb-4': currentTab === 'multimedia'}" class="text-gray-300 hover:text-white transition-all">
            <i class="fas fa-images mr-2"></i>Multimedia
        </button>
        <button type="button" @click="currentTab = 'contenido'" :class="{'text-blue-500 border-b-2 border-blue-500 -mb-4 pb-4': currentTab === 'contenido'}" class="text-gray-300 hover:text-white transition-all">
            <i class="fas fa-file-alt mr-2"></i>Contenido
        </button>
    </nav>

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

        <!-- Pestaña General -->
        <div x-show="currentTab === 'general'" class="space-y-6 animate-fade-in">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="col-span-2">
                    <label for="titulo" class="block text-sm font-medium text-gray-300 mb-2">Título de la Noticia</label>
                    <input type="text" name="titulo" id="titulo" value="{{ old('titulo') }}" required
                        class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-500 @error('titulo') border-red-500 @enderror"
                        placeholder="Ingrese un título descriptivo y atractivo">
                    @error('titulo')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="seccion_id" class="block text-sm font-medium text-gray-300 mb-2">Sección</label>
                    <select name="seccion_id" id="seccion_id" required
                        class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-500 @error('seccion_id') border-red-500 @enderror"
                        @change="tabs.general = true; updateProgress()">
                        <option value="">Selecciona una sección</option>
                        @foreach($secciones as $seccion)
                            <option value="{{ $seccion->id }}" {{ old('seccion_id') == $seccion->id ? 'selected' : '' }}>
                                {{ $seccion->titulo }}
                            </option>
                        @endforeach
                    </select>
                    @error('seccion_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="fecha_publicacion" class="block text-sm font-medium text-gray-300 mb-2">Fecha de Publicación</label>
                    <input type="date" name="fecha_publicacion" id="fecha_publicacion" value="{{ old('fecha_publicacion') }}" required
                        class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-500 @error('fecha_publicacion') border-red-500 @enderror">
                    @error('fecha_publicacion')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-span-2">
                    <label for="descripcion" class="block text-sm font-medium text-gray-300 mb-2">Descripción Corta</label>
                    <textarea name="descripcion" id="descripcion" rows="2" required
                        class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-500 @error('descripcion') border-red-500 @enderror"
                        placeholder="Breve descripción que aparecerá en la vista previa de la noticia"
                        @input="tabs.general = true; updateProgress()">{{ old('descripcion') }}</textarea>
                    <div class="text-sm text-gray-400 mt-1">Máximo 200 caracteres</div>
                    @error('descripcion')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="autor_noticia" class="block text-sm font-medium text-gray-300 mb-2">Autor de la Noticia</label>
                    <input type="text" name="autor_noticia" id="autor_noticia" value="{{ old('autor_noticia') }}" required
                        class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-500 @error('autor_noticia') border-red-500 @enderror"
                        placeholder="Nombre del autor">
                    @error('autor_noticia')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Pestaña Multimedia -->
        <div x-show="currentTab === 'multimedia'" class="space-y-6 animate-fade-in">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="col-span-2">
                    <label for="imagen" class="block text-sm font-medium text-gray-300 mb-2">Imagen Destacada</label>
                    <div class="flex items-center space-x-4">
                        <div class="flex-1">
                            <input type="file" name="imagen" id="imagen" accept="image/*" 
                                class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-500 @error('imagen') border-red-500 @enderror"
                                @change="previewImage($event); tabs.multimedia = true; updateProgress()">
                        </div>
                        <div id="imagePreview" class="hidden w-32 h-32 bg-gray-700 rounded-lg overflow-hidden">
                            <img src="#" alt="Vista previa" class="w-full h-full object-cover">
                        </div>
                    </div>
                    @error('imagen')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="descripcion_imagen" class="block text-sm font-medium text-gray-300 mb-2">Descripción de la Imagen</label>
                    <input type="text" name="descripcion_imagen" id="descripcion_imagen" value="{{ old('descripcion_imagen') }}" required
                        class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-500 @error('descripcion_imagen') border-red-500 @enderror"
                        placeholder="Describe la imagen"
                        @input="tabs.multimedia = true; updateProgress()">
                    @error('descripcion_imagen')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="autor_imagen" class="block text-sm font-medium text-gray-300 mb-2">Autor de la Imagen</label>
                    <input type="text" name="autor_imagen" id="autor_imagen" value="{{ old('autor_imagen') }}" required
                        class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-500 @error('autor_imagen') border-red-500 @enderror"
                        placeholder="Nombre del fotógrafo o fuente">
                    @error('autor_imagen')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Pestaña Contenido -->
        <div x-show="currentTab === 'contenido'" class="space-y-6 animate-fade-in">
            <div>
                <label for="contenido" class="block text-sm font-medium text-gray-300 mb-2">Contenido de la Noticia</label>
                <textarea name="contenido" id="contenido" rows="15" required
                    class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-500 @error('contenido') border-red-500 @enderror"
                    placeholder="Escribe el contenido detallado de la noticia aquí"
                    @input="tabs.contenido = true; updateProgress()">{{ old('contenido') }}</textarea>
                <div class="text-sm text-gray-400 mt-1">Utiliza formato Markdown para dar estilo al contenido</div>
                @error('contenido')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex justify-between items-center pt-6 border-t border-gray-700">
            <div class="flex space-x-4">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-all flex items-center">
                    <i class="fas fa-paper-plane mr-2"></i>Publicar Noticia
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