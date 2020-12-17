<?php
/**
 * Clase que hace de motor de plantillas para las vistas. 
 * Nos permite incluir una plantilla y asignarle variables.
 * 
 */
class View
{
   /**
    * Muestra una vista y pasa un array de valores que se van a usar ya que
    * todos los valores de la vista no se van a utilizar. 
    * Este funciona para las páginas no logadas.
    *
    * @param string $name Nombre de nuestra vista, por ej, Login
    * @param array $vars conjunto de variables que se van a usar en la vista. 
    * @return void
    */
   public function show($name, $vars = array())
   {
      //Creamos la ruta real del archivo vista.
      $ruta = VIEWS_FOLDER . ucwords($name). 'View.php';
      $template = VIEWS_FOLDER . 'includes/template.php';//Selecciona la plantilla.

      //Si no existe el fichero en cuestion, lanzamos una excepción
      if (file_exists($ruta) == false)
         throw new \Exception('El fichero ' . $ruta . ' no existe.');

      //Si hay variables para asignar, las pasamos una a una recorriendo el array introducido.
      if (is_array($vars)) {
         foreach ($vars as $key => $value) {
            $$key = $value;   // Es una variable variable, el valor de la variable hace de nombre de otra variable
         }
      }

      //Finalmente, incluimos el archivo vista.
      $viewRuta=$ruta;//Para controlar qué contenido tendrá el body que será uno distinto para cada vista.
      $viewClass="body-".strtolower($name);//Para controlar el css de los bodys que será uno para cada vista.
      require_once($template);
   }


   /**
    * Valida si el user está logueado, y si no, le reenvia al index para que se loguee.
    * Boolean.
    * @param string $name Nombre de nuestra vista, por ej, Login
    * @param array $vars conjunto de variables que se van a usar en la vista. 
    * @return void
    */
   public function authShow($name, $vars = array())
   {
      if(isset( $_SESSION['logueado'])){
         $this->show($name, $vars);
         return true;
      }else{
          return false;
      }
   }

   /**
    * Redirige a la vista si está logueado y el rol es admin.
    * Boolean.
    *
    * @return void
    */
   public function adminAuthShow($name, $vars = array())
   {
      //Comprobamos que esté logueado.
      if(isset( $_SESSION['logueado'])){
         //Comprobamos que sea rol admin
         if($_SESSION["usuario"]["rol_id"]==1){
            $this->show($name, $vars);
            return true;
         }else{
            return false;
         }
      }else{
          return false;
      }
   }


   /**
    *  Muestra una vista y pasa un array de valores que se van a usar ya que
    * todos los valores de la vista no se van a utilizar. 
    * Este funciona para las páginas que se vayan a imprimir.
    * Solo coge el body del html
    *
    * @param string $name Nombre de nuestra vista, por ej, Login
    * @param array $vars conjunto de variables que se van a usar en la vista.
    * @return void
    */
    public function showBody($name, $vars = array())
    {
       //Creamos la ruta real del archivo vista.
       $ruta = VIEWS_FOLDER . ucwords($name). 'View.php';
 
       //Si no existe el fichero en cuestion, lanzamos una excepción
       if (file_exists($ruta) == false)
          throw new \Exception('El fichero ' . $ruta . ' no existe.');
 
       //Si hay variables para asignar, las pasamos una a una recorriendo el array introducido.
       if (is_array($vars)) {
          foreach ($vars as $key => $value) {
             $$key = $value;   // Es una variable variable, el valor de la variable hace de nombre de otra variable
          }
       }
 
       //Finalmente, incluimos el archivo vista.
       require_once($ruta);
    }
}