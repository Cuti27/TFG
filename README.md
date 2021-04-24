# TFG

- [TFG](#tfg)
  - [Frontend realizado mediante **Vue**](#frontend-realizado-mediante-vue)
  - [Backend conexión con la base de datos y API mediante **Laravel** PHP](#backend-conexión-con-la-base-de-datos-y-api-mediante-laravel-php)
    - [Conexión con los dispositivos mediante **Node-Red**](#conexión-con-los-dispositivos-mediante-node-red)
  - [Dudas respecto al diseño de la página web](#dudas-respecto-al-diseño-de-la-página-web)

## Frontend realizado mediante **Vue**

La idea es realizar el frontend de la página utilizando Vue y componentes vue, para que la página sea reactiva, y permitir el funcionamiento como un SPA (Single page aplication), comunicandose con el backend mediante la creación de una API para recuperar los datos y modificarlos.

La ejecución se realiza moviendose a la carpeta frontend y realizando ```npm run serve```, para salir a producción se realizará ```npm run build``` que genera los archivos necesarios para su correcto funcionamiento, generalmente un html y una serie de archivos css/javascript

**REALIZADO:**
- Estudio de **Vue**, junto **Vuex**, **Vue-Router** y librerias para aumentar su funcionalidad como **Vue-boostrap**
- Estudio del funcionamiento de Css, tanto con **Grid** como **Flexbox** y **Bootstrap**
- Desarrollo de una serie de componentes:
  - DaySelector: Nos permite seleccionar los dias de una semana
  - List: Nos permite mostrar una lista de programas
  - Modal: Util para crear una ventana modal
  - NumberSelector: Un selector de números, útil para seleccionar una hora:minutos:segundos
  - SectionSelector: Matriz de seleccionables, con siete columnas, donde se van añadiendo botones dependiendo del tamaño especificado
  - SorceSelecto: Similar al anterior, pero sin la limitación de las columnas, la idea es utilizarlo para las bombas
- Creado una vista para ir probando los componentes, y otra para empezar a maquetar el visor del programa seleccionado
- Creado una barra de navegación provisional
- Comenzado con el desarrollo de la pestaña de fertirrigacion
- Realziado pantalla principal
- Realizado Login y Registro
- Realización de tour de ayuda

**TODO:**
- Centralizar la información completa del programa en Vuex
- Mirar si utilizar un servicio de autenticación o como se va realizar la autenticación con el backend
- Mejorar la vista del programa, y realizar el resto de vistas
- Realizar la futura conexión con la API
- Realizar el testing de la aplicación
- Centralizar animaciones
- Reordenar el código en subcarpetas

## Backend conexión con la base de datos y API mediante **Laravel** PHP

La idea es que el backend, su conexión con el frontend sea mediante la exposición de una API con autenticación, y posteriormente se conecte con Node-Red mediante la conexión por websocket

**REALIZADO:**
- Visto lo básico para **PHP**
- Visto librerias de conexión mediante **MQTT**
- Visto funcionamiento de **MQTT**
- Instalado Laravel, y comenzado a ver lo necesario para realizar la API
- Avanzado con el desarrollo de los mensajes

**TODO:**

- Verme el curso de Laravel
- Terminar de concretar los mensajes
- Realizar parte de Node-Red
- Mirar seguridad

### Conexión con los dispositivos mediante **Node-Red**

En node-red, se añadirá una pequeña autenticación para comprobar que se esta accediendo de la manera válida, y únicamente será una conexión entre los dispositivos y nuestro backend. La conexión se realizará mediante uno o varios JSON, aun esta por ver, la idea es la siguiente:

```json
{
    "id": 12345678,
    "fecha": "12/12/2000 12:12:12",
    "tipo": 2,
    "valor": "95%"
}

0 - > Ack - > Correcto
1 - > noAck - > No Correcto
2 - > Humedad
3 - > Sensor x
4 - > Sensor y
    ...

// Mensaje telemetria acumulada
{
    "id": 1234567,
    "tipo": 2,
    "datos": [{
            "fecha": "12/12/2000 12:12:12",
            "valor": "95%"
        },
        {
            "fecha": "12/12/2000 12:12:50",
            "valor": "93%"
        },
        {
            "fecha": "12/12/2000 12:13:15",
            "valor": "93%"
        }
        ...
    ]
}


// Programa de riego
{
    "id": 1234,
    "programa": 1234123,
    "activado": true,
    "fecha1": "12/12/2021 12:12:12",
    "fecha2": [12, 12, 2021, 12, 12, 12],
    "dias": [true, true, true, true, true, false, false],
    "bombas": [false, false, true, true],
    "sectores": [false, false, true, false],
    "emision": "aspersion/Goteo - 0/1",
    "temporizadores": [{
            "HoraI": "12:12:12",
            "Duracion": "12:12:12 123546 min  1253417245128654 seg",
            "TiempoPost": "12:12:12 123124 min 1235142172546 seg"
        },
        {
            "HoraI": "12:12:12",
            "Duracion": "12:12:12 123546 min  1253417245128654 seg",
            "TiempoPost": "12:12:12 123124 min 1235142172546 seg"
        },
        {
            "HoraI": "12:12:12",
            "Duracion": "12:12:12 123546 min  1253417245128654 seg",
            "TiempoPost": "12:12:12 123124 min 1235142172546 seg"
        },
        {
            "HoraI": "12:12:12",
            "Duracion": "12:12:12 123546 min  1253417245128654 seg",
            "TiempoPost": "12:12:12 123124 min 1235142172546 seg"
        },
    ]


}
```

## Dudas respecto al diseño de la página web

- Temporizadores en vertical mejor?
- Sectores por defecto mapa o por defecto botones