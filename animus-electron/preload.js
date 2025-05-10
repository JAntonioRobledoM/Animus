const { contextBridge, ipcRenderer } = require('electron');

// Exponer funciones protegidas a la ventana del navegador
contextBridge.exposeInMainWorld('electron', {
  // Función para ejecutar aplicaciones (juegos)
  launchGame: (path) => {
    console.log('Renderer process: Solicitando lanzamiento de juego:', path);
    return ipcRenderer.invoke('launch-game', path);
  },
  
  // Versión de Electron (útil para verificar que la API está disponible)
  getVersion: () => process.versions.electron
});