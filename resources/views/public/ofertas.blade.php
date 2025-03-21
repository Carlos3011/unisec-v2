@extends('layouts.public')

@section('titulo', 'Ofertas Académicas')

@section('contenido')
<!-- HERO Mejorado -->
<section class="relative min-h-[85vh] flex flex-col justify-center items-center bg-gradient-to-br from-space-900 via-cosmic-800 to-space-900 overflow-hidden" data-aos="zoom-in-up" data-aos-duration="1200">

    <!-- Capa de estrellas animadas -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute inset-0 bg-[url('/svg/starburst.svg')] bg-contain bg-center opacity-30 mix-blend-overlay animate-rotate-slow"></div>
        <div class="absolute inset-0 bg-[url('/svg/stars.svg')] bg-repeat opacity-20 animate-twinkle"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-6 sm:px-8 text-center z-20 space-y-8">
        <!-- Título con efecto futurista -->
        <h1 class="text-4xl sm:text-6xl md:text-8xl font-extrabold galactic-title tracking-wide uppercase leading-tight" data-aos="fade-up">
            <span class="text-transparent bg-clip-text bg-gradient-to-br from-cyan-400 to-primary animate-gradient">
                Ofertas Académicas
            </span>
        </h1>

        <!-- Subtítulo -->
        <p class="text-lg sm:text-xl md:text-2xl text-white max-w-3xl mx-auto leading-relaxed font-light" data-aos="fade-up" data-aos-delay="200">
            Explora programas educativos de vanguardia diseñados para llevarte más allá de los límites del conocimiento espacial
        </p>

        <!-- Botón de acción -->
        <div data-aos="fade-up" data-aos-delay="400">
            <a href="#cursos" class="inline-block px-6 sm:px-8 py-3 sm:py-4 text-base sm:text-lg font-semibold text-white bg-gradient-to-r from-cyan-500 to-primary rounded-lg shadow-lg hover:scale-105 transition-transform duration-300">
                Explorar Programas
            </a>
        </div>
    </div>

</section>

<style>
@keyframes twinkle {
    0% { opacity: 0.3; transform: scale(1); }
    50% { opacity: 0.5; transform: scale(1.05); }
    100% { opacity: 0.3; transform: scale(1); }
}
.animate-twinkle {
    animation: twinkle 6s infinite ease-in-out alternate;
}

@media (max-width: 768px) {
    .text-4xl {
        font-size: 3rem;
    }
    .text-xl {
        font-size: 1.125rem;
    }
    .px-6 {
        padding-left: 1.5rem;
        padding-right: 1.5rem;
    }
    .px-8 {
        padding-left: 2rem;
        padding-right: 2rem;
    }
}
</style>


<!-- SEPARADOR ORGÁNICO -->
<div class="h-48 bg-space-700 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-primary/20 to-secondary/20 opacity-60"></div>
    <div class="absolute inset-0 animate-orbital-movement">
        <div class="w-48 h-48 bg-secondary/20 rounded-full blur-3xl"></div>
    </div>
</div>

<!-- PROGRAMAS ACADÉMICOS -->
<section id="programas" class="py-24 bg-gradient-to-br from-cosmic-300 via-space-700" data-aos="fade-up">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-semibold text-white mb-4">Nuestros Programas Académicos</h2>
            <p class="text-white text-lg max-w-3xl mx-auto">
                Explora cursos y programas especializados en tecnología y ciencias espaciales
            </p>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Tarjeta 1 -->
            <a href="#" class="group p-6 bg-gray-800 rounded-xl shadow-lg border border-gray-700 transition-all duration-300 hover:border-cyan-400 hover:shadow-2xl">
                <div class="flex items-center justify-center mb-4">
                    <div class="bg-primary/20 text-primary p-4 rounded-xl">
                        <i class="fas fa-star text-2xl"></i>
                    </div>
                </div>
                <h3 class="text-xl font-semibold text-white mb-2">Curso de Astronomía Avanzada</h3>
                <p class="text-white text-sm">Explora los secretos del universo con clases interactivas y observaciones prácticas</p>
            </a>
            <!-- Tarjeta 2 -->
            <a href="#" class="group p-6 bg-gray-800 rounded-xl shadow-lg border border-gray-700 transition-all duration-300 hover:border-cyan-400 hover:shadow-2xl">
                <div class="flex items-center justify-center mb-4">
                    <div class="bg-secondary/20 text-secondary p-4 rounded-xl">
                        <i class="fas fa-robot text-2xl"></i>
                    </div>
                </div>
                <h3 class="text-xl font-semibold text-white mb-2">Diplomado en Robótica Espacial</h3>
                <p class="text-white text-sm">Domina la automatización y el control para desarrollar tecnologías espaciales de vanguardia</p>
            </a>
            <!-- Tarjeta 3 -->
            <a href="#" class="group p-6 bg-gray-800 rounded-xl shadow-lg border border-gray-700 transition-all duration-300 hover:border-cyan-400 hover:shadow-2xl">
                <div class="flex items-center justify-center mb-4">
                    <div class="bg-accent/20 text-accent p-4 rounded-xl">
                        <i class="fas fa-cogs text-2xl"></i>
                    </div>
                </div>
                <h3 class="text-xl font-semibold text-white mb-2">Seminario de Ingeniería Aeroespacial</h3>
                <p class="text-white text-sm">Conoce las estrategias y tecnologías que impulsan el desarrollo en la industria aeroespacial</p>
            </a>
            <!-- Tarjeta 4 -->
            <a href="#" class="group p-6 bg-gray-800 rounded-xl shadow-lg border border-gray-700 transition-all duration-300 hover:border-cyan-400 hover:shadow-2xl">
                <div class="flex items-center justify-center mb-4">
                    <div class="bg-primary/20 text-primary p-4 rounded-xl">
                        <i class="fas fa-graduation-cap text-2xl"></i>
                    </div>
                </div>
                <h3 class="text-xl font-semibold text-white mb-2">Maestría en Ciencias Espaciales</h3>
                <p class="text-white text-sm">Avanza en tu carrera con un programa de posgrado enfocado en investigación y desarrollo espacial</p>
            </a>
            <!-- Tarjeta 5 -->
            <a href="#" class="group p-6 bg-gray-800 rounded-xl shadow-lg border border-gray-700 transition-all duration-300 hover:border-cyan-400 hover:shadow-2xl">
                <div class="flex items-center justify-center mb-4">
                    <div class="bg-secondary/20 text-secondary p-4 rounded-xl">
                        <i class="fas fa-lightbulb text-2xl"></i>
                    </div>
                </div>
                <h3 class="text-xl font-semibold text-white mb-2">Taller de Innovación Tecnológica</h3>
                <p class="text-white text-sm">Desarrolla proyectos disruptivos y soluciones innovadoras en el ámbito espacial</p>
            </a>
            <!-- Tarjeta 6 -->
            <a href="#" class="group p-6 bg-gray-800 rounded-xl shadow-lg border border-gray-700 transition-all duration-300 hover:border-cyan-400 hover:shadow-2xl">
                <div class="flex items-center justify-center mb-4">
                    <div class="bg-accent/20 text-accent p-4 rounded-xl">
                        <i class="fas fa-satellite text-2xl"></i>
                    </div>
                </div>
                <h3 class="text-xl font-semibold text-white mb-2">Curso de Satélites y Comunicaciones</h3>
                <p class="text-white text-sm">Aprende los fundamentos de las comunicaciones satelitales y su impacto en la conectividad global</p>
            </a>
        </div>
    </div>
</section>

<!-- SEPARADOR ORGÁNICO -->
<div class="h-48 bg-space-700 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-primary/20 to-secondary/20 opacity-60"></div>
    <div class="absolute inset-0 animate-orbital-movement">
        <div class="w-48 h-48 bg-secondary/20 rounded-full blur-3xl"></div>
    </div>
</div>


<!-- ¿POR QUÉ ELEGIR NUESTROS PROGRAMAS? -->
<section class="py-24 bg-space-700" data-aos="fade-up">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-5xl font-bold text-white mb-4">¿Por qué elegir nuestros programas?</h2>
            <p class="text-white text-xl max-w-3xl mx-auto">
                Ofrecemos una formación integral con docentes expertos, proyectos innovadores y una red internacional de contactos que te impulsará a alcanzar tus metas
            </p>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Beneficio 1 -->
            <div class="flex flex-col items-center p-6 bg-gray-800 rounded-2xl shadow-lg text-center transition-all duration-300 hover:bg-gray-700 hover:scale-105">
                <div class="bg-primary/20 text-primary p-6 rounded-full mb-6">
                    <i class="fas fa-chalkboard-teacher text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">Docentes Expertos</h3>
                <p class="text-white text-sm">
                    Aprende de profesionales destacados con experiencia en la industria espacial y científica, para asegurar una formación de calidad
                </p>
            </div>
            <!-- Beneficio 2 -->
            <div class="flex flex-col items-center p-6 bg-gray-800 rounded-2xl shadow-lg text-center transition-all duration-300 hover:bg-gray-700 hover:scale-105">
                <div class="bg-secondary/20 text-secondary p-6 rounded-full mb-6">
                    <i class="fas fa-flask text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">Investigación Avanzada</h3>
                <p class="text-white text-sm">
                    Accede a proyectos de investigación pioneros, desarrollando soluciones innovadoras para el futuro de la tecnología espacial
                </p>
            </div>
            <!-- Beneficio 3 -->
            <div class="flex flex-col items-center p-6 bg-gray-800 rounded-2xl shadow-lg text-center transition-all duration-300 hover:bg-gray-700 hover:scale-105">
                <div class="bg-accent/20 text-accent p-6 rounded-full mb-6">
                    <i class="fas fa-network-wired text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">Conexiones Globales</h3>
                <p class="text-white text-sm">
                    Forma parte de una comunidad internacional, con acceso a contactos, conferencias y oportunidades de colaboración global
                </p>
            </div>
        </div>
        <!-- Agregando un Slider o Elemento Dinámico -->
        <div class="mt-16 text-center">
            <h3 class="text-3xl font-semibold text-white mb-8">Formación a tu Ritmo</h3>
            <div class="relative">
                <div class="w-full h-80 bg-cover bg-center rounded-lg" style="background-image: url('{{ asset('images/planetas-sistema-solar.webp') }}');"></div>
                <div class="absolute inset-0 bg-black opacity-50 rounded-lg"></div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <p class="text-white text-2xl font-semibold">Cursos y talleres con módulos flexibles para adaptarse a tu horario y necesidades</p>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- SEPARADOR ORGÁNICO -->
<div class="h-48 bg-space-700 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-primary/20 to-secondary/20 opacity-60"></div>
    <div class="absolute inset-0 animate-orbital-movement">
        <div class="w-48 h-48 bg-secondary/20 rounded-full blur-3xl"></div>
    </div>
</div>


<!-- TESTIMONIOS -->
<section class="py-24 bg-gradient-to-br from-cosmic-500 via-cosmic-700 to-black overflow-hidden" data-aos="fade-up">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-5xl font-bold text-white mb-4">Testimonios</h2>
            <p class="text-white text-xl max-w-3xl mx-auto">
                Conoce la experiencia de nuestros estudiantes y cómo nuestros programas han impulsado su éxito
            </p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Testimonio 1 -->
            <div class="p-6 bg-gray-800 rounded-2xl shadow-lg" data-aos="fade-up" data-aos-delay="100">
                <p class="text-white italic mb-4">
                    "El curso de Astronomía Avanzada cambió mi perspectiva. La experiencia práctica y los conocimientos adquiridos me abrieron nuevas puertas."
                </p>
                <h4 class="text-xl font-bold text-white">- Ana Rodríguez</h4>
            </div>
            <!-- Testimonio 2 -->
            <div class="p-6 bg-gray-800 rounded-2xl shadow-lg" data-aos="fade-up" data-aos-delay="200">
                <p class="text-white italic mb-4">
                    "El diplomado en Robótica Espacial me preparó para enfrentar los desafíos de la industria. ¡Totalmente recomendable!"
                </p>
                <h4 class="text-xl font-bold text-white">- Luis Méndez</h4>
            </div>
            <!-- Testimonio 3 -->
            <div class="p-6 bg-gray-800 rounded-2xl shadow-lg" data-aos="fade-up" data-aos-delay="300">
                <p class="text-white italic mb-4">
                    "La maestría en Ciencias Espaciales fue la clave para avanzar en mi carrera. Profesores excepcionales y una metodología innovadora."
                </p>
                <h4 class="text-xl font-bold text-white">- Carla Jiménez</h4>
            </div>
        </div>
    </div>
</section>

<!-- SEPARADOR ORGÁNICO -->
<div class="h-48 bg-space-700 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-primary/20 to-secondary/20 opacity-60"></div>
    <div class="absolute inset-0 animate-orbital-movement">
        <div class="w-48 h-48 bg-secondary/20 rounded-full blur-3xl"></div>
    </div>
</div>


<!-- PREGUNTAS FRECUENTES (FAQ) -->
<section class="py-24 bg-cosmic" data-aos="fade-up">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-5xl font-bold text-white mb-4">Preguntas Frecuentes</h2>
            <p class="text-white text-xl max-w-3xl mx-auto">
                Resolvemos tus dudas sobre nuestros programas y el proceso de inscripción
            </p>
        </div>
        <div class="space-y-6">
            <!-- FAQ 1 -->
            <details class="bg-gray-800 rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 ease-in-out">
                <summary class="text-white font-bold cursor-pointer text-xl flex justify-between items-center">
                    <span>¿Qué requisitos necesito para inscribirme?</span>
                    <svg class="w-6 h-6 text-white transition-transform duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </summary>
                <p class="text-white mt-2">
                    Para inscribirte, debes contar con el título de bachiller y cumplir con los requisitos específicos de cada programa.
                </p>
            </details>
            <!-- FAQ 2 -->
            <details class="bg-gray-800 rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 ease-in-out">
                <summary class="text-white font-bold cursor-pointer text-xl flex justify-between items-center">
                    <span>¿Existen becas o financiamiento?</span>
                    <svg class="w-6 h-6 text-white transition-transform duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </summary>
                <p class="text-white mt-2">
                    Sí, ofrecemos diversas opciones de becas y financiamiento para apoyar a nuestros estudiantes.
                </p>
            </details>
            <!-- FAQ 3 -->
            <details class="bg-gray-800 rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 ease-in-out">
                <summary class="text-white font-bold cursor-pointer text-xl flex justify-between items-center">
                    <span>¿Cuál es la modalidad de los programas?</span>
                    <svg class="w-6 h-6 text-white transition-transform duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </summary>
                <p class="text-white mt-2">
                    Nuestros programas se ofrecen en modalidad presencial, semipresencial y en línea, según las necesidades del curso.
                </p>
            </details>
        </div>
    </div>
</section>

<!-- LLAMADO A LA ACCIÓN (CTA) -->
<section class="py-24 bg-gradient-to-r from-secondary to-primary" data-aos="zoom-in">
    <div class="max-w-7xl mx-auto px-6 text-center">
        <h2 class="text-5xl font-bold text-white mb-4 text-glow animate__animated animate__fadeInUp">¿Listo para transformar tu futuro?</h2>
        <p class="text-xl text-white mb-8 max-w-3xl mx-auto">
            Inscríbete ahora y forma parte de la vanguardia en la exploración espacial. Da el siguiente paso hacia una educación de excelencia
        </p>
        <div class="flex justify-center">
            <a href="#" class="inline-block bg-cosmic text-white font-bold py-3 px-8 rounded-full shadow-xl hover:scale-105 hover:shadow-2xl transition-all duration-300 transform">
                Inscríbete
            </a>
        </div>
        <div class="mt-8">
            <p class="text-white text-lg italic">¡No dejes pasar esta oportunidad única!</p>
        </div>
    </div>
</section>


<!-- ESTILOS PERSONALIZADOS -->
<style>
    .galactic-title {
        text-shadow: 0 0 40px rgba(76, 175, 255, 0.3),
                     0 0 80px rgba(76, 175, 255, 0.2),
                     0 0 120px rgba(76, 175, 255, 0.1);
    }
    .animate-gradient {
        animation: gradient 3s ease infinite;
        background-size: 400% 400%;
    }
    @keyframes gradient {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    .animate-rotate-slow {
        animation: rotate-slow 20s linear infinite;
    }
    @keyframes rotate-slow {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .animate-float {
        animation: float 3s ease-in-out infinite;
    }
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(10px); }
    }
</style>
@endsection
