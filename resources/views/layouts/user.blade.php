<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('titulo') - UNISEC</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  @vite('resources/css/app.css')
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="bg-cosmic text-base font-['Inter']">


  <!-- Capa de partículas -->
  <div class="fixed inset-0 z-0 pointer-events-none">
    <canvas id="starsCanvas" class="absolute inset-0 w-full h-full"></canvas>
  </div>

  <!-- NAVBAR RESPONSIVO -->
  <nav x-data="{ open: false, dropdownOpen: false }"
    class="sticky top-0 w-full bg-gradient-primary shadow-lg z-50 backdrop-blur-md bg-opacity-90 transition duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-20">

        <!-- Logo -->
        <a href="{{ route('inicio') }}" class="flex items-center">
          <img src="{{ asset('images/logo.png') }}" alt="Logo de UniSec" class="w-64 h-auto">
        </a>

        <!-- Menú principal (versión escritorio) -->
        <div class="hidden lg:flex items-center space-x-6">
          <a href="{{ route('user.inicio') }}"
            class="relative text-gray-200 hover:text-white px-3 py-2 text-sm font-medium flex items-center space-x-2 transition-all duration-300 before:absolute before:-bottom-1 before:left-0 before:w-0 before:h-0.5 before:bg-secondary-500 before:transition-all before:duration-300 hover:before:w-full">
            <i class="fas fa-home"></i>
            <span>Inicio</span>
          </a>

          <a href="{{ route('user.espacio') }}"
            class="relative text-gray-200 hover:text-white px-3 py-2 text-sm font-medium flex items-center space-x-2 transition-all duration-300 before:absolute before:-bottom-1 before:left-0 before:w-0 before:h-0.5 before:bg-secondary-500 before:transition-all before:duration-300 hover:before:w-full">
            <i class="fa-solid fa-user-astronaut"></i>
            <span>Espacio</span>
          </a>

          <a href="{{ route('user.noticias') }}"
            class="relative text-gray-200 hover:text-white px-3 py-2 text-sm font-medium flex items-center space-x-2 transition-all duration-300 before:absolute before:-bottom-1 before:left-0 before:w-0 before:h-0.5 before:bg-secondary-500 before:transition-all before:duration-300 hover:before:w-full">
            <i class="fa-solid fa-newspaper"></i>
            <span>Noticias</span>
          </a>

          <!-- Dropdown de Eventos -->
          <div class="relative" x-data="{ open: false, timeout: null }" @mouseleave="timeout = setTimeout(() => open = false, 250)" @mouseenter="clearTimeout(timeout)">
            <button @click="open = !open" @mouseenter="open = true"
              class="relative text-gray-200 hover:text-white px-3 py-2 text-sm font-medium flex items-center space-x-2 focus:outline-none transition-all duration-300 before:absolute before:-bottom-1 before:left-0 before:w-0 before:h-0.5 before:bg-secondary-500 before:transition-all before:duration-300 hover:before:w-full group">
              <i class="fas fa-graduation-cap transition-transform group-hover:scale-110 duration-300"></i>
              <span>Eventos</span>
              <i class="fas fa-chevron-down transition-transform duration-300" :class="{'rotate-180': open}"></i>
            </button>
            <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
              class="absolute left-0 mt-2 w-48 bg-gray-800/95 backdrop-blur-sm border border-gray-600/50 rounded-lg shadow-xl py-2 z-50">
              <a href="{{ route('user.concursos.index') }}"
                class="block px-4 py-2.5 text-gray-300 hover:text-white hover:bg-gray-700/50 transition-colors duration-200">
                <i class="fas fa-trophy mr-2 opacity-75"></i>Concursos
              </a>
              <a href="{{ route('user.congresos.index') }}"
                class="block px-4 py-2.5 text-gray-300 hover:text-white hover:bg-gray-700/50 transition-colors duration-200 first:rounded-t-lg last:rounded-b-lg">
                <i class="fas fa-graduation-cap mr-2 opacity-75"></i>Congresos
              </a>
            </div>
          </div>

          <!-- Dropdown de Pagos -->
          <div class="relative" x-data="{ open: false, timeout: null }" @mouseleave="timeout = setTimeout(() => open = false, 300)" @mouseenter="clearTimeout(timeout)">
            <button @click="open = !open" @mouseenter="open = true"
              class="relative text-gray-200 hover:text-white px-3 py-2 text-sm font-medium flex items-center space-x-2 focus:outline-none transition-all duration-300 before:absolute before:-bottom-1 before:left-0 before:w-0 before:h-0.5 before:bg-secondary-500 before:transition-all before:duration-300 hover:before:w-full group">
              <i class="fas fa-tags transition-transform group-hover:scale-110 duration-300"></i>
              <span>Pagos</span>
              <i class="fas fa-chevron-down transition-transform duration-300" :class="{'rotate-180': open}"></i>
            </button>
            <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
              class="absolute left-0 mt-2 w-48 bg-gray-800/95 backdrop-blur-sm border border-gray-600/50 rounded-lg shadow-xl py-2 z-50">
              <a href="{{ route('user.pagos') }}"
                class="block px-4 py-2.5 text-gray-300 hover:text-white hover:bg-gray-700/50 transition-colors duration-200 first:rounded-t-lg last:rounded-b-lg">
                <i class="fas fa-credit-card mr-2 opacity-75"></i>Mis Pagos
              </a>
              <a href="{{ route('user.soporte') }}"
                class="block px-4 py-2.5 text-gray-300 hover:text-white hover:bg-gray-700/50 transition-colors duration-200">
                <i class="fas fa-headset mr-2 opacity-75"></i>Soporte
              </a>
            </div>
          </div>

          <!-- Dropdown de Usuario -->
          <div class="relative" x-data="{ open: false, timeout: null }" @mouseleave="timeout = setTimeout(() => open = false, 300)" @mouseenter="clearTimeout(timeout)">
            <button @click="open = !open" @mouseenter="open = true"
              class="relative text-gray-200 hover:text-white px-3 py-2 text-sm font-medium flex items-center space-x-2 focus:outline-none transition-all duration-300 before:absolute before:-bottom-1 before:left-0 before:w-0 before:h-0.5 before:bg-secondary-500 before:transition-all before:duration-300 hover:before:w-full group">
              <i class="fas fa-user transition-transform group-hover:scale-110 duration-300"></i>
              <span>{{ Auth::user()->name }}</span>
              <i class="fas fa-chevron-down transition-transform duration-300" :class="{'rotate-180': open}"></i>
            </button>
            <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
              class="absolute left-0 mt-2 w-48 bg-gray-800/95 backdrop-blur-sm border border-gray-600/50 rounded-lg shadow-xl py-2 z-50">
              <a href="#" class="block px-4 py-2.5 text-gray-300 hover:text-white hover:bg-gray-700/50 transition-colors duration-200 first:rounded-t-lg">
                <i class="fas fa-user-circle mr-2 opacity-75"></i>Perfil
              </a>
              <a href="{{ route('user.inscripciones') }}" class="block px-4 py-2.5 text-gray-300 hover:text-white hover:bg-gray-700/50 transition-colors duration-200">
                <i class="fas fa-clipboard-list mr-2 opacity-75"></i>Mis Inscripciones
              </a>
              <a href="{{ route('user.certificados') }}" class="block px-4 py-2.5 text-gray-300 hover:text-white hover:bg-gray-700/50 transition-colors duration-200">
                <i class="fas fa-certificate mr-2 opacity-75"></i>Mis Certificados
              </a>
              <a href="{{ route('user.resenas') }}" class="block px-4 py-2.5 text-gray-300 hover:text-white hover:bg-gray-700/50 transition-colors duration-200">
                <i class="fas fa-star mr-2 opacity-75"></i>Mis Reseñas
              </a>
              <a href="{{ route('user.eventos') }}" class="block px-4 py-2.5 text-gray-300 hover:text-white hover:bg-gray-700/50 transition-colors duration-200">
                <i class="fas fa-calendar-alt mr-2 opacity-75"></i>Mis Eventos
              </a>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2.5 text-gray-300 hover:text-white hover:bg-gray-700/50 transition-colors duration-200 last:rounded-b-lg">
                  <i class="fas fa-sign-out-alt mr-2 opacity-75"></i>Cerrar Sesión
                </button>
              </form>
            </div>
          </div>
        </div>

        <!-- Botón Menú Móvil -->
        <button @click="open = !open" class="lg:hidden text-gray-200 focus:outline-none">
          <i :class="open ? 'fas fa-times' : 'fas fa-bars'" class="text-2xl"></i>
        </button>
      </div>
    </div>

    <!-- Menú Móvil -->
    <div x-show="open" @click.away="open = false"
      class="lg:hidden bg-gray-900 text-gray-200 w-full absolute top-20 left-0 py-4 px-6 space-y-4 z-50">
      <a href="{{ route('user.inicio') }}" class="block text-gray-200 hover:text-white">Tablero</a>
      <div x-data="{ dropdown: false }">
        <button @click="dropdown = !dropdown"
          class="w-full text-left flex justify-between text-gray-200 hover:text-white">
          Eventos <i class="fas fa-chevron-down"></i>
        </button>
        <div x-show="dropdown" class="pl-4 space-y-2">
          <a href="{{ route('user.cursos') }}" class="block text-gray-300 hover:text-white">Cursos</a>
          <a href="{{ route('user.talleres') }}" class="block text-gray-300 hover:text-white">Talleres</a>
          <a href="{{ route('user.ponencias') }}" class="block text-gray-300 hover:text-white">Ponencias</a>
          <a href="{{ route('user.concursos.index') }}" class="block text-gray-300 hover:text-white">Concursos</a>
        </div>
      </div>
      <div x-data="{ dropdown: false }">
        <button @click="dropdown = !dropdown"
          class="w-full text-left flex justify-between text-gray-200 hover:text-white">
          Pagos <i class="fas fa-chevron-down"></i>
        </button>
        <div x-show="dropdown" class="pl-4 space-y-2">
          <a href="{{ route('user.pagos') }}" class="block text-gray-300 hover:text-white">Mis Pagos</a>
          <a href="{{ route('user.soporte') }}" class="block text-gray-300 hover:text-white">Soporte</a>
        </div>
      </div>
      <!-- Dropdown de Perfil en móvil -->
      <div x-data="{ open: false }">
        <button @click="open = !open" class="w-full text-left flex justify-between text-gray-200 hover:text-white">
          Perfil <i class="fas fa-chevron-down"></i>
        </button>
        <div x-show="open" class="pl-4 space-y-2">
          <a href="#" class="block text-gray-300 hover:text-white">Editar Perfil</a>
          <a href="{{ route('user.inscripciones') }}" class="block text-gray-300 hover:text-white">Mis Inscripciones</a>
          <a href="{{ route('user.certificados') }}" class="block text-gray-300 hover:text-white">Mis Certificados</a>
          <a href="{{ route('user.resenas') }}" class="block text-gray-300 hover:text-white">Mis Reseñas</a>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-left text-gray-200 hover:text-white">Cerrar Sesión</button>
          </form>
        </div>
      </div>
    </div>
  </nav>


  <!-- CONTENIDO PRINCIPAL -->
  <main class="flex-1 relative overflow-hidden">
    @yield('contenido')
  </main>

  <!-- FOOTER RESPONSIVO -->
  <footer class="bg-gradient-primary text-gray-300 mt-24 py-12 border-t border-tech-medium">
    <div
      class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 text-center sm:text-left">

      <!-- Logo y descripción -->
      <div class="space-y-4">
        <img src="{{ asset('images/logo.png') }}" alt="Logo de UniSec" class="w-64 h-auto mx-auto sm:mx-0">
        <p class="text-sm text-gray-400">Innovación cosmonáutica.</p>
      </div>

      <!-- Menú de navegación -->
      <div>
        <h3 class="text-gray-100 text-lg font-semibold mb-4">Explorar</h3>
        <ul class="space-y-2">
          @foreach(['miembros' => 'Miembros', 'blog' => 'Blog Técnico'] as $route => $label)
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
        <p class="text-sm text-white"><i class="fas fa-envelope mr-2"></i>contacto@unisec.aero</p>
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