const { app, BrowserWindow, shell, ipcMain, session } = require('electron');
const path = require('path');
const isDev = require('electron-is-dev');
const { exec } = require('child_process');

// Mantener referencia global del objeto window
let mainWindow;
let laravelProcess;

function createWindow() {
  // Crear la ventana del navegador
  mainWindow = new BrowserWindow({
    width: 1280,
    height: 800,
    fullscreen: true,  // Abrir en pantalla completa
    webPreferences: {
      nodeIntegration: false,
      contextIsolation: true,
      // Habilitar webSecurity en desarrollo (solo deshabilitar en producción si es absolutamente necesario)
      webSecurity: true,
      preload: path.join(__dirname, 'preload.js')
    },
    icon: path.join(__dirname, 'assets/icons/icon.png')
  });

  // Configurar CSP solo para desarrollo
  if (isDev) {
    session.defaultSession.webRequest.onHeadersReceived((details, callback) => {
      callback({
        responseHeaders: {
          ...details.responseHeaders,
          'Content-Security-Policy': [
            "default-src 'self' http://localhost:* http://127.0.0.1:* data: blob:; " +
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' http://localhost:* http://127.0.0.1:* https://cdn.tailwindcss.com; " +
            "style-src 'self' 'unsafe-inline' http://localhost:* http://127.0.0.1:* https://fonts.googleapis.com https://cdn.tailwindcss.com; " +
            "font-src 'self' data: https://fonts.gstatic.com; " +
            "img-src 'self' data: http://localhost:* http://127.0.0.1:* blob:; " +
            "connect-src 'self' http://localhost:* http://127.0.0.1:* ws://localhost:* ws://127.0.0.1:*;"
          ],
        }
      });
    });
  }

  // Cargar la URL de la aplicación Laravel
  mainWindow.loadURL(isDev ? 'http://localhost:8000' : 'http://localhost:8000');

  // Manejar errores de carga
  mainWindow.webContents.on('did-fail-load', (event, errorCode, errorDescription) => {
    console.error('Error al cargar la página:', errorCode, errorDescription);

    // Reintento automático después de un breve retraso
    setTimeout(() => {
      console.log('Reintentando cargar la página...');
      mainWindow.loadURL(isDev ? 'http://localhost:8000' : 'http://localhost:8000');
    }, 3000);
  });

  // Gestionar ventanas emergentes y enlaces externos
  mainWindow.webContents.setWindowOpenHandler(({ url }) => {
    // Si la URL comienza con file://, abrir con shell
    if (url.startsWith('file://')) {
      shell.openPath(url.replace('file://', ''));
      return { action: 'deny' };
    }
    // Dejar que Electron maneje otros enlaces
    return { action: 'allow' };
  });

  // Cuando la ventana se cierre
  mainWindow.on('closed', function () {
    mainWindow = null;
  });
}

// Verificar si Laravel ya está ejecutándose
function checkLaravelRunning(port = 8000) {
  return new Promise((resolve) => {
    const client = require('net').connect({port, host: 'localhost'}, () => {
      // Laravel está ejecutándose
      client.end();
      resolve(true);
    });
    
    client.on('error', () => {
      // Laravel no está ejecutándose
      resolve(false);
    });
  });
}

// Iniciar el servidor Laravel antes de crear la ventana
async function startLaravel() {
  // Verificar si Laravel ya está ejecutándose
  const isRunning = await checkLaravelRunning();
  
  if (isRunning) {
    console.log('Laravel ya está ejecutándose en el puerto 8000');
    createWindow();
    return;
  }
  
  // Ruta al proyecto Laravel (ajusta según tu estructura)
  const laravelPath = path.join(__dirname, '..', 'animus-laravel');
  
  console.log('Iniciando servidor Laravel en:', laravelPath);
  
  try {
    laravelProcess = exec('php artisan serve', { cwd: laravelPath });
    
    laravelProcess.stdout.on('data', (data) => {
      console.log(`Laravel: ${data}`);
      
      // Si detectamos que Laravel ha iniciado correctamente
      if (data.includes('Development Server')) {
        console.log('Laravel iniciado correctamente');
        setTimeout(createWindow, 1000);
      }
    });
    
    laravelProcess.stderr.on('data', (data) => {
      console.error(`Laravel Error: ${data}`);
    });
    
    // Si después de un tiempo no hemos detectado el mensaje de éxito,
    // intentamos crear la ventana de todos modos
    setTimeout(() => {
      if (!mainWindow) {
        console.log('Creando ventana después del tiempo de espera');
        createWindow();
      }
    }, 5000);
  } catch (error) {
    console.error('Error al iniciar Laravel:', error);
    // Crear la ventana de todos modos, tal vez Laravel ya esté ejecutándose
    createWindow();
  }
}

// Cuando Electron está listo
app.on('ready', startLaravel);

// Salir cuando todas las ventanas estén cerradas
app.on('window-all-closed', function () {
  // En macOS es común que las aplicaciones y su barra de menú
  // permanezcan activas hasta que el usuario salga explícitamente con Cmd + Q
  if (process.platform !== 'darwin') {
    app.quit();
  }
  
  // Matar el proceso de Laravel al cerrar la aplicación
  if (laravelProcess) {
    laravelProcess.kill();
  }
});

app.on('activate', function () {
  if (mainWindow === null) {
    createWindow();
  }
});

// Gestionar el cierre de la aplicación
app.on('before-quit', () => {
  if (laravelProcess) {
    laravelProcess.kill();
  }
});

// Manejar eventos IPC (comunicación entre procesos)
ipcMain.handle('launch-game', async (event, gamePath) => {
  console.log('Main process: Intentando lanzar juego:', gamePath);
  
  return new Promise((resolve, reject) => {
    try {
      // Ejecutar el juego
      const child = exec(`"${gamePath}"`, (error) => {
        if (error) {
          console.error('Error al lanzar el juego:', error);
          reject(error);
        }
      });
      
      // Consideramos que se lanzó correctamente cuando el proceso comienza
      child.on('spawn', () => {
        console.log('Juego lanzado correctamente');
        resolve(true);
      });
      
      // También manejar el caso en que el proceso termine
      child.on('exit', (code) => {
        console.log(`Juego cerrado con código: ${code}`);
      });
    } catch (error) {
      console.error('Error al intentar lanzar el juego:', error);
      reject(error);
    }
  });
});