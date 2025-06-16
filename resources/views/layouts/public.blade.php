<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('titulo') - UNISEC</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  @vite('resources/css/app.css')
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="bg-cosmic text-base font-['Inter']">
  
  <!-- Barra de progreso superior -->
  <div class="h-1 bg-secondary/20 fixed top-0 left-0 right-0 z-50">
    <div class="h-full bg-secondary-900 transition-all duration-300 ease-out" id="progress-bar"></div>
  </div>

   <!-- Capa de partículas -->
  <div class="fixed inset-0 z-0 pointer-events-none">
    <canvas id="starsCanvas" class="absolute inset-0 w-full h-full"></canvas>
  </div>

 <!-- NAVBAR RESPONSIVO -->
  <nav x-data="{ open: false }" class="sticky top-0 w-full bg-gradient-primary shadow-lg z-50 backdrop-blur-md bg-opacity-90 transition duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-20">
        
        <!-- Logo -->
        <a href="{{ route('inicio') }}" class="flex items-center mr-8">
          <img src="{{ asset('images/logo.png') }}" alt="Logo de UNISEC" class="w-48 h-auto">
        </a>

        <!-- Menú principal -->
        <div class="hidden lg:flex items-center space-x-8">
          @foreach([
            'inicio' => ['Inicio', 'fas fa-home'],
            'acerca' => ['Acerca de', 'fas fa-info-circle'], 
            'espacio' => ['Espacio', 'fa-solid fa-user-astronaut'],
            'convocatorias.index' => ['Convocatorias', 'fas fa-tags'], 
            'blog' => ['Blog', 'fas fa-blog'], 
            'contacto' => ['Contacto', 'fas fa-envelope'], 
            'login' => ['Ingresar', 'fas fa-sign-in-alt'], 
            'register' => ['Registrarse', 
            'fas fa-user-plus']
          ] as $route => [$label, $icon])
            <a href="{{ route($route) }}" class="relative text-gray-200 hover:text-white px-3 py-2 text-sm font-medium flex items-center space-x-2 transition-all duration-300 
              before:absolute before:-bottom-1 before:left-0 before:w-0 before:h-0.5 before:bg-secondary-500 before:transition-all before:duration-300
              hover:before:w-full">
              <i class="{{ $icon }} text-lg"></i>
              <span>{{ $label }}</span>
            </a>
          @endforeach
        </div>

        <!-- Botón Menú Móvil -->
        <button @click="open = !open" class="lg:hidden text-gray-200 focus:outline-none">
          <i :class="open ? 'fas fa-times' : 'fas fa-bars'" class="text-2xl"></i>
        </button>
      </div>

      <!-- Menú desplegable móvil -->
      <div x-show="open" @click.away="open = false" x-transition class="lg:hidden bg-tech-dark rounded-lg mt-2 py-4 px-6 space-y-4">
        @foreach([
          'inicio' => ['Inicio', 'fas fa-home'],
          'acerca' => ['Acerca de', 'fas fa-info-circle'],
          'espacio' => ['Espacio', 'fa-solid fa-user-astronaut'],
          'convocatorias.index' => ['Convocatorias', 'fas fa-tags'],
          'blog' => ['Blog', 'fas fa-blog'], 
          'contacto' => ['Contacto', 
          'fas fa-envelope'], 
          'login' => ['Ingresar', 'fas fa-sign-in-alt'],
          'register' => ['Registrarse', 'fas fa-user-plus']
          ] as $route => [$label, $icon])
          <a href="{{ route($route) }}" class="block text-gray-200 hover:text-white text-base transition-colors text-center flex items-center justify-center space-x-2">
            <i class="{{ $icon }} text-lg"></i>
            <span>{{ $label }}</span>
          </a>
        @endforeach
      </div>
    </div>
  </nav>


  <!-- CONTENIDO PRINCIPAL -->
  <main class="flex-1 relative overflow-hidden">
    @yield('contenido')
  </main>

  <!-- FOOTER RESPONSIVO -->
  <footer class="bg-gradient-primary text-gray-300 mt-24 py-12 border-t border-tech-medium">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 text-center sm:text-left">
      
      <!-- Logo y descripción -->
      <div class="space-y-4">
        <img src="{{ asset('images/logo.png') }}" alt="Logo de UniSec" class="w-32 h-auto mx-auto sm:mx-0">
        <p class="text-sm text-white">Innovación cosmonáutica</p>
      </div>

      <!-- Menú de navegación -->
      <div>
        <h3 class="text-gray-100 text-lg font-semibold mb-4">Explorar</h3>
        <ul class="space-y-2">
          @foreach(['espacio' => 'Espacio', 'miembros' => 'Miembros', 'blog' => 'Blog Técnico'] as $route => $label)
            <li>
              <a href="{{ route($route) }}" class="text-sm hover:text-white transition-colors">
                {{ $label }}
              </a>
              
            </li>
          @endforeach
        </ul>
      </div>

      <!-- Información de contacto -->
      <div>
        <h3 class="text-gray-100 text-lg font-semibold mb-4">Contacto</h3>
        <p class="text-sm text-white"><i class="fas fa-envelope mr-2"></i>unisecmx@unisecmexico.mx</p>
      </div>

      <!-- Redes Sociales -->
      <div>
        <h3 class="text-gray-100 text-lg font-semibold mb-4">Conecta con nosotros</h3>
        <div class="flex justify-center sm:justify-start space-x-4">
          @php
            $socialIcons = ['facebook' => 'fab fa-facebook-f', 'twitter' => 'fab fa-twitter', 'instagram' => 'fab fa-instagram'];
          @endphp
          @foreach($socialIcons as $social => $icon)
            <a href="#" class="p-3 bg-tech-dark rounded-lg hover:bg-primary transition-colors">
              <i class="{{ $icon }} text-gray-300 hover:text-white transition-colors text-xl"></i>
            </a>
          @endforeach
        </div>
      </div>

    </div>

    <!-- Copyright -->
    <div class="pt-8 text-center text-sm text-gray-500">
      &copy; {{ date('Y') }} UNISEC México. Todos los derechos reservados.
    </div>
  </footer>

  @vite('resources/js/app.js')
  @vite('resources/js/typed.js')
</body>
</html>
