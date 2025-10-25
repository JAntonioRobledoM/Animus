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
        /* Estilos para la navegación entre recuerdos en la misma ubicación */
        .nav-arrows {
            display: flex;
            justify-content: space-between;
            margin-top: 8px;
            padding-top: 8px;
            border-top: 1px solid rgba(0, 130, 202, 0.3);
        }
        .nav-arrows a.prev-btn,
        .nav-arrows a.next-btn {
            background: rgba(0, 130, 202, 0.2);
            border: 1px solid #0082CA;
            color: #00d4ff;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }
        .nav-arrows a.prev-btn:hover,
        .nav-arrows a.next-btn:hover {
            background: rgba(0, 212, 255, 0.3);
            box-shadow: 0 0 10px rgba(0, 130, 202, 0.5);
            text-decoration: none;
        }
        .nav-arrows a.prev-btn:active,
        .nav-arrows a.next-btn:active,
        .nav-arrows a.prev-btn:focus,
        .nav-arrows a.next-btn:focus {
            outline: none;
            box-shadow: 0 0 15px rgba(0, 212, 255, 0.7);
            text-decoration: none;
        }
        .nav-arrows .current-index {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.7);
            display: flex;
            align-items: center;
        }
        /* Evitar que los botones sean afectados por eventos de Leaflet */
        .leaflet-popup-pane button {
            pointer-events: auto !important;
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

        // Función global para navegación entre recuerdos
        window.navegarRecuerdo = function(locationKey, direction) {
            // Buscar el marcador correcto
            for (var i = 0; i < allMarkers.length; i++) {
                var marker = allMarkers[i];
                if (marker.groupData && marker.groupData.locationKey === locationKey) {
                    navigateRecuerdos(marker, direction);
                    return false;
                }
            }
            return false;
        };

        // Inicializar el mapa centrado en el mundo
        var map = L.map('map', {
            center: [20, 0],
            zoom: 2,
            minZoom: 1,
            maxZoom: 19
        });

        // Capa base oscura tipo Animus - usando OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            subdomains: ['a', 'b', 'c'],
            maxZoom: 19,
            className: 'map-tiles'
        }).addTo(map);

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

        // Agrupar recuerdos por ubicación
        var locationGroups = {};

        // Procesar cada recuerdo y agruparlos por ubicación
        recuerdos.forEach(function(recuerdo, index) {
            // Crear una clave única para esta ubicación
            var locationKey = parseFloat(recuerdo.latitud).toFixed(6) + '_' + parseFloat(recuerdo.longitud).toFixed(6);

            // Inicializar el grupo si no existe
            if (!locationGroups[locationKey]) {
                locationGroups[locationKey] = {
                    lat: parseFloat(recuerdo.latitud),
                    lng: parseFloat(recuerdo.longitud),
                    lugar: recuerdo.lugar,
                    items: []
                };
            }

            // Añadir este recuerdo al grupo
            locationGroups[locationKey].items.push(recuerdo);
        });

        console.log('Ubicaciones agrupadas:', Object.keys(locationGroups).length);

        // Crear marcadores para cada ubicación
        var allMarkers = [];

        Object.keys(locationGroups).forEach(function(locationKey) {
            var group = locationGroups[locationKey];
            var position = [group.lat, group.lng];

            console.log('Creando marcador para la ubicación:', locationKey, 'con', group.items.length, 'recuerdos');

            var marker = L.marker(position, {
                icon: customIcon
            });

            // Si hay solo un recuerdo en esta ubicación
            if (group.items.length === 1) {
                var recuerdo = group.items[0];

                var popupContent = '<div class="font-rajdhani">' +
                    '<div class="font-orbitron font-bold text-abstergo-accent mb-2">' + recuerdo.title + '</div>';

                if (recuerdo.subtitle) {
                    popupContent += '<div class="text-sm text-gray-300 mb-2">' + recuerdo.subtitle + '</div>';
                }

                popupContent += '<div class="text-sm text-gray-400 mb-1">' +
                    '<svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 20 20">' +
                    '<path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>' +
                    '</svg>' + group.lugar + '</div>';

                if (recuerdo.year) {
                    popupContent += '<div class="text-xs text-gray-500">Año: ' + recuerdo.year + '</div>';
                }

                popupContent += '</div>';

                marker.bindPopup(popupContent);
            }
            // Si hay múltiples recuerdos en esta ubicación
            else {
                // Crear un popup con navegación entre recuerdos
                marker.groupData = {
                    locationKey: locationKey,
                    currentIndex: 0,
                    items: group.items,
                    lugar: group.lugar
                };

                // Generar el contenido del popup para el primer recuerdo
                var initialPopupContent = createPopupContent(marker, 0);
                marker.bindPopup(initialPopupContent);

                // Añadir un manejador de eventos para cuando se abra el popup
                marker.on('popupopen', function(e) {
                    // Esto asegura que los botones de navegación funcionen después de abrir el popup
                    setupNavButtons(this.getPopup(), this);
                });
            }

            marker.addTo(map);
            allMarkers.push(marker);
        });

        // Función para generar el contenido del popup
        function createPopupContent(marker, index) {
            var data = marker.groupData;
            var recuerdo = data.items[index];

            var content = '<div class="font-rajdhani" data-location-key="' + data.locationKey + '" data-index="' + index + '">' +
                '<div class="font-orbitron font-bold text-abstergo-accent mb-2">' + recuerdo.title + '</div>';

            if (recuerdo.subtitle) {
                content += '<div class="text-sm text-gray-300 mb-2">' + recuerdo.subtitle + '</div>';
            }

            content += '<div class="text-sm text-gray-400 mb-1">' +
                '<svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 20 20">' +
                '<path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>' +
                '</svg>' + data.lugar + '</div>';

            if (recuerdo.year) {
                content += '<div class="text-xs text-gray-500">Año: ' + recuerdo.year + '</div>';
            }

            // Añadir controles de navegación si hay más de un recuerdo
            if (data.items.length > 1) {
                content += '<div class="nav-arrows leaflet-popup-content" id="nav-' + data.locationKey + '-' + index + '">' +
                    '<a href="javascript:void(0)" class="prev-btn leaflet-interactive" onclick="navegarRecuerdo(\'' + data.locationKey + '\', -1); event.stopPropagation(); return false;">&larr; Anterior</a>' +
                    '<div class="current-index">' + (index + 1) + ' de ' + data.items.length + '</div>' +
                    '<a href="javascript:void(0)" class="next-btn leaflet-interactive" onclick="navegarRecuerdo(\'' + data.locationKey + '\', 1); event.stopPropagation(); return false;">Siguiente &rarr;</a>' +
                '</div>';
            }

            content += '</div>';

            return content;
        }

        // Función para configurar los botones de navegación en el popup
        function setupNavButtons(popup, marker) {
            // Esta función ahora es más simple, ya que usamos enlaces con
            // funciones globales en lugar de event listeners locales.
            // Se mantiene por si necesitamos hacer alguna configuración adicional en el futuro
            console.log('Popup preparado para la navegación');
        }

        // Función para navegar entre recuerdos de un marcador
        function navigateRecuerdos(marker, direction) {
            try {
                var data = marker.groupData;
                var newIndex = data.currentIndex + direction;

                // Asegurar que el índice esté dentro de los límites
                if (newIndex < 0) {
                    newIndex = data.items.length - 1; // Ir al último si estamos al inicio
                } else if (newIndex >= data.items.length) {
                    newIndex = 0; // Volver al inicio si estamos al final
                }

                console.log('Navegando de', data.currentIndex, 'a', newIndex, 'de', data.items.length, 'recuerdos');

                // Actualizar el índice actual
                data.currentIndex = newIndex;

                // Actualizar el contenido del popup
                var newContent = createPopupContent(marker, newIndex);
                var popup = marker.getPopup();

                // Guardar el estado abierto
                var wasOpen = popup.isOpen();

                // Actualizar contenido
                popup.setContent(newContent);

                // Asegurarnos de que el popup permanezca abierto
                if (wasOpen && !popup.isOpen()) {
                    popup.openOn(map);
                }

                popup.update();

                // Volver a configurar los botones de navegación
                setTimeout(function() {
                    setupNavButtons(popup, marker);
                }, 50);

                // Prevenir la propagación de eventos
                return false;
            } catch (e) {
                console.error('Error al navegar entre recuerdos:', e);
            }
        }

        // Ajustar el zoom para mostrar todos los marcadores
        if (allMarkers.length > 0) {
            var group = new L.featureGroup(allMarkers);
            map.fitBounds(group.getBounds().pad(0.1));
        }

        // Forzar redibujado del mapa después de cargar
        setTimeout(function() {
            map.invalidateSize();
        }, 100);

        @endif
    </script>
</body>
</html>
