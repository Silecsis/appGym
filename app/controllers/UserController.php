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
      require_once 'ValidationFormController.php';
      if(isset($_POST["submit"])){
           
         $errors=validate();

         if(count($errors) != 0){
            $params=[
               "errors"=>$errors
            ];
            //Cargamos la vista con los aprámetros de los errores, que serán los mensajes.
            $this->view->show("editUser",$params);
         }else{
            $userModel=new UserModel();

            $archivo = (isset($_FILES['imagen'])) ? $_FILES['imagen'] : null;
               if ($archivo) {
                  $fileName=uniqid("avatar",true);
                  $fileName=$fileName.".".pathinfo($archivo['name'],PATHINFO_EXTENSION);
                  $ruta_destino_archivo = "assets/img/avatarsUsers/{$fileName}";
                  $archivo_ok = move_uploaded_file($archivo['tmp_name'], $ruta_destino_archivo);
               }
                                                         
            $registrerCorrect=$userModel-> createUser($_POST["nif"], $_POST["nombre"], $_POST["apellidos"], $_POST["email"], $_POST["passwordMod"],  $_POST["telefono"],$_POST["direccion"], $fileName);

            if($registrerCorrect["correct"]){
               $params=[
                  "message"=>"registrer",
               ];
                
               $this->redirect(DEFAULT_CONTROLLER, DEFAULT_ACTION,$params);
            }else{ 
               $params=[
                  "errors"=>$registrerCorrect["errors"],
               ];
               $this->view->show("editUser",$params);
            }
         }
      }else{
          $this->view->show("editUser");
      } 
     
    }



   /**
    * Redirige a editView.
    *
    * @return void
    */
   public function edit()
   {
      require_once 'ValidationFormController.php';
      if(isset($_POST["submit"])){
           
         $errors=validate();

         if(count($errors) != 0){
            $params=[
               "errors"=>$errors
            ];
            //Cargamos la vista con los aprámetros de los errores, que serán los mensajes.
            $this->authView("editUser","user","index",$params);
         }else{
            $userModel=new UserModel();

            $archivo = (isset($_FILES['imagen']) && $_FILES["imagen"]["error"]==0) ? $_FILES['imagen'] : null;
            $fileName="";
               if ($archivo) {
                  $fileName=uniqid("avatar",true);
                  $fileName=$fileName.".".pathinfo($archivo['name'],PATHINFO_EXTENSION);
                  $ruta_destino_archivo = "assets/img/avatarsUsers/{$fileName}";
                  $archivo_ok = move_uploaded_file($archivo['tmp_name'], $ruta_destino_archivo);
               }
                                                   
            $editCorrect=$userModel-> editUser($_POST["nif"], $_POST["nombre"], $_POST["apellidos"],  $_POST["passwordMod"], $_POST["telefono"], $_POST["direccion"], $fileName, $_SESSION['usuario']["id"]);
               if(isset($fileName) && $fileName!=""){
                  $_SESSION["usuario"]["img"]=$fileName;
               }

            //Cargamos la vista con los aprámetros de los errores, que serán los mensajes.
            $this->authView("editUser","user","index",$editCorrect);
         }
      }else{
         $userModel=new UserModel();

         $user=$userModel->getBy("email",$_SESSION["usuario"]["email"]);//COGER CON $_GET(PARA ADMINCONTROLLLER)

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
}
?>