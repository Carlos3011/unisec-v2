@extends('layouts.admin')

@section('contenido')
<div class="bg-gray-800 bg-opacity-50 p-6 rounded-lg shadow-lg">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-white flex items-center">
            <i class="fas fa-bullhorn mr-3 text-blue-400"></i>Crear Convocatoria
        </h1>
        <a href="{{ route('admin.concursos.convocatorias.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 transition-all duration-150">
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

    <form action="{{ route('admin.concursos.convocatorias.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6" x-data="{
        currentTab: 'general',
        progress: 20,
        tabs: {
            general: true,
            requisitos: false,
            documentos: false,
            evaluacion: false,
            archivos: false
        },
        updateProgress() {
            const completedTabs = Object.values(this.tabs).filter(Boolean).length;
            this.progress = (completedTabs / Object.keys(this.tabs).length) * 100;
        },
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

        <!-- Barra de Progreso -->
        <div class="w-full bg-gray-700 rounded-full h-2.5 mb-6">
            <div class="bg-blue-500 h-2.5 rounded-full transition-all duration-300" x-bind:style="'width: ' + progress + '%'"></div>
        </div>

        <!-- Navegación de Pestañas -->
        <nav class="flex space-x-4 mb-6 border-b border-gray-700 pb-4">
            <button type="button" @click="currentTab = 'general'" :class="{'text-blue-500 border-b-2 border-blue-500 -mb-4 pb-4': currentTab === 'general'}" class="text-gray-300 hover:text-white transition-all">
                <i class="fas fa-info-circle mr-2"></i>General
            </button>
            <button type="button" @click="currentTab = 'fechas'" :class="{'text-blue-500 border-b-2 border-blue-500 -mb-4 pb-4': currentTab === 'fechas'}" class="text-gray-300 hover:text-white transition-all">
                <i class="fas fa-calendar mr-2"></i>Fechas Importantes
            </button>
            <button type="button" @click="currentTab = 'requisitos'" :class="{'text-blue-500 border-b-2 border-blue-500 -mb-4 pb-4': currentTab === 'requisitos'}" class="text-gray-300 hover:text-white transition-all">
                <i class="fas fa-list-check mr-2"></i>Requisitos
            </button>
            <button type="button" @click="currentTab = 'documentos'" :class="{'text-blue-500 border-b-2 border-blue-500 -mb-4 pb-4': currentTab === 'documentos'}" class="text-gray-300 hover:text-white transition-all">
                <i class="fas fa-file-lines mr-2"></i>Documentación
            </button>
            <button type="button" @click="currentTab = 'evaluacion'" :class="{'text-blue-500 border-b-2 border-blue-500 -mb-4 pb-4': currentTab === 'evaluacion'}" class="text-gray-300 hover:text-white transition-all">
                <i class="fas fa-star mr-2"></i>Evaluación
            </button>
            <button type="button" @click="currentTab = 'pagos'" :class="{'text-blue-500 border-b-2 border-blue-500 -mb-4 pb-4': currentTab === 'pagos'}" class="text-gray-300 hover:text-white transition-all">
                <i class="fas fa-money-bill mr-2"></i>Pagos
            </button>
            <button type="button" @click="currentTab = 'archivos'" :class="{'text-blue-500 border-b-2 border-blue-500 -mb-4 pb-4': currentTab === 'archivos'}" class="text-gray-300 hover:text-white transition-all">
                <i class="fas fa-upload mr-2"></i>Archivos
            </button>
        </nav>

        <!-- Contenido de Pestañas -->
        <div x-show="currentTab === 'fechas'" class="space-y-6 animate-fade-in">
            <div class="space-y-4">
                <template x-for="(fecha, index) in fechasImportantes" :key="index">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-gray-700/50 rounded-lg">
                        <div>
                            <label :for="'fecha_titulo_' + index" class="block text-sm font-medium text-gray-300">Título del Evento</label>
                            <input type="text" :name="'fechas_importantes[' + index + '][titulo]'" :id="'fecha_titulo_' + index" x-model="fecha.titulo" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500" required>
                        </div>
                        <div>
                            <label :for="'fecha_fecha_' + index" class="block text-sm font-medium text-gray-300">Fecha</label>
                            <input type="date" :name="'fechas_importantes[' + index + '][fecha]'" :id="'fecha_fecha_' + index" x-model="fecha.fecha" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500" required>
                        </div>
                        <div class="md:col-span-2 flex justify-end">
                            <button type="button" @click="removeFecha(index)" class="inline-flex items-center px-3 py-1 bg-red-600/20 text-red-400 rounded-lg text-sm hover:bg-red-600/30 transition-all">
                                <i class="fas fa-trash mr-2"></i> Eliminar
                            </button>
                        </div>
                    </div>
                </template>

                <div class="flex justify-center">
                    <button type="button" @click="addFecha()" class="inline-flex items-center px-4 py-2 bg-blue-600/20 text-blue-400 rounded-lg text-sm hover:bg-blue-600/30 transition-all">
                        <i class="fas fa-plus mr-2"></i> Agregar Fecha Importante
                    </button>
                </div>
            </div>
        </div>


        <div x-show="currentTab === 'general'" class="space-y-6 animate-fade-in">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="concurso_id" class="block text-sm font-medium text-gray-300">Seleccionar Concurso</label>
                    <select name="concurso_id" id="concurso_id" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500" required>
                        <option value="">-- Selecciona un concurso --</option>
                        @foreach ($concursos as $concurso)
                            <option value="{{ $concurso->id }}" {{ old('concurso_id') == $concurso->id ? 'selected' : '' }}>{{ $concurso->titulo }}</option>
                        @endforeach
                    </select>
                    @error('concurso_id')
                        <span class="text-red-400 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="sede" class="block text-sm font-medium text-gray-300">Sede</label>
                    <input type="text" name="sede" id="sede" value="{{ old('sede') }}" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500" required>
                    @error('sede')
                        <span class="text-red-400 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="dirigido_a" class="block text-sm font-medium text-gray-300">Dirigido a</label>
                    <input type="text" name="dirigido_a" id="dirigido_a" value="{{ old('dirigido_a', 'Estudiantes de nivel licenciatura') }}" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500">
                    @error('dirigido_a')
                        <span class="text-red-400 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="contacto_email" class="block text-sm font-medium text-gray-300">Email de Contacto</label>
                    <input type="email" name="contacto_email" id="contacto_email" value="{{ old('contacto_email') }}" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500">
                    @error('contacto_email')
                        <span class="text-red-400 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="max_integrantes" class="block text-sm font-medium text-gray-300">Máximo de Integrantes</label>
                    <input type="number" name="max_integrantes" id="max_integrantes" value="{{ old('max_integrantes', 5) }}" min="1" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500">
                    @error('max_integrantes')
                        <span class="text-red-400 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="asesor_requerido" class="block text-sm font-medium text-gray-300">¿Requiere Asesor?</label>
                    <select name="asesor_requerido" id="asesor_requerido" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500">
                        <option value="1" {{ old('asesor_requerido', true) ? 'selected' : '' }}>Sí</option>
                        <option value="0" {{ old('asesor_requerido') === '0' ? 'selected' : '' }}>No</option>
                    </select>
                    @error('asesor_requerido')
                        <span class="text-red-400 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div x-show="currentTab === 'requisitos'" class="space-y-6 animate-fade-in">
            <div>
                <label for="requisitos" class="block text-sm font-medium text-gray-300">Requisitos</label>
                <textarea name="requisitos" id="requisitos" rows="4" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500" required>{{ old('requisitos') }}</textarea>
                @error('requisitos')
                    <span class="text-red-400 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="etapas_mision" class="block text-sm font-medium text-gray-300">Etapas de la Misión</label>
                <textarea name="etapas_mision" id="etapas_mision" rows="4" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500" required>{{ old('etapas_mision') }}</textarea>
                @error('etapas_mision')
                    <span class="text-red-400 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="pruebas_requeridas" class="block text-sm font-medium text-gray-300">Pruebas Requeridas</label>
                <textarea name="pruebas_requeridas" id="pruebas_requeridas" rows="4" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500" required>{{ old('pruebas_requeridas') }}</textarea>
                @error('pruebas_requeridas')
                    <span class="text-red-400 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div x-show="currentTab === 'documentos'" class="space-y-6 animate-fade-in">
            <div>
                <label for="documentacion_requerida" class="block text-sm font-medium text-gray-300">Documentación Requerida</label>
                <input type="text" name="documentacion_requerida" id="documentacion_requerida" value="{{ old('documentacion_requerida', 'PDR, CDR, PFR') }}" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500">
                @error('documentacion_requerida')
                    <span class="text-red-400 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div x-show="currentTab === 'evaluacion'" class="space-y-6 animate-fade-in">
            <div>
                <label for="criterios_evaluacion" class="block text-sm font-medium text-gray-300">Criterios de Evaluación</label>
                <textarea name="criterios_evaluacion" id="criterios_evaluacion" rows="4" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500" required>{{ old('criterios_evaluacion') }}</textarea>
                @error('criterios_evaluacion')
                    <span class="text-red-400 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="premiacion" class="block text-sm font-medium text-gray-300">Premiación</label>
                <textarea name="premiacion" id="premiacion" rows="4" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500">{{ old('premiacion') }}</textarea>
                @error('premiacion')
                    <span class="text-red-400 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="penalizaciones" class="block text-sm font-medium text-gray-300">Penalizaciones</label>
                <textarea name="penalizaciones" id="penalizaciones" rows="4" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500">{{ old('penalizaciones') }}</textarea>
                @error('penalizaciones')
                    <span class="text-red-400 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div x-show="currentTab === 'pagos'" class="space-y-6 animate-fade-in">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="costo_pre_registro" class="block text-sm font-medium text-gray-300">Costo de Pre-registro</label>
                    <input type="number" step="0.01" name="costo_pre_registro" id="costo_pre_registro" value="{{ old('costo_pre_registro', 0) }}" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500">
                    @error('costo_pre_registro')
                        <span class="text-red-400 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="costo_inscripcion" class="block text-sm font-medium text-gray-300">Costo de Inscripción</label>
                    <input type="number" step="0.01" name="costo_inscripcion" id="costo_inscripcion" value="{{ old('costo_inscripcion', 0) }}" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500">
                    @error('costo_inscripcion')
                        <span class="text-red-400 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div x-show="currentTab === 'archivos'" class="space-y-6 animate-fade-in">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="archivo_convocatoria" class="block text-sm font-medium text-gray-300">Archivo Convocatoria</label>
                    <input type="file" name="archivo_convocatoria" id="archivo_convocatoria" accept=".pdf" class="mt-1 block w-full text-sm text-gray-300
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-md file:border-0
                        file:text-sm file:font-semibold
                        file:bg-blue-500 file:text-white
                        hover:file:bg-blue-600">
                    @error('archivo_convocatoria')
                        <span class="text-red-400 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="archivo_articulo" class="block text-sm font-medium text-gray-300">Archivo Articulo</label>
                    <input type="file" name="archivo_articulo" id="archivo_articulo" accept=".pdf" class="mt-1 block w-full text-sm text-gray-300
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-md file:border-0
                        file:text-sm file:font-semibold
                        file:bg-blue-500 file:text-white
                        hover:file:bg-blue-600">
                    @error('archivo_articulo')
                        <span class="text-red-400 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="imagen_portada" class="block text-sm font-medium text-gray-300">Imagen Convocatoria</label>
                    <input type="file" name="imagen_portada" id="imagen_portada" accept="image/*" class="mt-1 block w-full text-sm text-gray-300
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-md file:border-0
                        file:text-sm file:font-semibold
                        file:bg-blue-500 file:text-white
                        hover:file:bg-blue-600">
                    @error('imagen_portada')
                        <span class="text-red-400 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="archivo_pdr" class="block text-sm font-medium text-gray-300">Archivo PDR</label>
                    <input type="file" name="archivo_pdr" id="archivo_pdr" accept=".pdf" class="mt-1 block w-full text-sm text-gray-300
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-md file:border-0
                        file:text-sm file:font-semibold
                        file:bg-blue-500 file:text-white
                        hover:file:bg-blue-600">
                    @error('archivo_pdr')
                        <span class="text-red-400 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="archivo_cdr" class="block text-sm font-medium text-gray-300">Archivo CDR</label>
                    <input type="file" name="archivo_cdr" id="archivo_cdr" accept=".pdf" class="mt-1 block w-full text-sm text-gray-300
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-md file:border-0
                        file:text-sm file:font-semibold
                        file:bg-blue-500 file:text-white
                        hover:file:bg-blue-600">
                    @error('archivo_cdr')
                        <span class="text-red-400 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="archivo_pfr" class="block text-sm font-medium text-gray-300">Archivo PFR</label>
                    <input type="file" name="archivo_pfr" id="archivo_pfr" accept=".pdf" class="mt-1 block w-full text-sm text-gray-300
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-md file:border-0
                        file:text-sm file:font-semibold
                        file:bg-blue-500 file:text-white
                        hover:file:bg-blue-600">
                    @error('archivo_pfr')
                        <span class="text-red-400 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Botones de Navegación -->
        <div class="flex justify-between mt-8">
            <button type="button" @click="currentTab = ['general','fechas', 'requisitos', 'documentos', 'evaluacion', 'pagos', 'archivos'][Math.max(0, ['general','fechas', 'requisitos', 'documentos', 'evaluacion', 'pagos', 'archivos'].indexOf(currentTab) - 1)]" class="inline-flex items-center px-4 py-2 bg-gray-600 rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 transition-all duration-150" x-show="currentTab !== 'general'">
                <i class="fas fa-arrow-left mr-2"></i> Anterior
            </button>
            <template x-if="currentTab !== 'archivos'">
                <button type="button" @click="currentTab = ['general','fechas', 'requisitos', 'documentos', 'evaluacion', 'pagos', 'archivos'][['general', 'fechas', 'requisitos', 'documentos', 'evaluacion', 'pagos', 'archivos'].indexOf(currentTab) + 1]; tabs[currentTab] = true; updateProgress()" class="inline-flex items-center px-4 py-2 bg-blue-600 rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 transition-all duration-150 ml-auto">
                    Siguiente <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </template>
            <template x-if="currentTab === 'archivos'">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 transition-all duration-150 ml-auto">
                    <i class="fas fa-save mr-2"></i> Guardar Convocatoria
                </button>
            </template>
        </div>
    </form>
</div>
@endsection



