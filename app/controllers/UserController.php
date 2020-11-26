<?php

/**
 * Incluimos los modelos que necesite este controlador
 */
require_once MODELS_FOLDER . 'UserModel.php';

/**
 * Clase controlador que será la encargada de obtener, para cada tarea, los datos
 * necesarios de la base de datos, y posteriormente, tras su proceso de elaboración,
 * enviarlos a la vista para su visualización
 */
class UserController extends BaseController
{
    // El atributo $modelo es de la 'clase modelo' y será a través del que podremos 
   // acceder a los datos y las operaciones de la base de datos desde el controlador
   private $modelo;
   //$mensajes se utiliza para almacenar los mensajes generados en las tareas, 
   //que serán posteriormente transmitidos a la vista para su visualización
   private $mensajes;

   /**
    * Constructor que crea automáticamente un objeto modelo en el controlador e
    * inicializa los mensajes a vacío
    */
   public function __construct()
   {
      parent::__construct();
      $this->modelo = new UserModel();
      $this->mensajes = [];
   }

   /**
     * Carga la vista para registrar el usuario.
     */
    public function registrer()
    {
      $this->view->show("editUser");
    }



   /**
    * Redirige a editView.
    *
    * @return void
    */
   public function edit()
   {
      $userModel=new UserModel();

      $user=$userModel->getBy("login",$_SESSION["usuario"]["login"]);

      if(count($user)==1){
         $params=[
            "user"=>$user[0]//Cojo la posición porque cojo el usuario ya que el getby me lo devuelve dentro de un array y lo que necesito es el usuario.
         ];
         $this->authView("editUser","user","index",$params);
      }else{
         $this->redirect(DEFAULT_CONTROLLER,DEFAULT_ACTION);
      }
       
   }

}
?>