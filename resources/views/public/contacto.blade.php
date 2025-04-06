@extends('layouts.public')

@section('titulo', 'Contacto')

@section('contenido')
<!-- HERO -->
<section class="relative min-h-[25vh] flex items-center justify-center bg-gradient-to-b from-cosmic-900 via-space-800 to-space-950 overflow-hidden" data-aos="fade">
    <div class="container mx-auto px-6 relative z-10 text-center">
        <h1 class="text-6xl font-extrabold bg-gradient-to-r from-primary via-secondary to-accent bg-clip-text text-transparent drop-shadow-lg mb-4">Contáctanos</h1>
        <p class="text-xl text-gray-200/90 max-w-2xl mx-auto leading-relaxed">Estamos aquí para responder a cualquier pregunta que tengas</p>
        <p class="text-xl text-gray-200/90 max-w-2xl mx-auto leading-relaxed">¡Envíanos un mensaje y te responderemos lo antes posible!</p>
    </div>
</section>

<!-- FORMULARIO DE CONTACTO -->
<section class="py-16 bg-space-950 relative overflow-hidden">
   
    
    <div class="container mx-auto px-6 relative z-10">
        <div class="max-w-2xl mx-auto backdrop-blur-2xl bg-space-800/30 rounded-3xl shadow-2xl border border-space-500/10 overflow-hidden transform hover:scale-[1.02] transition-all duration-500" data-aos="fade-up">
            <form class="p-8 space-y-6">
                <div class="space-y-2">
                    <label class="block text-gray-300 font-medium text-sm">Nombre</label>
                    <input type="text" 
                           class="w-full px-4 py-3 bg-space-700/30 border border-space-500/20 rounded-xl text-white placeholder-gray-400 focus:ring-2 focus:ring-primary/50 focus:border-primary/50 focus:outline-none transition-all duration-300" 
                           placeholder="Tu nombre completo"
                           required>
                </div>
                
                <div class="space-y-2">
                    <label class="block text-gray-300 font-medium text-sm">Correo Electrónico</label>
                    <input type="email" 
                           class="w-full px-4 py-3 bg-space-700/30 border border-space-500/20 rounded-xl text-white placeholder-gray-400 focus:ring-2 focus:ring-primary/50 focus:border-primary/50 focus:outline-none transition-all duration-300" 
                           placeholder="tucorreo@ejemplo.com"
                           required>
                </div>
                
                <div class="space-y-2">
                    <label class="block text-gray-300 font-medium text-sm">Mensaje</label>
                    <textarea class="w-full px-4 py-3 bg-space-700/30 border border-space-500/20 rounded-xl text-white placeholder-gray-400 focus:ring-2 focus:ring-primary/50 focus:border-primary/50 focus:outline-none transition-all duration-300" 
                              rows="4" 
                              placeholder="¿En qué podemos ayudarte?"
                              required></textarea>
                </div>
                
                <button type="submit" 
                        class="w-full py-4 bg-gradient-to-r from-primary via-secondary to-accent text-white rounded-xl font-semibold hover:opacity-90 transform hover:scale-[1.02] transition-all duration-300 shadow-lg shadow-primary/20">
                    Enviar Mensaje
                </button>
            </form>
        </div>
    </div>
</section>

@endsection
