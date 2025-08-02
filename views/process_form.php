<?php
session_start();

// Incluir configuración
require_once __DIR__ . '/../config/config.php';

// Configuración de la base de datos desde config.php
$db_config = getDBConfig();

// Función para conectar a la base de datos
function conectarDB($config) {
    try {
        $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4";
        $pdo = new PDO($dsn, $config['username'], $config['password']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        error_log("Error de conexión: " . $e->getMessage());
        return false;
    }
}

// Función para crear la tabla si no existe
function crearTabla($pdo) {
    $sql = "CREATE TABLE IF NOT EXISTS postulaciones (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(255) NOT NULL,
        edad INT NOT NULL,
        departamento VARCHAR(100) NOT NULL,
        ciudad VARCHAR(100) NOT NULL,
        barrio VARCHAR(100) NULL,
        direccion VARCHAR(255) NULL,
        email VARCHAR(255) NOT NULL,
        telefono VARCHAR(50) NOT NULL,
        tipo_obra ENUM('individual', 'colectiva') NOT NULL,
        integrantes INT NULL,
        profesion VARCHAR(100) NOT NULL,
        portfolio VARCHAR(500) NULL,
        categoria VARCHAR(10) NOT NULL,
        titulo_obra VARCHAR(100) NOT NULL,
        tecnica TEXT NOT NULL,
        inspiracion TEXT NOT NULL,
        mensaje TEXT NOT NULL,
        archivo_nombre VARCHAR(255) NULL,
        transportable ENUM('si', 'no') NOT NULL,
        como_enteraste VARCHAR(50) NOT NULL,
        accion_climatica TEXT NOT NULL,
        conexion_comunidad TEXT NOT NULL,
        sostenibilidad TEXT NOT NULL,
        acepta_bases BOOLEAN NOT NULL,
        fecha_postulacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        ip_address VARCHAR(45) NULL,
        user_agent TEXT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    try {
        $pdo->exec($sql);
        return true;
    } catch (PDOException $e) {
        error_log("Error creando tabla: " . $e->getMessage());
        return false;
    }
}

// Función para validar datos
function validarDatos($datos) {
    $errores = [];
    
    // Validar campos requeridos
    $campos_requeridos = [
        'nombre', 'edad', 'departamento', 'ciudad', 'email', 'telefono',
        'tipo_obra', 'profesion', 'categoria', 'titulo_obra', 'tecnica',
        'inspiracion', 'mensaje', 'transportable', 'como_enteraste',
        'accion_climatica', 'conexion_comunidad', 'sostenibilidad'
    ];
    
    foreach ($campos_requeridos as $campo) {
        if (empty($datos[$campo])) {
            $errores[] = "El campo '$campo' es requerido.";
        }
    }
    
    // Validar edad
    if (!empty($datos['edad'])) {
        $edad = intval($datos['edad']);
        if ($edad < 18 || $edad > 35) {
            $errores[] = "La edad debe estar entre 18 y 35 años.";
        }
    }
    
    // Validar email
    if (!empty($datos['email']) && !filter_var($datos['email'], FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El email no es válido.";
    }
    
    // Validar tipo de obra colectiva
    if ($datos['tipo_obra'] === 'colectiva' && empty($datos['integrantes'])) {
        $errores[] = "Debe especificar la cantidad de integrantes para obras colectivas.";
    }
    
    // Validar longitud de campos
    if (strlen($datos['titulo_obra']) > 100) {
        $errores[] = "El título de la obra no puede exceder 100 caracteres.";
    }
    
    if (strlen($datos['tecnica']) > 300) {
        $errores[] = "La descripción de la técnica no puede exceder 300 caracteres.";
    }
    
    if (strlen($datos['inspiracion']) > 500) {
        $errores[] = "La inspiración no puede exceder 500 caracteres.";
    }
    
    if (strlen($datos['mensaje']) > 300) {
        $errores[] = "El mensaje no puede exceder 300 caracteres.";
    }
    
    return $errores;
}

// Función para procesar archivo subido
function procesarArchivo($archivo) {
    if ($archivo['error'] !== UPLOAD_ERR_OK) {
        return ['error' => 'Error al subir el archivo'];
    }
    
    $tipos_permitidos = ['image/jpeg', 'image/png', 'video/mp4', 'video/quicktime'];
    $max_size = 50 * 1024 * 1024; // 50 MB
    
    // Validar tipo
    if (!in_array($archivo['type'], $tipos_permitidos)) {
        return ['error' => 'Tipo de archivo no permitido'];
    }
    
    // Validar tamaño
    if ($archivo['size'] > $max_size) {
        return ['error' => 'El archivo es demasiado grande (máximo 50 MB)'];
    }
    
    // Crear directorio de uploads si no existe
    $upload_dir = 'uploads/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    
    // Generar nombre único
    $extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
    $nombre_archivo = uniqid() . '_' . time() . '.' . $extension;
    $ruta_completa = $upload_dir . $nombre_archivo;
    
    // Mover archivo
    if (move_uploaded_file($archivo['tmp_name'], $ruta_completa)) {
        return ['success' => true, 'nombre' => $nombre_archivo];
    } else {
        return ['error' => 'Error al guardar el archivo'];
    }
}

// Función para guardar en base de datos
function guardarPostulacion($pdo, $datos) {
    $sql = "INSERT INTO postulaciones (
        nombre, edad, departamento, ciudad, barrio, direccion, email, telefono,
        tipo_obra, integrantes, profesion, portfolio, categoria,
        titulo_obra, tecnica, inspiracion, mensaje, archivo_nombre,
        transportable, como_enteraste, accion_climatica,
        conexion_comunidad, sostenibilidad, acepta_bases,
        ip_address, user_agent
    ) VALUES (
        :nombre, :edad, :departamento, :ciudad, :barrio, :direccion, :email, :telefono,
        :tipo_obra, :integrantes, :profesion, :portfolio, :categoria,
        :titulo_obra, :tecnica, :inspiracion, :mensaje, :archivo_nombre,
        :transportable, :como_enteraste, :accion_climatica,
        :conexion_comunidad, :sostenibilidad, :acepta_bases,
        :ip_address, :user_agent
    )";
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nombre' => $datos['nombre'],
            ':edad' => intval($datos['edad']),
            ':departamento' => $datos['departamento'],
            ':ciudad' => $datos['ciudad'],
            ':barrio' => $datos['barrio'] ?? null,
            ':direccion' => $datos['direccion'] ?? null,
            ':email' => $datos['email'],
            ':telefono' => $datos['telefono'],
            ':tipo_obra' => $datos['tipo_obra'],
            ':integrantes' => $datos['tipo_obra'] === 'colectiva' ? intval($datos['integrantes']) : null,
            ':profesion' => $datos['profesion'],
            ':portfolio' => $datos['portfolio'] ?? null,
            ':categoria' => $datos['categoria'],
            ':titulo_obra' => $datos['titulo_obra'],
            ':tecnica' => $datos['tecnica'],
            ':inspiracion' => $datos['inspiracion'],
            ':mensaje' => $datos['mensaje'],
            ':archivo_nombre' => $datos['archivo_nombre'] ?? null,
            ':transportable' => $datos['transportable'],
            ':como_enteraste' => $datos['como_enteraste'],
            ':accion_climatica' => $datos['accion_climatica'],
            ':conexion_comunidad' => $datos['conexion_comunidad'],
            ':sostenibilidad' => $datos['sostenibilidad'],
            ':acepta_bases' => isset($datos['acepta_bases']) ? 1 : 0,
            ':ip_address' => $_SERVER['REMOTE_ADDR'] ?? null,
            ':user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? null
        ]);
        
        return $pdo->lastInsertId();
    } catch (PDOException $e) {
        error_log("Error guardando postulación: " . $e->getMessage());
        return false;
    }
}

// Función para enviar email de confirmación
function enviarEmailConfirmacion($datos) {
    $to = $datos['email'];
    $subject = "Confirmación de Postulación - Beca Voces por el Planeta";
    
    $message = "
    <html>
    <head>
        <title>Confirmación de Postulación</title>
    </head>
    <body>
        <h2>¡Gracias por tu postulación!</h2>
        <p>Hola <strong>{$datos['nombre']}</strong>,</p>
        <p>Hemos recibido tu postulación para la <strong>Beca Voces por el Planeta</strong>.</p>
        
        <h3>Detalles de tu postulación:</h3>
        <ul>
            <li><strong>Proyecto:</strong> {$datos['titulo_obra']}</li>
            <li><strong>Categoría:</strong> {$datos['categoria']}</li>
            <li><strong>Departamento:</strong> {$datos['departamento']}</li>
            <li><strong>Ciudad:</strong> {$datos['ciudad']}</li>
            <li><strong>Barrio:</strong> " . ($datos['barrio'] ?? 'No especificado') . "</li>
            <li><strong>Dirección:</strong> " . ($datos['direccion'] ?? 'No especificada') . "</li>
        </ul>
        
        <h3>Próximos pasos:</h3>
        <ul>
            <li>Revisaremos todas las propuestas entre el 1 y 6 de septiembre de 2025.</li>
            <li>Publicaremos la lista de proyectos seleccionados el 15 de septiembre.</li>
            <li>Los resultados se publicarán en las redes de WWF Paraguay y ASOEDHU.</li>
        </ul>
        
        <p>Si tienes alguna duda, escríbenos a <strong>info@asoedhu.org</strong></p>
        
        <p><strong>¡Éxitos y gracias por crear arte en defensa del clima!</strong></p>
        
        <hr>
        <p><small>Este es un email automático, por favor no respondas a este mensaje.</small></p>
    </body>
    </html>
    ";
    
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: Beca Voces por el Planeta <noreply@asoedhu.org>" . "\r\n";
    
    return mail($to, $subject, $message, $headers);
}

// Procesar la solicitud
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = ['success' => false, 'message' => '', 'errors' => []];
    
    try {
        // Combinar datos de ambos pasos
        $datos_completos = array_merge(
            $_SESSION['step1_data'] ?? [],
            $_POST
        );
        
        // Validar datos
        $errores = validarDatos($datos_completos);
        if (!empty($errores)) {
            $response['errors'] = $errores;
            $response['message'] = 'Por favor, corrige los errores en el formulario.';
        } else {
            // Procesar archivo si se subió
            $archivo_nombre = null;
            if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] !== UPLOAD_ERR_NO_FILE) {
                $resultado_archivo = procesarArchivo($_FILES['archivo']);
                if (isset($resultado_archivo['error'])) {
                    $response['errors'][] = $resultado_archivo['error'];
                } else {
                    $archivo_nombre = $resultado_archivo['nombre'];
                }
            }
            
            if (empty($response['errors'])) {
                // Conectar a la base de datos
                $pdo = conectarDB($db_config);
                if ($pdo) {
                    // Crear tabla si no existe
                    if (crearTabla($pdo)) {
                        // Agregar nombre del archivo a los datos
                        $datos_completos['archivo_nombre'] = $archivo_nombre;
                        
                        // Guardar en base de datos
                        $id_postulacion = guardarPostulacion($pdo, $datos_completos);
                        
                        if ($id_postulacion) {
                            // Enviar email de confirmación
                            enviarEmailConfirmacion($datos_completos);
                            
                            // Limpiar sesión
                            unset($_SESSION['step1_data']);
                            unset($_SESSION['step2_data']);
                            
                            $response['success'] = true;
                            $response['message'] = '¡Postulación enviada exitosamente!';
                            $response['id'] = $id_postulacion;
                        } else {
                            $response['message'] = 'Error al guardar la postulación.';
                        }
                    } else {
                        $response['message'] = 'Error al crear la tabla de datos.';
                    }
                } else {
                    $response['message'] = 'Error de conexión a la base de datos.';
                }
            }
        }
    } catch (Exception $e) {
        error_log("Error procesando formulario: " . $e->getMessage());
        $response['message'] = 'Error interno del servidor.';
    }
    
    // Devolver respuesta JSON
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Si no es POST, redirigir al formulario
header('Location: index.php');
exit;
?> 