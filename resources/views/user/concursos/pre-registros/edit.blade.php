@extends('layouts.user')

@section('titulo', 'Editar Pre-registro')

@section('contenido')
<div class="relative z-10 min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
    <div class="w-full sm:max-w-2xl mt-6 px-10 py-10 bg-gradient-to-br from-gray-900 via-orange-900/20 to-black shadow-2xl overflow-hidden sm:rounded-xl hover:border-orange-400/60 transition-all duration-500 ease-out border border-orange-500/40 relative group hover:-translate-y-1 backdrop-blur-sm">
        <h2 class="text-2xl font-bold mb-6 text-center text-white">Editar Pre-registro</h2>

        @if ($errors->any())
            <div class="bg-red-500/10 border border-red-400 text-red-400 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('user.concursos.pre-registros.update', $preRegistro) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="concurso_id" class="block text-sm font-medium text-white mb-1">Concurso</label>
                <div class="mt-1 block w-full rounded-md border-gray-300 bg-gray-800/50 text-white font-bold shadow-sm px-3 py-2 border border-gray-600">
                    {{ $preRegistro->concurso->titulo }}
                </div>
                <input type="hidden" name="concurso_id" value="{{ $preRegistro->concurso_id }}">
            </div>

            <div>
                <label for="nombre_equipo" class="block text-sm font-medium text-white mb-1">Nombre del Equipo</label>
                <input type="text" name="nombre_equipo" id="nombre_equipo" value="{{ old('nombre_equipo', $preRegistro->nombre_equipo) }}" required
                    class="mt-1 block w-full rounded-lg border-gray-600 bg-gray-800/50 text-white shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-all duration-300 hover:bg-gray-700/50">
            </div>

            <div>
                <label for="integrantes" class="block text-sm font-medium text-white mb-1">Número de Integrantes</label>
                <input type="number" name="integrantes" id="integrantes" value="{{ old('integrantes', $preRegistro->integrantes) }}" required min="1" max="5"
                    class="mt-1 block w-full rounded-lg border-gray-600 bg-gray-800/50 text-white shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-all duration-300 hover:bg-gray-700/50"
                    onchange="actualizarIntegrantes(this.value)">
            </div>

            <div id="integrantes-container" class="space-y-6">
                <!-- Los campos de los integrantes se generarán aquí dinámicamente -->
            </div>

            <script>
                function actualizarIntegrantes(cantidad) {
                    cantidad = Math.min(Math.max(parseInt(cantidad) || 1, 1), 5);
                    document.getElementById('integrantes').value = cantidad;
                    const container = document.getElementById('integrantes-container');
                    container.innerHTML = '';
                    
                    const integrantesData = @json($preRegistro->integrantes_data ?? []);
                    
                    for (let i = 0; i < cantidad; i++) {
                        const integranteData = integrantesData[i] || {};
                        const integranteHtml = `
                            <div class="bg-gray-800/30 p-6 rounded-xl border border-gray-700/50 space-y-4 shadow-lg hover:border-purple-500/50 transition-all duration-300 backdrop-blur-sm">
                                <div class="flex justify-between items-center cursor-pointer p-2 rounded-lg hover:bg-gray-700/30 transition-all duration-300" onclick="toggleIntegrante(${i})">
                                    <h3 class="text-white font-medium">Integrante ${i + 1}</h3>
                                    <button type="button" class="text-white hover:text-orange-400 transition-colors">
                                        <i id="icon-${i}" class="fas fa-chevron-up transform transition-transform duration-300"></i>
                                    </button>
                                </div>
                                
                                <div id="content-${i}" class="space-y-4 transition-all duration-300 overflow-hidden" style="max-height: ${i === 0 ? 'none' : '0px'}">
                                    <div>
                                        <label class="block text-sm font-medium text-white mb-1">Nombre Completo</label>
                                        <input type="text" name="integrantes_data[${i}][nombre_completo]" required
                                            value="${integranteData.nombre_completo || ''}"
                                            class="mt-1 block w-full rounded-lg border-gray-600 bg-gray-800/50 text-white shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-all duration-300 hover:bg-gray-700/50">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-white mb-1">Matrícula</label>
                                        <input type="text" name="integrantes_data[${i}][matricula]" required
                                            value="${integranteData.matricula || ''}"
                                            class="mt-1 block w-full rounded-lg border-gray-600 bg-gray-800/50 text-white shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-all duration-300 hover:bg-gray-700/50">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-white mb-1">Carrera</label>
                                        <input type="text" name="integrantes_data[${i}][carrera]" required
                                            value="${integranteData.carrera || ''}"
                                            class="mt-1 block w-full rounded-lg border-gray-600 bg-gray-800/50 text-white shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-all duration-300 hover:bg-gray-700/50">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-white mb-1">Correo Institucional</label>
                                        <input type="email" name="integrantes_data[${i}][correo_institucional]" required
                                            value="${integranteData.correo_institucional || ''}"
                                            class="mt-1 block w-full rounded-lg border-gray-600 bg-gray-800/50 text-white shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-all duration-300 hover:bg-gray-700/50">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-white mb-1">Periodo Académico</label>
                                        <input type="number" name="integrantes_data[${i}][periodo_academico]" required min="1"
                                            value="${integranteData.periodo_academico || ''}"
                                            class="mt-1 block w-full rounded-lg border-gray-600 bg-gray-800/50 text-white shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-all duration-300 hover:bg-gray-700/50">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-white mb-1">Tipo de Periodo</label>
                                        <select name="integrantes_data[${i}][tipo_periodo]" required
                                            class="mt-1 block w-full rounded-lg border-gray-600 bg-gray-800/50 text-white shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-all duration-300 hover:bg-gray-700/50">
                                            <option value="semestre" ${integranteData.tipo_periodo === 'semestre' ? 'selected' : ''}>Semestre</option>
                                            <option value="cuatrimestre" ${integranteData.tipo_periodo === 'cuatrimestre' ? 'selected' : ''}>Cuatrimestre</option>
                                            <option value="trimestre" ${integranteData.tipo_periodo === 'trimestre' ? 'selected' : ''}>Trimestre</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        `;
                        container.insertAdjacentHTML('beforeend', integranteHtml);
                        
                        // Establecer la rotación inicial del icono
                        const icon = document.getElementById(`icon-${i}`);
                        icon.style.transform = i === 0 ? 'rotate(180deg)' : 'rotate(0deg)';
                    }
                }

                function toggleIntegrante(index) {
                    const content = document.getElementById(`content-${index}`);
                    const icon = document.getElementById(`icon-${index}`);
                    
                    if (content.style.maxHeight !== '0px') {
                        content.style.maxHeight = '0px';
                        icon.style.transform = 'rotate(0deg)';
                    } else {
                        content.style.maxHeight = content.scrollHeight + 'px';
                        icon.style.transform = 'rotate(180deg)';
                    }
                }

                // Inicializar los campos de integrantes al cargar la página
                document.addEventListener('DOMContentLoaded', function() {
                    const cantidadInicial = document.getElementById('integrantes').value;
                    actualizarIntegrantes(cantidadInicial);
                    
                    // Inicializar el estado de los paneles: primer panel expandido, los demás colapsados
                    setTimeout(() => {
                        const cantidad = document.getElementById('integrantes').value;
                        for (let i = 0; i < cantidad; i++) {
                            const content = document.getElementById(`content-${i}`);
                            const icon = document.getElementById(`icon-${i}`);
                            
                            if (i === 0) {
                                // Expandir el primer panel
                                content.style.maxHeight = content.scrollHeight + 'px';
                                icon.style.transform = 'rotate(180deg)';
                            } else {
                                // Colapsar los demás paneles
                                content.style.maxHeight = '0px';
                                icon.style.transform = 'rotate(0deg)';
                            }
                        }
                    }, 100);
                });
            </script>

            <div>
                <label for="asesor" class="block text-sm font-medium text-white mb-1">Asesor (Opcional)</label>
                <input type="text" name="asesor" id="asesor" value="{{ old('asesor', $preRegistro->asesor) }}"
                    class="mt-1 block w-full rounded-lg border-gray-600 bg-gray-800/50 text-white shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-all duration-300 hover:bg-gray-700/50">
            </div>

            <div>
                <label for="institucion" class="block text-sm font-medium text-white mb-1">Institución (Opcional)</label>
                <input type="text" name="institucion" id="institucion" value="{{ old('institucion', $preRegistro->institucion) }}"
                    class="mt-1 block w-full rounded-lg border-gray-600 bg-gray-800/50 text-white shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-all duration-300 hover:bg-gray-700/50">
            </div>



            <div>
                <label for="archivo_pdr" class="block text-sm font-medium text-white mb-1">Archivo PDR (PDF, DOC, DOCX - Max 10MB)</label>
                @if($preRegistro->archivo_pdr)
                    <div class="mb-2 text-sm text-gray-400">
                        Archivo actual: 
                        <a href="{{ route('user.concursos.pre-registros.download-pdr', $preRegistro) }}" class="text-blue-400 hover:text-blue-300">
                            Descargar archivo
                        </a>
                    </div>
                @endif
                <input type="file" name="archivo_pdr" id="archivo_pdr" accept=".pdf,.doc,.docx"
                    class="mt-1 block w-full rounded-lg border-gray-600 bg-gray-800/50 text-white shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-all duration-300 hover:bg-gray-700/50">
            </div>

            <div class="flex justify-between space-x-4">
                <a href="{{ route('user.concursos.pre-registros.show', $preRegistro) }}"
                    class="flex-1 inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-xl shadow-lg text-sm font-medium text-white bg-gray-800/50 hover:bg-gray-700 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all duration-300">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Cancelar
                </a>
                <button type="submit"
                    class="flex-1 inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-xl shadow-lg text-sm font-medium text-white bg-orange-600/30 hover:bg-orange-700 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-300">
                    <i class="fas fa-save mr-2"></i>
                    Actualizar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection