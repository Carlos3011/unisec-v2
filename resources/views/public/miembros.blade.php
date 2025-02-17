@extends('layouts.public')

@section('titulo', 'Miembros')

@section('contenido')
<!-- HERO -->
<section class="relative bg-gradient-to-br from-cosmic-300 via-space-700 to-cosmic-900 py-24 overflow-hidden" data-aos="fade-down">
  <div class="absolute inset-0">
    <img src="{{ asset('images/planetas-sistema-solar.webp') }}" alt="Fondo espacial" class="w-full h-full object-cover opacity-20 animate-parallax">
  </div>
  <div class="relative container mx-auto px-6 text-center">
    <div class="max-w-4xl mx-auto">
      <div class="relative inline-block mb-8">
        <div class="absolute inset-0 bg-primary/20 blur-3xl rounded-full animate-pulse-slow"></div>
        <h1 class="text-5xl md:text-7xl font-extrabold bg-gradient-to-r from-cyan-400 via-primary to-purple-400 bg-clip-text text-transparent leading-tight drop-shadow-xl">
          <span class="inline-block bg-galaxy-pattern bg-cover bg-clip-text text-transparent">Miembros</span>
        </h1>
      </div>
      <p class="text-xl text-gray-200/90 max-w-2xl mx-auto mb-8 font-light leading-relaxed tracking-wide">
        Conoce al equipo pionero que está redefiniendo los límites de la exploración espacial mediante innovación y colaboración interdisciplinaria.
      </p>
    </div>
  </div>
</section>


<!-- ESTILOS PERSONALIZADOS -->
<style>
  .animate-parallax {
    animation: parallax 20s linear infinite;
  }
  
  @keyframes parallax {
    0% { transform: scale(1) translateY(0); }
    50% { transform: scale(1.03) translateY(-15px); }
    100% { transform: scale(1) translateY(0); }
  }

  .animate-pulse-slow {
    animation: pulse 6s cubic-bezier(0.4, 0, 0.6, 1) infinite;
  }

  @keyframes pulse {
    0%, 100% { opacity: 0.4; }
    50% { opacity: 0.2; }
  }

  .bg-galaxy-pattern {
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
  }
</style>
@endsection
