@extends('layouts.public')

@section('titulo', 'Acerca de')

@section('contenido')
<section class="relative min-h-[80vh] flex flex-col justify-center items-center bg-gradient-to-br from-space-950 via-cosmic-900 to-space-950 overflow-hidden" data-aos="zoom-in-up" data-aos-duration="1200">
    <!-- Fondo estelar mejorado -->
    <div class="absolute inset-0 -z-10">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-primary/10 via-transparent to-transparent"></div>
        <div class="stars-small animate-twinkle"></div>
        <div class="stars-medium animate-twinkle-slow"></div>
        <div class="stars-large animate-twinkle-fast"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-6 sm:px-8 lg:px-12 text-center z-20 space-y-10">
        <!-- Título con efecto moderno -->
        <h1 class="text-5xl md:text-7xl font-extrabold galactic-title" data-aos="fade-up">
            <span class="text-transparent bg-clip-text bg-gradient-to-br from-cyan-400 to-primary animate-text-glow">UNISEC MÉXICO</span>
        </h1>

        <!-- Subtítulo con efecto flotante -->
        <p class="text-lg md:text-2xl text-white max-w-2xl mx-auto leading-relaxed">
            Innovación espacial impulsada por la excelencia humana.
        </p>

        <!-- Tarjetas interactivas con efecto glassmorphism -->
        <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto" data-aos="fade-up" data-aos-delay="400">
            <a href="#que-somos" class="group cosmic-card backdrop-blur-md bg-white/10 border border-white/20 rounded-2xl p-6 transition-all duration-500 hover:scale-[1.05] hover:shadow-glow">
                <div class="flex items-center gap-4 mb-4">
                    <div class="cosmic-icon bg-primary/20 text-primary p-4 rounded-2xl">
                        <i class="fas fa-scroll text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white">Nuestra Travesía</h3>
                </div>
                <p class="text-white leading-relaxed">Desde 2012, escribiendo la historia de la exploración espacial con innovación y determinación.</p>
            </a>

            <a href="#valores" class="group cosmic-card backdrop-blur-md bg-white/10 border border-white/20 rounded-2xl p-6 transition-all duration-500 hover:scale-[1.05] hover:shadow-glow">
                <div class="flex items-center gap-4 mb-4">
                    <div class="cosmic-icon bg-secondary/20 text-secondary p-4 rounded-2xl">
                        <i class="fas fa-hand-holding text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white">Principios</h3>
                </div>
                <p class="text-white leading-relaxed">Ética, innovación sostenible y colaboración global como pilares fundamentales.</p>
            </a>
        </div>
    </div>

    <!-- Indicador de desplazamiento mejorado -->
    <div class="absolute bottom-10 w-full flex justify-center" data-aos="fade-up" data-aos-delay="600">
        <a href="#que-somos" class="scroll-indicator animate-bounce">
            <i class="fas fa-chevron-down text-2xl text-secondary"></i>
        </a>
    </div>

    <!-- Estilos personalizados -->
    <style>
        .galactic-title {
            text-shadow: 0 0 60px rgba(76, 175, 255, 0.5),
                         0 0 120px rgba(76, 175, 255, 0.3);
        }
        .animate-text-glow {
            animation: textGlow 2.5s infinite alternate ease-in-out;
        }
        @keyframes textGlow {
            from { text-shadow: 0 0 10px rgba(76, 175, 255, 0.5); }
            to { text-shadow: 0 0 30px rgba(76, 175, 255, 0.8); }
        }
        .animate-twinkle {
            animation: twinkle 8s infinite alternate ease-in-out;
        }
        .animate-twinkle-slow {
            animation: twinkle 12s infinite alternate ease-in-out;
        }
        .animate-twinkle-fast {
            animation: twinkle 4s infinite alternate ease-in-out;
        }
        @keyframes twinkle {
            0% { opacity: 0.3; }
            50% { opacity: 0.8; }
            100% { opacity: 0.3; }
        }
        .hover\:shadow-glow:hover {
            box-shadow: 0 0 20px rgba(76, 175, 255, 0.4);
        }
    </style>
</section>


<!-- SEPARADOR ORGÁNICO -->
<div class="h-48 bg-space-700 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-primary/20 to-secondary/20 opacity-60"></div>
    <div class="absolute inset-0 animate-orbital-movement">
        <div class="w-48 h-48 bg-secondary/20 rounded-full blur-3xl"></div>
    </div>
</div>

<!-- QUIÉNES SOMOS -->
<section id="que-somos" class="relative py-32 bg-gradient-to-br from-cosmic-300 via-space-700 to-space-900 overflow-hidden" data-aos="fade-up">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <!-- Imagen Representativa con efecto parallax -->
            <div class="relative rounded-3xl overflow-hidden shadow-2xl transition-all duration-500 group" data-aos="fade-right" data-aos-duration="800">
                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <img src="{{ asset('images/exoplanetas.jpg')}}" alt="Laboratorio Espacial" class="w-full h-full object-cover filter brightness-75 group-hover:brightness-100 transition-all duration-500 transform group-hover:scale-105">
            </div>

            <!-- Texto Descriptivo con efecto Glassmorphism -->
            <div class="relative backdrop-blur-md bg-white/10 border border-white/20 rounded-2xl p-8 shadow-lg" data-aos="fade-left" data-aos-duration="800">
                <h2 class="text-5xl font-extrabold text-white mb-6 drop-shadow-md animate-text-glow">
                    ¿Quiénes Somos?
                </h2>
                <p class="text-gray-300 text-lg leading-relaxed">
                    UNISEC es un centro de innovación aeroespacial comprometido con la investigación, el desarrollo y la colaboración global. Impulsamos proyectos que desafían los límites de la tecnología y acercamos la exploración espacial a nuevas fronteras.
                </p>
            </div>
        </div>
    </div>

    <!-- Estilos Personalizados -->
    <style>
        .animate-text-glow {
            text-shadow: 0 0 20px rgba(255, 255, 255, 0.3),
                         0 0 40px rgba(76, 175, 255, 0.5);
        }
    </style>
</section>

<!-- SEPARADOR ORGÁNICO -->
<div class="h-48 bg-space-700 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-primary/20 to-secondary/20 opacity-60"></div>
    <div class="absolute inset-0 animate-orbital-movement">
        <div class="w-48 h-48 bg-secondary/20 rounded-full blur-3xl"></div>
    </div>
</div>


<!-- MISIÓN, VISIÓN Y OBJETIVOS -->
<section class="relative py-32 bg-gradient-to-br from-cosmic-700 via-space-800 to-space-900 overflow-hidden" data-aos="fade-up">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-5xl font-extrabold text-white drop-shadow-md animate-text-glow">Nuestra Misión, Visión y Objetivos</h2>
            <p class="text-gray-300 text-xl max-w-3xl mx-auto mt-4">
                Dirigimos nuestra energía hacia un futuro donde la exploración espacial impulse la innovación y el desarrollo tecnológico global.
            </p>
        </div>

        <!-- Contenedor de tarjetas -->
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Tarjeta Misión -->
            <div class="glass-card" data-aos="fade-right" data-aos-delay="100">
                <div class="icon-container">
                    <i class="fas fa-rocket text-4xl text-purple-500"></i>
                </div>
                <h3 class="text-3xl font-bold text-accent">Misión</h3>
                <p class="text-gray-300">
                    Impulsar la investigación y el desarrollo en el ámbito aeroespacial, fomentando la colaboración internacional y la innovación para transformar el futuro en realidades tangibles.
                </p>
            </div>

            <!-- Tarjeta Visión -->
            <div class="glass-card" data-aos="fade-up" data-aos-delay="200">
                <div class="icon-container">
                    <i class="fas fa-eye text-4xl text-purple-500"></i>
                </div>
                <h3 class="text-3xl font-bold text-accent">Visión</h3>
                <p class="text-gray-300">
                    Ser el referente principal en innovación aeroespacial en Latinoamérica, liderando proyectos tecnológicos que conecten el mundo con el cosmos.
                </p>
            </div>

            <!-- Tarjeta Objetivos -->
            <div class="glass-card" data-aos="fade-left" data-aos-delay="300">
                <div class="icon-container">
                    <i class="fas fa-bullseye text-4xl text-purple-500"></i>
                </div>
                <h3 class="text-3xl font-bold text-accent">Objetivos</h3>
                <p class="text-gray-300">
                    Desarrollar tecnologías espaciales de vanguardia, fortalecer la educación aeroespacial y promover el acceso a la exploración espacial para las futuras generaciones.
                </p>
            </div>
        </div>
    </div>

    <!-- Estilos Personalizados -->
    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            transition: all 0.4s ease-in-out;
            box-shadow: 0 4px 20px rgba(255, 255, 255, 0.1);
        }

        .glass-card:hover {
            border-color: rgba(0, 255, 255, 0.6);
            box-shadow: 0 4px 40px rgba(0, 255, 255, 0.4);
            transform: translateY(-5px);
        }

        .icon-container {
            width: 80px;
            height: 80px;
            margin: 0 auto 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .animate-text-glow {
            text-shadow: 0 0 20px rgba(255, 255, 255, 0.3),
                         0 0 40px rgba(76, 175, 255, 0.5);
        }
    </style>
</section>


<!-- MENSAJE DEL PRESIDENTE -->
<section class="relative py-24 bg-gradient-to-br from-cosmic-500 via-cosmic-700 to-black overflow-hidden" data-aos="zoom-in" data-aos-duration="1000">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,_rgba(255,255,255,0.07),_transparent_70%)]"></div>
    </div>
    <div class="max-w-3xl mx-auto px-6 relative z-10 text-center">
        <blockquote class="text-white">
            <p class="text-2xl md:text-3xl leading-relaxed font-medium mb-6 drop-shadow-xl">
                "La exploración del espacio no es solo un sueño, sino una misión que transforma nuestro presente y nos proyecta hacia un futuro lleno de posibilidades infinitas."
            </p>
            <footer class="flex items-center justify-center">
                <div class="border-l-4 border-cyan-400 pl-4">
                    <p class="font-bold text-xl">Dr. Hermes Moreno Alvarez</p>
                    <p class="text-sm text-gray-400">Presidente UNISEC Seccion México</p>
                </div>
            </footer>
        </blockquote>
    </div>
</section>


<!-- SEPARADOR ORGÁNICO -->
<div class="h-48 bg-space-700 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-primary/20 to-secondary/20 opacity-60"></div>
    <div class="absolute inset-0 animate-orbital-movement">
        <div class="w-48 h-48 bg-secondary/20 rounded-full blur-3xl"></div>
    </div>
</div>


<!-- SECCIÓN NUESTRO EQUIPO -->
@php
$presidente = [
    'nombre' => 'HERMES MORENO ÁLVAREZ',
    'cargo' => 'Presidente UNISEC México',
    'descripcion' => 'Líder visionario en el desarrollo aeroespacial y la educación espacial en México.',
    'imagen' => 'team/ejemplo.jpg',
    'linkedin' => '#',
    'email' => 'presidente@unisec.mx'
];

$secciones = [
    [
        'nombre' => 'Sección Norte',
        'director' => [
            'nombre' => 'ANTONIO GÓMEZ ROA',
            'cargo' => 'Universidad Autónoma de Baja California',
            'descripcion' => 'Coordinación de proyectos espaciales en la región norte del país.',
            'imagen' => 'team/ejemplo.jpg',
            'email' => 'norte.director@unisec.mx'
        ],
        'equipo' => [
            [
                'nombre' => 'SILVIA KARINA REYES LIO',
                'cargo' => 'Instituto Tcnológico de Nogales Sonora',
                'descripcion' => 'Especialista en sistemas de propulsión espacial.',
                'imagen' => 'team/ejemplo.jpg',
                'email' => 'norte.investigacion@unisec.mx'
            ],
            [
                'nombre' => 'OSCAR MARTÍNEZ HERNÁNDEZ',
                'cargo' => 'Líder de Proyectos',
                'descripcion' => 'Experto en diseño de nanosatélites.',
                'imagen' => 'team/ejemplo.jpg',
                'email' => 'norte.proyectos@unisec.mx'
            ]
        ]
    ],
    [
        'nombre' => 'Sección Centro',
        'director' => [
            'nombre' => 'JORGE ALFREDO FERRER PÉREZ',
            'cargo' => 'UNAM - QUERÉTARO',
            'descripcion' => 'Gestión de investigación y desarrollo en la zona central.',
            'imagen' => 'team/ejemplo.jpg',
            'email' => 'centro.director@unisec.mx'
        ],
        'equipo' => [
   
        ]
    ],
    [
        'nombre' => 'Sección Sur',
        'director' => [
            'nombre' => 'ROSA MARÍA MARTÍNEZ GALVÁN',
            'cargo' => 'Instituto Tecnológico de Puebla',
            'descripcion' => 'Desarrollo de programas espaciales en la región sur.',
            'imagen' => 'team/ejemplo.jpg',
            'email' => 'sur.director@unisec.mx'
        ],
        'equipo' => [
            [
                'nombre' => 'JOSUÉ MANCILLA CEREZO',
                'cargo' => 'Instituto Tecnológico Superior de Tepeaca',
                'descripcion' => 'Especialista en astrofísica aplicada.',
                'imagen' => 'team/ejemplo.jpg',
                'email' => 'sur.investigacion@unisec.mx'
            ]
        ]
    ]
];
@endphp

<!-- SECCIÓN NUESTRO EQUIPO -->
<section class="relative py-24 bg-gradient-to-b from-space-900 to-space-950/80 overflow-hidden">
  <div class="container mx-auto px-6 lg:px-12">
    <div class="text-center mb-16">
      <div class="inline-flex relative mb-6">
        <span class="absolute inset-0 bg-primary/10 blur-xl rounded-full"></span>
        <h2 class="text-4xl md:text-5xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-primary to-cyan-300 drop-shadow-md">
          Nuestro Equipo
        </h2>
      </div>
      <p class="text-lg text-gray-300/80 max-w-3xl mx-auto leading-relaxed tracking-wide">
        Estructura organizacional de UNISEC México, unidos por la pasión espacial y la innovación tecnológica.
      </p>
    </div>

    <!-- Presidente -->
    <div class="mb-10">
      <div class="max-w-md mx-auto bg-space-500/20 backdrop-blur-xl rounded-2xl border-2 border-primary/60 shadow-2xl shadow-primary/20 overflow-hidden transform hover:scale-[1.03] hover:border-primary transition-all duration-500 group">
        <div class="relative overflow-hidden">
          <img src="{{ asset('images/' . $presidente['imagen']) }}" alt="{{ $presidente['nombre'] }}" 
               class="w-full h-80 object-cover transform group-hover:scale-105 transition-transform duration-500">
          <div class="absolute inset-0 bg-gradient-to-t from-space-900 via-space-900/60 to-transparent opacity-90 group-hover:opacity-70 transition-opacity duration-500"></div>
        </div>
        
        <div class="p-8 relative text-center">
          <h3 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-primary to-cyan-300 mb-2 tracking-wide">{{ $presidente['nombre'] }}</h3>
          <p class="text-primary font-medium text-lg mb-4">{{ $presidente['cargo'] }}</p>
          <p class="text-gray-300/90 text-base leading-relaxed mb-6">
            {{ $presidente['descripcion'] }}
          </p>
          
          <div class="flex justify-center space-x-4">
            <a href="{{ $presidente['linkedin'] }}" target="_blank" class="p-3 rounded-xl bg-space-700/40 hover:bg-primary/30 transform hover:scale-110 transition-all duration-300">
              <i class="fab fa-linkedin text-gray-300 hover:text-primary text-xl"></i>
            </a>
            <a href="mailto:{{ $presidente['email'] }}" class="p-3 rounded-xl bg-space-700/40 hover:bg-primary/30 transform hover:scale-110 transition-all duration-300">
              <i class="fas fa-envelope text-gray-300 hover:text-primary text-xl"></i>
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Línea conectora vertical -->
    <div class="w-px h-24 bg-primary/90 mx-auto mb-10"></div>

    <!-- Secciones Regionales -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-12 relative">
      <!-- Línea conectora horizontal -->
      <div class="absolute top-0 left-1/4 right-1/4 h-px bg-primary/90 hidden md:block"></div>

      @foreach($secciones as $seccion)
      <!-- {{ $seccion['nombre'] }} -->
      <div class="space-y-12">
        <div class="text-center mb-8">
          <h3 class="text-2xl font-bold text-primary mb-2">{{ $seccion['nombre'] }}</h3>
          <div class="w-px h-12 bg-primary/30 mx-auto"></div>
        </div>

        <!-- Director Regional -->
        <div class="relative">
          <div class="bg-space-500/20 backdrop-blur-xl rounded-2xl border-2 border-primary/40 hover:border-primary/60 transition-all p-8 transform hover:scale-[1.03] hover:shadow-2xl hover:shadow-primary/20 group">
            <div class="mb-6 relative overflow-hidden rounded-xl">
              <img src="{{ asset('images/' . $seccion['director']['imagen']) }}" 
                   alt="{{ $seccion['director']['nombre'] }}" 
                   class="w-full h-56 object-cover transform group-hover:scale-105 transition-transform duration-500">
              <div class="absolute inset-0 bg-gradient-to-t from-space-900 via-space-900/60 to-transparent opacity-90 group-hover:opacity-70 transition-opacity duration-500"></div>
            </div>
            <h4 class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-primary to-cyan-300 mb-3">{{ $seccion['director']['nombre'] }}</h4>
            <p class="text-primary font-medium text-lg mb-3">{{ $seccion['director']['cargo'] }}</p>
            <p class="text-gray-300/90 text-base leading-relaxed mb-4">{{ $seccion['director']['descripcion'] }}</p>
            <div class="flex justify-center space-x-4">
              <a href="mailto:{{ $seccion['director']['email'] }}" class="p-3 rounded-xl bg-space-700/40 hover:bg-primary/30 transform hover:scale-110 transition-all duration-300">
                <i class="fas fa-envelope text-gray-300 hover:text-primary text-xl"></i>
              </a>
            </div>
          </div>

          <!-- Línea conectora vertical desde el director -->
          <div class="w-px h-12 bg-gradient-to-b from-primary/90 to-primary/30 mx-auto my-8"></div>
        </div>

        <!-- Equipo Regional -->
        <div class="space-y-8">
          @foreach($seccion['equipo'] as $miembro)
          <div class="relative">
            <!-- Línea conectora vertical -->
            <div class="absolute -top-4 left-1/2 w-0.5 h-4 bg-gradient-to-b from-primary/90 to-primary/90"></div>
            
            <div class="bg-space-500/20 backdrop-blur-xl rounded-2xl border-2 border-primary/30 hover:border-primary/50 transition-all p-6 transform hover:scale-[1.03] hover:shadow-xl hover:shadow-primary/20 group">
              <div class="mb-4 relative overflow-hidden rounded-xl">
                <img src="{{ asset('images/' . $miembro['imagen']) }}" 
                     alt="{{ $miembro['nombre'] }}" 
                     class="w-full h-40 object-cover transform group-hover:scale-105 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-space-900 via-space-900/60 to-transparent opacity-90 group-hover:opacity-70 transition-opacity duration-500"></div>
              </div>
              <h4 class="text-xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-primary to-cyan-300 mb-2">{{ $miembro['nombre'] }}</h4>
              <p class="text-primary font-medium text-base mb-2">{{ $miembro['cargo'] }}</p>
              <p class="text-gray-300/90 text-sm leading-relaxed mb-4">{{ $miembro['descripcion'] }}</p>
              <div class="flex justify-center space-x-4">
                <a href="mailto:{{ $miembro['email'] }}" class="p-2 rounded-lg bg-space-700/40 hover:bg-primary/30 transform hover:scale-110 transition-all duration-300">
                  <i class="fas fa-envelope text-gray-300 hover:text-primary text-lg"></i>
                </a>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
      @endforeach

    </div>
  </div>
</section>

<!-- NUESTRA HISTORIA - MINIMALISTA Y CENTRADA -->
<section class="py-24 bg-gray-900">
    <div class="max-w-6xl mx-auto px-6 lg:px-8">
        <!-- TÍTULO -->
        <div class="text-center mb-16">
            <h2 class="text-5xl font-semibold text-white mb-4 tracking-tight">Nuestra Historia</h2>
            <p class="text-gray-400 text-lg max-w-2xl mx-auto">
                Un recorrido de innovación y exploración que define nuestro impacto en el futuro de la tecnología espacial.
            </p>
        </div>

        <!-- TIMELINE CENTRADO -->
        <div class="relative flex flex-col items-center">
            @php
                $timeline = [
                    ['year' => '2020', 'event' => 'Fundación de UNISEC y lanzamiento del primer proyecto de investigación aeroespacial.'],
                    ['year' => '2021', 'event' => 'Desarrollo de colaboraciones internacionales y registro de patentes innovadoras.'],
                    ['year' => '2023', 'event' => 'Reconocimiento como líder en tecnología espacial en Latinoamérica.'],
                    ['year' => '2025', 'event' => 'Liderazgo en el desarrollo de misiones interplanetarias y construcción de satélites de próxima generación.'],
                ];
            @endphp

            <div class="absolute w-1 h-full bg-gray-700 dark:bg-gray-600"></div>

            @foreach($timeline as $index => $item)
                <div class="mb-12 relative w-full max-w-2xl text-center" data-aos="fade-up" data-aos-delay="{{ $index * 150 }}">
                    <!-- PUNTO DE LA LÍNEA -->
                    <div class="absolute left-1/2 transform -translate-x-1/2 w-4 h-4 bg-cyan-500 rounded-full border-4 border-gray-900"></div>

                    <!-- TARJETA DE EVENTO -->
                    <div class="bg-gray-800 p-6 rounded-lg shadow-md hover:bg-gray-700 transition duration-300 ease-in-out mx-auto w-full">
                        <span class="block text-cyan-400 text-lg font-semibold">{{ $item['year'] }}</span>
                        <p class="text-gray-300 text-base mt-2 leading-relaxed">{{ $item['event'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>




<!-- NUESTROS VALORES - MEJORADO Y CENTRADO -->
<section id="valores" class="py-24 bg-gray-900" data-aos="fade-up">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-5xl font-bold text-white mb-4">Nuestros Valores</h2>
            <p class="text-gray-300 text-xl max-w-3xl mx-auto">
                Estos son los principios que guían cada uno de nuestros proyectos y decisiones.
            </p>
        </div>

        <!-- GRID DE VALORES -->
        <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-10">
            @php
                $valores = [
                    ['nombre' => 'Innovación', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 19h6l-.75-2M9 11l.75-2h4.5L15 11M7.75 11h8.5l-1.5-4H9.25l-1.5 4z" /></svg>'],
                    ['nombre' => 'Compromiso', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>'],
                    ['nombre' => 'Colaboración', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-5-3.5" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20H4v-2a4 4 0 015-3.5" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>'],
                    ['nombre' => 'Exploración', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2a10 10 0 00-10 10 10 10 0010 10 10 10 0010-10A10 10 0 0012 2z" /></svg>'],
                    ['nombre' => 'Excelencia', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>'],
                ];
            @endphp

            @foreach($valores as $valor)
            <div class="p-8 bg-gray-800 rounded-2xl shadow-lg transition-transform transform hover:scale-105 hover:bg-gradient-to-r hover:from-cyan-500 hover:to-purple-600 hover:shadow-2xl flex flex-col items-center text-center">
                <div class="mb-6">
                    {!! $valor['icon'] !!}
                </div>
                <h4 class="text-2xl font-semibold text-white mb-2">{{ $valor['nombre'] }}</h4>
                <p class="text-gray-300 text-sm">
                    Reflejamos nuestro compromiso con la excelencia en cada proyecto.
                </p>
            </div>
            @endforeach
        </div>
    </div>
</section>


@endsection
