@extends('layouts.user')

@section('titulo', 'Crear Pre-registro')

@section('contenido')
<div class="min-h-screen flex flex-col sm:justify-center items-center p-4 sm:p-6">
    <div class="w-full max-w-2xl mx-auto mt-6 px-4 sm:px-10 py-8 sm:py-10 bg-gradient-to-br from-gray-900 to-black shadow-md overflow-hidden rounded-lg sm:rounded-xl hover:border-orange-400/60 transition-all duration-500 ease-out border border-blue-500/40 relative group hover:-translate-y-0.5">
        <h2 class="text-2xl font-bold mb-6 text-center text-white">Pre-registro para Concurso</h2>

        @if ($errors->any())
            <div class="bg-red-500/10 border border-red-400 text-red-400 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('user.concursos.pre-registros.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            

            <div>
                <label class="block text-sm font-medium text-white mb-1">Concurso</label>
                <input type="hidden" name="concurso_id" value="{{ $concursos->first()->id }}">
                <div class="mt-1 block w-full rounded-md border-gray-300 bg-gray-800/50 text-white font-bold shadow-sm px-3 py-2 border border-gray-600">
                    {{ $concursos->first()->titulo }}
                </div>
            </div>

            <div>
                <label for="nombre_equipo" class="block text-sm font-medium text-white mb-1">Nombre del Equipo</label>
                <input type="text" name="nombre_equipo" id="nombre_equipo" value="{{ old('nombre_equipo') }}" required
                    class="mt-1 block w-full rounded-lg border-gray-600 bg-gray-800/50 text-white shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-all duration-300 hover:bg-gray-700/50">
            </div>

            <div>
                <label for="integrantes" class="block text-sm font-medium text-white mb-1">Número de Integrantes</label>
                <input type="number" name="integrantes" id="integrantes" value="{{ old('integrantes', 1) }}" required min="1" max="5"
                    class="mt-1 block w-full rounded-lg border-gray-600 bg-gray-800/50 text-white shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-all duration-300 hover:bg-gray-700/50"
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
                    
                    for (let i = 0; i < cantidad; i++) {
                        const integranteHtml = `
                            <div class="bg-gray-800/30 p-4 sm:p-6 rounded-xl border border-gray-700/50 space-y-4 shadow-lg hover:border-purple-500/50 transition-all duration-300 backdrop-blur-sm">
                                <div class="flex justify-between items-center cursor-pointer p-2 rounded-lg hover:bg-gray-700/30 transition-all duration-300" onclick="toggleIntegrante(${i})">
                                    <h3 class="text-white font-medium text-sm sm:text-base">Integrante ${i + 1}</h3>
                                    <button type="button" class="text-white hover:text-purple-400 transition-colors">
                                        <i id="icon-${i}" class="fas fa-chevron-up transform transition-transform duration-300"></i>
                                    </button>
                                </div>
                                
                                <div id="content-${i}" class="space-y-4 transition-all duration-300 overflow-hidden" style="max-height: ${i === 0 ? 'none' : '0px'}">
                                    <div>
                                        <label class="block text-sm font-medium text-white mb-1">Nombre Completo</label>
                                        <input type="text" name="integrantes_data[${i}][nombre_completo]" required
                                            value="${i === 0 ? '{{ ($user->name) }}' : ''}"
                                            class="mt-1 block w-full rounded-lg border-gray-600 bg-gray-800/50 text-white shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-all duration-300 hover:bg-gray-700/50">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-white mb-1">Matrícula</label>
                                        <input type="text" name="integrantes_data[${i}][matricula]" required
                                            class="mt-1 block w-full rounded-lg border-gray-600 bg-gray-800/50 text-white shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-all duration-300 hover:bg-gray-700/50">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-white mb-1">Carrera</label>
                                        <input type="text" name="integrantes_data[${i}][carrera]" required
                                            class="mt-1 block w-full rounded-lg border-gray-600 bg-gray-800/50 text-white shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-all duration-300 hover:bg-gray-700/50">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-white mb-1">Correo Institucional</label>
                                        <input type="email" name="integrantes_data[${i}][correo_institucional]" required
                                            value="${i === 0 ? '{{ ($user->email) }}' : ''}"
                                            class="mt-1 block w-full rounded-lg border-gray-600 bg-gray-800/50 text-white shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-all duration-300 hover:bg-gray-700/50">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-white mb-1">Periodo Académico</label>
                                        <input type="number" name="integrantes_data[${i}][periodo_academico]" required min="1"
                                            class="mt-1 block w-full rounded-lg border-gray-600 bg-gray-800/50 text-white shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-all duration-300 hover:bg-gray-700/50">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-white mb-1">Tipo de Periodo</label>
                                        <select name="integrantes_data[${i}][tipo_periodo]" required
                                            class="mt-1 block w-full rounded-lg border-gray-600 bg-gray-800/50 text-white shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-all duration-300 hover:bg-gray-700/50">
                                            <option value="semestre">Semestre</option>
                                            <option value="cuatrimestre">Cuatrimestre</option>
                                            <option value="trimestre">Trimestre</option>
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
                <label for="asesor" class="block text-sm font-medium text-white mb-1">Asesor</label>
                <input type="text" name="asesor" id="asesor" value="{{ old('asesor') }}" required
                    class="mt-1 block w-full rounded-lg border-gray-600 bg-gray-800/50 text-white shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-all duration-300 hover:bg-gray-700/50">
            </div>

            <div>
                <label for="institucion" class="block text-sm font-medium text-white mb-1">Institución</label>
                <input type="text" name="institucion" id="institucion" value="{{ old('institucion') }}" required
                    class="mt-1 block w-full rounded-lg border-gray-600 bg-gray-800/50 text-white shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-all duration-300 hover:bg-gray-700/50">
            </div>

            <div>
                <label for="archivo_pdr" class="block text-sm font-medium text-white mb-1">Archivo PDR (PDF, DOC, DOCX - Max 10MB)</label>
                <input type="file" name="archivo_pdr" id="archivo_pdr" accept=".pdf,.doc,.docx" required
                    class="mt-1 block w-full rounded-lg border-gray-600 bg-gray-800/50 text-white shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-all duration-300 hover:bg-gray-700/50">
            </div>

            <div class="flex flex-col sm:flex-row justify-between space-y-4 sm:space-y-0 sm:space-x-4">
                <a href="{{ route('user.concursos.pre-registros.index') }}"
                    class="w-full sm:flex-1 inline-flex items-center justify-center px-4 sm:px-6 py-3 border border-transparent rounded-xl shadow-lg text-sm font-medium text-white bg-gray-800/50 hover:bg-gray-700 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all duration-300">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Cancelar
                </a>
                <button type="submit"
                    class="w-full sm:flex-1 inline-flex items-center justify-center px-4 sm:px-6 py-3 border border-transparent rounded-xl shadow-lg text-sm font-medium text-white bg-purple-600/30 hover:bg-purple-700 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all duration-300">
                    <i class="fas fa-save mr-2"></i>
                    Crear Pre-registro
                </button>
            </div>
        </form>
    </div>
</div>
@endsection