<?php

/**
 * Clase abstracta base para los controladores (será el controlador base).
 * Carga una vista.
 */
abstract class BaseController
{
   protected $view;

   function __construct()
   {
      $this->view = new View();
   }

   /**
    * Redirige a un controlador dado, con una acción y una serie de parámetros
    *
    * @param string $controlador
    * @param string $accion
    * @param array $params  Parejas clave-valor para luego añadir a la url que llama al controlador
    * @return void
    */
   public function redirect($controlador = DEFAULT_CONTROLLER, $accion = DEFAULT_ACTION, $params = null)
   {
      if ($params != null) {
         $urlpar="";
         foreach ($params as $key => $valor) {
            $urlpar .= "&$key=$valor";
         }
         header("Location: ?controller=" . $controlador . "&action=" . $accion . $urlpar);
      } else {
         header("Location: ?controller=" . $controlador . "&action=" . $accion);
      }
   }


   /**
    * Undocumented function
    *
    * @param [type] $name
    * @param array $vars
    * @return void
    */
   public function authView($name, $controller,$action, $vars = array()){
      //Cuando no estemos logueados.
      if (!$this->view->authShow($name, $vars)){
         $params=[
            "tController"=>$controller,
            "tAction"=>$action,
            "error"=>"authRequired"
         ];

         $this->redirect(DEFAULT_CONTROLLER,DEFAULT_ACTION,$params);
      }
      
   }
}
