<?php
/**
 * Inclusión de los archivos que contienen las clases de core
 * Cuando PHP usa una clase que no encuentra va a llamar a la función anónima definida en el callback
 * que requiere (incluye) la clase
 * @return void
 */

spl_autoload_register(function ($nombre) {
   require 'core/' . $nombre . '.php';
});

require_once("core/sececho.php");

try {
   session_start();//Para que no de problemas, iniciamos las sesion solo en el index.

   //Primero comprobamos si está activa el mantener sesión.
   MainController::keepSession();

   //Luego lo iniciamos con su método estático main.
   MainController::main();
} catch (\Exception $e) {
   echo $e->getMessage();
}

