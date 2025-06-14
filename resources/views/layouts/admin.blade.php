<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Panel de Administración - UNISEC</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  @vite('resources/css/app.css')
</head>
<body class="bg-black font-['Inter']">
  <!-- Capa de partículas -->
  <div class="fixed inset-0 z-0 pointer-events-none">
    <canvas id="starsCanvas" class="absolute inset-0 w-full h-full"></canvas>
  </div>
  
  <div class="flex h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-gradient-to-b from-primary-500 to-purple-700 shadow-xl h-full p-6 text-gray-100 space-y-6">
      <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3">
        <img src="{{ asset('images/logo.png') }}" alt="Logo de UniSec" class="w-36 h-auto">
      </a>
      <nav class="space-y-4">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-5 py-3 rounded-lg hover:bg-blue-600 transition-all shadow-md">
          <i class="fas fa-home text-lg"></i>
          <span class="ml-3 font-medium">Dashboard</span>
        </a>

        <!-- Gestion de Academica -->
        <div x-data="{ open: false }">
          <button @click="open = !open" class="flex items-center justify-between w-full px-5 py-3 rounded-lg hover:bg-blue-600 transition-all shadow-md">
            <div class="flex items-center space-x-3">
              <i class="fas fa-cogs text-lg"></i>
              <span class="font-medium">Gestión Académica</span>
            </div>
            <i class="fas fa-chevron-down" x-show="!open"></i>
            <i class="fas fa-chevron-up" x-show="open"></i>
          </button>
          <div x-show="open" class="pl-8 space-y-2" x-collapse>
            <a href="{{ route('admin.categorias.index') }}" class="block px-5 py-2 rounded-lg hover:bg-blue-500 transition-all">Categorías</a>
            <a href="{{ route('admin.cursos.index') }}" class="block px-5 py-2 rounded-lg hover:bg-blue-500 transition-all">Cursos</a>
            <a href="{{ route('admin.talleres.index')}}" class="block px-5 py-2 rounded-lg hover:bg-blue-500 transition-all">Talleres</a>
            <a href="#" class="block px-5 py-2 rounded-lg hover:bg-blue-500 transition-all">Ponencias</a>
          </div>
        </div>

        <!-- Gestion de Concursos -->
        <div x-data="{ open: false }">
          <button @click="open = !open" class="flex items-center justify-between w-full px-5 py-3 rounded-lg hover:bg-blue-600 transition-all shadow-md">
            <div class="flex items-center space-x-3">
              <i class="fa-solid fa-medal"></i>
              <span class="font-medium">Gestión Concursos</span>
            </div>
            <i class="fas fa-chevron-down" x-show="!open"></i>
            <i class="fas fa-chevron-up" x-show="open"></i>
          </button>
          <div x-show="open" class="pl-8 space-y-2" x-collapse>
            <a href="{{ route('admin.concursos.index') }}" class="block px-5 py-2 rounded-lg hover:bg-blue-500 transition-all">Concursos</a>
            <a href="{{ route('admin.concursos.convocatorias.index') }}" class="block px-5 py-2 rounded-lg hover:bg-blue-500 transition-all">Convocatorias</a>
            <a href="{{ route('admin.concursos.pre-registros.index') }}" class="block px-5 py-2 rounded-lg hover:bg-blue-500 transition-all">Pre-Registro</a>
          </div>
        </div>

        <!-- Gestion de Congresos -->
        <div x-data="{ open: false }">
          <button @click="open = !open" class="flex items-center justify-between w-full px-5 py-3 rounded-lg hover:bg-blue-600 transition-all shadow-md">
            <div class="flex items-center space-x-3">
              <i class="fa-solid fa-graduation-cap"></i>
              <span class="font-medium">Gestión Congresos</span>
            </div>
            <i class="fas fa-chevron-down" x-show="!open"></i>
            <i class="fas fa-chevron-up" x-show="open"></i>
          </button>
          <div x-show="open" class="pl-8 space-y-2" x-collapse>
            <a href="{{ route('admin.congresos.index') }}" class="block px-5 py-2 rounded-lg hover:bg-blue-500 transition-all">Congresos</a>
            <a href="{{ route('admin.congresos.convocatorias.index') }}" class="block px-5 py-2 rounded-lg hover:bg-blue-500 transition-all">Convocatorias</a>
            <a href="{{ route('admin.congresos.inscripciones.index')  }}" class="block px-5 py-2 rounded-lg hover:bg-blue-500 transition-all">Inscripciones</a>
          </div>
        </div>


         <!-- Gestion de Noticias -->
         <div x-data="{ open: false }">
          <button @click="open = !open" class="flex items-center justify-between w-full px-5 py-3 rounded-lg hover:bg-blue-600 transition-all shadow-md">
            <div class="flex items-center space-x-3">
              <i class="fas fa-newspaper"></i>
              <span class="font-medium">Gestión Noticias</span>
            </div>
            <i class="fas fa-chevron-down" x-show="!open"></i>
            <i class="fas fa-chevron-up" x-show="open"></i>
          </button>
          <div x-show="open" class="pl-8 space-y-2" x-collapse>
            <a href="{{ route('admin.noticias.secciones.index') }}" class="block px-5 py-2 rounded-lg hover:bg-blue-500 transition-all">Secciones</a>
            <a href="{{ route('admin.noticias.noticia.index') }}" class="block px-5 py-2 rounded-lg hover:bg-blue-500 transition-all">Noticias</a>
          </div>
        </div>

        <div x-data="{ open: false }">
          <button @click="open = !open" class="flex items-center justify-between w-full px-5 py-3 rounded-lg hover:bg-blue-600 transition-all shadow-md">
            <div class="flex items-center space-x-3">
              <i class="fas fa-user-tie text-lg"></i>
              <span class="font-medium">Gestión de Usuarios</span>
            </div>
            <i class="fas fa-chevron-down" x-show="!open"></i>
            <i class="fas fa-chevron-up" x-show="open"></i>
          </button>
          <div x-show="open" class="pl-8 space-y-2" x-collapse>
            <a href="{{ route('admin.users.index') }}" class="block px-5 py-2 rounded-lg hover:bg-blue-500 transition-all">Usuarios</a>
            <a href="{{ route('admin.ponentes.index') }}" class="block px-5 py-2 rounded-lg hover:bg-blue-500 transition-all">Ponentes</a>
          </div>
        </div>

        <div x-data="{ open: false }">
          <button @click="open = !open" class="flex items-center justify-between w-full px-5 py-3 rounded-lg hover:bg-blue-600 transition-all shadow-md">
            <div class="flex items-center space-x-3">
              <i class="fas fa-file-invoice text-lg"></i>
              <span class="font-medium">Administración Financiera</span>
            </div>
            <i class="fas fa-chevron-down" x-show="!open"></i>
            <i class="fas fa-chevron-up" x-show="open"></i>
          </button>
          <div x-show="open" class="pl-8 space-y-2" x-collapse>
           
            <a href="{{ route('admin.pagos-terceros.index') }}" class="block px-5 py-2 rounded-lg hover:bg-blue-500 transition-all">Pagos Transferencias</a>
            <a href="{{ route('admin.becas') }}" class="block px-5 py-2 rounded-lg hover:bg-blue-500 transition-all">Becas</a>
          </div>
        </div>

        <div x-data="{ open: false }">
          <button @click="open = !open" class="flex items-center justify-between w-full px-5 py-3 rounded-lg hover:bg-blue-600 transition-all shadow-md">
            <div class="flex items-center space-x-3">
              <i class="fas fa-file-invoice text-lg"></i>
              <span class="font-medium">Pagos con PayPal</span>
            </div>
            <i class="fas fa-chevron-down" x-show="!open"></i>
            <i class="fas fa-chevron-up" x-show="open"></i>
          </button>
          <div x-show="open" class="pl-8 space-y-2" x-collapse>
            <a href="{{ route('admin.pagos.index') }}" class="block px-5 py-2 rounded-lg hover:bg-blue-500 transition-all">Pagos Concursos Pre-Registros</a>
            <a href="{{ route('admin.congresos.pagos.index') }}" class="block px-5 py-2 rounded-lg hover:bg-blue-500 transition-all">Pagos Congresos Inscripciones </a>
          </div>
        </div>

        <div x-data="{ open: false }">
          <button @click="open = !open" class="flex items-center justify-between w-full px-5 py-3 rounded-lg hover:bg-blue-600 transition-all shadow-md">
            <div class="flex items-center space-x-3">
              <i class="fas fa-chart-line text-lg"></i>
              <span class="font-medium">Reportes y Estadísticas</span>
            </div>
            <i class="fas fa-chevron-down" x-show="!open"></i>
            <i class="fas fa-chevron-up" x-show="open"></i>
          </button>
          <div x-show="open" class="pl-8 space-y-2" x-collapse>
            <a href="{{ route('admin.reportes-estadisticas') }}" class="block px-5 py-2 rounded-lg hover:bg-blue-500 transition-all">Reportes</a>
          </div>
        </div>

        <div x-data="{ open: false }">
          <button @click="open = !open" class="flex items-center justify-between w-full px-5 py-3 rounded-lg hover:bg-blue-600 transition-all shadow-md">
            <div class="flex items-center space-x-3">
              <i class="fas fa-user text-lg"></i>
              <span class="font-medium">{{ Auth::user()->name }}</span>
            </div>
            <i class="fas fa-chevron-down" x-show="!open"></i>
            <i class="fas fa-chevron-up" x-show="open"></i>
          </button>
          <div x-show="open" class="pl-8 space-y-2" x-collapse>
            <a href="#" class="block px-5 py-2 rounded-lg hover:bg-blue-500 transition-all">Perfil</a>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="w-full text-left px-4 py-2 text-gray-300 hover:text-white hover:bg-gray-700">Cerrar Sesión</button>
            </form>
          </div>
        </div>


      </nav>
    </aside>
    
    <!-- Contenido Principal -->
    <main class="flex-1 p-8 overflow-auto  shadow-md rounded-lg">
      @yield('contenido')
    </main>
  </div>

  @vite('resources/js/app.js')
  @stack('scripts')
</body>
</html>