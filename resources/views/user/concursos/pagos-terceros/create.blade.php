@extends('layouts.user')

@section('titulo', 'Registro de Pago por Transferencia')

@section('contenido')
<div class="min-h-screen py-12 relative overflow-hidden bg-gradient-to-b from-space-950 to-cosmic-900">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto bg-black/30 backdrop-blur-xl rounded-2xl overflow-hidden border border-white/10 relative transition-all duration-300 hover:border-white/20 hover:shadow-[0_0_30px_rgba(147,51,234,0.3)]">
            <div class="p-6">
                <a href="{{ route('user.concursos.index') }}" class="text-white/90 hover:text-white flex items-center gap-2 bg-white/5 px-4 py-2 rounded-lg w-fit transition-all duration-300 hover:bg-white/10">
                    <i class="fas fa-arrow-left"></i>
                    <span>Volver a Concursos</span>
                </a>
            </div>

            <div class="p-8">
                <h1 class="text-3xl font-bold text-white mb-6 text-center">Registro de Pago por Transferencia</h1>
                
                <form id="pagoForm" class="space-y-6" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-white/90">Seleccionar Concurso</label>
                        <select name="concurso_id" class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-2.5 text-white focus:ring-2 focus:ring-purple-400 focus:border-transparent transition-all" required>
                            <option value="">Seleccione un concurso</option>
                            @foreach($concursos as $concurso)
                                <option value="{{ $concurso->id }}">{{ $concurso->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tipo de Tercero -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-white/90">Tipo de Tercero</label>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <label class="relative flex items-center justify-center p-4 cursor-pointer bg-white/5 rounded-lg border border-white/10 hover:bg-white/10 transition-all">
                                <input type="radio" name="tipo_tercero" value="universidad" class="sr-only peer" required>
                                <div class="peer-checked:text-purple-400 text-white/70 text-center">
                                    <i class="fas fa-university text-2xl mb-2"></i>
                                    <p>Universidad</p>
                                </div>
                                <div class="absolute inset-0 border-2 border-transparent peer-checked:border-purple-400 rounded-lg pointer-events-none"></div>
                            </label>
                            <label class="relative flex items-center justify-center p-4 cursor-pointer bg-white/5 rounded-lg border border-white/10 hover:bg-white/10 transition-all">
                                <input type="radio" name="tipo_tercero" value="empresa" class="sr-only peer" required>
                                <div class="peer-checked:text-purple-400 text-white/70 text-center">
                                    <i class="fas fa-building text-2xl mb-2"></i>
                                    <p>Empresa</p>
                                </div>
                                <div class="absolute inset-0 border-2 border-transparent peer-checked:border-purple-400 rounded-lg pointer-events-none"></div>
                            </label>
                            <label class="relative flex items-center justify-center p-4 cursor-pointer bg-white/5 rounded-lg border border-white/10 hover:bg-white/10 transition-all">
                                <input type="radio" name="tipo_tercero" value="persona_fisica" class="sr-only peer" required>
                                <div class="peer-checked:text-purple-400 text-white/70 text-center">
                                    <i class="fas fa-user text-2xl mb-2"></i>
                                    <p>Persona Física</p>
                                </div>
                                <div class="absolute inset-0 border-2 border-transparent peer-checked:border-purple-400 rounded-lg pointer-events-none"></div>
                            </label>
                        </div>
                    </div>

                    <!-- Información del Tercero -->
                    <div class="space-y-4">
                        <div>
                            <label for="nombre" class="block text-sm font-medium text-white/90">Nombre o Razón Social</label>
                            <input type="text" id="nombre" name="nombre" required class="mt-1 block w-full rounded-lg bg-white/5 border border-white/10 text-white placeholder-white/50 focus:border-purple-500 focus:ring-purple-500">
                        </div>

                        <div>
                            <label for="rfc" class="block text-sm font-medium text-white/90">RFC</label>
                            <input type="text" id="rfc" name="rfc" required maxlength="13" class="mt-1 block w-full rounded-lg bg-white/5 border border-white/10 text-white placeholder-white/50 focus:border-purple-500 focus:ring-purple-500">
                        </div>

                        <div>
                            <label for="contacto" class="block text-sm font-medium text-white/90">Nombre del Contacto</label>
                            <input type="text" id="contacto" name="contacto" required class="mt-1 block w-full rounded-lg bg-white/5 border border-white/10 text-white placeholder-white/50 focus:border-purple-500 focus:ring-purple-500">
                        </div>

                        <div>
                            <label for="correo" class="block text-sm font-medium text-white/90">Correo Electrónico</label>
                            <input type="email" id="correo" name="correo" required class="mt-1 block w-full rounded-lg bg-white/5 border border-white/10 text-white placeholder-white/50 focus:border-purple-500 focus:ring-purple-500">
                        </div>
                    </div>

                    <!-- Tipo de Cobertura -->
                    <div class="space-y-4">
                        <label class="block text-sm font-medium text-white/90">Tipo de Cobertura</label>
                        <div class="flex flex-col space-y-2">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="cubre_pre_registro" class="form-checkbox rounded bg-white/5 border-white/10 text-purple-500 focus:ring-purple-500">
                                <span class="ml-2 text-white/90">Pre-registro (${{ number_format($concurso->costo_pre_registro, 2) }} MXN)</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="cubre_inscripcion" class="form-checkbox rounded bg-white/5 border-white/10 text-purple-500 focus:ring-purple-500">
                                <span class="ml-2 text-white/90">Inscripción (${{ number_format($concurso->costo_inscripcion, 2) }} MXN)</span>
                            </label>
                        </div>
                    </div>

                    <!-- Número de Pagos -->
                    <div>
                        <label for="numero_pagos" class="block text-sm font-medium text-white/90">Número de Pagos a Cubrir</label>
                        <input type="number" id="numero_pagos" name="numero_pagos" min="1" required class="mt-1 block w-full rounded-lg bg-white/5 border border-white/10 text-white placeholder-white/50 focus:border-purple-500 focus:ring-purple-500">
                        <p class="mt-1 text-sm text-white/60">Indica cuántos participantes cubrirá este pago</p>
                    </div>

                    <!-- Comprobante de Pago -->
                    <div>
                        <label class="block text-sm font-medium text-white/90 mb-2">Comprobante de Pago</label>
                        <div class="flex justify-center px-6 pt-5 pb-6 border-2 border-white/10 border-dashed rounded-lg hover:border-purple-500/50 transition-all">
                            <div class="space-y-1 text-center">
                                <i class="fas fa-cloud-upload-alt text-4xl text-white/50"></i>
                                <div class="flex text-sm text-white/70">
                                    <label for="comprobante" class="relative cursor-pointer rounded-md font-medium text-purple-400 hover:text-purple-300 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-purple-500">
                                        <span>Subir archivo</span>
                                        <input id="comprobante" name="comprobante" type="file" class="sr-only" accept=".pdf,.jpg,.jpeg,.png" required>
                                    </label>
                                    <p class="pl-1">o arrastra y suelta</p>
                                </div>
                                <p class="text-xs text-white/50">PNG, JPG, PDF hasta 2MB</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all duration-300 transform hover:scale-105">
                            Registrar Pago
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('pagoForm');
    const fileInput = document.getElementById('comprobante');

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = new FormData(form);
        
        try {
            const response = await fetch('{{ route("user.concursos.pagos-terceros.store") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            const data = await response.json();

            if (response.ok) {
                Swal.fire({
                    title: '¡Éxito!',
                    text: 'Tu pago ha sido registrado. Guarda este código para validar los pagos: ' + data.codigo_validacion,
                    icon: 'success',
                    confirmButtonText: 'Entendido'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '{{ route("user.concursos.convocatorias.show", $concurso) }}';
                    }
                });
            } else {
                throw new Error(data.message || 'Error al procesar el pago');
            }
        } catch (error) {
            Swal.fire({
                title: 'Error',
                text: error.message || 'Hubo un error al procesar tu solicitud',
                icon: 'error',
                confirmButtonText: 'Cerrar'
            });
        }
    });

    // Previsualización del archivo
    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file && file.size > 2 * 1024 * 1024) {
            Swal.fire({
                title: 'Error',
                text: 'El archivo no debe superar los 2MB',
                icon: 'error',
                confirmButtonText: 'Entendido'
            });
            fileInput.value = '';
        }
    });
});
</script>
@endpush

@endsection