/**
 * Utilidades para ayudar con problemas comunes de API
 * Complementa a departamentos.js para solucionar problemas específicos
 */

/**
 * Verifica si la API está disponible
 * @param {string} endpoint - URL del endpoint a verificar
 * @param {number} timeout - Timeout en milisegundos
 * @returns {Promise<boolean>} - Promise que resuelve a true si la API está disponible
 */
async function verificarEndpoint(endpoint = 'https://api.delpi.dev/api/departamentos', timeout = 5000) {
    try {
        // Usamos AbortSignal para manejar timeout
        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), timeout);
        // Usamos GET porque la API puede no soportar HEAD
        const response = await fetch(endpoint, {
            method: 'GET',
            signal: controller.signal,
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        });
        clearTimeout(timeoutId);
        // Verificamos que el status sea 2xx y que el tipo de contenido sea JSON
        const contentType = response.headers.get("content-type");
        return response.ok && contentType && contentType.includes("application/json");
    } catch (error) {
        console.error(`Error verificando endpoint ${endpoint}:`, error);
        return false;
    }
}

/**
 * Obtiene y muestra información sobre por qué la API podría no estar funcionando
 * @param {string} elementId - ID del elemento donde mostrar el diagnóstico
 * @param {string} endpoint - URL del endpoint a verificar
 */
async function diagnosticarAPI(elementId, endpoint = 'https://api.delpi.dev/api/departamentos') {
    const element = document.getElementById(elementId);
    
    if (!element) {
        console.error(`Elemento con ID "${elementId}" no encontrado`);
        return;
    }
    
    element.innerHTML = `<p class="api-checking">Verificando conexión con la API...</p>`;
    
    try {
        // Hacemos un intento para ver qué tipo de respuesta obtenemos
        const response = await fetch(endpoint, {
            method: 'GET',
            headers: {
                'Accept': 'application/json'
            },
            signal: AbortSignal.timeout(8000) // 8 segundos de timeout
        });
        
        // Obtenemos información de la respuesta
        const contentType = response.headers.get("content-type") || 'Sin tipo de contenido';
        let responseText;
        
        try {
            // Intentamos obtener el texto de la respuesta
            responseText = await response.text();
            // Si parece HTML, solo mostramos una parte
            if (responseText.includes('<!doctype') || responseText.includes('<html')) {
                responseText = responseText.substring(0, 150) + '... (HTML truncado)';
            }
        } catch (e) {
            responseText = 'No se pudo leer el contenido de la respuesta';
        }
        
        // Mostramos el diagnóstico
        element.innerHTML = `
            <div class="api-diagnosis">
                <h4>Diagnóstico de API</h4>
                <ul>
                    <li><strong>Status:</strong> ${response.status} ${response.statusText}</li>
                    <li><strong>Tipo de contenido:</strong> ${contentType}</li>
                    <li><strong>Respuesta recibida:</strong> 
                        <pre class="response-preview">${responseText}</pre>
                    </li>
                </ul>
                <div class="api-solution">
                    <h5>Soluciones posibles:</h5>
                    <ol>
                        <li>La API está devolviendo HTML en lugar de JSON. Posiblemente está redirigiendo a una página de error.</li>
                        <li>Verifique si la URL del endpoint es correcta y está accesible.</li>
                        <li>Si está en desarrollo local, considere usar CORS proxy o configurar adecuadamente los encabezados CORS en el servidor.</li>
                        <li>Si persiste el problema, use los datos en caché local mientras se resuelve.</li>
                    </ol>
                    <button onclick="window.location.reload()" class="retry-btn">Intentar de nuevo</button>
                </div>
            </div>
        `;
    } catch (error) {
        // Error en la petición
        element.innerHTML = `
            <div class="api-diagnosis error">
                <h4>Error de conexión</h4>
                <p class="error-message">${error.message}</p>
                <div class="api-solution">
                    <h5>Soluciones posibles:</h5>
                    <ol>
                        <li>Verifique su conexión a internet.</li>
                        <li>La API puede estar caída o inaccesible.</li>
                        <li>Puede haber un problema con CORS si está en desarrollo local.</li>
                        <li>El servidor puede estar bloqueando las peticiones.</li>
                    </ol>
                    <button onclick="window.location.reload()" class="retry-btn">Intentar de nuevo</button>
                </div>
            </div>
        `;
    }
}

/**
 * Ajusta el archivo vocesporelplaneta.php para corregir problemas comunes
 * Esta función debe ser invocada desde el script de vocesporelplaneta.php
 */
function fixVocesPorElPlanetaAPI() {
    // Reescribe la función loadDepartamentos para manejar mejor los errores
    if (typeof window.loadDepartamentos === 'function') {
        const originalLoad = window.loadDepartamentos;
        
        window.loadDepartamentos = function() {
            try {
                // Intentamos cargar usando departamentos.js en lugar de hacer fetch directamente
                if (typeof window.cargarDepartamentos === 'function') {
                    cargarDepartamentos("departamento", function(departamentos) {
                        console.log("Departamentos cargados correctamente usando biblioteca local");
                    });
                    return;
                }
                
                // Si no está disponible, usamos el método original pero con mejor manejo de errores
                originalLoad();
            } catch (error) {
                console.error("Error en loadDepartamentos modificado:", error);
                // Mostramos un mensaje y usamos datos locales como último recurso
                const selectElement = document.getElementById("departamento");
                if (selectElement) {
                    selectElement.innerHTML = '<option value="">Seleccione un departamento</option>';
                    // Agregamos al menos Asunción como opción
                    const option = document.createElement('option');
                    option.value = 1;
                    option.textContent = "ASUNCIÓN";
                    selectElement.appendChild(option);
                }
            }
        };
    }
}

// Exportamos funciones
window.verificarEndpoint = verificarEndpoint;
window.diagnosticarAPI = diagnosticarAPI;
window.fixVocesPorElPlanetaAPI = fixVocesPorElPlanetaAPI;
