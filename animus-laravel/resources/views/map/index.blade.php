<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animus - Mapa de Recuerdos</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700;900&family=Rajdhani:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Leaflet CSS LOCAL -->
    <link rel="stylesheet" href="{{ asset('css/leaflet.css') }}" />

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'abstergo-blue': '#0082CA',
                        'abstergo-light-blue': '#00a8ff',
                        'abstergo-dark': '#0a0a0a',
                        'abstergo-gray': '#1a1a1a',
                        'abstergo-accent': '#00d4ff',
                        'abstergo-gold': '#ffd700',
                    },
                    fontFamily: {
                        'rajdhani': ['Rajdhani', 'sans-serif'],
                        'orbitron': ['Orbitron', 'monospace'],
                    },
                    animation: {
                        'pulse-blue': 'pulse-blue 2s ease-in-out infinite',
                        'glow': 'glow 2s ease-in-out infinite alternate',
                        'scan': 'scan 3s ease-in-out infinite',
                    },
                    keyframes: {
                        'pulse-blue': {
                            '0%, 100%': { boxShadow: '0 0 5px #0082CA' },
                            '50%': { boxShadow: '0 0 20px #0082CA, 0 0 30px #0082CA' },
                        },
                        'glow': {
                            'from': { textShadow: '0 0 10px #0082CA' },
                            'to': { textShadow: '0 0 20px #0082CA, 0 0 30px #00a8ff' },
                        },
                        'scan': {
                            '0%': { transform: 'translateX(-100%)' },
                            '100%': { transform: 'translateX(100vw)' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background: radial-gradient(ellipse at center, #0a0a0a 0%, #000000 100%);
        }
        .text-hologram {
            background: linear-gradient(45deg, #0082CA, #00a8ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .btn-hologram {
            background: linear-gradient(45deg, rgba(0, 130, 202, 0.2), rgba(0, 168, 255, 0.2));
            border: 1px solid #0082CA;
            position: relative;
            overflow: hidden;
        }
        .btn-hologram::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
            pointer-events: none;
        }
        .btn-hologram:hover::before {
            left: 100%;
        }
        .scan-line {
            position: absolute;
            top: 0;
            left: 0;
            width: 2px;
            height: 100%;
            background: linear-gradient(to bottom, transparent, #0082CA, transparent);
            animation: scan 3s ease-in-out infinite;
            opacity: 0.8;
            pointer-events: none;
        }
        #map {
            height: 600px;
            border: 2px solid #0082CA;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 130, 202, 0.3);
        }
        /* Estilo oscuro para las tiles del mapa */
        .map-tiles {
            filter: invert(100%) hue-rotate(180deg) brightness(0.7) contrast(1.2);
        }
        .leaflet-popup-content-wrapper {
            background: #1a1a1a;
            color: #00d4ff;
            border: 1px solid #0082CA;
            border-radius: 4px;
        }
        .leaflet-popup-tip {
            background: #1a1a1a;
        }
        .custom-marker {
            background: radial-gradient(circle, #00d4ff, #0082CA);
            border: 2px solid #fff;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            box-shadow: 0 0 10px rgba(0, 130, 202, 0.8);
        }
    </style>
</head>
<body class="bg-abstergo-dark font-rajdhani text-white flex flex-col min-h-screen relative">
    <div class="scan-line"></div>

    <nav class="bg-black/90 border-b-2 border-abstergo-blue shadow-lg shadow-abstergo-blue/20 py-4 px-6 relative">
        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-abstergo-blue/5 to-transparent"></div>
        <div class="flex justify-between items-center relative z-10">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-gradient-to-br from-abstergo-blue to-abstergo-light-blue rounded-full flex items-center justify-center mr-4 animate-pulse-blue">
                    <div class="w-6 h-6 bg-white rounded-full opacity-80"></div>
                </div>
                <span class="text-3xl font-orbitron font-bold text-hologram animate-glow tracking-widest">ANIMUS OS</span>
                <div class="ml-4 text-xs text-abstergo-accent font-orbitron">v1.0</div>
            </div>
            <div class="flex items-center space-x-6">
                <a href="{{ route('dashboard') }}" class="text-white hover:text-abstergo-accent transition-all duration-300 px-3 py-1 hover:bg-abstergo-accent/10 rounded">
                    DASHBOARD
                </a>
                <a href="{{ route('recuerdos.index') }}" class="text-white hover:text-abstergo-accent transition-all duration-300 px-3 py-1 hover:bg-abstergo-accent/10 rounded">
                    GESTIONAR RECUERDOS
                </a>
                <a href="{{ route('map.index') }}" class="text-abstergo-accent border-b-2 border-abstergo-accent px-3 py-1 font-medium tracking-wide">
                    MAPA DE RECUERDOS
                </a>
                <div class="flex items-center space-x-4 ml-8">
                    <div class="text-sm text-abstergo-accent font-orbitron">USUARIO:</div>
                    <div class="text-white font-medium">{{ auth()->user()->name }}</div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn-hologram text-white px-4 py-2 rounded-md transition-all duration-300 hover:bg-abstergo-blue/30 font-medium">
                            CERRAR SESIÓN
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-6 py-8 flex-grow relative z-10">
        <div class="mb-8">
            <h1 class="text-4xl font-orbitron font-bold text-hologram mb-2 animate-glow">
                MAPA MUNDIAL DE RECUERDOS GENÉTICOS
            </h1>
            <div class="w-full h-1 bg-gradient-to-r from-abstergo-blue via-abstergo-accent to-transparent rounded-full"></div>
            <p class="text-gray-400 mt-4 font-rajdhani">
                Visualiza la ubicación geográfica de todos tus recuerdos en el mapa mundial.
            </p>
        </div>

        @if($recuerdos->isEmpty())
            <div class="bg-gradient-to-r from-yellow-500/20 to-yellow-600/20 border-l-4 border-yellow-400 p-6 mb-8 rounded-r-lg">
                <div class="flex items-center">
                    <div class="w-6 h-6 bg-yellow-400 rounded-full flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-black" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-yellow-300 font-medium">No hay recuerdos con ubicación</div>
                        <p class="text-yellow-200 text-sm mt-1">Crea o edita tus recuerdos añadiendo un lugar para verlos en el mapa.</p>
                        <p class="text-yellow-100 text-xs mt-2">Tienes {{ auth()->user()->recuerdos->count() }} recuerdos en total. Añade ubicaciones editándolos.</p>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-gradient-to-r from-green-500/20 to-green-600/20 border-l-4 border-green-400 p-4 mb-8 rounded-r-lg">
                <div class="flex items-center">
                    <div class="w-6 h-6 bg-green-400 rounded-full flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-black" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <span class="text-green-300 font-medium font-orbitron">{{ $recuerdos->count() }} RECUERDOS MAPEADOS</span>
                    </div>
                </div>
            </div>

            <div id="map" class="mb-8"></div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-8">
                @foreach($recuerdos as $recuerdo)
                    <div class="bg-gradient-to-br from-black/80 to-abstergo-gray/50 border border-abstergo-blue/40 rounded-lg p-4 hover:border-abstergo-accent transition-all duration-300">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-3 h-3 bg-abstergo-accent rounded-full animate-pulse"></div>
                            </div>
                            <div class="flex-grow">
                                <h3 class="text-abstergo-accent font-orbitron font-medium">{{ $recuerdo->title }}</h3>
                                @if($recuerdo->subtitle)
                                    <p class="text-gray-400 text-sm">{{ $recuerdo->subtitle }}</p>
                                @endif
                                <div class="flex items-center mt-2 text-sm text-gray-500">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $recuerdo->lugar }}
                                </div>
                                @if($recuerdo->year)
                                    <div class="text-xs text-gray-600 mt-1">Año: {{ $recuerdo->year }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </main>

    <footer class="bg-black/90 border-t-2 border-abstergo-blue py-6 px-6 text-center relative mt-auto">
        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-abstergo-blue/5 to-transparent"></div>
        <div class="relative z-10">
            <p class="text-abstergo-accent font-orbitron font-medium tracking-widest">ABSTERGO INDUSTRIES &copy; {{ date('Y') }} - ANIMUS OS v1.0</p>
            <p class="mt-2 text-sm text-gray-400 font-rajdhani">SISTEMA DE RECUPERACIÓN DE MEMORIAS GENÉTICAS</p>
            <div class="mt-3 w-32 h-0.5 bg-gradient-to-r from-transparent via-abstergo-blue to-transparent mx-auto"></div>
        </div>
    </footer>

    <!-- Leaflet JS LOCAL -->
    <script src="{{ asset('js/leaflet.js') }}"></script>

    <script>
        @if(!$recuerdos->isEmpty())
        console.log('Inicializando mapa...');
        console.log('Recuerdos:', @json($recuerdos));

        // Inicializar el mapa centrado en el mundo
        var map = L.map('map', {
            center: [20, 0],
            zoom: 2,
            minZoom: 1,
            maxZoom: 19
        });

        console.log('Mapa inicializado');

        // Capa base oscura tipo Animus - usando OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            subdomains: ['a', 'b', 'c'],
            maxZoom: 19,
            className: 'map-tiles'
        }).addTo(map);

        console.log('Capa base añadida');

        // Datos de los recuerdos
        var recuerdos = @json($recuerdos);
        console.log('Total recuerdos a mapear:', recuerdos.length);

        // Icono personalizado
        var customIcon = L.divIcon({
            className: 'custom-marker',
            iconSize: [20, 20],
            iconAnchor: [10, 10],
            popupAnchor: [0, -10]
        });

        // Añadir marcadores
        var markers = [];
        recuerdos.forEach(function(recuerdo) {
            console.log('Añadiendo marcador:', recuerdo.title, 'en', recuerdo.latitud, recuerdo.longitud);

            var marker = L.marker([parseFloat(recuerdo.latitud), parseFloat(recuerdo.longitud)], {
                icon: customIcon
            }).addTo(map);

            var popupContent = '<div class="font-rajdhani">' +
                '<div class="font-orbitron font-bold text-abstergo-accent mb-2">' + recuerdo.title + '</div>';

            if (recuerdo.subtitle) {
                popupContent += '<div class="text-sm text-gray-300 mb-2">' + recuerdo.subtitle + '</div>';
            }

            popupContent += '<div class="text-sm text-gray-400 mb-1">' +
                '<svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 20 20">' +
                '<path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>' +
                '</svg>' + recuerdo.lugar + '</div>';

            if (recuerdo.year) {
                popupContent += '<div class="text-xs text-gray-500">Año: ' + recuerdo.year + '</div>';
            }

            popupContent += '</div>';

            marker.bindPopup(popupContent);
            markers.push(marker);
        });

        console.log('Marcadores añadidos:', markers.length);

        // Ajustar el zoom para mostrar todos los marcadores
        if (markers.length > 0) {
            var group = new L.featureGroup(markers);
            map.fitBounds(group.getBounds().pad(0.1));
            console.log('Zoom ajustado a los marcadores');
        }

        // Forzar redibujado del mapa después de cargar
        setTimeout(function() {
            map.invalidateSize();
            console.log('Mapa redibujado');
        }, 100);
        @endif
    </script>
</body>
</html>
