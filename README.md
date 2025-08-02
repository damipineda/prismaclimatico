# Beca Voces por el Planeta - Sistema de Postulaciones

## 🎨 Descripción

Sistema web completo para la gestión de postulaciones de la "Beca Voces por el Planeta", desarrollado en PHP con arquitectura MVC, formulario multi-paso, validaciones avanzadas y base de datos MySQL.

## 🚀 Características

- ✅ **Página de Bienvenida**: Diseño atractivo con mensaje de bienvenida
- ✅ **Formulario Multi-paso**: División en 2 secciones para mejor UX
- ✅ **Arquitectura MVC**: Estructura organizada y mantenible
- ✅ **Sistema de Rutas**: URLs amigables y SEO-friendly
- ✅ **Validaciones Complejas**: Frontend y backend
- ✅ **Base de Datos MySQL**: Almacenamiento seguro
- ✅ **Geolocalización Paraguay**: Departamentos y ciudades dinámicas
- ✅ **Subida de Archivos**: Imágenes y videos (máx. 50MB)
- ✅ **Email de Confirmación**: Notificación automática
- ✅ **Responsive Design**: Compatible móviles
- ✅ **Seguridad Avanzada**: CSRF, XSS, SQL Injection protection

## 📁 Estructura del Proyecto

```
├── index.php                 # Página principal de bienvenida
├── .htaccess                 # Configuración Apache
├── README.md                 # Documentación
├── config/                   # Configuraciones
│   ├── app.php              # Configuración principal
│   ├── config.php           # Configuración base de datos
│   └── routes.php           # Configuración rutas
├── views/                    # Vistas/Páginas
│   ├── vocesporelplaneta.php # Página principal con formulario
│   ├── process_form.php     # Procesamiento formulario
│   └── formulario.html      # Formulario HTML
├── routes/                   # Sistema de rutas
│   └── router.php           # Router principal
├── assets/                   # Recursos estáticos
│   ├── css/                 # Hojas de estilo
│   │   ├── style.css        # Estilos generales
│   │   ├── mobile.css       # Estilos móviles
│   │   └── form.css         # Estilos formulario
│   ├── js/                  # JavaScript
│   │   ├── script.js        # JS general
│   │   ├── mobile.js        # JS móvil
│   │   └── form.js          # JS formulario
│   └── media/               # Archivos multimedia
├── uploads/                  # Archivos subidos
└── logs/                     # Logs del sistema
```

## 🛠️ Requisitos del Sistema

- **PHP**: 7.4 o superior
- **MySQL**: 5.7 o superior / MariaDB 10.2+
- **Servidor Web**: Apache/Nginx
- **Extensiones PHP**: PDO, PDO_MySQL, fileinfo, mbstring

## ⚙️ Instalación

### 1. Configuración del Servidor

1. **Clona o descarga** los archivos en tu servidor web
2. **Configura el servidor web** para que apunte al directorio del proyecto
3. **Asegúrate de que PHP esté habilitado** en tu servidor

### 2. Configuración de la Base de Datos

1. **Crea una base de datos MySQL**:
```sql
CREATE DATABASE voces_planeta CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

2. **Edita el archivo `config/config.php`** con tus credenciales:
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

2. **Establece permisos** (Unix/Linux):
```bash
chmod 755 uploads/
chmod 755 logs/
chmod 644 *.php
chmod 644 assets/css/*.css
chmod 644 assets/js/*.js
```

### 4. Configuración de Email

Edita `config/app.php` para configurar el email:
```php
define('EMAIL_FROM', 'noreply@tudominio.com');
define('EMAIL_FROM_NAME', 'Beca Voces por el Planeta');
```

## 🌐 URLs del Sistema

- **Página Principal**: `/` - Mensaje de bienvenida
- **Formulario**: `/vocesporelplaneta` - Formulario de postulación
- **Procesamiento**: `/process-form` - Procesa el formulario (POST)

## 🎯 Funcionalidades

### Página de Bienvenida (`index.php`)
- Diseño atractivo con gradientes y animaciones
- Mensaje de bienvenida personalizado
- Botón CTA que lleva al formulario
- Características destacadas del programa

### Formulario Multi-paso (`views/vocesporelplaneta.php`)

#### Paso 1: Datos Personales
- Nombre y apellido
- Edad (18-35 años)
- Departamento y ciudad (selección dinámica)
- Email y teléfono
- Tipo de obra (individual/colectiva)
- Profesión
- Portfolio/redes sociales

#### Paso 2: Proyecto Artístico
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

## 🔧 Configuración Avanzada

### Personalización de Estilos
Los estilos se encuentran en `assets/css/`:
- `style.css`: Estilos generales
- `mobile.css`: Estilos para dispositivos móviles
- `form.css`: Estilos específicos del formulario

### Modificación de Validaciones
- **Frontend**: `assets/js/form.js`
- **Backend**: `views/process_form.php`

### Configuración de Rutas
Edita `config/routes.php` para modificar las URLs del sistema.

## 🔒 Seguridad

- **CSRF Protection**: Tokens de seguridad en formularios
- **SQL Injection**: Prepared statements
- **XSS Protection**: Sanitización de datos
- **File Upload**: Validación de tipos y tamaños
- **Rate Limiting**: Límite de postulaciones por IP
- **Headers de Seguridad**: CSP, X-Frame-Options, etc.

## 📊 Base de Datos

La tabla `postulaciones` incluye:
- Datos personales del postulante
- Información del proyecto artístico
- Metadatos (IP, user agent, timestamp)
- Archivos adjuntos

## 📧 Email de Confirmación

El sistema envía automáticamente un email de confirmación con:
- Detalles de la postulación
- Próximos pasos
- Información de contacto

## 🛠️ Mantenimiento

### Logs
- `logs/app.log`: Actividad general
- `logs/error.log`: Errores del sistema

### Limpieza Automática
- Archivos temporales se limpian cada 24 horas
- Logs se pueden limpiar manualmente

### Backup
```bash
mysqldump -u usuario -p voces_planeta > backup_$(date +%Y%m%d).sql
```

## 🐛 Solución de Problemas

### Error de Conexión a Base de Datos
1. Verifica credenciales en `config/config.php`
2. Asegúrate de que MySQL esté ejecutándose
3. Verifica que la base de datos existe

### Error de Subida de Archivos
1. Verifica permisos del directorio `uploads/`
2. Asegúrate de que PHP tenga permisos de escritura
3. Verifica límite de tamaño en `php.ini`

### Error de Email
1. Verifica configuración SMTP del servidor
2. Asegúrate de que la función `mail()` esté habilitada
3. Verifica el dominio del remitente

## 📞 Soporte

Para soporte técnico o consultas:
- **Email**: info@asoedhu.org
- **Documentación**: Revisa los comentarios en el código
- **Logs**: Revisa los archivos en `logs/` para diagnóstico

## 📄 Licencia

Este proyecto es desarrollado para ASOEDHU y WWF Paraguay. Todos los derechos reservados.

## 📝 Changelog

### v1.0.0 (2024)
- ✅ Página de bienvenida implementada
- ✅ Arquitectura MVC organizada
- ✅ Sistema de rutas implementado
- ✅ Formulario multi-paso funcional
- ✅ Base de datos MySQL configurada
- ✅ Validaciones frontend y backend
- ✅ Sistema de geolocalización para Paraguay
- ✅ Subida de archivos con validación
- ✅ Email de confirmación automático
- ✅ Diseño responsive
- ✅ Sistema de logs y estadísticas
- ✅ Medidas de seguridad implementadas
