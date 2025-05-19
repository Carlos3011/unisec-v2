@extends('layouts.user')

@section('titulo', 'Validar Código de Pago')

@section('contenido')
<div class="min-h-screen py-12 relative overflow-hidden bg-gradient-to-b from-space-950 to-cosmic-900">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto bg-black/30 backdrop-blur-xl rounded-2xl overflow-hidden border border-white/10 relative transition-all duration-300 hover:border-white/20 hover:shadow-[0_0_30px_rgba(147,51,234,0.3)]">
            <div class="p-6">
                <a href="{{ route('user.concursos.convocatorias.show', $convocatoria) }}" class="text-white/90 hover:text-white flex items-center gap-2 bg-white/5 px-4 py-2 rounded-lg w-fit transition-all duration-300 hover:bg-white/10">
                    <i class="fas fa-arrow-left"></i>
                    <span>Volver a la Convocatoria</span>
                </a>
            </div>

            <div class="p-8">
                <h1 class="text-3xl font-bold text-white mb-6 text-center">Validar Código de Pago</h1>
                
                <form id="validarForm" class="space-y-6">
                    @csrf
                    <input type="hidden" name="concurso_id" value="{{ $concurso->id }}">

                    <div class="space-y-4">
                        <div>
                            <label for="codigo" class="block text-sm font-medium text-white/90">Código de Validación</label>
                            <input type="text" id="codigo" name="codigo" required 
                                   class="mt-1 block w-full rounded-lg bg-white/5 border border-white/10 text-white placeholder-white/50 focus:border-purple-500 focus:ring-purple-500"
                                   placeholder="Ingresa el código proporcionado">
                        </div>

                        <div>
                            <label for="tipo_uso" class="block text-sm font-medium text-white/90">Tipo de Uso</label>
                            <select id="tipo_uso" name="tipo_uso" required 
                                    class="mt-1 block w-full rounded-lg bg-white/5 border border-white/10 text-white focus:border-purple-500 focus:ring-purple-500">
                                <option value="pre_registro">Pre-registro</option>
                                <option value="inscripcion">Inscripción</option>
                            </select>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" 
                                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all duration-300 transform hover:scale-105">
                            Validar Código
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
    const form = document.getElementById('validarForm');

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = new FormData(form);
        const data = Object.fromEntries(formData);
        
        try {
            const response = await fetch('{{ route("user.concursos.pagos-terceros.validar-codigo") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (response.ok) {
                Swal.fire({
                    title: '¡Código Válido!',
                    text: 'El código ha sido validado correctamente.',
                    icon: 'success',
                    confirmButtonText: 'Continuar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (data.tipo_uso === 'pre_registro') {
                            window.location.href = '{{ route("user.concursos.pre-registros.create", "") }}/' + data.concurso_id;
                        } else {
                            window.location.href = '{{ route("user.concursos.inscripciones.create", "") }}/' + data.concurso_id;
                        }
                    }
                });
            } else {
                throw new Error(result.error || 'Error al validar el código');
            }
        } catch (error) {
            Swal.fire({
                title: 'Error',
                text: error.message,
                icon: 'error',
                confirmButtonText: 'Cerrar'
            });
        }
    });
});
</script>
@endpush

@endsection