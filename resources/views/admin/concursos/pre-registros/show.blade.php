@extends('layouts.admin')

@section('contenido')
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="bg-gray-800 rounded-2xl shadow-xl border border-gray-700 p-8 mb-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="flex items-center space-x-4">
                    <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-3 rounded-xl">
                        <i class="fas fa-clipboard-list text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-white">Detalles del Pre-registro</h1>
                        <p class="text-gray-300 mt-1">Información completa del equipo registrado</p>
                    </div>
                </div>
                <div class="flex flex-wrap gap-3">
                    <!-- <a href="{{ route('admin.concursos.pre-registros.edit', $preRegistro) }}" 
                       class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5">
                        <i class="fas fa-edit mr-2"></i>
                        <span>Editar</span>
                    </a> -->
                    <a href="{{ route('admin.concursos.pre-registros.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-700 hover:bg-gray-600 text-gray-200 font-medium rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>
                        <span>Volver</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="space-y-8">
            <!-- Información del Equipo e Integrantes -->
            <div class="bg-gray-800 rounded-2xl shadow-lg border border-gray-700 p-8 hover:shadow-xl transition-shadow duration-300">
                <!-- Información General del Equipo -->
                <div class="flex items-center mb-6">
                    <div class="bg-gradient-to-r from-emerald-500 to-teal-600 p-3 rounded-xl mr-4">
                        <i class="fas fa-users text-white text-lg"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-white">Información del Equipo</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
                    <div class="bg-gray-700 rounded-xl p-4 border border-blue-500">
                        <label class="text-blue-400 text-sm font-semibold uppercase tracking-wide">Nombre del Equipo</label>
                        <p class="text-white text-lg font-medium mt-1">{{ $preRegistro->nombre_equipo }}</p>
                    </div>
                    <div class="bg-gray-700 rounded-xl p-4 border border-purple-500">
                        <label class="text-purple-400 text-sm font-semibold uppercase tracking-wide">Número de Integrantes</label>
                        <div class="flex items-center mt-1">
                            <span class="text-white text-lg font-medium">{{ $preRegistro->integrantes }}</span>
                            <span class="ml-2 bg-purple-600 text-purple-200 text-xs font-medium px-2.5 py-0.5 rounded-full">miembros</span>
                        </div>
                    </div>
                    <div class="bg-gray-700 rounded-xl p-4 border border-amber-500">
                        <label class="text-amber-400 text-sm font-semibold uppercase tracking-wide">Asesor</label>
                        <p class="text-white text-lg font-medium mt-1">{{ $preRegistro->asesor ?: 'No especificado' }}</p>
                    </div>
                    <div class="bg-gray-700 rounded-xl p-4 border border-green-500">
                        <label class="text-green-400 text-sm font-semibold uppercase tracking-wide">Institución</label>
                        <p class="text-white text-lg font-medium mt-1">{{ $preRegistro->institucion ?: 'No especificada' }}</p>
                    </div>
                </div>

                <!-- Separador -->
                <div class="border-t border-gray-600 my-8"></div>

                <!-- Integrantes del Equipo -->
                <div class="flex items-center mb-6">
                    <div class="bg-gradient-to-r from-violet-500 to-purple-600 p-3 rounded-xl mr-4">
                        <i class="fas fa-user-friends text-white text-lg"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white">Detalle de Integrantes</h3>
                </div>
                @if($preRegistro->integrantes_data)
                    @php
                        // Si ya es un array, lo usamos directamente; si es string, lo decodificamos
                        $integrantes = is_array($preRegistro->integrantes_data) 
                            ? $preRegistro->integrantes_data 
                            : json_decode($preRegistro->integrantes_data, true);
                    @endphp
                    @if($integrantes && is_array($integrantes))
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            @foreach($integrantes as $index => $integrante)
                                <div class="bg-gray-600 rounded-2xl p-6 border border-gray-500 hover:shadow-md transition-all duration-200">
                                    <div class="flex items-center mb-4">
                                        <div class="bg-gradient-to-r from-indigo-500 to-blue-600 text-white w-10 h-10 rounded-full flex items-center justify-center font-bold text-lg mr-3">
                                            {{ $index + 1 }}
                                        </div>
                                        <h4 class="text-lg font-bold text-white">Integrante {{ $index + 1 }}</h4>
                                    </div>
                                    <div class="grid grid-cols-1 gap-4">
                                        <div class="bg-gray-700 rounded-xl p-4 border border-blue-400">
                                            <label class="text-blue-300 text-xs font-bold uppercase tracking-wider">Nombre Completo</label>
                                            <p class="text-white text-sm font-medium mt-1">{{ $integrante['nombre_completo'] ?? 'No especificado' }}</p>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div class="bg-gray-700 rounded-xl p-4 border border-purple-400">
                                                <label class="text-purple-300 text-xs font-bold uppercase tracking-wider">Matrícula</label>
                                                <p class="text-white text-sm font-medium mt-1">{{ $integrante['matricula'] ?? 'No especificada' }}</p>
                                            </div>
                                            <div class="bg-gray-700 rounded-xl p-4 border border-green-400">
                                                <label class="text-green-300 text-xs font-bold uppercase tracking-wider">Carrera</label>
                                                <p class="text-white text-sm font-medium mt-1">{{ $integrante['carrera'] ?? 'No especificada' }}</p>
                                            </div>
                                        </div>
                                        <div class="bg-gray-700 rounded-xl p-4 border border-orange-400">
                                            <label class="text-orange-300 text-xs font-bold uppercase tracking-wider">Correo Institucional</label>
                                            <p class="text-white text-sm font-medium mt-1 break-all">{{ $integrante['correo_institucional'] ?? 'No especificado' }}</p>
                                        </div>
                                        <div class="bg-gray-700 rounded-xl p-4 border border-pink-400">
                                            <label class="text-pink-300 text-xs font-bold uppercase tracking-wider">Período Académico</label>
                                            <div class="flex items-center mt-1">
                                                <p class="text-white text-sm font-medium">{{ $integrante['periodo_academico'] ?? 'No especificado' }}</p>
                                                @if($integrante['tipo_periodo'] ?? '')
                                                    <span class="ml-2 bg-pink-600 text-pink-200 text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $integrante['tipo_periodo'] }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="bg-gray-700 rounded-full p-4 w-16 h-16 mx-auto mb-4">
                                <i class="fas fa-exclamation-triangle text-yellow-400 text-2xl"></i>
                            </div>
                            <p class="text-gray-400 text-lg font-medium">No se pudo procesar la información de los integrantes</p>
                        </div>
                    @endif
                @else
                    <div class="text-center py-12">
                        <div class="bg-gray-700 rounded-full p-4 w-16 h-16 mx-auto mb-4">
                            <i class="fas fa-users-slash text-gray-500 text-2xl"></i>
                        </div>
                        <p class="text-gray-400 text-lg font-medium">No hay información de integrantes disponible</p>
                    </div>
                @endif
            </div>

            <!-- Grid para Información del Concurso y Usuario -->
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                <!-- Información del Concurso y Estado -->
                <div class="xl:col-span-2 bg-gray-800 rounded-2xl shadow-lg border border-gray-700 p-8 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center mb-6">
                        <div class="bg-gradient-to-r from-emerald-500 to-teal-600 p-3 rounded-xl mr-4">
                            <i class="fas fa-trophy text-white text-lg"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-white">Información del Concurso y Estado</h2>
                    </div>
                    
                    <!-- Información Básica del Concurso -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="bg-gray-700 rounded-xl p-6 border border-blue-500">
                            <div class="flex items-center mb-3">
                                <div class="bg-blue-500 p-2 rounded-lg mr-3">
                                    <i class="fas fa-medal text-white"></i>
                                </div>
                                <label class="text-blue-700 text-sm font-bold uppercase tracking-wider">Concurso</label>
                            </div>
                            <p class="text-white text-lg font-semibold">{{ $preRegistro->concurso->titulo }}</p>
                        </div>
                        <div class="bg-gray-700 rounded-xl p-6 border border-green-500">
                            <div class="flex items-center mb-3">
                                <div class="bg-green-500 p-2 rounded-lg mr-3">
                                    <i class="fas fa-check-circle text-white"></i>
                                </div>
                                <label class="text-green-700 text-sm font-bold uppercase tracking-wider">Estado del Pre-registro</label>
                            </div>
                            <div class="flex items-center">
                                <span class="px-4 py-2 rounded-full text-sm font-medium inline-block
                                    @switch($preRegistro->estado_pdr)
                                        @case('aprobado')
                                            bg-green-100 text-green-800
                                            @break
                                        @case('pendiente')
                                            bg-yellow-100 text-yellow-800
                                            @break
                                        @case('rechazado')
                                            bg-red-100 text-red-800
                                            @break
                                    @endswitch">
                                    @switch($preRegistro->estado_pdr)
                                        @case('aprobado')
                                            <i class="fas fa-check mr-1"></i>Aprobado
                                            @break
                                        @case('pendiente')
                                            <i class="fas fa-clock mr-1"></i>Pendiente
                                            @break
                                        @case('rechazado')
                                            <i class="fas fa-times mr-1"></i>Rechazado
                                            @break
                                    @endswitch
                                </span>
                            </div>
                        </div>
                        <div class="bg-gray-700 rounded-xl p-6 border border-purple-500 lg:col-span-2">
                            <div class="flex items-center mb-3">
                                <div class="bg-purple-500 p-2 rounded-lg mr-3">
                                    <i class="fas fa-calendar-plus text-white"></i>
                                </div>
                                <label class="text-purple-700 text-sm font-bold uppercase tracking-wider">Fecha de Pre-registro</label>
                            </div>
                            <p class="text-white text-lg font-semibold">{{ $preRegistro->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Información del Usuario -->
                <div class="bg-gray-800 rounded-2xl shadow-lg border border-gray-700 p-8 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center mb-6">
                        <div class="bg-gradient-to-r from-cyan-500 to-blue-600 p-3 rounded-xl mr-4">
                            <i class="fas fa-user text-white text-lg"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-white">Información del Usuario</h2>
                    </div>
                    <div class="space-y-6">
                        <div class="bg-gray-700 rounded-xl p-6 border border-cyan-500">
                            <div class="flex items-center mb-3">
                                <div class="bg-cyan-500 p-2 rounded-lg mr-3">
                                    <i class="fas fa-id-card text-white"></i>
                                </div>
                                <label class="text-cyan-700 text-sm font-bold uppercase tracking-wider">Nombre</label>
                            </div>
                            <p class="text-white text-lg font-semibold">{{ $preRegistro->usuario->name }}</p>
                        </div>
                        <div class="bg-gray-700 rounded-xl p-6 border border-indigo-500">
                            <div class="flex items-center mb-3">
                                <div class="bg-indigo-500 p-2 rounded-lg mr-3">
                                    <i class="fas fa-envelope text-white"></i>
                                </div>
                                <label class="text-indigo-700 text-sm font-bold uppercase tracking-wider">Email</label>
                            </div>
                            <p class="text-white text-lg font-semibold break-all">{{ $preRegistro->usuario->email }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Evaluación PDR y Comentarios -->
            <div class="bg-gray-800 rounded-2xl shadow-lg border border-gray-700 p-6 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center mb-6">
                    <div class="bg-gradient-to-r from-rose-500 to-pink-600 p-3 rounded-xl mr-4">
                        <i class="fas fa-clipboard-check text-white text-lg"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-white">Evaluación PDR y Comentarios</h2>
                </div>
                
                <!-- Estado PDR -->
                <div class="mb-8">
                    
                    <div class="bg-gray-700 rounded-xl p-6 border border-rose-500">
                        <!-- Estado Actual -->
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
                            <div class="flex items-center">
                                <div class="bg-rose-500 p-2 rounded-lg mr-3">
                                    <i class="fas fa-info-circle text-white"></i>
                                </div>
                                <label class="text-rose-300 text-sm font-bold uppercase tracking-wider">Estado Actual</label>
                            </div>
                            <span class="px-4 py-2 rounded-full text-sm font-medium inline-block w-fit
                                @switch($preRegistro->estado_pdr)
                                    @case('aprobado')
                                        bg-green-100 text-green-800
                                        @break
                                    @case('pendiente')
                                        bg-yellow-100 text-yellow-800
                                        @break
                                    @case('rechazado')
                                        bg-red-100 text-red-800
                                        @break
                                @endswitch">
                                @switch($preRegistro->estado_pdr)
                                    @case('aprobado')
                                        <i class="fas fa-check mr-1"></i>Aprobado
                                        @break
                                    @case('pendiente')
                                        <i class="fas fa-clock mr-1"></i>Pendiente
                                        @break
                                    @case('rechazado')
                                        <i class="fas fa-times mr-1"></i>Rechazado
                                        @break
                                @endswitch
                            </span>
                        </div>
                        
                        <!-- Botones de Acción -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 mb-6">
                            @if($preRegistro->estado_pdr !== 'aprobado')
                                <button type="button" onclick="aprobarPDR()" 
                                        class="inline-flex items-center justify-center px-4 py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5">
                                    <i class="fas fa-check mr-2"></i>
                                    Aprobar PDR
                                </button>
                            @endif
                            @if($preRegistro->estado_pdr !== 'rechazado')
                                <button type="button" onclick="rechazarPDR()" 
                                        class="inline-flex items-center justify-center px-4 py-3 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5">
                                    <i class="fas fa-times mr-2"></i>
                                    Rechazar PDR
                                </button>
                            @endif
                            @if($preRegistro->estado_pdr !== 'pendiente')
                                <button type="button" onclick="cambiarAPendiente()" 
                                        class="inline-flex items-center justify-center px-4 py-3 bg-gradient-to-r from-yellow-500 to-amber-600 hover:from-yellow-600 hover:to-amber-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5">
                                    <i class="fas fa-clock mr-2"></i>
                                    Cambiar a Pendiente
                                </button>
                            @endif
                        </div>
                        
                        <!-- Descarga de Archivo PDR -->
                        <div class="border-t border-gray-600 pt-4">
                            @if($preRegistro->archivo_pdr)
                                <div class="bg-gray-600 rounded-lg p-4 border border-rose-400">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <i class="fas fa-file-pdf text-red-400 text-xl mr-3"></i>
                                            <div>
                                                <p class="text-white font-medium">Archivo PDR disponible</p>
                                                <p class="text-gray-400 text-sm">Documento de proyecto de investigación</p>
                                            </div>
                                        </div>
                                        <a href="{{ route('admin.concursos.pre-registros.download-pdr', $preRegistro) }}" 
                                           class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5">
                                            <i class="fas fa-download mr-2"></i>
                                            Descargar
                                        </a>
                                    </div>
                                </div>
                            @else
                                <div class="bg-gray-600 rounded-lg p-4 border border-gray-500">
                                    <div class="flex items-center">
                                        <i class="fas fa-file-times text-gray-400 text-xl mr-3"></i>
                                        <div>
                                            <p class="text-gray-300 font-medium">No hay archivo PDR disponible</p>
                                            <p class="text-gray-400 text-sm">El equipo aún no ha subido su documento</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Comentarios de Evaluación -->
                <div>
                    <div class="flex items-center mb-4">
                        <div class="bg-gradient-to-r from-amber-500 to-orange-600 p-2 rounded-lg mr-3">
                            <i class="fas fa-comments text-white"></i>
                        </div>
                        <h3 class="text-xl font-bold text-white">Comentarios de Evaluación</h3>
                    </div>
                    <div class="bg-gray-700 rounded-xl p-6 border border-amber-500">
                        <form id="evaluacionForm" class="space-y-4">
                            <div>
                                <div class="flex items-center mb-4">
                                    <div class="bg-amber-500 p-2 rounded-lg mr-3">
                                        <i class="fas fa-comment-dots text-white"></i>
                                    </div>
                                    <label for="comentarios_pdr" class="text-amber-300 text-sm font-bold uppercase tracking-wider">Comentarios del Evaluador</label>
                                </div>
                                <div class="bg-gray-600 rounded-lg border border-amber-400">
                                    <textarea id="comentarios_pdr" name="comentarios_pdr" rows="6"
                                              class="w-full bg-transparent text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent resize-none"
                                              placeholder="Ingrese sus comentarios sobre la evaluación del PDR...">{{ $preRegistro->comentarios_pdr }}</textarea>
                                </div>
                            </div>
                            <div class="flex justify-end">
                                <button type="button" onclick="guardarEvaluacion()" 
                                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white font-bold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5">
                                    <i class="fas fa-save mr-2"></i>
                                    Guardar Comentarios
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


        </div>


    </div>
</div>

<script>
function actualizarEstadoPDR(id, estado_pdr, comentarios = null) {
    let mensaje = '';
    let icon = '';
    let confirmButtonColor = '';
    
    switch(estado_pdr) {
        case 'aprobado':
            mensaje = 'aprobar';
            icon = 'question';
            confirmButtonColor = '#10b981';
            break;
        case 'rechazado':
            mensaje = 'rechazar';
            icon = 'warning';
            confirmButtonColor = '#ef4444';
            break;
        case 'pendiente':
            mensaje = 'cambiar a pendiente';
            icon = 'info';
            confirmButtonColor = '#f59e0b';
            break;
    }
    
    Swal.fire({
        title: `¿${mensaje.charAt(0).toUpperCase() + mensaje.slice(1)} PDR?`,
        text: `¿Estás seguro de ${mensaje} este PDR?`,
        icon: icon,
        showCancelButton: true,
        confirmButtonColor: confirmButtonColor,
        cancelButtonColor: '#6b7280',
        confirmButtonText: `Sí, ${mensaje}`,
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const requestBody = { estado_pdr: estado_pdr };
            if (comentarios) {
                requestBody.comentarios_pdr = comentarios;
            }
            
            fetch(`/admin/pre-registros/${id}/estado`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(requestBody)
            })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: data.message,
                        confirmButtonColor: '#10b981'
                    }).then(() => {
                        window.location.reload();
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al actualizar el estado PDR',
                    confirmButtonColor: '#ef4444'
                });
            });
        }
    });
}

function aprobarPDR() {
    const comentarios = document.getElementById('comentarios_pdr').value;
    actualizarEstadoPDR('{{ $preRegistro->id }}', 'aprobado', comentarios);
}

function rechazarPDR() {
    const comentarios = document.getElementById('comentarios_pdr').value;
    if (!comentarios.trim()) {
        alert('Por favor, agregue comentarios explicando el motivo del rechazo.');
        return;
    }
    actualizarEstadoPDR('{{ $preRegistro->id }}', 'rechazado', comentarios);
}

function cambiarAPendiente() {
    const comentarios = document.getElementById('comentarios_pdr').value;
    actualizarEstadoPDR('{{ $preRegistro->id }}', 'pendiente', comentarios);
}

function guardarEvaluacion() {
    const comentarios = document.getElementById('comentarios_pdr').value;
    
    fetch(`/admin/pre-registros/{{ $preRegistro->id }}/estado`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ 
            estado_pdr: '{{ $preRegistro->estado_pdr }}',
            comentarios_pdr: comentarios 
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            Swal.fire({
                icon: 'success',
                title: '¡Guardado!',
                text: 'Comentarios guardados exitosamente',
                confirmButtonColor: '#10b981',
                timer: 2000,
                timerProgressBar: true
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error al guardar los comentarios',
            confirmButtonColor: '#ef4444'
        });
    });
}
</script>

@endsection