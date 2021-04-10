# TFG

- [TFG](#tfg)
  - [Frontend realizado mediante **Vue**](#frontend-realizado-mediante-vue)
  - [Backend conexión con la base de datos y API mediante **Laravel** PHP](#backend-conexión-con-la-base-de-datos-y-api-mediante-laravel-php)
    - [Conexión con los dispositivos mediante **Node-Red**](#conexión-con-los-dispositivos-mediante-node-red)

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

**TODO:**
- Centralizar la información completa del programa en Vuex
- Mirar si utilizar un servicio de autenticación o como se va realizar la autenticación con el backend
- Mejorar la vista del programa, y realizar el resto de vistas
- Crear una maqueta de la aplicación final
- Realizar la futura conexión con la API
- Terminar de ver el funcionamiento correcto de Vue-router y bootstrap-vue
- Realizar el testing de la aplicación
- Seguir mirando el tema de transiciones

## Backend conexión con la base de datos y API mediante **Laravel** PHP

La idea es que el backend, su conexión con el frontend sea mediante la exposición de una API con autenticación, y posteriormente se conecte con Node-Red mediante la conexión por websocket

**REALIZADO:**
- Visto lo básico para **PHP**
- Visto librerias de conexión mediante **MQTT**
- Visto funcionamiento de **MQTT**

**TODO:**

- Seguir viendo Laravel
- Practicar PHP
- Terminar de ver como realizar correctamente la conexión

### Conexión con los dispositivos mediante **Node-Red**

En node-red, se añadirá una pequeña autenticación para comprobar que se esta accediendo de la manera válida, y únicamente será una conexión entre los dispositivos y nuestro backend. La conexión se realizará mediante uno o varios JSON, aun esta por ver, la idea es la siguiente:

```json
{
   "sent":"usuario",
   "receiver":123457,
   "topico": "proyecto/usuario/dispositivo",
   "program":"Programa de riego (probablemente mejor con numeros)",
   "date":"formate fecha a especificar",
   "numParams":3,
   "params":{
      "days":[
         0,
         1,
         1,
         0,
         0,
         0,
         1
      ],
      "numTemp":1,
      "temp":[
         {
            "start":"fecha",
            "end":"fecha",
            "pre-irrigation":"tiempo",
            "post-irrigation":"tiempo",
            "fertigation":"numPrograma"
         }
      ],
		
   }
}
```

