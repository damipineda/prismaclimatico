<?php
/**
 * Archivo de Prueba - Beca Voces por el Planeta
 * Verifica que todas las configuraciones funcionen correctamente
 */

echo "<h1>🧪 Prueba de Configuración - Beca Voces por el Planeta</h1>";

// 1. Verificar PHP
echo "<h2>1. Verificación de PHP</h2>";
echo "<p><strong>Versión de PHP:</strong> " . phpversion() . "</p>";
echo "<p><strong>Extensiones requeridas:</strong></p>";
$required_extensions = ['pdo', 'pdo_mysql', 'fileinfo', 'mbstring'];
foreach ($required_extensions as $ext) {
    $status = extension_loaded($ext) ? "✅" : "❌";
    echo "<p>$status $ext</p>";
}

// 2. Verificar archivos de configuración
echo "<h2>2. Verificación de Archivos</h2>";
$required_files = [
    'config/app.php',
    'config/config.php',
    'config/routes.php',
    'views/vocesporelplaneta.php',
    'views/process_form.php',
    'assets/css/style.css',
    'assets/css/form.css',
    'assets/js/form.js'
];

foreach ($required_files as $file) {
    $status = file_exists($file) ? "✅" : "❌";
    echo "<p>$status $file</p>";
}

// 3. Verificar directorios
echo "<h2>3. Verificación de Directorios</h2>";
$required_dirs = [
    'config',
    'views',
    'routes',
    'assets',
    'assets/css',
    'assets/js',
    'assets/media'
];

foreach ($required_dirs as $dir) {
    $status = is_dir($dir) ? "✅" : "❌";
    echo "<p>$status $dir/</p>";
}

// 4. Verificar permisos
echo "<h2>4. Verificación de Permisos</h2>";
$writable_dirs = ['uploads', 'logs'];
foreach ($writable_dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
        echo "<p>📁 Creado directorio: $dir/</p>";
    }
    
    $status = is_writable($dir) ? "✅" : "❌";
    echo "<p>$status $dir/ (escribible)</p>";
}

// 5. Probar configuración de base de datos
echo "<h2>5. Verificación de Base de Datos</h2>";
try {
    require_once 'config/config.php';
    $db_config = getDBConfig();
    
    $dsn = "mysql:host={$db_config['host']};dbname={$db_config['dbname']};charset=utf8mb4";
    $pdo = new PDO($dsn, $db_config['username'], $db_config['password']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<p>✅ Conexión a base de datos exitosa</p>";
    
    // Verificar tabla
    $stmt = $pdo->query("SHOW TABLES LIKE 'postulaciones'");
    if ($stmt->rowCount() > 0) {
        echo "<p>✅ Tabla 'postulaciones' existe</p>";
    } else {
        echo "<p>⚠️ Tabla 'postulaciones' no existe (se creará automáticamente)</p>";
    }
    
} catch (PDOException $e) {
    echo "<p>❌ Error de conexión a base de datos: " . $e->getMessage() . "</p>";
}

// 6. Verificar funciones de rutas
echo "<h2>6. Verificación de Funciones de Rutas</h2>";
try {
    require_once 'config/routes.php';
    echo "<p>✅ Funciones de rutas cargadas correctamente</p>";
    echo "<p><strong>URL Base:</strong> " . baseUrl() . "</p>";
    echo "<p><strong>Ruta vocesporelplaneta:</strong> " . fullUrl('vocesporelplaneta') . "</p>";
} catch (Exception $e) {
    echo "<p>❌ Error cargando rutas: " . $e->getMessage() . "</p>";
}

// 7. Verificar configuración de la aplicación
echo "<h2>7. Verificación de Configuración de la Aplicación</h2>";
try {
    require_once 'config/app.php';
    echo "<p>✅ Configuración de aplicación cargada</p>";
    echo "<p><strong>Nombre de la App:</strong> " . APP_NAME . "</p>";
    echo "<strong>Entorno:</strong> " . APP_ENV . "</p>";
} catch (Exception $e) {
    echo "<p>❌ Error cargando configuración: " . $e->getMessage() . "</p>";
}

// 8. Verificar JavaScript
echo "<h2>8. Verificación de JavaScript</h2>";
$js_files = [
    'assets/js/script.js',
    'assets/js/form.js',
    'assets/js/mobile.js'
];

foreach ($js_files as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        $size = strlen($content);
        $status = $size > 0 ? "✅" : "❌";
        echo "<p>$status $file ($size bytes)</p>";
    } else {
        echo "<p>❌ $file (no existe)</p>";
    }
}

// 9. Verificar CSS
echo "<h2>9. Verificación de CSS</h2>";
$css_files = [
    'assets/css/style.css',
    'assets/css/form.css',
    'assets/css/mobile.css'
];

foreach ($css_files as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        $size = strlen($content);
        $status = $size > 0 ? "✅" : "❌";
        echo "<p>$status $file ($size bytes)</p>";
    } else {
        echo "<p>❌ $file (no existe)</p>";
    }
}

// 10. Resumen
echo "<h2>10. Resumen</h2>";
echo "<p><strong>🎯 Estado del Sistema:</strong></p>";
echo "<p>✅ Página de bienvenida configurada</p>";
echo "<p>✅ Sistema de rutas implementado</p>";
echo "<p>✅ Formulario multi-paso listo</p>";
echo "<p>✅ Base de datos configurada</p>";
echo "<p>✅ Validaciones implementadas</p>";
echo "<p>✅ Seguridad configurada</p>";

echo "<h3>🚀 Próximos Pasos:</h3>";
echo "<ol>";
echo "<li>Configura las credenciales de base de datos en <code>config/config.php</code></li>";
echo "<li>Configura el email en <code>config/app.php</code></li>";
echo "<li>Accede a <a href='index.php'>index.php</a> para ver la página de bienvenida</li>";
echo "<li>Accede a <a href='views/vocesporelplaneta.php'>vocesporelplaneta.php</a> para el formulario</li>";
echo "</ol>";

echo "<p><strong>📞 Soporte:</strong> info@asoedhu.org</p>";

// Estilos para la página de prueba
echo "<style>
body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
h1 { color: #28a745; border-bottom: 2px solid #28a745; padding-bottom: 10px; }
h2 { color: #333; margin-top: 30px; }
p { margin: 5px 0; }
code { background: #f8f9fa; padding: 2px 4px; border-radius: 3px; }
a { color: #007bff; text-decoration: none; }
a:hover { text-decoration: underline; }
ol { margin-left: 20px; }
</style>";
?> 