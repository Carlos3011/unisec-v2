@extends('layouts.user')

@section('contenido')
<div class="min-h-screen py-12 relative overflow-hidden bg-gradient-to-b from-space-950 to-cosmic-900">
    <div class="container mx-auto px-4">
        <div class="mb-6">
            <a href="{{ route('user.concursos.pagos-terceros.index') }}" class="text-white/90 hover:text-white flex items-center gap-2 bg-white/5 px-4 py-2 rounded-lg w-fit transition-all duration-300 hover:bg-white/10">
                <i class="fas fa-arrow-left"></i>
                <span>Volver a la lista</span>
            </a>
        </div>

        <div class="bg-black/30 backdrop-blur-xl rounded-2xl overflow-hidden border border-white/10 hover:border-white/20 transition-all duration-300 hover:shadow-[0_0_30px_rgba(147,51,234,0.3)]">
            <div class="px-6 py-4 border-b border-white/10">
                <h2 class="text-2xl font-bold text-white">Detalles del Pago</h2>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white/5 rounded-xl p-6 border border-white/10">
                        <h3 class="text-lg font-semibold text-white mb-4">Información del Concurso</h3>
                        <div class="space-y-3 text-white/90">
                            <p><span class="font-medium">Concurso:</span> {{ $pago->concurso->nombre }}</p>
                            <p><span class="font-medium">Estado del pago:</span>
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($pago->estado_pago == 'validado')
                                        bg-green-400/10 text-green-400
                                    @elseif($pago->estado_pago == 'rechazado')
                                        bg-red-400/10 text-red-400
                                    @else
                                        bg-yellow-400/10 text-yellow-400
                                    @endif">
                                    {{ ucfirst($pago->estado_pago) }}
                                </span>
                            </p>
                            <p><span class="font-medium">Fecha de registro:</span> {{ $pago->created_at->format('d/m/Y H:i') }}</p>
                            <p><span class="font-medium">Monto total:</span> ${{ number_format($pago->monto_total, 2) }}</p>
                        </div>
                    </div>

                    <div class="bg-white/5 rounded-xl p-6 border border-white/10">
                        <h3 class="text-lg font-semibold text-white mb-4">Información del Tercero</h3>
                        <div class="space-y-3 text-white/90">
                            <p><span class="font-medium">Tipo:</span> {{ ucfirst(str_replace('_', ' ', $pago->tipo_tercero)) }}</p>
                            <p><span class="font-medium">Nombre:</span> {{ $pago->nombre_tercero }}</p>
                            <p><span class="font-medium">RFC:</span> {{ $pago->rfc_tercero }}</p>
                            <p><span class="font-medium">Contacto:</span> {{ $pago->contacto_tercero }}</p>
                            <p><span class="font-medium">Correo:</span> {{ $pago->correo_tercero }}</p>
                        </div>
                    </div>

                    <div class="md:col-span-2 bg-white/5 rounded-xl p-6 border border-white/10">
                        <h3 class="text-lg font-semibold text-white mb-4">Detalles de Cobertura</h3>
                        <div class="space-y-3 text-white/90">
                            <p><span class="font-medium">Cubre pre-registro:</span> 
                                <span class="{{ $pago->cubre_pre_registro ? 'text-green-400' : 'text-red-400' }}">
                                    {{ $pago->cubre_pre_registro ? 'Sí' : 'No' }}
                                </span>
                            </p>
                            <p><span class="font-medium">Cubre inscripción:</span>
                                <span class="{{ $pago->cubre_inscripcion ? 'text-green-400' : 'text-red-400' }}">
                                    {{ $pago->cubre_inscripcion ? 'Sí' : 'No' }}
                                </span>
                            </p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                <div class="bg-green-900/20 p-4 rounded-lg border border-green-400/30">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="font-medium">Pre-registros</span>
                                        <span class="text-green-400 text-sm">{{ $usosDisponiblesPre }} / {{ $pago->numero_pagos }}</span>
                                    </div>
                                    <div class="h-2 bg-green-900/30 rounded-full">
                                        <div class="h-2 bg-green-400 rounded-full" style="width: {{ ($usosDisponiblesPre / $pago->numero_pagos) * 100 }}%"></div>
                                    </div>
                                </div>
                                <div class="bg-purple-900/20 p-4 rounded-lg border border-purple-400/30">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="font-medium">Inscripciones</span>
                                        <span class="text-purple-400 text-sm">{{ $usosDisponiblesIns }} / {{ $pago->numero_pagos }}</span>
                                    </div>
                                    <div class="h-2 bg-purple-900/30 rounded-full">
                                        <div class="h-2 bg-purple-400 rounded-full" style="width: {{ ($usosDisponiblesIns / $pago->numero_pagos) * 100 }}%"></div>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-4"><span class="font-medium">Código de validación:</span> <code class="bg-white/5 px-2 py-1 rounded">{{ $pago->codigo_validacion_unico }}</code></p>
                        </div>
                    </div>

                    <div class="md:col-span-2 bg-white/5 rounded-xl p-6 border border-white/10">
                        <h3 class="text-lg font-semibold text-white mb-4">Comprobante de Pago</h3>
                        <div class="p-4 border border-white/10 rounded-lg bg-white/5">
                            // Control de visibilidad del comprobante
                            @if($pago->estado_pago === 'validado' && $pago->comprobante_pago)
                                <a href="{{ Storage::url($pago->comprobante_pago) }}" target="_blank" class="text-blue-400 hover:text-blue-300 transition-colors duration-200 flex items-center gap-2">
                                    <i class="fas fa-download"></i>
                                    <span>Ver comprobante</span>
                                </a>
                            @else
                                <p class="text-white/60">Comprobante no disponible</p>
                            @endif
                            
                            <div class="flex flex-col gap-2 md:flex-row md:items-center mt-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 w-full">
                                <div class="relative">
                                    <div class="absolute inset-0 bg-green-900/20 rounded-lg border border-green-400/30 opacity-30"></div>
                                    <select id="tipo_uso" class="relative z-10 w-full bg-transparent text-white p-2 rounded-lg">
                                        <option value="pre_registro" class="bg-green-900 text-white">Usar para Pre-registro</option>
                                        <option value="inscripcion" class="bg-purple-900 text-white">Usar para Inscripción</option>
                                    </select>
                                </div>
                                <button onclick="validarCodigo()" class="relative bg-gradient-to-r from-purple-600 to-blue-500 hover:from-purple-700 hover:to-blue-600 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105"
                                    id="btn-validar">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    Validar Código
                                </button>
                            </div>

                                
                            </div>

                            
                            <script>
                                function validarCodigo() {
                                    const tipoUso = document.getElementById('tipo_uso').value;
                                    const boton = document.getElementById('btn-validar');

                                    fetch('{{ route("user.concursos.pagos-terceros.validar") }}', {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                            'Content-Type': 'application/json'
                                        },
                                        body: JSON.stringify({
                                            codigo: '{{ $pago->codigo_validacion_unico }}',
                                            concurso_id: {{ $pago->concurso_id }},
                                            tipo_uso: tipoUso
                                        })
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        const resultadoDiv = document.getElementById('resultadoValidacion') || createResultContainer();
                                        if (data.valid) {
                                            resultadoDiv.innerHTML = `<div class="p-3 mb-2 bg-green-600 text-white rounded-lg">\${data.message}</div>`;

                                            // Actualizar contador individual
                                            if (tipoUso === 'pre_registro') {
                                                document.querySelector('option[value="pre_registro"]').textContent =
                                                    `Pre-registro (Usos restantes: ${data.usos_pre})`;
                                            } else {
                                                document.querySelector('option[value="inscripcion"]').textContent =
                                                    `Inscripción (Usos restantes: ${data.usos_ins})`;
                                            }

                                            // Desactivar si ya no hay usos para ambos
                                            if (data.usos_pre <= 0 && data.usos_ins <= 0) {
                                                boton.disabled = true;
                                                boton.classList.add('opacity-50', 'cursor-not-allowed');
                                            }
                                        } else {
                                            resultadoDiv.innerHTML = `<div class="p-3 mb-2 bg-red-600 text-white rounded-lg">\${data.error}</div>`;
                                        }
                                    });
                                }

                                function createResultContainer() {
                                    const div = document.createElement('div');
                                    div.id = 'resultadoValidacion';
                                    document.querySelector('.p-4.border').appendChild(div);
                                    return div;
                                }

                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection