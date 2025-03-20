@extends('layouts.admin')

@section('contenido')
<div class="bg-gray-800 bg-opacity-50 p-6 rounded-lg shadow-lg">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-white flex items-center">
            <i class="fas fa-bullhorn mr-3 text-blue-400"></i>Crear Convocatoria
        </h1>
        <a href="{{ route('admin.convocatorias.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 transition-all duration-150">
            <i class="fas fa-arrow-left mr-2"></i> Volver
        </a>
    </div>

    @if ($errors->any())
        <div class="bg-red-500/10 border border-red-500/20 text-red-400 p-4 rounded-lg mb-6">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.convocatorias.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6" x-data="{
        eventoType: '',
        fechasImportantes: [{ titulo: '', fecha: '' }],
        addFecha() {
            this.fechasImportantes.push({ titulo: '', fecha: '' });
        },
        removeFecha(index) {
            if (this.fechasImportantes.length > 1) {
                this.fechasImportantes.splice(index, 1);
            }
        }
    }">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <div>
                    <label for="titulo" class="block text-sm font-medium text-gray-300">Título</label>
                    <input type="text" name="titulo" id="titulo" value="{{ old('titulo') }}" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500" required>
                </div>

                <div>
                    <label for="descripcion" class="block text-sm font-medium text-gray-300">Descripción</label>
                    <textarea name="descripcion" id="descripcion" rows="4" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500" required>{{ old('descripcion') }}</textarea>
                </div>

                <div>
                    <label for="evento_type" class="block text-sm font-medium text-gray-300">Tipo de Evento</label>
                    <select name="evento_type" id="evento_type" x-model="eventoType" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500" required>
                        <option value="">-- Selecciona un tipo --</option>
                        <option value="congreso">Congreso</option>
                        <option value="curso">Curso</option>
                        <option value="taller">Taller</option>
                        <option value="concurso">Concurso</option>
                    </select>
                </div>

                <div>
                    <label for="evento_id" class="block text-sm font-medium text-gray-300">Selecciona el evento</label>
                    <select name="evento_id" id="evento_id" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500" required>
                        <option value="">-- Selecciona un evento --</option>
                        
                        <template x-if="eventoType === 'curso'">
                            @foreach ($cursos as $curso)
                                <option value="{{ $curso->id }}">{{ $curso->titulo }}</option>
                            @endforeach
                        </template>
                        
                        <template x-if="eventoType === 'taller'">
                            @foreach ($talleres as $taller)
                                <option value="{{ $taller->id }}">{{ $taller->titulo }}</option>
                            @endforeach
                        </template>
                        
                        <template x-if="eventoType === 'congreso'">
                            @foreach ($congresos as $congreso)
                                <option value="{{ $congreso->id }}">{{ $congreso->nombre }}</option>
                            @endforeach
                        </template>
                        
                        <template x-if="eventoType === 'concurso'">
                            @foreach ($concursos as $concurso)
                                <option value="{{ $concurso->id }}">{{ $concurso->titulo }}</option>
                            @endforeach
                        </template>
                    </select>
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <label for="imagen" class="block text-sm font-medium text-gray-300">Imagen (opcional)</label>
                    <input type="file" name="imagen" id="imagen" accept="image/*" class="mt-1 block w-full text-sm text-gray-300
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-md file:border-0
                        file:text-sm file:font-semibold
                        file:bg-blue-500 file:text-white
                        hover:file:bg-blue-600">
                </div>

                <div>
                    <label for="archivo_pdf" class="block text-sm font-medium text-gray-300">Archivo PDF (opcional)</label>
                    <input type="file" name="archivo_pdf" id="archivo_pdf" accept=".pdf" class="mt-1 block w-full text-sm text-gray-300
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-md file:border-0
                        file:text-sm file:font-semibold
                        file:bg-blue-500 file:text-white
                        hover:file:bg-blue-600">
                </div>

                <div class="border-t border-gray-600 pt-4">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-white">Fechas Importantes</h3>
                        <button type="button" @click="addFecha" class="inline-flex items-center px-3 py-1 bg-blue-600 rounded-md text-xs font-medium text-white hover:bg-blue-700 transition-colors duration-150">
                            <i class="fas fa-plus mr-1"></i> Agregar Fecha
                        </button>
                    </div>

                    <template x-for="(fecha, index) in fechasImportantes" :key="index">
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="flex-1">
                                <input type="text" :name="`fechas_importantes[${index}][titulo]`" x-model="fecha.titulo" placeholder="Título del evento" class="block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500" required>
                            </div>
                            <div class="flex-1">
                                <input type="date" :name="`fechas_importantes[${index}][fecha]`" x-model="fecha.fecha" class="block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500" required>
                            </div>
                            <button type="button" @click="removeFecha(index)" class="text-red-400 hover:text-red-500" :disabled="fechasImportantes.length === 1">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-6 border-t border-gray-600">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                <i class="fas fa-save mr-2"></i> Guardar Convocatoria
            </button>
        </div>
    </form>
</div>
@endsection