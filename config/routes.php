<?php
/**
 * Configuración de Rutas para Beca Voces por el Planeta
 */

// Definir rutas principales
$routes = [
    'home' => '/',
    'vocesporelplaneta' => '/vocesporelplaneta',
    'formulario' => '/formulario',
    'process_form' => '/process-form'
];

// Función para generar URL
function url($route) {
    global $routes;
    
    if (isset($routes[$route])) {
        return $routes[$route];
    }
    
    return $route;
}

// Función para obtener URL base
function baseUrl() {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $scriptName = $_SERVER['SCRIPT_NAME'];
    $basePath = dirname($scriptName);
    
    return $protocol . '://' . $host . $basePath;
}

// Función para obtener URL completa
function fullUrl($route) {
    return baseUrl() . url($route);
}

// Función para verificar si es la página actual
function isCurrentPage($route) {
    $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $routePath = url($route);
    
    return $currentPath === $routePath;
}

// Función para redirigir
function redirect($route) {
    header("Location: " . fullUrl($route));
    exit;
}

// Función para obtener assets
function asset($path) {
    return baseUrl() . '/assets/' . ltrim($path, '/');
}

// Función para obtener CSS
function css($file) {
    return asset('css/' . $file);
}

// Función para obtener JS
function js($file) {
    return asset('js/' . $file);
}

// Función para obtener media
function media($file) {
    return asset('media/' . $file);
}
?> 