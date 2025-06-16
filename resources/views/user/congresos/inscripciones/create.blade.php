@extends('layouts.user')

@section('titulo', 'Inscripción a Congreso')

@section('contenido')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-gray-900 rounded-lg shadow-xl overflow-hidden">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-white mb-6">Inscripción a Congreso</h2>

                @if(session('error'))
                    <div class="bg-red-500 text-white p-4 rounded-lg mb-6">
                        {{ session('error') }}
                    </div>
                @endif

                <form id="inscripcionForm" action="{{ route('user.congresos.inscripciones.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <input type="hidden" name="convocatoria_id" value="{{ $convocatoria->id }}">
                    <input type="hidden" name="congreso_id" value="{{ $convocatoria->congreso_id }}">

                    <div class="bg-gray-800/50 p-6 rounded-lg">
                        <h3 class="text-xl font-semibold text-white mb-4">{{ $convocatoria->congreso->nombre }}</h3>
                        <p class="text-gray-300 mb-4">{{ $convocatoria->congreso->descripcion }}</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="tipo_participante" class="block text-sm font-medium text-gray-300">
                                Tipo de Participante
                            </label>
                            <select name="tipo_participante" id="tipo_participante" required
                                class="mt-1 block w-full rounded-lg border-gray-600 bg-gray-800/50 text-white shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-all duration-300 hover:bg-gray-700/50">
                                <option value="">Seleccione un tipo</option>
                                <option value="estudiante" {{ old('tipo_participante') == 'estudiante' ? 'selected' : '' }}>Estudiante</option>
                                <option value="docente" {{ old('tipo_participante') == 'docente' ? 'selected' : '' }}>Docente</option>
                                <option value="investigador" {{ old('tipo_participante') == 'investigador' ? 'selected' : '' }}>Investigador</option>
                                <option value="profesional" {{ old('tipo_participante') == 'profesional' ? 'selected' : '' }}>Profesional</option>
                            </select>
                            @error('tipo_participante')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="institucion" class="block text-sm font-medium text-gray-300">
                                Institución
                            </label>
                            <input type="text" name="institucion" id="institucion" required
                                value="{{ old('institucion') }}"
                                class="mt-1 block w-full rounded-lg border-gray-600 bg-gray-800/50 text-white shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-all duration-300 hover:bg-gray-700/50">
                            @error('institucion')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div id="comprobante_estudiante_container" class="hidden">
                        <label for="comprobante_estudiante" class="block text-sm font-medium text-gray-300">
                            Comprobante de Estudiante (Kardex o Credencial)
                        </label>
                        <input type="file" name="comprobante_estudiante" id="comprobante_estudiante"
                            accept=".pdf,.jpg,.jpeg,.png"
                            class="mt-1 block w-full text-sm text-gray-300
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-lg file:border-0
                                file:text-sm file:font-semibold
                                file:bg-purple-600 file:text-white
                                hover:file:bg-purple-700
                                transition-all duration-300">
                        <p class="mt-1 text-sm text-gray-400">Formatos permitidos: PDF, JPG, JPEG, PNG. Máximo 2MB</p>
                        @error('comprobante_estudiante')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="archivo_articulo" class="block text-sm font-medium text-gray-300">
                            Artículo (Opcional)
                        </label>
                        <input type="file" name="archivo_articulo" id="archivo_articulo"
                            accept=".pdf"
                            class="mt-1 block w-full text-sm text-gray-300
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-lg file:border-0
                                file:text-sm file:font-semibold
                                file:bg-purple-600 file:text-white
                                hover:file:bg-purple-700
                                transition-all duration-300">
                        <p class="mt-1 text-sm text-gray-400">Solo PDF. Máximo 10MB</p>
                        @error('archivo_articulo')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="articulo_fields" class="hidden space-y-4">
                        <div>
                            <label for="titulo_articulo" class="block text-sm font-medium text-gray-300">
                                Título del Artículo
                            </label>
                            <input type="text" name="titulo_articulo" id="titulo_articulo"
                                value="{{ old('titulo_articulo') }}"
                                class="mt-1 block w-full rounded-lg border-gray-600 bg-gray-800/50 text-white shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-all duration-300 hover:bg-gray-700/50">
                            @error('titulo_articulo')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                Autores del Artículo
                            </label>
                            <div id="autores_container" class="space-y-4">
                                <div class="autor-item space-y-4 p-4 bg-gray-800/50 rounded-lg">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-300">Nombre</label>
                                        <input type="text" name="autores[0][nombre]" required
                                            class="mt-1 block w-full rounded-lg border-gray-600 bg-gray-800/50 text-white shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-all duration-300 hover:bg-gray-700/50">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-300">Correo</label>
                                        <input type="email" name="autores[0][correo]" required
                                            class="mt-1 block w-full rounded-lg border-gray-600 bg-gray-800/50 text-white shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-all duration-300 hover:bg-gray-700/50">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-300">Institución</label>
                                        <input type="text" name="autores[0][institucion]" required
                                            class="mt-1 block w-full rounded-lg border-gray-600 bg-gray-800/50 text-white shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-all duration-300 hover:bg-gray-700/50">
                                    </div>
                                </div>
                            </div>
                            <button type="button" id="agregar_autor" class="mt-4 px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-all duration-300">
                                Agregar Autor
                            </button>
                            @error('autores')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('user.congresos.inscripciones.index') }}"
                            class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-all duration-300">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-all duration-300">
                            Crear Inscripción
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const tipoParticipante = document.getElementById('tipo_participante');
    const comprobanteContainer = document.getElementById('comprobante_estudiante_container');
    const comprobanteInput = document.getElementById('comprobante_estudiante');
    const archivoArticulo = document.getElementById('archivo_articulo');
    const articuloFields = document.getElementById('articulo_fields');
    const agregarAutorBtn = document.getElementById('agregar_autor');
    const autoresContainer = document.getElementById('autores_container');
    const inscripcionForm = document.getElementById('inscripcionForm');
    let autorCount = 1;

    // Función para manejar el envío del formulario
    inscripcionForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Mostrar alerta de confirmación
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¿Deseas crear la inscripción?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#9333ea',
            cancelButtonColor: '#4b5563',
            confirmButtonText: 'Sí, crear inscripción',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Mostrar alerta de carga
                Swal.fire({
                    title: 'Procesando inscripción',
                    text: 'Por favor espere...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Enviar el formulario vía AJAX
                const formData = new FormData(inscripcionForm);
                
                fetch(inscripcionForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: '¡Éxito!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonColor: '#9333ea'
                        }).then(() => {
                            window.location.href = data.redirect;
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: 'Hubo un error al crear la inscripción',
                            icon: 'error',
                            confirmButtonColor: '#9333ea'
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        title: 'Error',
                        text: 'Hubo un error al procesar la solicitud',
                        icon: 'error',
                        confirmButtonColor: '#9333ea'
                    });
                });
            }
        });
    });

    function toggleComprobante() {
        if (tipoParticipante.value === 'estudiante') {
            comprobanteContainer.classList.remove('hidden');
            comprobanteInput.required = true;
        } else {
            comprobanteContainer.classList.add('hidden');
            comprobanteInput.required = false;
            comprobanteInput.value = '';
        }
    }

    function toggleArticuloFields() {
        if (archivoArticulo.files.length > 0) {
            articuloFields.classList.remove('hidden');
            document.getElementById('titulo_articulo').required = true;
            document.querySelectorAll('[name^="autores"][name$="[nombre]"]').forEach(input => input.required = true);
            document.querySelectorAll('[name^="autores"][name$="[correo]"]').forEach(input => input.required = true);
            document.querySelectorAll('[name^="autores"][name$="[institucion]"]').forEach(input => input.required = true);
        } else {
            articuloFields.classList.add('hidden');
            document.getElementById('titulo_articulo').required = false;
            document.querySelectorAll('[name^="autores"][name$="[nombre]"]').forEach(input => input.required = false);
            document.querySelectorAll('[name^="autores"][name$="[correo]"]').forEach(input => input.required = false);
            document.querySelectorAll('[name^="autores"][name$="[institucion]"]').forEach(input => input.required = false);
        }
    }

    function agregarAutor() {
        const autorItem = document.createElement('div');
        autorItem.className = 'autor-item space-y-4 p-4 bg-gray-800/50 rounded-lg mt-4';
        autorItem.innerHTML = `
            <div>
                <label class="block text-sm font-medium text-gray-300">Nombre</label>
                <input type="text" name="autores[${autorCount}][nombre]" required
                    class="mt-1 block w-full rounded-lg border-gray-600 bg-gray-800/50 text-white shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-all duration-300 hover:bg-gray-700/50">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300">Correo</label>
                <input type="email" name="autores[${autorCount}][correo]" required
                    class="mt-1 block w-full rounded-lg border-gray-600 bg-gray-800/50 text-white shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-all duration-300 hover:bg-gray-700/50">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300">Institución</label>
                <input type="text" name="autores[${autorCount}][institucion]" required
                    class="mt-1 block w-full rounded-lg border-gray-600 bg-gray-800/50 text-white shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-all duration-300 hover:bg-gray-700/50">
            </div>
            <button type="button" class="eliminar-autor px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all duration-300">
                Eliminar Autor
            </button>
        `;

        autoresContainer.appendChild(autorItem);
        autorCount++;

        // Agregar evento para eliminar autor
        autorItem.querySelector('.eliminar-autor').addEventListener('click', function() {
            autorItem.remove();
        });
    }

    tipoParticipante.addEventListener('change', toggleComprobante);
    archivoArticulo.addEventListener('change', toggleArticuloFields);
    agregarAutorBtn.addEventListener('click', agregarAutor);

    // Ejecutar al cargar la página
    toggleComprobante();
    toggleArticuloFields();
});
</script>
@endsection