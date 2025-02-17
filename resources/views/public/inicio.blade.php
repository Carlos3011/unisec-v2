@extends('layouts.public')

@section('titulo', 'Inicio - UniSec Aerospace')

@section('contenido')

<!-- Sección Hero Mejorada -->
<section class="relative min-h-screen flex items-center  via-space-700 to-black py-12 px-6">
    <div class="relative max-w-7xl mx-auto text-center z-10" data-aos="zoom-in-up" data-aos-duration="1000">
        <div class="mb-12">
            <h1 class="text-4xl sm:text-6xl md:text-7xl font-bold bg-gradient-to-r from-secondary to-primary-100 bg-clip-text text-transparent mb-6">
                <span id="typed-text-hover-title" class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-cyan-600"></span>
            </h1>
            <h1 class="text-3xl sm:text-5xl md:text-6xl font-bold text-white mb-6 leading-tight">
                Revolucionando la 
                <span id="typed-text-hover" class="text-transparent bg-clip-text bg-gradient-to-r from-accent-500 to-secondary-700"></span>
                Mediante la Innovación
            </h1>
            <p class="text-lg sm:text-xl text-gray-300 max-w-3xl mx-auto mb-8">
                Consorcio internacional líder en ingeniería aeroespacial avanzada y desarrollo de tecnologías espaciales sostenibles.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4 sm:gap-6">
                <a href="#inscripcion" class="relative px-6 sm:px-8 py-3 sm:py-4 rounded-lg font-bold text-white bg-secondary hover:bg-cyan-400 transition-all duration-300 shadow-lg flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                    </svg>
                    Ver programas académicos
                </a>
                <a href="#innovaciones" class="relative border-2 border-primary px-6 sm:px-8 py-3 sm:py-4 rounded-lg font-bold text-white hover:bg-primary/10 transition-all duration-300 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                    </svg>
                    Video institucional
                </a>
            </div>
        </div>
        
        <!-- Contador de logros con animación -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 mt-16 sm:mt-24">
            @foreach([
                ["count" => 127, "label" => "Misiones exitosas"],
                ["count" => 89, "label" => "Patentes registradas"],
                ["count" => 235, "label" => "Colaboraciones globales"],
                ["count" => 15, "label" => "Premios internacionales"]
            ] as $stat)
                <div class="text-center">
                    <div class="text-3xl sm:text-4xl font-bold text-accent mb-1 sm:mb-2 counter" data-count="{{ $stat['count'] }}">0</div>
                    <div class="text-xs sm:text-sm text-primary font-bold uppercase tracking-wide">{{ $stat["label"] }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>


<!-- SEPARADOR ORGÁNICO -->
<div class="h-48 bg-space-700 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-primary/20 to-secondary/20 opacity-50"></div>
    <div class="absolute inset-0 animate-orbital-movement">
        <div class="w-48 h-48 bg-secondary/20 rounded-full blur-3xl"></div>
    </div>
</div>

<!-- Galería de Videos Mejorada y Responsiva -->
<section class="py-16 bg-gradient-to-br relative overflow-hidden" data-aos="fade-up">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
        <!-- Encabezado con animación -->
        <div class="text-center mb-12">
            <div class="inline-flex relative">
                <span class="absolute -inset-4 bg-galactic-500/50 blur-3xl rounded-full"></span>
                <h2 id="typed-text-gallery-title" class="text-4xl sm:text-5xl md:text-6xl bg-gradient-to-r from-cyan-500 to-secondary bg-clip-text text-transparent font-bold mb-6 relative">
                    Galería de Videos
                </h2>
            </div>
            <p class="text-base sm:text-lg text-tech-300 max-w-2xl mx-auto">
                Descubre nuestros contenidos destacados y sumérgete en el universo.
            </p>
        </div>

        <!-- Video Principal -->
        <div class="mb-8 relative group">
            <div class="aspect-video bg-gray-800 rounded-xl overflow-hidden shadow-xl transition-transform duration-300 hover:scale-[1.02]">
                <iframe 
                    id="main-video-player"
                    class="w-full h-full"
                    src="https://www.youtube.com/embed/hI9HQfCAw64?modestbranding=1&rel=0" 
                    frameborder="0"
                    allowfullscreen
                    loading="lazy"
                ></iframe>
            </div>
        </div>

        <!-- Carrusel de Videos -->
        <div class="flex overflow-x-auto pb-6 space-x-4 scrollbar-hide" id="video-carousel">
            @foreach([
                ['id' => 'hI9HQfCAw64', 'title' => 'Lanzamiento histórico'],
                ['id' => '1C_zuHf6lP4', 'title' => 'Primeras imágenes James Webb'],
                ['id' => '5KygwcZ545U', 'title' => 'Entrenamiento de astronautas'],
                ['id' => 'BN624m0QJIM', 'title' => 'Falcon Heavy lanzamiento'],
            ] as $video)
            <div 
                class="flex-shrink-0 w-52 sm:w-64 cursor-pointer video-carousel-item transition-all duration-300 border border-tech-500 rounded-lg overflow-hidden bg-tech-700 hover:scale-105"
                data-video-id="{{ $video['id'] }}"
            >
                <div class="aspect-video bg-gray-800 relative">
                    <img 
                        src="https://img.youtube.com/vi/{{ $video['id'] }}/hqdefault.jpg" 
                        alt="{{ $video['title'] }}"
                        class="w-full h-full object-cover opacity-90 hover:opacity-100 transition-opacity"
                    >
                    <div class="absolute inset-0 flex items-center justify-center">
                        <button class="text-white bg-black/50 rounded-full p-3 hover:bg-black/70 transition-all">
                            <i class="fas fa-play text-xl"></i>
                        </button>
                    </div>
                </div>
                <div class="p-3 bg-cosmic-500">
                    <h3 class="text-sm sm:text-md font-semibold text-primary line-clamp-2">
                        {{ $video['title'] }}
                    </h3>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Efecto Nebulosa -->
    <div class="absolute inset-0 bg-gradient-to-br from-galactic-700 to-cosmic-500 opacity-20 pointer-events-none"></div>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const carouselItems = document.querySelectorAll('.video-carousel-item');
    const mainVideo = document.getElementById('main-video-player');

    carouselItems.forEach(item => {
        item.addEventListener('click', function() {
            const videoId = this.dataset.videoId;
            mainVideo.src = `https://www.youtube.com/embed/${videoId}?autoplay=1&modestbranding=1&rel=0`;
        });
    });
});
</script>

<style>
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }

    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    .video-carousel-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 0 10px rgba(0, 180, 216, 0.5);
    }

    #video-carousel {
        scroll-behavior: smooth;
    }
</style>



<!-- SEPARADOR ORGÁNICO -->
<div class="h-48 bg-space-700 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-primary/20 to-secondary/20 opacity-50"></div>
    <div class="absolute inset-0 animate-orbital-movement">
        <div class="w-48 h-48 bg-secondary/20 rounded-full blur-3xl"></div>
    </div>
</div>

<!-- Galería de Imágenes -->
<section class="py-24 bg-space-700" data-aos="fade-up">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-20">
            <div class="inline-flex relative">
                <span class="absolute -inset-4 bg-galactic-500/30 blur-3xl rounded-full"></span>
                <h2 id="typed-text-gallery-title" class="text-5xl sm:text-6xl md:text-7xl bg-gradient-to-r from-secondary to-primary bg-clip-text text-transparent font-bold mb-6 relative">
                    Exploración Visual
                </h2>
            </div>
            <p class="text-white text-lg max-w-2xl mx-auto">
                Instantáneas de nuestros logros espaciales y avances tecnológicos
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
            @php
                $imagenes = [
                    ["nombre" => "Lanzamiento Histórico", "archivo" => "spacex-rocket.jpg", "descripcion" => "El despegue que cambió la historia."],
                    ["nombre" => "Telescopio James Webb", "archivo" => "nebulosa-morada.jpg", "descripcion" => "Explorando el universo con nuevas imágenes."],
                    ["nombre" => "Satélite en órbita", "archivo" => "satelite.jpg", "descripcion" => "Tecnología avanzada en el espacio."],
                    ["nombre" => "La Tierra desde el espacio", "archivo" => "earth.jpg", "descripcion" => "Vista única de nuestro planeta."],
                    ["nombre" => "Anillos de Saturno", "archivo" => "saturno.jpg", "descripcion" => "Impresionante visión del cosmos."],
                    ["nombre" => "El sol", "archivo" => "sol.jpg", "descripcion" => "Una maravilla del universo profundo."],
                ];
            @endphp

            @foreach($imagenes as $index => $img)
                @php
                    $rutaImagen = asset('images/space/' . $img["archivo"]);

                    // Definir clases responsivas para tamaños adaptables
                    $spanClass = match ($index % 6) {
                        0 => 'lg:col-span-2 lg:row-span-2',  // Imágenes grandes solo en pantallas grandes
                        2, 4 => 'md:col-span-2',  // Imágenes medianas horizontales en pantallas medianas
                        default => 'col-span-1',  // Tamaño normal en móviles
                    };
                @endphp

                <div 
                    class="group relative overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transition-all duration-500 ease-in-out 
                    {{ $spanClass }} hover:z-10"
                    data-aos="zoom-in-up"
                    data-aos-delay="{{ $loop->index * 150 }}"
                    data-aos-anchor-placement="top-center"
                >
                    <div class="relative h-full w-full">
                        
                        <!-- Imagen con efecto de zoom -->
                        <img 
                            src="{{ $rutaImagen }}" 
                            alt="{{ $img['nombre'] }}"
                            class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500 rounded-xl"
                        >
                        
                        <!-- Overlay con información -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <div class="absolute bottom-0 left-0 right-0 p-4 space-y-2 translate-y-6 group-hover:translate-y-0 transition-all duration-500 delay-100">
                                <h3 class="text-lg md:text-xl font-bold text-white">
                                    {{ $img['nombre'] }}
                                </h3>
                                <div class="bg-space-800/80 backdrop-blur-md p-3 rounded-lg">
                                    <p class="text-white text-sm md:text-base">
                                        {{ $img["descripcion"] }}
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>


<!-- SEPARADOR ORGÁNICO -->
<div class="h-48 bg-space-700 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-primary/20 to-secondary/20 opacity-50"></div>
    <div class="absolute inset-0 animate-orbital-movement">
        <div class="w-48 h-48 bg-secondary/20 rounded-full blur-3xl"></div>
    </div>
</div>

<!-- SECCIÓN NOTICIAS -->
<section class="relative py-24 bg-gradient-to-br from-cosmic-500 via-cosmic-700 to-black overflow-hidden" data-aos="fade-up">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,_rgba(255,255,255,0.05),_transparent_60%)]"></div>
    </div>

    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="text-center mb-16">
            <div class="inline-flex relative">
                <span class="absolute -inset-4 bg-galactic-500/40 blur-3xl rounded-full"></span>
                <h2 id="typed-text-gallery-title" class="text-5xl md:text-6xl lg:text-7xl bg-gradient-to-r from-accent-300 to-primary bg-clip-text text-transparent font-extrabold mb-6 relative text-glow">
                    Últimas Noticias
                </h2>
            </div>
            <p class="text-tech-300 max-w-xl mx-auto text-lg">
                Mantente informado con nuestros avances y logros.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 lg:gap-8">
            @php 
                // Simulando datos dinámicos (puedes reemplazarlo con datos de base de datos)
                $noticias = [
                    [
                        'img' => 'noticias/spacex-despegue.jpg',  // Ruta local
                        'titulo' => 'Avances revolucionarios en propulsión espacial',
                        'descripcion' => 'Nuestro equipo de ingeniería ha logrado un hito histórico en el desarrollo de motores de plasma de alta eficiencia...',
                        'fecha' => '15 Mayo 2024',
                        'categoria' => '🚀 Ingeniería Espacial'
                    ],
                    [
                        'img' => 'noticias/spacex-despegue.jpg',  // Ruta local
                        'titulo' => 'Desarrollo de nuevas tecnologías para misiones lunares',
                        'descripcion' => 'Estamos trabajando en nuevas tecnologías para mejorar la seguridad y eficiencia de las misiones lunares...',
                        'fecha' => '22 Mayo 2024',
                        'categoria' => '🚀 Ingeniería Espacial'
                    ],
                    [
                        'img' => 'noticias/spacex-despegue.jpg',  // Ruta local
                        'titulo' => 'Investigación avanzada en motores de cohetes nucleares',
                        'descripcion' => 'Avances en la investigación de nuevos tipos de propulsión para explorar más allá de nuestro sistema solar...',
                        'fecha' => '5 Junio 2024',
                        'categoria' => '🚀 Ingeniería Espacial'
                    ],
                    [
                        'img' => 'noticias/spacex-despegue.jpg',  // Ruta local
                        'titulo' => 'Investigación avanzada en motores de cohetes nucleares',
                        'descripcion' => 'Avances en la investigación de nuevos tipos de propulsión para explorar más allá de nuestro sistema solar...',
                        'fecha' => '5 Junio 2024',
                        'categoria' => '🚀 Ingeniería Espacial'
                    ],
                    [
                        'img' => 'noticias/spacex-despegue.jpg',  // Ruta local
                        'titulo' => 'Investigación avanzada en motores de cohetes nucleares',
                        'descripcion' => 'Avances en la investigación de nuevos tipos de propulsión para explorar más allá de nuestro sistema solar...',
                        'fecha' => '5 Junio 2024',
                        'categoria' => '🚀 Ingeniería Espacial'
                    ],
                    [
                        'img' => 'noticias/spacex-despegue.jpg',  // Ruta local
                        'titulo' => 'Investigación avanzada en motores de cohetes nucleares',
                        'descripcion' => 'Avances en la investigación de nuevos tipos de propulsión para explorar más allá de nuestro sistema solar...',
                        'fecha' => '5 Junio 2024',
                        'categoria' => '🚀 Ingeniería Espacial'
                    ],
                ];
            @endphp

            @foreach($noticias as $noticia)
                <article class="group relative bg-tech-700/30 rounded-2xl border border-tech-500 hover:border-secondary transition-all duration-500 hover:-translate-y-2 shadow-xl hover:shadow-accent-500/40 overflow-hidden"
                         data-aos="fade-up" data-aos-delay="{{ ($loop->index + 1) * 100 }}">
                    <div class="relative overflow-hidden h-52 sm:h-64 md:h-72 lg:h-80">
                        <img src="{{ asset('images/' . $noticia['img']) }}" 
                             alt="{{ $noticia['titulo'] }}"
                             class="w-full h-full object-cover rounded-t-2xl group-hover:scale-105 transition-transform duration-700 ease-in-out">
                        <div class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    </div>

                    <div class="p-6">
                        <div class="flex items-center text-sm text-tech-300 mb-3">
                            <span class="mr-4">📅 {{ $noticia['fecha'] }}</span>
                            <span>{{ $noticia['categoria'] }}</span>
                        </div>
                        <h3 class="text-xl lg:text-2xl font-bold text-white mb-3 leading-tight transition-colors group-hover:text-accent-100">
                            {{ $noticia['titulo'] }}
                        </h3>
                        <p class="text-tech-100 line-clamp-3">
                            {{ $noticia['descripcion'] }}
                        </p>
                        <a href="#" class="inline-flex items-center mt-4 text-accent-500 hover:text-accent-300 font-semibold transition-all duration-300">
                            Leer más 
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

<!-- SEPARADOR ORGÁNICO -->
<div class="h-48 bg-space-700 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-primary/20 to-secondary/20 opacity-50"></div>
    <div class="absolute inset-0 animate-orbital-movement">
        <div class="w-48 h-48 bg-secondary/20 rounded-full blur-3xl"></div>
    </div>
</div>

<!-- SECCIÓN DE COLABORACIONES -->
<section class="py-20 bg-gradient-to-br from-space-700 to-primary-dark">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-20">
            <h2 class="text-4xl font-bold text-white mb-6">Nuestra Red Global</h2>
            <p class="text-gray-400 max-w-2xl mx-auto">Colaborando con líderes internacionales en la nueva era espacial</p>
        </div>

        <div class="relative">
            <div class="global-map-overlay"></div>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-8 relative z-10">
                @foreach(['nasa', 'esa', 'spacex', 'blue-origin', 'jaxa'] as $agency)
                <div class="group flex items-center justify-center p-6 bg-space-800 rounded-xl border border-space-700 hover:border-secondary transition-all duration-300">
                    <img src="/images/agencies/{{ $agency }}.png" alt="{{ strtoupper($agency) }}" class="h-12 opacity-80 group-hover:opacity-100 transition-opacity">
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- SEPARADOR ORGÁNICO -->
<div class="h-48 bg-space-700 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-primary/20 to-secondary/20 opacity-50"></div>
    <div class="absolute inset-0 animate-orbital-movement">
        <div class="w-48 h-48 bg-secondary/20 rounded-full blur-3xl"></div>
    </div>
</div>

<section class="relative py-24 overflow-hidden " data-aos="fade-up">
    <!-- Efecto de fondo -->
    <div class="absolute inset-0 opacity-20">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-secondary-500/10 via-galactic-700/20 to-transparent"></div>
    </div>

    <div class="max-w-7xl mx-auto px-6 flex flex-col lg:flex-row items-center gap-16 relative z-10">
        <!-- Contenedor de texto -->
        <div class="lg:w-1/2" data-aos="fade-right" data-aos-delay="200">
            <div class="relative group">
                <h2 class="text-5xl font-bold bg-gradient-to-r from-accent-300 to-primary bg-clip-text text-transparent mb-8">
                    Consultoría Especializada
                    <span class="absolute -bottom-2 left-0 w-32 h-1 bg-gradient-to-r from-secondary/80 to-transparent rounded-full"></span>
                </h2>
            </div>
            
            <p class="text-tech-200 text-xl mb-10 leading-relaxed">
                Apoyamos tu proyecto con la mejor asesoría espacial en el sector cosmonáutico en México.
            </p>

            <ul class="space-y-8 border-l-4 border-secondary/80 pl-8">
                @foreach([
                    ['title' => 'Planificación Estratégica', 'text' => 'Diseñamos estrategias para alcanzar tus metas espaciales.'],
                    ['title' => 'Innovación Tecnológica', 'text' => 'Te ayudamos a implementar tecnología de vanguardia en tus proyectos.'],
                    ['title' => 'Formación Profesional', 'text' => 'Capacitamos a tu equipo en las últimas tendencias en ingeniería espacial.'],
                    ['title' => 'Colaboración Internacional', 'text' => 'Facilitamos alianzas estratégicas a nivel global para potenciar tu proyecto.']
                ] as $index => $item)
                <li class="relative pl-4 group" data-aos="fade-up" data-aos-delay="{{ 300 + ($index * 100) }}">
                    <div class="absolute -left-4 top-0 h-full w-1 bg-secondary-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="flex items-start space-x-4 hover:translate-x-4 transition-transform duration-300">
                        <div class="relative mt-1">
                            <div class="absolute inset-0 bg-accent-700 rounded-full blur group-hover:blur-lg transition-all duration-300"></div>
                            <svg class="w-8 h-8 text-accent-300 p-1.5 relative" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-tech-100 mb-2">{{ $item['title'] }}</h3>
                            <p class="text-tech-300 leading-relaxed">{{ $item['text'] }}</p>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
        
        <!-- Contenedor de imagen -->
        <div class="lg:w-1/2" data-aos="fade-left" data-aos-delay="300">
            <div class="relative rounded-2xl overflow-hidden shadow-2xl hover:shadow-secondary-500/20 transition-all duration-500 group">
                <!-- Efecto de brillo dinámico -->
                <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <div class="absolute -inset-24 bg-[conic-gradient(from_90deg_at_50%_50%,#FF580030_0%,#00B4D840_50%,#FF580030_100%)] animate-spin-slow"></div>
                </div>
                
                <div class="relative z-10">
                    <img src="{{ asset('images/space/spacex-rocket.jpg') }}" alt="Lanzamiento de cohete" 
                         class="w-full h-[600px] object-cover rounded-2xl transform transition-transform duration-700 group-hover:scale-105">
                    
                    <!-- Superposición y badge -->
                    <div class="absolute inset-0 bg-gradient-to-t from-secondary-100/70 to-transparent"></div>
                    <div class="absolute bottom-8 left-8">
                        <div class="bg-secondary-500/90 px-4 py-2 rounded-full backdrop-blur-sm">
                            <span class="text-sm font-semibold text-galactic-700">+15 años de experiencia</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Elemento decorativo flotante -->
    <div class="absolute right-24 top-1/4 opacity-10 animate-float">
        <svg class="w-48 h-48 text-accent-300/20" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.75L19.25 9L12 13.25L4.75 9L12 4.75Z"/>
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.25 12L4.75 15L12 19.25L19.25 15L14.75 12"/>
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.25 12L12 13.25L14.75 12"/>
        </svg>
    </div>
</section>

<!-- SEPARADOR ORGÁNICO -->
<div class="h-48 bg-space-700 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-primary/20 to-secondary/20 opacity-50"></div>
    <div class="absolute inset-0 animate-orbital-movement">
        <div class="w-48 h-48 bg-secondary/20 rounded-full blur-3xl"></div>
    </div>
</div>

<section class="py-20 " data-aos="fade-in">
    <div class="max-w-7xl mx-auto px-6">
        <!-- Encabezado de la Sección -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-16">
            <div class="md:w-1/2 mb-8 md:mb-0" data-aos="fade-right">
                <h2 class="text-4xl font-extrabold text-white mb-6">Próximos Eventos</h2>
                <p class="text-gray-300 text-lg">Calendario de lanzamientos y eventos importantes</p>
            </div>
            <div class="md:w-1/2 text-right" data-aos="fade-left">
                <a href="#" class="inline-flex items-center text-primary hover:text-secondary font-semibold transition-all duration-300 group">
                    Ver calendario completo
                    <svg class="w-4 h-4 ml-2 transition-all duration-300 transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Tarjetas de Eventos -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            @php
                // Simulando los próximos eventos de manera estática
                $events = [
                    [
                        'title' => 'Voyager XIV',
                        'rocket' => 'Nova-9 Heavy',
                        'category' => 'Ciencia Planetaria',
                        'launch_date' => '15 Agosto 2024',
                        'platform' => 'SLC-40, Cabo Cañaveral',
                        'progress' => 85,
                    ],
                    [
                        'title' => 'Lunar Exploration',
                        'rocket' => 'Falcon Heavy',
                        'category' => 'Exploración Lunar',
                        'launch_date' => '30 Septiembre 2024',
                        'platform' => 'LC-39A, Cabo Cañaveral',
                        'progress' => 60,
                    ]
                ];
            @endphp

            @foreach($events as $index => $event)
                <div class="relative group" data-aos="fade-up" data-aos-delay="{{ 200 * ($index + 1) }}">
                    <div class="bg-cosmic-700 rounded-2xl p-8 border border-cosmic-500 transition-all duration-300 transform group-hover:-translate-y-2 group-hover:scale-105 backdrop-blur-cosmic shadow-lg group-hover:shadow-2xl">
                        <!-- Información Principal -->
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center">
                                <div class="w-14 h-14 bg-cosmic-500 rounded-full flex items-center justify-center mr-4 shadow-md">
                                    <span class="text-secondary font-bold text-2xl">{{ strtoupper(substr($event['title'], 0, 1)) }}</span>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-semibold text-white">{{ $event['title'] }}</h3>
                                    <p class="text-gray-400 text-sm">Cohete: {{ $event['rocket'] }}</p>
                                </div>
                            </div>
                            <span class="text-sm bg-primary/20 text-primary px-3 py-1 rounded-full">{{ $event['category'] }}</span>
                        </div>

                        <!-- Información Adicional -->
                        <div class="flex justify-between items-center text-sm text-gray-500 mb-4">
                            <div>
                                <div class="mb-1">Fecha de lanzamiento</div>
                                <div class="text-white font-medium">{{ $event['launch_date'] }}</div>
                            </div>
                            <div class="text-right">
                                <div class="mb-1">Plataforma</div>
                                <div class="text-white font-medium">{{ $event['platform'] }}</div>
                            </div>
                        </div>

                        <!-- Barra de Progreso -->
                        <div class="mt-6 relative pt-4">
                            <div class="flex justify-between text-xs text-gray-500 mb-2">
                                <span>Preparación</span>
                                <span>{{ $event['progress'] }}%</span>
                            </div>
                            <div class="w-full bg-cosmic-500 rounded-full h-2 overflow-hidden">
                                <div class="bg-secondary rounded-full h-2 transition-all duration-500" style="width: {{ $event['progress'] }}%"></div>
                            </div>
                        </div>
                    </div>
                    <!-- Elemento decorativo con Blur -->
                    <div class="absolute -inset-1 rounded-2xl bg-gradient-to-r from-secondary-700/5 via-primary-100/10 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@endsection