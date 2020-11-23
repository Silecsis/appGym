<?php
/**
 * El MainController es el que recibe todas las peticiones, incluye algunos ficheros, 
 * busca el controlador y llama a la acción que corresponde.
 * Nuestros controladores terminarán todos en Controller.
 * Por ej, la clase controladora Users, será UsersController
 */
class MainController
{
   static function main()
   {
      //Cargamos el archivo de configuración.
     require_once "config.php";
      

      //Formamos el nombre del Controlador o el controlador por defecto
      if (!empty($_GET['controller'])) {
         $controller = ucwords($_GET['controller']);
      } else {
         $controller = DEFAULT_CONTROLLER;
      }

      //Lo mismo sucede con las acciones, si no hay action tomamos index como action
      if (!empty($_GET['action'])) {
         $action = $_GET['action'];
      } else {
         $action = DEFAULT_ACTION;
      }

      $controller .= "Controller";
      $controller_path = CONTROLLERS_FOLDER . $controller . '.php';

      //Incluimos el fichero que contiene nuestra clase controladora solicitada
      if (!is_file($controller_path)) {
         throw new \Exception('El controlador no existe ' . $controller_path . ' - 404 not found');
      }
      require $controller_path;

      //Si no existe la clase que buscamos y su método mostramos un error
      if (!is_callable(array($controller, $action))) {
         throw new \Exception($controller . '->' . $action . ' no existe');
      }

      //Si todo esta bien, creamos una instancia del controlador
      //  y llamamos a la action
      $controller = new $controller();
      $controller->$action();
   }

   /**
    * Comprueba si el checkboox de mantenerSesión está activado y no hay una sesión activa actualmente,
    * en ese caso, crea una sesión activa al usuario. (Simula que el usuario se loga).
    *
    * @return void
    */ 
   static function keepSession(){
      if (empty($_SESSION["logueado"]) && isset($_COOKIE["mantenerSesion"])){
         $_SESSION['logueado']=$_COOKIE["mantenerSesion"];
         $_SESSION['usuario']=$_COOKIE["mantenerSesion"];
      }
   }
}
