@extends('layouts.public')

@section('titulo', 'Blog')

@section('contenido')
<!-- HERO -->
<section class="relative bg-gradient-to-br from-cosmic-300 via-space-700 to-cosmic-900 py-24 overflow-hidden" data-aos="fade-down" data-aos-duration="1000">
    <!-- Imagen de fondo semitransparente -->
    <div class="absolute inset-0">
        <img src="{{ asset('images/sistema-solar.webp') }}" alt="Blog Hero" class="w-full h-full object-cover opacity-30">
    </div>
    <div class="relative container mx-auto px-6 text-center">
        <h1 class="text-6xl font-bold text-white mb-4 drop-shadow-lg">Blog de UniSec</h1>
        <p class="text-xl text-white max-w-2xl mx-auto">
            Últimas noticias y artículos de interés sobre exploración espacial, tecnología y avances en la industria aeroespacial.
        </p>
    </div>
</section>

<!-- SECCIÓN DE ARTÍCULOS -->
<section class="py-24 ">
    <div class="container mx-auto px-6 lg:px-8">
        <div class="grid gap-12 md:grid-cols-2 lg:grid-cols-3">
            <!-- Artículo 1 -->
            <article class="bg-gray-800 rounded-2xl overflow-hidden shadow-lg transform transition duration-300 hover:scale-105">
                <img src="{{ asset('images/exoplanetas.jpg') }}" alt="Artículo 1" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-white mb-2">Descubriendo Nuevos Horizontes en la Astronomía</h2>
                    <p class="text-gray-300 mb-4">
                        Explora cómo los avances tecnológicos están transformando nuestra comprensión del universo y abriendo nuevas posibilidades en la astronomía.
                    </p>
                    <a href="#" class="text-primary font-semibold hover:underline">Leer más</a>
                </div>
            </article>
            <!-- Artículo 2 -->
            <article class="bg-gray-800 rounded-2xl overflow-hidden shadow-lg transform transition duration-300 hover:scale-105">
                <img src="{{ asset('images/exoplanetas.jpg') }}" alt="Artículo 2" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-white mb-2">Innovación en Robótica Espacial</h2>
                    <p class="text-gray-300 mb-4">
                        Descubre cómo la robótica está revolucionando la exploración espacial y abriendo el camino a nuevas misiones interplanetarias.
                    </p>
                    <a href="#" class="text-primary font-semibold hover:underline">Leer más</a>
                </div>
            </article>
            <!-- Artículo 3 -->
            <article class="bg-gray-800 rounded-2xl overflow-hidden shadow-lg transform transition duration-300 hover:scale-105">
                <img src="{{ asset('images/exoplanetas.jpg') }}" alt="Artículo 3" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-white mb-2">El Futuro de la Comunicación Satelital</h2>
                    <p class="text-gray-300 mb-4">
                        Conoce las últimas tendencias y tecnologías que están redefiniendo el mundo de las comunicaciones satelitales.
                    </p>
                    <a href="#" class="text-primary font-semibold hover:underline">Leer más</a>
                </div>
            </article>
            <!-- Artículo 4 -->
            <article class="bg-gray-800 rounded-2xl overflow-hidden shadow-lg transform transition duration-300 hover:scale-105">
                <img src="{{ asset('images/exoplanetas.jpg') }}" alt="Artículo 4" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-white mb-2">Avances en Exploración Planetaria</h2>
                    <p class="text-gray-300 mb-4">
                        Descubre los descubrimientos recientes que están cambiando la forma en que entendemos los planetas de nuestro sistema solar y más allá.
                    </p>
                    <a href="#" class="text-primary font-semibold hover:underline">Leer más</a>
                </div>
            </article>
            <!-- Artículo 5 -->
            <article class="bg-gray-800 rounded-2xl overflow-hidden shadow-lg transform transition duration-300 hover:scale-105">
                <img src="{{ asset('images/exoplanetas.jpg') }}" alt="Artículo 5" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-white mb-2">Innovación y Sostenibilidad en el Espacio</h2>
                    <p class="text-gray-300 mb-4">
                        Analizamos cómo las nuevas tecnologías están ayudando a crear soluciones sostenibles en la exploración espacial.
                    </p>
                    <a href="#" class="text-primary font-semibold hover:underline">Leer más</a>
                </div>
            </article>
            <!-- Artículo 6 -->
            <article class="bg-gray-800 rounded-2xl overflow-hidden shadow-lg transform transition duration-300 hover:scale-105">
                <img src="{{ asset('images/exoplanetas.jpg') }}" alt="Artículo 6" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-white mb-2">El Rol de la Inteligencia Artificial en el Espacio</h2>
                    <p class="text-gray-300 mb-4">
                        Explora cómo la inteligencia artificial está revolucionando la forma en que exploramos y comprendemos el cosmos.
                    </p>
                    <a href="#" class="text-primary font-semibold hover:underline">Leer más</a>
                </div>
            </article>
        </div>

        <!-- PAGINACIÓN (OPCIONAL) -->
        <div class="mt-16 flex justify-center">
            <nav class="inline-flex">
                <a href="#" class="px-4 py-2 mx-1 bg-gray-700 text-white rounded hover:bg-gray-600 transition-colors">Anterior</a>
                <a href="#" class="px-4 py-2 mx-1 bg-primary text-white rounded hover:bg-primary/80 transition-colors">1</a>
                <a href="#" class="px-4 py-2 mx-1 bg-gray-700 text-white rounded hover:bg-gray-600 transition-colors">2</a>
                <a href="#" class="px-4 py-2 mx-1 bg-gray-700 text-white rounded hover:bg-gray-600 transition-colors">3</a>
                <a href="#" class="px-4 py-2 mx-1 bg-gray-700 text-white rounded hover:bg-gray-600 transition-colors">Siguiente</a>
            </nav>
        </div>
    </div>
</section>
@endsection
