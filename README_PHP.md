# Beca Voces por el Planeta - Sistema de Postulaciones

## Descripción

Sistema web para la gestión de postulaciones de la "Beca Voces por el Planeta", desarrollado en PHP con formulario multi-paso, validaciones, base de datos MySQL y funcionalidades avanzadas.

## Características

- ✅ **Formulario Multi-paso**: División en 2 secciones para mejor experiencia de usuario
- ✅ **Validaciones Complejas**: Validación en frontend y backend
- ✅ **Base de Datos MySQL**: Almacenamiento seguro de postulaciones
- ✅ **Geolocalización**: Departamentos y ciudades de Paraguay con selección dinámica
- ✅ **Subida de Archivos**: Soporte para imágenes y videos (máx. 50MB)
- ✅ **Contadores de Caracteres**: Validación en tiempo real
- ✅ **Email de Confirmación**: Notificación automática al postulante
- ✅ **Responsive Design**: Compatible con dispositivos móviles
- ✅ **Seguridad**: Protección CSRF, validación de IP, sanitización de datos
- ✅ **Logs y Estadísticas**: Registro de actividad y reportes

## Requisitos del Sistema

- PHP 7.4 o superior
- MySQL 5.7 o superior / MariaDB 10.2 o superior
- Servidor web (Apache/Nginx)
- Extensiones PHP: PDO, PDO_MySQL, fileinfo, mbstring

## Instalación

### 1. Configuración del Servidor

1. **Clona o descarga** los archivos en tu servidor web
2. **Configura el servidor web** para que apunte al directorio del proyecto
3. **Asegúrate de que PHP esté habilitado** en tu servidor

### 2. Configuración de la Base de Datos

1. **Crea una base de datos MySQL**:
```sql
CREATE DATABASE voces_planeta CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

2. **Edita el archivo `config.php`** con tus credenciales de base de datos:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'voces_planeta');
define('DB_USER', 'tu_usuario');
define('DB_PASS', 'tu_password');
```

### 3. Configuración de Permisos

1. **Crea los directorios necesarios**:
```bash
mkdir uploads
mkdir logs
```

2. **Establece permisos** (en sistemas Unix/Linux):
```bash
chmod 755 uploads/
chmod 755 logs/
chmod 644 *.php
chmod 644 *.css
chmod 644 *.js
```

### 4. Configuración de Email

Edita el archivo `config.php` para configurar el email:
```php
define('EMAIL_FROM', 'noreply@tudominio.com');
define('EMAIL_FROM_NAME', 'Beca Voces por el Planeta');
```

### 5. Configuración de Seguridad

1. **Cambia la URL de la aplicación** en `config.php`:
```php
define('APP_URL', 'https://tudominio.com');
```

2. **Configura HTTPS** si es posible para mayor seguridad

## Estructura de Archivos

```
├── index.php              # Página principal con formulario
├── process_form.php       # Procesamiento del formulario
├── config.php             # Configuración general
├── form.css               # Estilos del formulario
├── form.js                # JavaScript del formulario
├── style.css              # Estilos generales
├── mobile.css             # Estilos móviles
├── script.js              # JavaScript general
├── mobile.js              # JavaScript móvil
├── uploads/               # Directorio para archivos subidos
├── logs/                  # Directorio para logs
├── media/                 # Archivos multimedia
└── README_PHP.md          # Este archivo
```

## Funcionalidades del Formulario

### Paso 1: Datos Personales
- Nombre y apellido
- Edad (18-35 años)
- Departamento y ciudad (selección dinámica)
- Email y teléfono
- Tipo de obra (individual/colectiva)
- Profesión
- Portfolio/redes sociales

### Paso 2: Proyecto Artístico
- Categoría artística principal
- Título de la obra (máx. 100 caracteres)
- Técnica a utilizar (máx. 300 caracteres)
- Inspiración (máx. 500 caracteres)
- Mensaje a transmitir (máx. 300 caracteres)
- Archivo adjunto (opcional)
- Transportabilidad de la obra
- Cómo se enteró del concurso
- Preguntas sobre impacto climático
- Aceptación de bases y condiciones

## Características Técnicas

### Validaciones Implementadas
- **Frontend**: JavaScript para validación en tiempo real
- **Backend**: PHP para validación de seguridad
- **Base de Datos**: Restricciones a nivel de esquema

### Seguridad
- **CSRF Protection**: Tokens de seguridad
- **SQL Injection**: Prepared statements
- **XSS Protection**: Sanitización de datos
- **File Upload**: Validación de tipos y tamaños
- **Rate Limiting**: Límite de postulaciones por IP

### Base de Datos
La tabla `postulaciones` incluye:
- Datos personales del postulante
- Información del proyecto artístico
- Metadatos (IP, user agent, timestamp)
- Archivos adjuntos

## Configuración Avanzada

### Personalización de Estilos
Edita los archivos CSS para personalizar la apariencia:
- `style.css`: Estilos generales
- `form.css`: Estilos específicos del formulario
- `mobile.css`: Estilos para dispositivos móviles

### Modificación de Validaciones
Las validaciones se pueden modificar en:
- `form.js`: Validaciones del frontend
- `process_form.php`: Validaciones del backend

### Configuración de Email
Para personalizar los emails de confirmación, edita la función `enviarEmailConfirmacion()` en `process_form.php`.

## Mantenimiento

### Logs
El sistema genera logs en:
- `logs/actividad.log`: Actividad general
- `logs/error.log`: Errores del sistema

### Limpieza Automática
- Los archivos temporales se limpian automáticamente cada 24 horas
- Los logs se pueden limpiar manualmente

### Backup de Base de Datos
Recomendamos hacer backups regulares de la base de datos:
```bash
mysqldump -u usuario -p voces_planeta > backup_$(date +%Y%m%d).sql
```

## Solución de Problemas

### Error de Conexión a Base de Datos
1. Verifica las credenciales en `config.php`
2. Asegúrate de que MySQL esté ejecutándose
3. Verifica que la base de datos existe

### Error de Subida de Archivos
1. Verifica los permisos del directorio `uploads/`
2. Asegúrate de que PHP tenga permisos de escritura
3. Verifica el límite de tamaño en `php.ini`

### Error de Email
1. Verifica la configuración SMTP del servidor
2. Asegúrate de que la función `mail()` esté habilitada
3. Verifica el dominio del remitente

## Soporte

Para soporte técnico o consultas:
- Email: info@asoedhu.org
- Documentación: Revisa los comentarios en el código
- Logs: Revisa los archivos en `logs/` para diagnóstico

## Licencia

Este proyecto es desarrollado para ASOEDHU y WWF Paraguay. Todos los derechos reservados.

## Changelog

### v1.0.0 (2024)
- ✅ Formulario multi-paso implementado
- ✅ Base de datos MySQL configurada
- ✅ Validaciones frontend y backend
- ✅ Sistema de geolocalización para Paraguay
- ✅ Subida de archivos con validación
- ✅ Email de confirmación automático
- ✅ Diseño responsive
- ✅ Sistema de logs y estadísticas
- ✅ Medidas de seguridad implementadas 