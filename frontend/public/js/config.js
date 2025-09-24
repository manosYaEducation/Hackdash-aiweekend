// Configuración dinámica de URLs
// Cargar configuración desde el servidor
(async function() {
    try {
        // Intentar cargar configuración desde el servidor
        const response = await fetch('/hackdash-aiweekend/backend/api/config');
        const config = await response.json();
        
        // Configurar URLs globales
        window.API_URL = config.api_url;
        window.API_URL_PHP = config.api_url;
        window.FRONTEND_URL = config.frontend_url;
        window.BASE_URL = config.base_url;
        
    } catch (error) {
        console.warn('No se pudo cargar configuración del servidor, usando configuración local');
        
        // Fallback a configuración local
        const isLocal = window.location.hostname === 'localhost' || 
                       window.location.hostname === '127.0.0.1';
        
        window.API_URL = isLocal 
            ? 'http://localhost/hackdash-aiweekend/backend'
            : 'https://kreative.alphadocere.cl/backend';
            
        window.API_URL_PHP = window.API_URL;
        window.FRONTEND_URL = isLocal 
            ? 'http://localhost/hackdash-aiweekend/frontend'
            : 'https://kreative.alphadocere.cl/frontend';
        window.BASE_URL = isLocal 
            ? 'http://localhost'
            : 'https://kreative.alphadocere.cl';
    }
})();