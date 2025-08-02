<?php
/**
 * Configuración Principal de la Aplicación
 * Beca Voces por el Planeta
 */

// Configuración de la aplicación
define('APP_NAME', 'Beca Voces por el Planeta');
define('APP_VERSION', '1.0.0');
define('APP_ENV', 'development'); // development, production

// Configuración de directorios
define('BASE_PATH', dirname(__DIR__));
define('VIEWS_PATH', BASE_PATH . '/views');
define('ASSETS_PATH', BASE_PATH . '/assets');
define('CONFIG_PATH', BASE_PATH . '/config');
define('ROUTES_PATH', BASE_PATH . '/routes');
define('UPLOADS_PATH', BASE_PATH . '/uploads');
define('LOGS_PATH', BASE_PATH . '/logs');

// Configuración de URLs
define('APP_URL', 'http://localhost'); // Cambiar en producción
define('ASSETS_URL', APP_URL . '/assets');

// Configuración de sesión
define('SESSION_NAME', 'voces_planeta_session');
define('SESSION_LIFETIME', 3600); // 1 hora

// Configuración de seguridad
define('CSRF_TOKEN_NAME', 'voces_planeta_csrf');
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOCKOUT_TIME', 900); // 15 minutos

// Configuración de archivos
define('MAX_FILE_SIZE', 50 * 1024 * 1024); // 50 MB
define('ALLOWED_FILE_TYPES', [
    'image/jpeg',
    'image/png',
    'video/mp4',
    'video/quicktime'
]);

// Configuración de email
define('EMAIL_FROM', 'noreply@asoedhu.org');
define('EMAIL_FROM_NAME', 'Beca Voces por el Planeta');
define('EMAIL_REPLY_TO', 'info@asoedhu.org');

// Configuración de timezone
date_default_timezone_set('America/Asuncion');

// Configuración de errores
if (APP_ENV === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Función para cargar configuraciones
function loadConfig($file) {
    $configFile = CONFIG_PATH . '/' . $file . '.php';
    if (file_exists($configFile)) {
        return require $configFile;
    }
    return [];
}

// Función para obtener configuración
function config($key, $default = null) {
    static $config = null;
    
    if ($config === null) {
        $config = [
            'app' => loadConfig('app'),
            'database' => loadConfig('config'),
            'routes' => loadConfig('routes')
        ];
    }
    
    $keys = explode('.', $key);
    $value = $config;
    
    foreach ($keys as $k) {
        if (isset($value[$k])) {
            $value = $value[$k];
        } else {
            return $default;
        }
    }
    
    return $value;
}

// Función para debug
function debug($data) {
    if (APP_ENV === 'development') {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }
}

// Función para log
function logMessage($level, $message, $context = []) {
    $logFile = LOGS_PATH . '/app.log';
    $timestamp = date('Y-m-d H:i:s');
    $logEntry = "[$timestamp] [$level] $message " . json_encode($context) . PHP_EOL;
    
    if (!is_dir(LOGS_PATH)) {
        mkdir(LOGS_PATH, 0755, true);
    }
    
    file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);
}

// Función para limpiar datos
function sanitize($data) {
    if (is_array($data)) {
        return array_map('sanitize', $data);
    }
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

// Función para validar email
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

// Función para generar token CSRF
function generateCSRFToken() {
    if (!isset($_SESSION[CSRF_TOKEN_NAME])) {
        $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
    }
    return $_SESSION[CSRF_TOKEN_NAME];
}

// Función para validar token CSRF
function validateCSRFToken($token) {
    return isset($_SESSION[CSRF_TOKEN_NAME]) && hash_equals($_SESSION[CSRF_TOKEN_NAME], $token);
}

// Función para redirigir
function redirect($url) {
    header("Location: $url");
    exit;
}

// Función para obtener IP del cliente
function getClientIP() {
    $ipKeys = ['HTTP_X_FORWARDED_FOR', 'HTTP_X_REAL_IP', 'HTTP_CLIENT_IP', 'REMOTE_ADDR'];
    
    foreach ($ipKeys as $key) {
        if (isset($_SERVER[$key])) {
            $ip = $_SERVER[$key];
            if (strpos($ip, ',') !== false) {
                $ip = trim(explode(',', $ip)[0]);
            }
            if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                return $ip;
            }
        }
    }
    
    return $_SERVER['REMOTE_ADDR'] ?? 'unknown';
}

// Función para verificar si es una petición AJAX
function isAjaxRequest() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
           strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}

// Función para responder JSON
function jsonResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

// Función para obtener el método HTTP
function getMethod() {
    return $_SERVER['REQUEST_METHOD'];
}

// Función para obtener la URL actual
function getCurrentUrl() {
    return $_SERVER['REQUEST_URI'];
}

// Función para obtener el path actual
function getCurrentPath() {
    return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
}

// Inicializar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_name(SESSION_NAME);
    session_start();
}

// Configurar headers de seguridad
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');

// Configurar Content Security Policy
$csp = "default-src 'self'; ";
$csp .= "script-src 'self' 'unsafe-inline' https://kit.fontawesome.com https://cdnjs.cloudflare.com; ";
$csp .= "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdnjs.cloudflare.com; ";
$csp .= "font-src 'self' https://fonts.gstatic.com https://cdnjs.cloudflare.com; ";
$csp .= "img-src 'self' data: https:; ";
$csp .= "media-src 'self' https:; ";
$csp .= "connect-src 'self' https://nominatim.openstreetmap.org;";

header("Content-Security-Policy: $csp");
?> 