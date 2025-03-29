@extends('layouts.user')

@section('titulo', 'Espacio')

@section('contenido')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Sección de introducción -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-white mb-4">Exploración Espacial Interactiva</h1>
            <p class="text-xl text-gray-300 max-w-3xl mx-auto">Embárcate en un viaje fascinante a través de nuestro sistema
                solar. Explora planetas, lunas y otros cuerpos celestes en esta experiencia inmersiva proporcionada por NASA
                Eyes.</p>
        </div>

        <!-- Instrucciones de uso -->
        <div class="bg-gradient-to-r from-blue-900/50 to-purple-900/50 rounded-lg p-6 mb-8 backdrop-blur-sm">
            <h2 class="text-2xl font-semibold text-white mb-4">Guía de Exploración</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="flex items-start space-x-3">
                    <i class="fas fa-mouse text-blue-400 text-2xl mt-1"></i>
                    <div>
                        <h3 class="text-lg font-medium text-white">Navegación</h3>
                        <p class="text-gray-300">Usa el mouse para rotar y el scroll para hacer zoom</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <i class="fas fa-info-circle text-blue-400 text-2xl mt-1"></i>
                    <div>
                        <h3 class="text-lg font-medium text-white">Información</h3>
                        <p class="text-gray-300">Haz clic en cualquier objeto para ver sus detalles</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <i class="fas fa-clock text-blue-400 text-2xl mt-1"></i>
                    <div>
                        <h3 class="text-lg font-medium text-white">Tiempo Real</h3>
                        <p class="text-gray-300">Observa las posiciones actuales de los planetas</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Visualizador NASA Eyes con Pestañas -->
        <h2
            class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400 mb-6 text-center">
            Interactúa con Nuestro Sistema Solar</h2>

        <!-- Sistema de Pestañas -->
        <div class="mb-4 border-b border-blue-500/30">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="spaceViewTabs" role="tablist">
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 text-blue-400 border-b-2 border-blue-400 rounded-t-lg active"
                        id="solar-system-tab" data-tabs-target="#solar-system" type="button" role="tab"
                        aria-controls="solar-system" aria-selected="true">
                        Sistema Solar
                    </button>
                </li>
                <li class="mr-2" role="presentation">
                    <button
                        class="inline-block p-4 text-gray-400 hover:text-blue-400 border-b-2 border-transparent hover:border-blue-400 rounded-t-lg"
                        id="mercury-tab" data-tabs-target="#mercury" type="button" role="tab" aria-controls="mercury"
                        aria-selected="false">
                        Mercurio
                    </button>
                </li>
                <li class="mr-2" role="presentation">
                    <button
                        class="inline-block p-4 text-gray-400 hover:text-blue-400 border-b-2 border-transparent hover:border-blue-400 rounded-t-lg"
                        id="venus-tab" data-tabs-target="#venus" type="button" role="tab" aria-controls="venus"
                        aria-selected="false">
                        Venus
                    </button>
                </li>
                <li class="mr-2" role="presentation">
                    <button
                        class="inline-block p-4 text-gray-400 hover:text-blue-400 border-b-2 border-transparent hover:border-blue-400 rounded-t-lg"
                        id="earth-tab" data-tabs-target="#earth" type="button" role="tab" aria-controls="earth"
                        aria-selected="false">
                        Tierra
                    </button>
                </li>
                <li class="mr-2" role="presentation">
                    <button
                        class="inline-block p-4 text-gray-400 hover:text-blue-400 border-b-2 border-transparent hover:border-blue-400 rounded-t-lg"
                        id="mars-tab" data-tabs-target="#mars" type="button" role="tab" aria-controls="mars"
                        aria-selected="false">
                        Marte
                    </button>
                </li>
                <li class="mr-2" role="presentation">
                    <button
                        class="inline-block p-4 text-gray-400 hover:text-blue-400 border-b-2 border-transparent hover:border-blue-400 rounded-t-lg"
                        id="jupiter-tab" data-tabs-target="#jupiter" type="button" role="tab" aria-controls="jupiter"
                        aria-selected="false">
                        Jupiter
                    </button>
                </li>
                <li class="mr-2" role="presentation">
                    <button
                        class="inline-block p-4 text-gray-400 hover:text-blue-400 border-b-2 border-transparent hover:border-blue-400 rounded-t-lg"
                        id="saturn-tab" data-tabs-target="#saturn" type="button" role="tab" aria-controls="saturn"
                        aria-selected="false">
                        Saturno
                    </button>
                </li>
                <li class="mr-2" role="presentation">
                    <button
                        class="inline-block p-4 text-gray-400 hover:text-blue-400 border-b-2 border-transparent hover:border-blue-400 rounded-t-lg"
                        id="uranus-tab" data-tabs-target="#uranus" type="button" role="tab" aria-controls="uranus"
                        aria-selected="false">
                        Urano
                    </button>
                </li>
                <li class="mr-2" role="presentation">
                    <button
                        class="inline-block p-4 text-gray-400 hover:text-blue-400 border-b-2 border-transparent hover:border-blue-400 rounded-t-lg"
                        id="neptune-tab" data-tabs-target="#neptune" type="button" role="tab" aria-controls="neptune"
                        aria-selected="false">
                        Neptuno
                    </button>
                </li>
            </ul>
        </div>

        <!-- Contenido de las Pestañas -->
        <div id="spaceViewContent">
            <div class="relative mb-6 rounded-lg overflow-hidden shadow-2xl border border-blue-500/30 bg-black/20 backdrop-blur-sm group hover:border-blue-400/40 transition-all duration-500"
                id="solar-system" role="tabpanel" aria-labelledby="solar-system-tab">
                <div class="aspect-w-16 aspect-h-9 relative mb-6">
                    <iframe src="https://eyes.nasa.gov/apps/solar-system/#/home" allowfullscreen class="w-full h-full"
                        style="min-height: 850px"></iframe>
                </div>
            </div>

            <div class="hidden relative mb-6 rounded-lg overflow-hidden shadow-2xl border border-blue-500/30 bg-black/20 backdrop-blur-sm group hover:border-blue-400/40 transition-all duration-500"
                id="mercury" role="tabpanel" aria-labelledby="mercury-tab">
                <div class="aspect-w-16 aspect-h-9 relative mb-6">
                    <iframe src="https://eyes.nasa.gov/apps/solar-system/#/mercury" allowfullscreen class="w-full h-full"
                        style="min-height: 850px"></iframe>
                </div>
            </div>

            <div class="hidden relative mb-6 rounded-lg overflow-hidden shadow-2xl border border-blue-500/30 bg-black/20 backdrop-blur-sm group hover:border-blue-400/40 transition-all duration-500"
                id="venus" role="tabpanel" aria-labelledby="venus-tab">
                <div class="aspect-w-16 aspect-h-9 relative mb-6">
                    <iframe src="https://eyes.nasa.gov/apps/solar-system/#/venus" allowfullscreen class="w-full h-full"
                        style="min-height: 850px"></iframe>
                </div>
            </div>

            <div class="hidden relative mb-6 rounded-lg overflow-hidden shadow-2xl border border-blue-500/30 bg-black/20 backdrop-blur-sm group hover:border-blue-400/40 transition-all duration-500"
                id="earth" role="tabpanel" aria-labelledby="earth-tab">
                <div class="aspect-w-16 aspect-h-9 relative mb-6">
                    <iframe src="https://eyes.nasa.gov/apps/earth/#/" allowfullscreen class="w-full h-full"
                        style="min-height: 850px"></iframe>
                </div>
            </div>

            <div class="hidden relative mb-6 rounded-lg overflow-hidden shadow-2xl border border-blue-500/30 bg-black/20 backdrop-blur-sm group hover:border-blue-400/40 transition-all duration-500"
                id="mars" role="tabpanel" aria-labelledby="mars-tab">
                <div class="aspect-w-16 aspect-h-9 relative mb-6">
                    <iframe src="https://eyes.nasa.gov/apps/solar-system/#/mars" allowfullscreen class="w-full h-full"
                        style="min-height: 850px"></iframe>
                </div>
            </div>

            <div class="hidden relative mb-6 rounded-lg overflow-hidden shadow-2xl border border-blue-500/30 bg-black/20 backdrop-blur-sm group hover:border-blue-400/40 transition-all duration-500"
                id="jupiter" role="tabpanel" aria-labelledby="jupiter-tab">
                <div class="aspect-w-16 aspect-h-9 relative mb-6">
                    <iframe src="https://eyes.nasa.gov/apps/solar-system/#/jupiter" allowfullscreen class="w-full h-full"
                        style="min-height: 850px"></iframe>
                </div>
            </div>

            <div class="hidden relative mb-6 rounded-lg overflow-hidden shadow-2xl border border-blue-500/30 bg-black/20 backdrop-blur-sm group hover:border-blue-400/40 transition-all duration-500"
                id="saturn" role="tabpanel" aria-labelledby="saturn-tab">
                <div class="aspect-w-16 aspect-h-9 relative mb-6">
                    <iframe src="https://eyes.nasa.gov/apps/solar-system/#/saturn" allowfullscreen class="w-full h-full"
                        style="min-height: 850px"></iframe>
                </div>
            </div>

            <div class="hidden relative mb-6 rounded-lg overflow-hidden shadow-2xl border border-blue-500/30 bg-black/20 backdrop-blur-sm group hover:border-blue-400/40 transition-all duration-500"
                id="uranus" role="tabpanel" aria-labelledby="uranus-tab">
                <div class="aspect-w-16 aspect-h-9 relative mb-6">
                    <iframe src="https://eyes.nasa.gov/apps/solar-system/#/uranus" allowfullscreen class="w-full h-full"
                        style="min-height: 850px"></iframe>
                </div>
            </div>

            <div class="hidden relative mb-6 rounded-lg overflow-hidden shadow-2xl border border-blue-500/30 bg-black/20 backdrop-blur-sm group hover:border-blue-400/40 transition-all duration-500"
                id="neptune" role="tabpanel" aria-labelledby="neptune-tab">
                <div class="aspect-w-16 aspect-h-9 relative mb-6">
                    <iframe src="https://eyes.nasa.gov/apps/solar-system/#/neptune" allowfullscreen class="w-full h-full"
                        style="min-height: 850px"></iframe>
                </div>
            </div>
        </div>

        <!-- Script para el funcionamiento de las pestañas -->
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const tabs = document.querySelectorAll('[role="tab"]');
                const tabPanels = document.querySelectorAll('[role="tabpanel"]');

                tabs.forEach(tab => {
                    tab.addEventListener('click', function () {
                        // Desactivar todas las pestañas
                        tabs.forEach(t => {
                            t.classList.remove('text-blue-400', 'border-blue-400');
                            t.classList.add('text-gray-400', 'border-transparent');
                            t.setAttribute('aria-selected', 'false');
                        });

                        // Activar la pestaña seleccionada
                        this.classList.remove('text-gray-400', 'border-transparent');
                        this.classList.add('text-blue-400', 'border-blue-400');
                        this.setAttribute('aria-selected', 'true');

                        // Ocultar todos los paneles
                        tabPanels.forEach(panel => {
                            panel.classList.add('hidden');
                        });

                        // Mostrar el panel seleccionado
                        const targetPanel = document.querySelector(this.getAttribute('data-tabs-target'));
                        targetPanel.classList.remove('hidden');
                    });
                });
            });
        </script>

        <!-- Datos Curiosos y Últimos Descubrimientos -->
        <div class="space-y-8">
            <!-- Sección de Datos Curiosos -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div
                    class="bg-gradient-to-br from-blue-900/30 to-purple-900/30 rounded-lg p-6 backdrop-blur-sm border border-blue-500/20 hover:border-blue-400/40 transition-all duration-300">
                    <i class="fas fa-sun text-yellow-400 text-3xl mb-4"></i>
                    <h3 class="text-lg font-medium text-white mb-2">El Sol</h3>
                    <p class="text-gray-300 mb-2">Contiene el 99.86% de la masa del sistema solar</p>
                    <ul class="text-gray-400 text-sm space-y-1">
                        <li>• Temperatura superficial: 5,500°C</li>
                        <li>• Edad: 4.6 mil millones de años</li>
                        <li>• Diámetro: 1.4 millones de km</li>
                    </ul>
                </div>
                <div
                    class="bg-gradient-to-br from-blue-900/30 to-purple-900/30 rounded-lg p-6 backdrop-blur-sm border border-blue-500/20 hover:border-blue-400/40 transition-all duration-300">
                    <i class="fas fa-meteor text-red-400 text-3xl mb-4"></i>
                    <h3 class="text-lg font-medium text-white mb-2">Asteroides</h3>
                    <p class="text-gray-300 mb-2">Más de 1 millón en el cinturón principal</p>
                    <ul class="text-gray-400 text-sm space-y-1">
                        <li>• Ceres: El asteroide más grande</li>
                        <li>• Velocidad promedio: 25 km/s</li>
                        <li>• Origen: Formación del sistema solar</li>
                    </ul>
                </div>
                <div
                    class="bg-gradient-to-br from-blue-900/30 to-purple-900/30 rounded-lg p-6 backdrop-blur-sm border border-blue-500/20 hover:border-blue-400/40 transition-all duration-300">
                    <i class="fas fa-globe-americas text-blue-400 text-3xl mb-4"></i>
                    <h3 class="text-lg font-medium text-white mb-2">La Tierra</h3>
                    <p class="text-gray-300 mb-2">El único planeta conocido con vida</p>
                    <ul class="text-gray-400 text-sm space-y-1">
                        <li>• Edad: 4.54 mil millones de años</li>
                        <li>• 71% superficie de agua</li>
                        <li>• Atmósfera: 78% nitrógeno, 21% oxígeno</li>
                    </ul>
                </div>
                <div
                    class="bg-gradient-to-br from-blue-900/30 to-purple-900/30 rounded-lg p-6 backdrop-blur-sm border border-blue-500/20 hover:border-blue-400/40 transition-all duration-300">
                    <i class="fas fa-rocket text-purple-400 text-3xl mb-4"></i>
                    <h3 class="text-lg font-medium text-white mb-2">Exploración</h3>
                    <p class="text-gray-300 mb-2">Más de 50 años de misiones espaciales</p>
                    <ul class="text-gray-400 text-sm space-y-1">
                        <li>• +500 personas en el espacio</li>
                        <li>• 6 alunizajes tripulados</li>
                        <li>• +40 misiones a Marte</li>
                    </ul>
                </div>
            </div>

            <!-- Últimos Descubrimientos -->
            <div
                class="bg-gradient-to-br from-blue-900/20 to-purple-900/20 rounded-xl p-8 backdrop-blur-sm border border-blue-500/20">
                <h2 class="text-2xl font-bold text-white mb-6">Últimos Descubrimientos Espaciales</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div
                        class="bg-space-900/40 rounded-lg p-6 border border-blue-500/30 hover:border-blue-400/40 transition-all duration-300">
                        <div class="flex items-center mb-4">
                            <i class="fas fa-satellite text-blue-400 text-xl mr-3"></i>
                            <h3 class="text-lg font-medium text-white">Exoplanetas Habitables</h3>
                        </div>
                        <p class="text-gray-300 text-sm">Descubrimiento de nuevos planetas en la zona habitable de sus
                            estrellas, aumentando las posibilidades de encontrar vida extraterrestre.</p>
                    </div>
                    <div
                        class="bg-space-900/40 rounded-lg p-6 border border-blue-500/30 hover:border-blue-400/40 transition-all duration-300">
                        <div class="flex items-center mb-4">
                            <i class="fas fa-atom text-blue-400 text-xl mr-3"></i>
                            <h3 class="text-lg font-medium text-white">Materia Oscura</h3>
                        </div>
                        <p class="text-gray-300 text-sm">Nuevas evidencias sobre la distribución de materia oscura en el
                            universo y su papel en la formación de galaxias.</p>
                    </div>
                    <div
                        class="bg-space-900/40 rounded-lg p-6 border border-blue-500/30 hover:border-blue-400/40 transition-all duration-300">
                        <div class="flex items-center mb-4">
                            <i class="fas fa-meteor text-blue-400 text-xl mr-3"></i>
                            <h3 class="text-lg font-medium text-white">Agua en Marte</h3>
                        </div>
                        <p class="text-gray-300 text-sm">Confirmación de depósitos de agua subterránea en Marte, aumentando
                            las posibilidades de futuras misiones tripuladas.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection