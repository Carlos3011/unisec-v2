@extends('layouts.public')

@section('titulo', 'Contacto')

@section('contenido')
<!-- HERO -->
<section class="relative bg-gradient-to-br from-cosmic-300 via-space-700 to-cosmic-900 py-24 text-center" data-aos="fade-down">
    <div class="container mx-auto px-6">
        <h1 class="text-5xl font-extrabold text-white drop-shadow-lg">Contáctanos</h1>
        <p class="text-lg text-gray-200 mt-4 max-w-2xl mx-auto">Estamos aquí para responder a cualquier pregunta que tengas</p>
        <p class="text-lg text-gray-200 mt-2 max-w-2xl mx-auto">¡Envíanos un mensaje y te responderemos lo antes posible!</p>
    </div>
</section>

<!-- FORMULARIO DE CONTACTO -->
<section class="py-16 bg-space-950">
    <div class="container mx-auto px-6 lg:px-12">
        <div class="max-w-3xl mx-auto bg-space-800/50 backdrop-blur-lg p-8 rounded-2xl shadow-xl border border-space-500/20" data-aos="fade-up">
            <form>
                <div class="mb-6">
                    <label class="block text-gray-300 font-semibold mb-2">Nombre</label>
                    <input type="text" class="w-full px-4 py-3 bg-space-700/50 border border-space-500/20 rounded-lg text-white focus:ring-2 focus:ring-primary focus:outline-none" placeholder="Tu nombre" required>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-300 font-semibold mb-2">Correo Electrónico</label>
                    <input type="email" class="w-full px-4 py-3 bg-space-700/50 border border-space-500/20 rounded-lg text-white focus:ring-2 focus:ring-primary focus:outline-none" placeholder="tucorreo@example.com" required>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-300 font-semibold mb-2">Mensaje</label>
                    <textarea class="w-full px-4 py-3 bg-space-700/50 border border-space-500/20 rounded-lg text-white focus:ring-2 focus:ring-primary focus:outline-none" rows="5" placeholder="Escribe tu mensaje aquí..." required></textarea>
                </div>
                <button type="submit" class="w-full py-3 text-lg font-semibold bg-primary text-white rounded-lg hover:bg-primary/90 transition-all duration-300">
                    Enviar Mensaje
                </button>
            </form>
        </div>
    </div>
</section>

<style>
    .bg-space-950 { background-color: #0a0f1a; }
    .bg-space-800\/50 { background-color: rgba(20, 24, 38, 0.5); }
    .bg-space-700\/50 { background-color: rgba(30, 35, 50, 0.5); }
</style>
@endsection
