<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba de Estilos - Beca Voces por el Planeta</title>
    
    <!-- Fuentes -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    
    <!-- Estilos -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/mobile.css">
    <link rel="stylesheet" href="assets/css/form.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        .test-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        
        .test-section {
            margin: 30px 0;
            padding: 20px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
        }
        
        .test-section h3 {
            color: #28a745;
            margin-bottom: 15px;
        }
        
        .status {
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
        }
        
        .status.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .status.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: linear-gradient(45deg, #28a745, #20c997);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            margin: 10px 5px;
            transition: all 0.3s ease;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }
        
        .form-group {
            margin: 15px 0;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #333;
        }
        
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }
        
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #28a745;
        }
    </style>
</head>
<body>
    <div class="test-container">
        <h1><i class="fas fa-check-circle"></i> Prueba de Estilos - Beca Voces por el Planeta</h1>
        
        <div class="test-section">
            <h3>1. Verificación de Archivos CSS</h3>
            <?php
            $css_files = [
                'assets/css/style.css',
                'assets/css/mobile.css',
                'assets/css/form.css'
            ];
            
            foreach ($css_files as $file) {
                if (file_exists($file)) {
                    $size = filesize($file);
                    echo "<div class='status success'>✅ $file ($size bytes)</div>";
                } else {
                    echo "<div class='status error'>❌ $file (no encontrado)</div>";
                }
            }
            ?>
        </div>
        
        <div class="test-section">
            <h3>2. Verificación de Archivos JavaScript</h3>
            <?php
            $js_files = [
                'assets/js/script.js',
                'assets/js/mobile.js',
                'assets/js/form.js'
            ];
            
            foreach ($js_files as $file) {
                if (file_exists($file)) {
                    $size = filesize($file);
                    echo "<div class='status success'>✅ $file ($size bytes)</div>";
                } else {
                    echo "<div class='status error'>❌ $file (no encontrado)</div>";
                }
            }
            ?>
        </div>
        
        <div class="test-section">
            <h3>3. Prueba de Estilos Aplicados</h3>
            <p>Si puedes ver este texto con estilos, significa que los CSS se están cargando correctamente.</p>
            
            <div class="form-group">
                <label for="test-input">Campo de prueba:</label>
                <input type="text" id="test-input" placeholder="Escribe algo aquí...">
            </div>
            
            <div class="form-group">
                <label for="test-select">Selector de prueba:</label>
                <select id="test-select">
                    <option value="">Selecciona una opción</option>
                    <option value="1">Opción 1</option>
                    <option value="2">Opción 2</option>
                </select>
            </div>
            
            <a href="#" class="btn">Botón de Prueba</a>
        </div>
        
        <div class="test-section">
            <h3>4. Enlaces de Prueba</h3>
            <a href="index.php" class="btn">Ir a Página Principal</a>
            <a href="views/vocesporelplaneta.php" class="btn">Ir a Formulario</a>
            <a href="test.php" class="btn">Ver Test Completo</a>
        </div>
        
        <div class="test-section">
            <h3>5. Información del Sistema</h3>
            <p><strong>URL Actual:</strong> <?php echo $_SERVER['REQUEST_URI']; ?></p>
            <p><strong>Directorio Actual:</strong> <?php echo __DIR__; ?></p>
            <p><strong>Servidor:</strong> <?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'Desconocido'; ?></p>
            <p><strong>PHP Version:</strong> <?php echo phpversion(); ?></p>
        </div>
    </div>
    
    <!-- JavaScript -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="assets/js/script.js"></script>
    <script src="assets/js/mobile.js"></script>
    <script src="assets/js/form.js"></script>
    
    <script>
        // Verificar que JavaScript se carga correctamente
        console.log('✅ JavaScript cargado correctamente');
        
        // Verificar que los archivos CSS se cargaron
        document.addEventListener('DOMContentLoaded', function() {
            const styles = document.styleSheets;
            console.log('📄 Hojas de estilo cargadas:', styles.length);
            
            for (let i = 0; i < styles.length; i++) {
                try {
                    const rules = styles[i].cssRules || styles[i].rules;
                    console.log(`📄 Estilo ${i}: ${styles[i].href || 'inline'} - ${rules.length} reglas`);
                } catch (e) {
                    console.log(`📄 Estilo ${i}: ${styles[i].href || 'inline'} - Error al acceder`);
                }
            }
        });
    </script>
</body>
</html> 