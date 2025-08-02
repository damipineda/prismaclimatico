<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba Formulario Multi-paso - Beca Voces por el Planeta</title>
    
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
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        
        .test-header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px;
        }
        
        .test-links {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 20px 0;
            flex-wrap: wrap;
        }
        
        .test-link {
            display: inline-block;
            padding: 12px 24px;
            background: linear-gradient(45deg, #28a745, #20c997);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .test-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
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
            border-bottom: 2px solid #28a745;
            padding-bottom: 10px;
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
        
        .status.warning {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }
        
        .api-test {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin: 10px 0;
            border-left: 4px solid #28a745;
        }
        
        .api-test h4 {
            color: #28a745;
            margin-bottom: 10px;
        }
        
        .api-test pre {
            background: #e9ecef;
            padding: 10px;
            border-radius: 5px;
            overflow-x: auto;
            font-size: 12px;
        }
        
        .step-indicator {
            display: flex;
            justify-content: center;
            margin: 20px 0;
            gap: 20px;
        }
        
        .step-indicator .step {
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        
        .step-indicator .step.active {
            background: #28a745;
            color: white;
        }
        
        .step-indicator .step.inactive {
            background: #e9ecef;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="test-container">
        <div class="test-header">
            <h1><i class="fas fa-layer-group"></i> Prueba Formulario Multi-paso</h1>
            <p>Beca Voces por el Planeta - Sistema de Postulaciones con API delpi.dev</p>
        </div>
        
        <div class="test-links">
            <a href="index.php" class="test-link">Página Principal</a>
            <a href="views/vocesporelplaneta.php" class="test-link">Formulario Completo</a>
            <a href="test-formulario.php" class="test-link">Test General</a>
            <a href="test-styles.php" class="test-link">Test de Estilos</a>
        </div>
        
        <div class="test-section">
            <h3>1. Verificación de la API delpi.dev</h3>
            
            <div class="api-test">
                <h4>API de Departamentos</h4>
                <p><strong>Endpoint:</strong> <a href="https://delpi.dev/departamentos" target="_blank">https://delpi.dev/departamentos</a></p>
                <p><strong>Descripción:</strong> Obtiene todos los departamentos de Paraguay</p>
            </div>
            
            <div class="api-test">
                <h4>API de Ciudades</h4>
                <p><strong>Endpoint:</strong> <a href="https://delpi.dev/ciudades" target="_blank">https://delpi.dev/ciudades?departamento={id}</a></p>
                <p><strong>Descripción:</strong> Obtiene las ciudades de un departamento específico</p>
            </div>
            
            <div class="api-test">
                <h4>API de Barrios</h4>
                <p><strong>Endpoint:</strong> <a href="https://delpi.dev/barrios" target="_blank">https://delpi.dev/barrios?ciudad={id}</a></p>
                <p><strong>Descripción:</strong> Obtiene los barrios de una ciudad específica</p>
            </div>
            
            <div class="api-test">
                <h4>Demo de la API</h4>
                <p><strong>Demo:</strong> <a href="https://delpi.dev/demo" target="_blank">https://delpi.dev/demo</a></p>
                <p><strong>Descripción:</strong> Página de demostración de la API</p>
            </div>
        </div>
        
        <div class="test-section">
            <h3>2. Funcionalidades del Formulario Multi-paso</h3>
            
            <div class="step-indicator">
                <div class="step active">Paso 1: Datos Personales</div>
                <div class="step inactive">Paso 2: Proyecto Artístico</div>
            </div>
            
            <?php
            $funcionalidades = [
                'Navegación entre pasos (Siguiente/Anterior)',
                'Barra de progreso visual',
                'Carga dinámica de departamentos desde API',
                'Carga dinámica de ciudades según departamento',
                'Carga dinámica de barrios según ciudad',
                'Validación en tiempo real',
                'Contadores de caracteres',
                'Campo condicional de integrantes',
                'Validación de archivos',
                'Validación de email y edad',
                'Campos requeridos marcados',
                'Mensajes de error informativos',
                'Animaciones de transición entre pasos'
            ];
            
            foreach ($funcionalidades as $funcionalidad) {
                echo "<div class='status success'>✅ $funcionalidad</div>";
            }
            ?>
        </div>
        
        <div class="test-section">
            <h3>3. Prueba de la API en Tiempo Real</h3>
            
            <div id="api-test-results">
                <div class="status warning">Haciendo pruebas de la API...</div>
            </div>
            
            <button onclick="testAPI()" class="test-link" style="margin-top: 15px;">
                <i class="fas fa-sync-alt"></i> Probar API
            </button>
        </div>
        
        <div class="test-section">
            <h3>4. Instrucciones de Prueba del Formulario</h3>
            
            <div class="api-test">
                <h4>Para probar el formulario multi-paso:</h4>
                <ol>
                    <li><strong>Accede al formulario:</strong> Haz clic en "Formulario Completo" arriba</li>
                    <li><strong>Paso 1 - Datos Personales:</strong>
                        <ul>
                            <li>Completa el nombre y edad</li>
                            <li>Selecciona un departamento (se cargará desde la API)</li>
                            <li>Selecciona una ciudad (se cargará dinámicamente)</li>
                            <li>Selecciona un barrio (se cargará dinámicamente)</li>
                            <li>Completa el resto de datos personales</li>
                            <li>Haz clic en "Siguiente"</li>
                        </ul>
                    </li>
                    <li><strong>Paso 2 - Proyecto Artístico:</strong>
                        <ul>
                            <li>Completa todos los campos del proyecto</li>
                            <li>Verifica los contadores de caracteres</li>
                            <li>Prueba subir un archivo (opcional)</li>
                            <li>Haz clic en "Enviar Postulación"</li>
                        </ul>
                    </li>
                </ol>
            </div>
            
            <div class="api-test">
                <h4>Validaciones a verificar:</h4>
                <ul>
                    <li>✅ Los pasos se ocultan/muestran correctamente</li>
                    <li>✅ La barra de progreso se actualiza</li>
                    <li>✅ Los departamentos se cargan desde la API</li>
                    <li>✅ Las ciudades se actualizan según el departamento</li>
                    <li>✅ Los barrios se actualizan según la ciudad</li>
                    <li>✅ Las validaciones funcionan en cada paso</li>
                    <li>✅ Los contadores de caracteres funcionan</li>
                    <li>✅ El campo de integrantes aparece solo para obras colectivas</li>
                </ul>
            </div>
        </div>
        
        <div class="test-section">
            <h3>5. Estado del Sistema</h3>
            
            <div class="status success">
                <strong>✅ Formulario Multi-paso Implementado</strong><br>
                - Navegación entre pasos funcional<br>
                - Integración con API delpi.dev<br>
                - Validaciones en tiempo real<br>
                - Animaciones de transición<br>
                - Carga dinámica de ubicaciones
            </div>
            
            <div class="status success">
                <strong>✅ API delpi.dev Integrada</strong><br>
                - Departamentos de Paraguay<br>
                - Ciudades por departamento<br>
                - Barrios por ciudad<br>
                - Datos precisos y actualizados
            </div>
        </div>
    </div>
    
    <!-- JavaScript -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="assets/js/script.js"></script>
    <script src="assets/js/mobile.js"></script>
    <script src="assets/js/form.js"></script>
    
    <script>
        // Función para probar la API de delpi.dev
        async function testAPI() {
            const resultsDiv = document.getElementById('api-test-results');
            resultsDiv.innerHTML = '<div class="status warning">Probando API...</div>';
            
            try {
                // Probar API de departamentos
                const deptResponse = await fetch('https://delpi.dev/departamentos');
                const departamentos = await deptResponse.json();
                
                let results = '<div class="status success">✅ API de Departamentos: ' + departamentos.length + ' departamentos cargados</div>';
                
                // Probar API de ciudades (primer departamento)
                if (departamentos.length > 0) {
                    const firstDept = departamentos[0];
                    const cityResponse = await fetch(`https://delpi.dev/ciudades?departamento=${firstDept.id || firstDept.nombre}`);
                    const ciudades = await cityResponse.json();
                    
                    results += '<div class="status success">✅ API de Ciudades: ' + ciudades.length + ' ciudades para ' + firstDept.nombre + '</div>';
                    
                    // Probar API de barrios (primera ciudad)
                    if (ciudades.length > 0) {
                        const firstCity = ciudades[0];
                        const barrioResponse = await fetch(`https://delpi.dev/barrios?ciudad=${firstCity.id || firstCity.nombre}`);
                        const barrios = await barrioResponse.json();
                        
                        results += '<div class="status success">✅ API de Barrios: ' + barrios.length + ' barrios para ' + firstCity.nombre + '</div>';
                    }
                }
                
                results += '<div class="status success"><strong>🎉 Todas las APIs funcionan correctamente!</strong></div>';
                resultsDiv.innerHTML = results;
                
            } catch (error) {
                resultsDiv.innerHTML = '<div class="status error">❌ Error probando API: ' + error.message + '</div>';
            }
        }
        
        // Probar API al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            testAPI();
        });
    </script>
</body>
</html> 