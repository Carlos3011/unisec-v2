@extends('layouts.admin')

@section('contenido')
<div class="bg-gray-800 bg-opacity-50 p-6 rounded-lg shadow-lg">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-white flex items-center">
            <i class="fa-solid fa-graduation-cap mr-3 text-blue-400"></i>Crear Convocatoria de Congreso
        </h1>
        <a href="{{ route('admin.congresos.convocatorias.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 transition-all duration-150">
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

    <form action="{{ route('admin.congresos.convocatorias.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6" x-data="{
        currentTab: 'general',
        progress: 20,
        tabs: {
            general: true,
            fechas: false,
            requisitos: false,
            documentos: false,
            evaluacion: false,
            pagos: false,
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
        },
        tematicas: [{ titulo: '', descripcion: '' }],
        addTematica() {
            this.tematicas.push({ titulo: '', descripcion: '' });
        },
        removeTematica(index) {
            if (this.tematicas.length > 1) {
                this.tematicas.splice(index, 1);
            }
        }
    }">
        @csrf

        <!-- Barra de Progreso -->
        <div class="w-full bg-gray-700 rounded-full h-2.5 mb-6">
            <div class="bg-blue-500 h-2.5 rounded-full transition-all duration-300" x-bind:style="'width: ' + progress + '%'"></div>
        </div>

        <!-- Navegación de Pestañas -->
        <nav class="flex space-x-4 mb-6 border-b border-gray-700 pb-4 overflow-x-auto">
            <button type="button" @click="currentTab = 'general'" :class="{'text-blue-500 border-b-2 border-blue-500 -mb-4 pb-4': currentTab === 'general'}" class="text-gray-300 hover:text-white transition-all whitespace-nowrap">
                <i class="fas fa-info-circle mr-2"></i>General
            </button>
            <button type="button" @click="currentTab = 'fechas'" :class="{'text-blue-500 border-b-2 border-blue-500 -mb-4 pb-4': currentTab === 'fechas'}" class="text-gray-300 hover:text-white transition-all whitespace-nowrap">
                <i class="fas fa-calendar mr-2"></i>Fechas Importantes
            </button>
            <button type="button" @click="currentTab = 'requisitos'" :class="{'text-blue-500 border-b-2 border-blue-500 -mb-4 pb-4': currentTab === 'requisitos'}" class="text-gray-300 hover:text-white transition-all whitespace-nowrap">
                <i class="fas fa-list-check mr-2"></i>Requisitos
            </button>
            <button type="button" @click="currentTab = 'documentos'" :class="{'text-blue-500 border-b-2 border-blue-500 -mb-4 pb-4': currentTab === 'documentos'}" class="text-gray-300 hover:text-white transition-all whitespace-nowrap">
                <i class="fas fa-file-lines mr-2"></i>Documentación
            </button>
            <button type="button" @click="currentTab = 'evaluacion'" :class="{'text-blue-500 border-b-2 border-blue-500 -mb-4 pb-4': currentTab === 'evaluacion'}" class="text-gray-300 hover:text-white transition-all whitespace-nowrap">
                <i class="fas fa-star mr-2"></i>Evaluación
            </button>
            <button type="button" @click="currentTab = 'pagos'" :class="{'text-blue-500 border-b-2 border-blue-500 -mb-4 pb-4': currentTab === 'pagos'}" class="text-gray-300 hover:text-white transition-all whitespace-nowrap">
                <i class="fas fa-money-bill mr-2"></i>Pagos
            </button>
            <button type="button" @click="currentTab = 'archivos'" :class="{'text-blue-500 border-b-2 border-blue-500 -mb-4 pb-4': currentTab === 'archivos'}" class="text-gray-300 hover:text-white transition-all whitespace-nowrap">
                <i class="fas fa-upload mr-2"></i>Archivos
            </button>
        </nav>

        <!-- Pestaña General -->
        <div x-show="currentTab === 'general'" class="space-y-6 animate-fade-in">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="congreso_id" class="block text-sm font-medium text-gray-300">Congreso</label>
                    <select name="congreso_id" id="congreso_id" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500" required>
                        <option value="">Seleccionar congreso</option>
                        @foreach($congresos as $congreso)
                            <option value="{{ $congreso->id }}">{{ $congreso->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label for="descripcion" class="block text-sm font-medium text-gray-300">Descripción</label>
                    <textarea name="descripcion" id="descripcion" rows="4" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500" required></textarea>
                </div>

                <div>
                    <label for="sede" class="block text-sm font-medium text-gray-300">Sede</label>
                    <input type="text" name="sede" id="sede" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500" required>
                </div>

                <div>
                    <label for="dirigido_a" class="block text-sm font-medium text-gray-300">Dirigido a</label>
                    <input type="text" name="dirigido_a" id="dirigido_a" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500" required>
                </div>

                <div>
                    <label for="contacto_email" class="block text-sm font-medium text-gray-300">Email de Contacto</label>
                    <input type="email" name="contacto_email" id="contacto_email" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500">
                </div>
            </div>
        </div>

        <!-- Pestaña Fechas Importantes -->
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

                <button type="button" @click="addFecha()" class="inline-flex items-center px-4 py-2 bg-blue-600/20 text-blue-400 rounded-lg text-sm hover:bg-blue-600/30 transition-all">
                    <i class="fas fa-plus mr-2"></i> Agregar Fecha
                </button>
            </div>
        </div>

        <!-- Pestaña Requisitos -->
        <div x-show="currentTab === 'requisitos'" class="space-y-6 animate-fade-in">
            <div>
                <label for="requisitos" class="block text-sm font-medium text-gray-300">Requisitos</label>
                <textarea name="requisitos" id="requisitos" rows="6" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500" required></textarea>
            </div>

            <div>
                <label for="tematicas" class="block text-sm font-medium text-gray-300">Temáticas</label>
                <div class="mt-2 space-y-2">
                    <template x-for="(tematica, index) in tematicas" :key="index">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-gray-700/50 rounded-lg">
                            <div>
                                <label :for="'tematica_titulo_' + index" class="block text-sm font-medium text-gray-300">Título</label>
                                <input type="text" :name="'tematicas[' + index + '][titulo]'" :id="'tematica_titulo_' + index" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500" required>
                            </div>
                            <div>
                                <label :for="'tematica_descripcion_' + index" class="block text-sm font-medium text-gray-300">Descripción</label>
                                <input type="text" :name="'tematicas[' + index + '][descripcion]'" :id="'tematica_descripcion_' + index" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500" required>
                            </div>
                            <div class="md:col-span-2 flex justify-end">
                                <button type="button" @click="removeTematica(index)" class="inline-flex items-center px-3 py-1 bg-red-600/20 text-red-400 rounded-lg text-sm hover:bg-red-600/30 transition-all">
                                    <i class="fas fa-trash mr-2"></i> Eliminar
                                </button>
                            </div>
                        </div>
                    </template>
                    <button type="button" @click="addTematica()" class="inline-flex items-center px-3 py-1 bg-blue-600/20 text-blue-400 rounded-lg text-sm hover:bg-blue-600/30 transition-all">
                        <i class="fas fa-plus mr-2"></i> Agregar Temática
                    </button>
                </div>
            </div>
        </div>

        <!-- Pestaña Documentación -->
        <div x-show="currentTab === 'documentos'" class="space-y-6 animate-fade-in">
            <div>
                <label for="formato_articulo" class="block text-sm font-medium text-gray-300">Formato de Artículo</label>
                <textarea name="formato_articulo" id="formato_articulo" rows="4" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500" required></textarea>
            </div>

            <div>
                <label for="formato_extenso" class="block text-sm font-medium text-gray-300">Formato de Extenso</label>
                <textarea name="formato_extenso" id="formato_extenso" rows="4" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500" required></textarea>
            </div>
        </div>

        <!-- Pestaña Evaluación -->
        <div x-show="currentTab === 'evaluacion'" class="space-y-6 animate-fade-in">
            <div>
                <label for="criterios_evaluacion" class="block text-sm font-medium text-gray-300">Criterios de Evaluación</label>
                <textarea name="criterios_evaluacion" id="criterios_evaluacion" rows="6" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500" required></textarea>
            </div>
        </div>

        <!-- Pestaña Pagos -->
        <div x-show="currentTab === 'pagos'" class="space-y-6 animate-fade-in">

            <div x-data="{ cuotas: [{ rol: '', monto: '' }] }" class="space-y-4">
                <label class="block text-sm font-medium text-gray-300">Cuotas de Inscripción</label>
                <template x-for="(cuota, index) in cuotas" :key="index">
                    <div class="grid grid-cols-2 gap-4 p-4 bg-gray-700/50 rounded-lg">
                        <div>
                            <label :for="'cuota_rol_' + index" class="block text-sm font-medium text-gray-300">Rol</label>
                            <input type="text" :name="'cuotas_inscripcion[' + index + '][rol]'" :id="'cuota_rol_' + index" x-model="cuota.rol" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500" required>
                        </div>
                        <div>
                            <label :for="'cuota_monto_' + index" class="block text-sm font-medium text-gray-300">Monto</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-400">$</span>
                                </div>
                                <input type="number" :name="'cuotas_inscripcion[' + index + '][monto]'" :id="'cuota_monto_' + index" step="0.01" min="0" x-model="cuota.monto" class="pl-7 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500" required>
                            </div>
                        </div>
                        <div class="col-span-2 flex justify-end">
                            <button type="button" @click="if (cuotas.length > 1) cuotas.splice(index, 1)" class="inline-flex items-center px-3 py-1 bg-red-600/20 text-red-400 rounded-lg text-sm hover:bg-red-600/30 transition-all">
                                <i class="fas fa-trash mr-2"></i> Eliminar
                            </button>
                        </div>
                    </div>
                </template>
                <button type="button" @click="cuotas.push({ rol: '', monto: '' })" class="inline-flex items-center px-4 py-2 bg-blue-600/20 text-blue-400 rounded-lg text-sm hover:bg-blue-600/30 transition-all">
                    <i class="fas fa-plus mr-2"></i> Agregar Cuota
                </button>
            </div>
        </div>

        <!-- Pestaña Archivos -->
        <div x-show="currentTab === 'archivos'" class="space-y-6 animate-fade-in">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="archivo_convocatoria" class="block text-sm font-medium text-gray-300">Archivo de Convocatoria (PDF)</label>
                    <input type="file" name="archivo_convocatoria" id="archivo_convocatoria" accept=".pdf" class="mt-1 block w-full text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-500/20 file:text-blue-400 hover:file:bg-blue-500/30 file:cursor-pointer">
                </div>

                <div>
                    <label for="archivo_articulo" class="block text-sm font-medium text-gray-300">Formato de Artículo (PDF)</label>
                    <input type="file" name="archivo_articulo" id="archivo_articulo" accept=".pdf" class="mt-1 block w-full text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-500/20 file:text-blue-400 hover:file:bg-blue-500/30 file:cursor-pointer">
                </div>

                <div class="md:col-span-2">
                    <label for="imagen_portada" class="block text-sm font-medium text-gray-300">Imagen de Portada</label>
                    <input type="file" name="imagen_portada" id="imagen_portada" accept="image/*" class="mt-1 block w-full text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-500/20 file:text-blue-400 hover:file:bg-blue-500/30 file:cursor-pointer">
                </div>
            </div>
        </div>

        <!-- Botones de Navegación -->
        <div class="flex justify-between pt-6 border-t border-gray-700">
            <button type="button" @click="currentTab = Object.keys(tabs)[Object.keys(tabs).indexOf(currentTab) - 1]" x-show="Object.keys(tabs).indexOf(currentTab) > 0" class="inline-flex items-center px-4 py-2 bg-gray-600 rounded-lg text-white hover:bg-gray-500 transition-all">
                <i class="fas fa-arrow-left mr-2"></i> Anterior
            </button>
            <button type="button" @click="currentTab = Object.keys(tabs)[Object.keys(tabs).indexOf(currentTab) + 1]; tabs[currentTab] = true; updateProgress();" x-show="Object.keys(tabs).indexOf(currentTab) < Object.keys(tabs).length - 1" class="inline-flex items-center px-4 py-2 bg-blue-600 rounded-lg text-white hover:bg-blue-500 transition-all ml-auto">
                Siguiente <i class="fas fa-arrow-right ml-2"></i>
            </button>
            <button type="submit" x-show="Object.keys(tabs).indexOf(currentTab) === Object.keys(tabs).length - 1" class="inline-flex items-center px-4 py-2 bg-green-600 rounded-lg text-white hover:bg-green-500 transition-all ml-auto">
                <i class="fas fa-save mr-2"></i> Guardar Convocatoria
            </button>
        </div>
    </form>
</div>
@endsection