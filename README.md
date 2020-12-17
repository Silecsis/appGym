# appGym
Práctica final del primer trimestre (asignatura DWES).
Versión 1. (Diciembre)


(Recomiendo hacer las pruebas con estos dos usuarios principalmente y coger el resto para practicar)
Contraseña del usuario administrador maria@gmail.com -> kk
Contraseña del usuario socio silecsis@gmail.com --> Blanca8.

Base de datos: Está el import de la base de datos empleada en la carpeta install dentro de app.

----------------------------------------------------------------------------------

Al iniciar la práctica se recomienda:
 	-Ejecutar Composer init para cargar las vistas para generar pdf (que de momento será únicamente el horario.)
	-Cambiar las variables de usuario necesarias para phpMyAdmin del archivo config para poder acceder.

----------------------------------------------------------------------------------
Breve explicación de las carpetas(dentro de APP):
	-Assets: Contiene todas aquellas carpetas relacionadas con el diseño. Esta se subdivide en:
		-CSS: Solo contiene un fichero css con los estilos de la web.
		-IMG: En el directorio principal contiene las imágenes utilizadas para el diseño y una carpeta llamada avatarsUsers.
			-avatarsUsers: contiene todas las imágenes de los usuarios.
		-JS: Contiene las funcionalidades necesarias de JavaScript.

	-Controllers: Contiene los controladores de los modelos y vistas.
	-Core: Se encuentran los archivos principales necesarios de forma que se cargan siempre en cualquier archivo php por si se requieren dichas funciones (como sececho.php).
	-install: contiene el archivo de importación de la base de datos utilizada.
	- models: Contiene los modelos de las base de datos.
	-phpmailer: Contiene los archivos necesarios para poder enviar correos a servicios email desde la app.
	-vendor: Contiene los archivos necesarios del composer.
	-views: Contiene las vistas de la aplicacion.

	-Archivo config.php: Contiene las variables generales.
	-Archivo index.php: es el archivo que ejecuta la aplicación.

En la carpeta Doc se encuentra la documentación de la aplicación realizada con phpDocumenter.

----------------------------------------------------------------------------------
Documentación extra:

------------R E P O S I T O R I O     D E     G I T H U B------------------------

https://github.com/Silecsis/appGym 



