/**
 * Manejo de carga de departamentos de Paraguay
 * Solución para evitar problemas con la API externa
 */

// Datos de los departamentos (cache local)
const departamentosData = [
  {
    "id": 1,
    "nombre": "ASUNCIÓN",
    "gps": {
      "lat": -25.2637,
      "long": -57.5759
    },
    "dato": "Capital y ciudad más grande de Paraguay, independiente de la división departamental."
  },
  {
    "id": 2,
    "nombre": "CONCEPCION",
    "gps": {
      "lat": -23.4064,
      "long": -57.4344
    },
    "dato": "Conocido por el río Paraguay y su comercio."
  },
  {
    "id": 3,
    "nombre": "SAN PEDRO",
    "gps": {
      "lat": -24.0899,
      "long": -57.0759
    },
    "dato": "Mayor departamento por área, con significativa producción agrícola."
  },
  {
    "id": 4,
    "nombre": "CORDILLERA",
    "gps": {
      "lat": -25.2049,
      "long": -57.5503
    },
    "dato": "Hogar del sitio de Patrimonio Mundial de la UNESCO de las Misiones Jesuíticas."
  },
  {
    "id": 5,
    "nombre": "GUAIRA",
    "gps": {
      "lat": -25.5097,
      "long": -56.4547
    },
    "dato": "Conocido por el Salto del Guairá, una significativa cascada antes de su sumersión."
  },
  {
    "id": 6,
    "nombre": "CAAGUAZU",
    "gps": {
      "lat": -25.4682,
      "long": -56.0153
    },
    "dato": "Importante para la producción de madera y yerba mate."
  },
  {
    "id": 7,
    "nombre": "CAAZAPA",
    "gps": {
      "lat": -26.2005,
      "long": -56.3803
    },
    "dato": "Conocido por su cultura musical, incluyendo la producción de arpas paraguayas."
  },
  {
    "id": 8,
    "nombre": "ITAPUA",
    "gps": {
      "lat": -27.3306,
      "long": -55.8638
    },
    "dato": "Alberga Encarnación, conocida por sus playas y carnaval."
  },
  {
    "id": 9,
    "nombre": "MISIONES",
    "gps": {
      "lat": -26.8601,
      "long": -57.2829
    },
    "dato": "Nombrado por las Misiones Jesuíticas, con un rico patrimonio cultural."
  },
  {
    "id": 10,
    "nombre": "PARAGUARI",
    "gps": {
      "lat": -25.6209,
      "long": -57.1516
    },
    "dato": "Sitio histórico de la Batalla de Paraguari durante la Guerra del Paraguay."
  },
  {
    "id": 11,
    "nombre": "ALTO PARANA",
    "gps": {
      "lat": -25.5545,
      "long": -54.611
    },
    "dato": "Hogar de la represa de Itaipú, una de las plantas hidroeléctricas más grandes del mundo."
  },
  {
    "id": 12,
    "nombre": "CENTRAL",
    "gps": {
      "lat": -25.3333,
      "long": -57.5333
    },
    "dato": "Departamento más poblado, un centro industrial y comercial."
  },
  {
    "id": 13,
    "nombre": "ÑEEMBUCU",
    "gps": {
      "lat": -26.96,
      "long": -58.28
    },
    "dato": "Caracterizado por sus humedales y la histórica ciudad de Alberdi."
  },
  {
    "id": 14,
    "nombre": "AMAMBAY",
    "gps": {
      "lat": -23.3428,
      "long": -56.4708
    },
    "dato": "Conocido por el Parque Nacional Cerro Corá, la mayor área protegida del país."
  },
  {
    "id": 15,
    "nombre": "CANINDEYU",
    "gps": {
      "lat": -24.1697,
      "long": -55.25
    },
    "dato": "Fronterizo con Brasil, es significativo por su agricultura y reservas naturales."
  },
  {
    "id": 16,
    "nombre": "PRESIDENTE HAYES",
    "gps": {
      "lat": -23.4628,
      "long": -58.1694
    },
    "dato": "Nombrado en honor a Rutherford B. Hayes, 19º Presidente de los Estados Unidos."
  },
  {
    "id": 17,
    "nombre": "ALTO PARAGUAY",
    "gps": {
      "lat": -20.1703,
      "long": -58.167
    },
    "dato": "Cuenta con el Parque Nacional Defensores del Chaco, con ecosistemas diversos."
  },
  {
    "id": 18,
    "nombre": "BOQUERÓN",
    "gps": {
      "lat": -22.6667,
      "long": -60.1667
    },
    "dato": "Habitado principalmente por comunidades indígenas, con grandes áreas del Chaco."
  }
];

/**
 * Carga los departamentos desde una fuente local o remota
 * @param {string} selectId - ID del elemento select donde cargar los departamentos
 * @param {Function} callback - Función a ejecutar después de cargar (opcional)
 * @param {boolean} refreshCache - Si es true, intenta actualizar la caché local desde la API primero
 */
function cargarDepartamentos(selectId, callback = null, refreshCache = false) {
  const selectElement = document.getElementById(selectId);
  
  if (!selectElement) {
    console.error(`Elemento con ID "${selectId}" no encontrado`);
    return;
  }
  
  // Limpiar opciones existentes
  selectElement.innerHTML = '<option value="">Seleccione un departamento</option>';
  
  // Si queremos intentar refrescar la caché primero
  if (refreshCache) {
    // Configuramos un timeout para detectar problemas de conexión
    const timeoutPromise = new Promise((_, reject) => 
      setTimeout(() => reject(new Error('Timeout al conectar a la API')), 5000)
    );
    
    // Intentamos actualizar desde la API primero
    Promise.race([
      fetch('https://api.delpi.dev/api/departamentos'),
      timeoutPromise
    ])
      .then(response => {
        if (!response.ok) {
          throw new Error(`Error en la respuesta de la API: ${response.status}`);
        }
        return response.json();
      })
      .then(data => {
        // Verificamos si la estructura es la esperada
        const departamentos = data.data || data;
        
        if (Array.isArray(departamentos) && departamentos.length > 0) {
          cargarOpcionesDepartamentos(selectElement, departamentos, callback);
          console.log('Departamentos actualizados exitosamente desde API');
          
          // Podríamos guardar esto en localStorage para futuras visitas
          try {
            localStorage.setItem('departamentosCache', JSON.stringify(departamentos));
            console.log('Caché local actualizada');
          } catch (e) {
            console.warn('No se pudo guardar en localStorage:', e);
          }
        } else {
          throw new Error('Formato de datos incorrecto o lista vacía');
        }
      })
      .catch(error => {
        console.warn(`No se pudo actualizar desde API: ${error.message}. Usando caché local.`);
        cargarDesdeLocal();
      });
  } else {
    // Directamente usamos la caché local
    cargarDesdeLocal();
  }
  
  // Función para cargar desde datos locales
  function cargarDesdeLocal() {
    try {
      // Primero intentamos usar la versión en caché local
      cargarOpcionesDepartamentos(selectElement, departamentosData, callback);
      console.log('Departamentos cargados exitosamente desde caché local');
      
      // Agregamos nota sobre origen de datos solo cuando usamos caché local sin intentar API
      if (!refreshCache) {
        const notaOption = document.createElement('option');
        notaOption.disabled = true;
        notaOption.value = "";
        notaOption.textContent = "ℹ️ Datos locales - Puede intentar actualizar";
        selectElement.insertBefore(notaOption, selectElement.childNodes[1]);
      }
    } catch (errorLocal) {
      console.error('Error crítico al cargar departamentos:', errorLocal);
      
      // En caso de error grave, mostramos mensaje al usuario
      const errorOption = document.createElement('option');
      errorOption.value = "";
      errorOption.textContent = "Error al cargar - Recargue la página";
      selectElement.appendChild(errorOption);
    }
  }
  
  // Función auxiliar para cargar las opciones en el select
  function cargarOpcionesDepartamentos(select, departamentos, callback) {
    departamentos.forEach(depto => {
      const option = document.createElement('option');
      option.value = depto.id;
      option.textContent = depto.nombre;
      select.appendChild(option);
    });
    
    if (callback && typeof callback === 'function') {
      callback(departamentos);
    }
  }
}

/**
 * Obtiene el nombre de un departamento por su ID
 * @param {number} id - ID del departamento
 * @returns {string} Nombre del departamento o cadena vacía si no se encuentra
 */
function getNombreDepartamento(id) {
  const depto = departamentosData.find(d => d.id === parseInt(id));
  return depto ? depto.nombre : '';
}

// Datos locales de barrios por departamento (versión simplificada para casos de error)
const barriosData = {
  // Asunción (id: 1)
  "1": [
    { id: 1, nombre: "Barrio Jara" },
    { id: 2, nombre: "Barrio Obrero" },
    { id: 3, nombre: "Sajonia" },
    { id: 4, nombre: "San Roque" },
    { id: 5, nombre: "Recoleta" },
    { id: 6, nombre: "Villa Morra" },
    { id: 7, nombre: "Carmelitas" },
    { id: 8, nombre: "Centro" }
  ],
  // Central (id: 12)
  "12": [
    { id: 1, nombre: "Lambaré" },
    { id: 2, nombre: "Fernando de la Mora" },
    { id: 3, nombre: "San Lorenzo" },
    { id: 4, nombre: "Luque" },
    { id: 5, nombre: "Mariano Roque Alonso" },
    { id: 6, nombre: "Capiatá" }
  ],
  // Otros departamentos - barrios básicos para tener una opción por defecto
  "default": [
    { id: 1, nombre: "Ciudad Capital" },
    { id: 2, nombre: "Zona Urbana" },
    { id: 3, nombre: "Zona Rural" }
  ]
};

/**
 * Carga los barrios de un departamento
 * @param {string} departamentoId - ID del departamento
 * @param {string} selectId - ID del elemento select donde cargar los barrios
 * @param {Function} callback - Función a ejecutar después de cargar (opcional)
 */
function cargarBarriosPorDepartamento(departamentoId, selectId, callback = null) {
  const selectElement = document.getElementById(selectId);
  
  if (!selectElement) {
    console.error(`Elemento con ID "${selectId}" no encontrado`);
    return;
  }
  
  // Limpiar opciones existentes
  selectElement.innerHTML = '<option value="">Seleccione un barrio</option>';
  
  if (!departamentoId) {
    return; // No hay departamento seleccionado
  }
  
  // Variable para controlar si se usa la caché local
  let usandoCache = false;
  
  // Configuramos un timeout para detectar problemas de conexión
  const timeoutPromise = new Promise((_, reject) => 
    setTimeout(() => reject(new Error('Timeout al conectar a la API')), 5000)
  );
  
  // Intentamos usar la API con un timeout
  Promise.race([
    fetch(`https://api.delpi.dev/api/barrios/${departamentoId}`),
    timeoutPromise
  ])
    .then(response => {
      if (!response.ok) {
        throw new Error(`Error en la respuesta de la API: ${response.status}`);
      }
      return response.json();
    })
    .then(data => {
      // Verificamos si la estructura es la esperada
      const barrios = data.data || data;
      
      if (Array.isArray(barrios) && barrios.length > 0) {
        barrios.forEach(barrio => {
          const option = document.createElement('option');
          option.value = barrio.id;
          option.textContent = barrio.nombre;
          selectElement.appendChild(option);
        });
        
        if (callback && typeof callback === 'function') {
          callback(barrios);
        }
        
        console.log(`Barrios cargados exitosamente desde API para departamento ${departamentoId}`);
      } else {
        console.warn('API devolvió una lista vacía o con formato incorrecto, usando caché local');
        throw new Error('Lista de barrios vacía o formato incorrecto');
      }
    })
    .catch(error => {
      console.warn(`No se pudieron cargar barrios desde API: ${error.message}. Usando datos locales.`);
      usandoCache = true;
      
      // Usamos datos locales como respaldo
      const barrios = barriosData[departamentoId] || barriosData.default;
      
      barrios.forEach(barrio => {
        const option = document.createElement('option');
        option.value = barrio.id;
        option.textContent = barrio.nombre;
        selectElement.appendChild(option);
      });
      
      // Agregamos un mensaje visible al usuario de que son datos locales
      const notaOption = document.createElement('option');
      notaOption.disabled = true;
      notaOption.value = "";
      notaOption.textContent = "⚠️ Usando datos locales - Conexión limitada";
      selectElement.insertBefore(notaOption, selectElement.firstChild);
      
      if (callback && typeof callback === 'function') {
        callback(barrios);
      }
    });
}

/**
 * Verifica el estado de conexión con la API
 * @param {Function} callback - Función a ejecutar después de verificar la conexión
 * @returns {Promise<boolean>} - Promesa que resuelve a true si la API está disponible
 */
function verificarConexionAPI(callback = null) {
  return new Promise((resolve) => {
    // Configuramos un timeout corto para verificar rápidamente
    const timeoutPromise = new Promise((_, reject) => 
      setTimeout(() => reject(new Error('Timeout')), 3000)
    );
    
    Promise.race([
      fetch('https://api.delpi.dev/api/departamentos'),
      timeoutPromise
    ])
      .then(response => {
        const disponible = response.ok;
        if (callback && typeof callback === 'function') {
          callback(disponible);
        }
        resolve(disponible);
        console.log(`API ${disponible ? 'disponible' : 'no disponible'}`);
      })
      .catch(error => {
        console.warn('Error al verificar API:', error);
        if (callback && typeof callback === 'function') {
          callback(false);
        }
        resolve(false);
      });
  });
}

/**
 * Intenta reparar la conexión o sugerir soluciones al usuario
 * @param {string} messageElementId - ID del elemento donde mostrar mensajes
 */
function repararConexionAPI(messageElementId) {
  const messageElement = document.getElementById(messageElementId);
  
  if (!messageElement) {
    console.error(`Elemento con ID "${messageElementId}" no encontrado`);
    return;
  }
  
  messageElement.innerHTML = "Verificando conexión con la API...";
  messageElement.classList.add('checking');
  
  verificarConexionAPI((disponible) => {
    if (disponible) {
      messageElement.innerHTML = "✅ Conexión establecida. Puede continuar utilizando el formulario.";
      messageElement.classList.remove('checking');
      messageElement.classList.add('success');
      setTimeout(() => {
        messageElement.innerHTML = "";
        messageElement.classList.remove('success');
      }, 3000);
    } else {
      messageElement.innerHTML = `
        <strong>⚠️ Problemas de conexión detectados</strong>
        <ul>
          <li>Verifique su conexión a Internet</li>
          <li>Es posible que la API esté temporalmente fuera de servicio</li>
          <li>Se están usando datos locales como respaldo</li>
        </ul>
        <button id="retry-connection" class="btn btn-sm btn-primary mt-2">Intentar nuevamente</button>
      `;
      messageElement.classList.remove('checking');
      messageElement.classList.add('error');
      
      // Agregar evento al botón de reintento
      document.getElementById('retry-connection').addEventListener('click', function() {
        repararConexionAPI(messageElementId);
      });
    }
  });
}

// Exportamos las funciones para su uso
window.cargarDepartamentos = cargarDepartamentos;
window.getNombreDepartamento = getNombreDepartamento;
window.cargarBarriosPorDepartamento = cargarBarriosPorDepartamento;
window.verificarConexionAPI = verificarConexionAPI;
window.repararConexionAPI = repararConexionAPI;
