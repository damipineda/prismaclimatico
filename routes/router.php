<?php
/**
 * Sistema de Rutas para Beca Voces por el Planeta
 */

class Router {
    private $routes = [];
    private $basePath = '';
    
    public function __construct($basePath = '') {
        $this->basePath = $basePath;
    }
    
    /**
     * Agregar una ruta
     */
    public function addRoute($method, $path, $handler) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler
        ];
    }
    
    /**
     * Agregar ruta GET
     */
    public function get($path, $handler) {
        $this->addRoute('GET', $path, $handler);
    }
    
    /**
     * Agregar ruta POST
     */
    public function post($path, $handler) {
        $this->addRoute('POST', $path, $handler);
    }
    
    /**
     * Obtener la URL actual
     */
    private function getCurrentPath() {
        $requestUri = $_SERVER['REQUEST_URI'];
        $scriptName = $_SERVER['SCRIPT_NAME'];
        
        // Remover el directorio base si existe
        if ($this->basePath) {
            $requestUri = str_replace($this->basePath, '', $requestUri);
        }
        
        // Remover query string
        $path = parse_url($requestUri, PHP_URL_PATH);
        
        // Remover el nombre del script si está en la URL
        $path = str_replace(dirname($scriptName), '', $path);
        
        return $path ?: '/';
    }
    
    /**
     * Verificar si la ruta coincide
     */
    private function matchRoute($routePath, $currentPath) {
        // Convertir parámetros de ruta a regex
        $pattern = preg_replace('/\{([^}]+)\}/', '([^/]+)', $routePath);
        $pattern = '#^' . $pattern . '$#';
        
        if (preg_match($pattern, $currentPath, $matches)) {
            array_shift($matches); // Remover el match completo
            return $matches;
        }
        
        return false;
    }
    
    /**
     * Ejecutar el router
     */
    public function run() {
        $currentPath = $this->getCurrentPath();
        $method = $_SERVER['REQUEST_METHOD'];
        
        foreach ($this->routes as $route) {
            if ($route['method'] === $method) {
                $params = $this->matchRoute($route['path'], $currentPath);
                
                if ($params !== false) {
                    // Ejecutar el handler
                    if (is_callable($route['handler'])) {
                        return call_user_func_array($route['handler'], $params);
                    } elseif (is_string($route['handler'])) {
                        return $this->loadView($route['handler'], $params);
                    }
                }
            }
        }
        
        // Ruta no encontrada
        $this->notFound();
    }
    
    /**
     * Cargar una vista
     */
    private function loadView($viewPath, $params = []) {
        $fullPath = __DIR__ . '/../views/' . $viewPath;
        
        if (file_exists($fullPath)) {
            // Extraer parámetros a variables
            extract($params);
            
            // Incluir la vista
            include $fullPath;
            return true;
        }
        
        return false;
    }
    
    /**
     * Página 404
     */
    private function notFound() {
        http_response_code(404);
        include __DIR__ . '/../views/404.php';
    }
    
    /**
     * Redirigir a otra URL
     */
    public static function redirect($url) {
        header("Location: $url");
        exit;
    }
    
    /**
     * Obtener URL base
     */
    public static function getBaseUrl() {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        $scriptName = $_SERVER['SCRIPT_NAME'];
        $basePath = dirname($scriptName);
        
        return $protocol . '://' . $host . $basePath;
    }
    
    /**
     * Generar URL para una ruta
     */
    public function url($path) {
        return self::getBaseUrl() . $path;
    }
}

// Crear instancia del router
$router = new Router();

// Definir rutas
$router->get('/', function() {
    // La página principal ya está en index.php
    return true;
});

$router->get('/vocesporelplaneta', function() {
    include __DIR__ . '/../views/vocesporelplaneta.php';
});

$router->get('/formulario', function() {
    include __DIR__ . '/../views/formulario.html';
});

$router->post('/process-form', function() {
    include __DIR__ . '/../views/process_form.php';
});

// Ejecutar el router si se accede directamente
if (basename(__FILE__) === basename($_SERVER['SCRIPT_NAME'])) {
    $router->run();
}
?> 