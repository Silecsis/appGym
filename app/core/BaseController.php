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
    * Carga la vista indicada si el usuario está logado, sino está logado, redirige al login
    * y le indica a qué vista quería entrar.
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
   
   /**
    * Manda a error si intentan entrar por URL estando logado pero sin ser admin.
    *
    * @param [type] $name
    * @param [type] $controller
    * @param [type] $action
    * @param array $vars
    * @return void
    */
   public function adminView($name, $controller,$action, $vars = array()){
      //Cuando estamos logados pero no somos administradores.
      if (!$this->view->adminAuthShow($name, $vars)){
         $params=[
            "type"=>"noAdmin"
         ];
         $this->redirect("error","index",$params);
      } 
   }
   
}
