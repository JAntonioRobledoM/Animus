<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animus - Panel Principal</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'abstergo-blue': '#0082CA',
                        'abstergo-light-blue': '#00a8ff',
                        'abstergo-dark': '#121212',
                        'abstergo-gray': '#333333',
                    },
                    fontFamily: {
                        'rajdhani': ['Rajdhani', 'sans-serif'],
                    },
                }
            }
        }
    </script>
</head>
<body class="bg-abstergo-dark font-rajdhani text-white flex flex-col min-h-screen">
    <!-- Barra de navegación superior -->
    <nav class="bg-black/80 border-b border-abstergo-blue py-4 px-6">
        <div class="flex justify-between items-center">
            <div class="flex items-center">
                <img src="{{ asset('images/abstergo-logo.png') }}" alt="Abstergo" class="h-8 mr-4">
                <span class="text-2xl font-semibold text-abstergo-blue tracking-wider">ANIMUS OS</span>
            </div>
            
            <div class="flex items-center space-x-4">
                <!-- Enlaces de navegación -->
                <a href="{{ route('dashboard') }}" class="text-abstergo-blue border-b border-abstergo-blue">
                    Dashboard
                </a>
                <a href="{{ route('recuerdos.index') }}" class="text-white hover:text-abstergo-blue transition-colors">
                    Gestionar Recuerdos
                </a>
                
                <span class="mx-6 text-sm opacity-80">Usuario: {{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-abstergo-blue/20 hover:bg-abstergo-blue/30 text-white px-4 py-2 rounded transition-all">
                        Cerrar Sesión
                    </button>
                </form>
            </div>
        </div>
    </nav>
    
    <!-- Contenido principal -->
    <main class="container mx-auto px-4 py-6 flex-grow">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-semibold text-abstergo-blue border-b border-abstergo-blue/30 pb-2">
                Panel de Control del Animus
            </h1>
            
            <!-- Botón para añadir nuevo recuerdo -->
            <a href="{{ route('recuerdos.create') }}" class="bg-abstergo-blue hover:bg-abstergo-light-blue text-white px-4 py-2 rounded transition-colors flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Añadir Nuevo Recuerdo
            </a>
        </div>
        
        <!-- Notificaciones -->
        @if(session('success'))
            <div class="bg-green-900/20 border-l-4 border-green-500 p-4 mb-6 text-green-300">
                {{ session('success') }}
            </div>
        @endif
        
        <!-- Sistema de recuerdos -->
        <section class="mb-10">
            <h2 class="text-xl font-semibold mb-4">Recuerdos Disponibles</h2>
            
            @if($recuerdos->isEmpty())
                <div class="bg-abstergo-blue/10 border border-abstergo-blue/30 rounded p-8 text-center">
                    <p class="mb-4 text-lg">No hay recuerdos genéticos disponibles. ¿Deseas añadir tu primer recuerdo?</p>
                    <a href="{{ route('recuerdos.create') }}" class="inline-block bg-abstergo-blue px-6 py-3 text-white rounded hover:bg-abstergo-light-blue transition-colors">
                        Añadir Primer Recuerdo
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($recuerdos as $recuerdo)
                        <div class="bg-black/50 border border-abstergo-blue/40 rounded overflow-hidden hover:shadow-md hover:shadow-abstergo-blue/20 transition-all">
                            @if($recuerdo->img)
                                <img src="{{ asset($recuerdo->img) }}" alt="{{ $recuerdo->title }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gradient-to-r from-abstergo-dark to-abstergo-gray flex items-center justify-center">
                                    <span class="text-abstergo-blue opacity-50 text-xl">Sin imagen</span>
                                </div>
                            @endif
                            
                            <div class="p-4">
                                <h3 class="text-lg font-semibold mb-1">{{ $recuerdo->title }}</h3>
                                @if($recuerdo->subtitle)
                                    <p class="text-sm text-gray-400 mb-3">{{ $recuerdo->subtitle }}</p>
                                @endif
                                
                                <div class="flex justify-between items-center mt-4">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('recuerdos.show', $recuerdo) }}" class="bg-abstergo-blue/30 hover:bg-abstergo-blue/40 text-white px-2 py-1 rounded text-xs transition-colors">
                                            Ver
                                        </a>
                                        <a href="{{ route('recuerdos.edit', $recuerdo) }}" class="bg-yellow-600/30 hover:bg-yellow-600/40 text-white px-2 py-1 rounded text-xs transition-colors">
                                            Editar
                                        </a>
                                    </div>
                                    <a href="#" class="bg-abstergo-blue px-4 py-2 text-sm rounded hover:bg-abstergo-light-blue transition-colors flex items-center launch-game" data-path="{{ $recuerdo->path }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Sincronizar
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Enlace a gestión completa de recuerdos -->
                <div class="mt-8 text-center">
                    <a href="{{ route('recuerdos.index') }}" class="inline-block bg-abstergo-gray/50 hover:bg-abstergo-gray/70 text-white px-6 py-3 rounded transition-colors">
                        Gestión Avanzada de Recuerdos
                    </a>
                </div>
            @endif
        </section>
    </main>
    
    <!-- Pie de página -->
    <footer class="bg-black/80 border-t border-abstergo-blue py-4 px-6 text-center text-sm opacity-70 mt-auto">
        <p>ABSTERGO INDUSTRIES &copy; {{ date('Y') }} - ANIMUS OS v0.3</p>
        <p class="mt-1">SISTEMA DE RECUPERACIÓN DE MEMORIAS GENÉTICAS</p>
    </footer>

    <!-- Modal de sincronización -->
    <div id="sync-modal" class="fixed inset-0 bg-black/80 flex flex-col items-center justify-center z-50 hidden">
        <div class="text-abstergo-blue text-4xl mb-4 font-semibold">INICIANDO SINCRONIZACIÓN</div>
        <div class="w-64 h-2 bg-gray-800 rounded-full overflow-hidden">
            <div id="progress-bar" class="h-full bg-abstergo-blue" style="width: 0%"></div>
        </div>
        <div id="loading-text" class="mt-4 text-white">Preparando secuencia genética...</div>
    </div>

    <script>
        // Función para detectar si estamos en Electron
        function isElectron() {
            return window.electron && window.electron.getVersion;
        }

        // Función para lanzar juegos
        async function launchGame(path) {
            if (!path) {
                console.error('Ruta de juego no válida');
                return;
            }
            
            console.log('Intentando lanzar juego:', path);
            
            // Mostrar modal de sincronización
            const syncModal = document.getElementById('sync-modal');
            const progressBar = document.getElementById('progress-bar');
            const loadingText = document.getElementById('loading-text');
            
            syncModal.classList.remove('hidden');
            
            // Simular progreso
            let progress = 0;
            const interval = setInterval(() => {
                progress += 5;
                progressBar.style.width = `${progress}%`;
                
                if (progress === 30) {
                    loadingText.textContent = 'Analizando datos de ADN...';
                } else if (progress === 60) {
                    loadingText.textContent = 'Inicializando entorno virtual...';
                } else if (progress === 90) {
                    loadingText.textContent = 'Abriendo aplicación externa...';
                }
                
                if (progress >= 100) {
                    clearInterval(interval);
                    
                    // Intento abrir la aplicación 
                    setTimeout(async () => {
                        try {
                            // Verificar si estamos en Electron
                            if (isElectron()) {
                                // Usar la API de Electron
                                console.log('Usando API de Electron para lanzar:', path);
                                await window.electron.launchGame(path);
                            } else {
                                // Fallback para navegador web (abrirá error de seguridad)
                                console.log('Usando navegador para intentar abrir:', path);
                                window.location.href = path;
                            }
                        } catch (error) {
                            console.error("Error al intentar abrir el juego:", error);
                            loadingText.textContent = "Error al abrir el juego. Verifica la ruta.";
                            progressBar.style.backgroundColor = "#ff3333";
                            
                            // Mantener el modal visible por 3 segundos más en caso de error
                            setTimeout(() => {
                                syncModal.classList.add('hidden');
                                progressBar.style.width = '0%';
                                progressBar.style.backgroundColor = "#0082CA";
                                loadingText.textContent = 'Preparando secuencia genética...';
                            }, 3000);
                            return;
                        }
                        
                        // Ocultamos el modal después de iniciar la app
                        setTimeout(() => {
                            syncModal.classList.add('hidden');
                            progressBar.style.width = '0%';
                            loadingText.textContent = 'Preparando secuencia genética...';
                        }, 1000);
                    }, 500);
                }
            }, 50);
        }

        // Configurar todos los botones de sincronización cuando el DOM esté listo
        document.addEventListener('DOMContentLoaded', function() {
            // Seleccionar todos los botones de sincronización
            const syncButtons = document.querySelectorAll('.launch-game');
            
            syncButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Obtener la ruta del juego del atributo data-path
                    const gamePath = this.dataset.path;
                    
                    if (gamePath) {
                        launchGame(gamePath);
                    } else {
                        console.warn('Ruta de juego no válida o no encontrada');
                    }
                    
                    return false;
                });
            });
            
            // Mensaje de depuración para confirmar funcionamiento
            if (isElectron()) {
                console.log('Electron detectado, versión:', window.electron.getVersion());
            } else {
                console.log('Electron no detectado, ejecutando en navegador normal');
            }
        });
    </script>
</body>
</html>