# Documentación para la API de Departamentos y Barrios

## Introducción

Este conjunto de archivos proporciona una solución robusta para manejar la carga de departamentos y barrios de Paraguay en aplicaciones web, incluso cuando la API externa está caída o hay problemas de conexión.

## Archivos incluidos

- **assets/js/departamentos.js**: Archivo principal con funciones para cargar departamentos y barrios
- **assets/css/api-status.css**: Estilos para mostrar el estado de la conexión API
- **ejemplo-formulario.html**: Ejemplo de implementación en un formulario

## Funciones principales

- **cargarDepartamentos(selectId, callback, refreshCache)**: Carga los departamentos en un select
- **cargarBarriosPorDepartamento(departamentoId, selectId, callback)**: Carga los barrios de un departamento
- **getNombreDepartamento(id)**: Obtiene el nombre de un departamento por su ID
- **verificarConexionAPI(callback)**: Verifica si la API está disponible
- **repararConexionAPI(messageElementId)**: Muestra mensajes de estado y opciones de solución

## Uso básico

1. Incluir los archivos JS y CSS necesarios:

```html
<link rel="stylesheet" href="assets/css/api-status.css" />
<script src="assets/js/departamentos.js"></script>
```

2. Crear los elementos select para departamentos y barrios:

```html
<select id="departamento">
  <option value="">Seleccione un departamento</option>
</select>

<select id="barrio">
  <option value="">Seleccione un barrio</option>
</select>

<div id="api-status" class="api-status"></div>
```

3. Inicializar los selectores con JavaScript:

```javascript
// Cargar departamentos al iniciar
cargarDepartamentos("departamento", function () {
  console.log("Departamentos cargados correctamente");
});

// Manejar cambio en departamento para cargar barrios
document.getElementById("departamento").addEventListener("change", function () {
  const departamentoId = this.value;
  if (departamentoId) {
    cargarBarriosPorDepartamento(departamentoId, "barrio");
  }
});

// Verificar estado de la API cuando sea necesario
document.getElementById("btn-verificar").addEventListener("click", function () {
  repararConexionAPI("api-status");
});
```

## Manejo de errores

- Incluye sistema de caché local para cuando la API no está disponible
- Timeouts para detectar problemas de conexión
- Mensajes de error claros para el usuario
- Opciones para reintentar la conexión

## Personalización

Puedes personalizar el comportamiento modificando:

1. **Cache de barrios**: Añadir más barrios a la variable `barriosData` para más departamentos
2. **Tiempos de espera**: Ajustar los tiempos de timeout según la velocidad de conexión esperada
3. **Mensajes**: Personalizar los mensajes de error y éxito según la aplicación

Ver el archivo ejemplo-formulario.html para una implementación completa.
