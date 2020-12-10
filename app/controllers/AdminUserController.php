<?php

/**
 * Incluimos los modelos que necesite este controlador
 */
require_once MODELS_FOLDER . 'UserModel.php';

/**
 * Clase controlador que será la encargada de obtener, para cada tarea, los datos
 * necesarios de la base de datos, y posteriormente, tras su proceso de elaboración,
 * enviarlos a la vista para su visualización.
 * 
 * Esta clase contiene las acciones que solo los admin pueden realizar.
 */
class AdminUserController extends BaseController
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
    * Lista los usuarios.
    * Solo lo hace el rol de admin.
    * También los lista mediante búsqueda.
    *
    * @return void
    */
   public function listUser()
   {
      $userModel=new UserModel();

      if(isset($_GET["submit"])){
        $user=$userModel->listUserDatas($_GET["nif"],$_GET["nombre"],$_GET["apellidos"],$_GET["email"],$_GET["telefono"],$_GET["direccion"],$_GET["estado"],$_GET["rol"]);

      }else{
        $user=$userModel->listUserDatas(); 
      }

      if($user["correct"]){
         $params=[
            "data"=>$user
         ];
      }else if($user["count"]==0){
         $params=[
            "error"=>"count0"
         ];
      }else{
         $params=[
            "error"=>"unexpected"
         ];
      }

      $this->view->adminAuthShow("adminListUser",$params);
   }


   /**
    * Elimina al usuario de la base de datos y muestra el listado actual.
    * Solo podrá realizarlo el administrador.
    * Un admin no podrá eliminarse a sí mismo.
    *
    * @return void
    */
   public function deleteUser()
   {
      //Verificamos que hemos recibido los parámetros desde la vista de listUserView 
      if (isset($_GET['id']) && (is_numeric($_GET['id'])) && $_GET["id"]!=$_SESSION["usuario"]["id"]) {
         $id = $_GET["id"];

         $userModel=new UserModel();

         //Realizamos la operación de suprimir el usuario con el id=$id
         $resultModelo = $userModel->deleteUser($id);


         if ($resultModelo["correct"]){
            $params=[
               "correct"=>true
            ];

         }else{
            $params=[
               "type"=> "deleteIncorrect"
            ];
           $this->redirect("error","index",$params);
         }
      } else { //Si no recibimos el valor del parámetro $id generamos el mensaje indicativo:
         $params=[
            "type"=> "deleteSelfAdmin"
         ];
        $this->redirect("error","index",$params);
      }
      //Realizamos el listado de los usuarios
      $this->redirect("adminUser","listUser");
   }



   /**
    * Edita al usuario de la lista de usuarios.
    * Solo podrá realizarlo el administrador.
    * Un admin no podrá editarse a sí mismo desde la tabla de listar.
    *
    * @return void
    */
   public function editUser()
   {
      require_once 'ValidationFormController.php';

      //Verificamos que hemos recibido los parámetros desde la vista de listUserView 
      if (isset($_GET['id']) && (is_numeric($_GET['id'])) && $_GET["id"] != $_SESSION["usuario"]["id"]) {
         $id = $_GET["id"];

         $userModel=new UserModel();

         if(isset($_POST["submit"])){
            $errors=validate();

            if(count($errors) != 0){
               $params=[
                  "errors"=>$errors
               ];
               //Cargamos la vista con los aprámetros de los errores, que serán los mensajes.
               $this->authView("adminEditUser","AdminUser","index",$params);
            }else{
               //Sino hay errores, modificamos los datos del user en la bd.
               $userModel=new UserModel();

               $archivo = (isset($_FILES['imagen']) && $_FILES["imagen"]["error"]==0) ? $_FILES['imagen'] : null;
               $fileName="";
                  if ($archivo) {
                     $fileName=uniqid("avatar",true);
                     $fileName=$fileName.".".pathinfo($archivo['name'],PATHINFO_EXTENSION);
                     $ruta_destino_archivo = "assets/img/avatarsUsers/{$fileName}";
                     $archivo_ok = move_uploaded_file($archivo['tmp_name'], $ruta_destino_archivo);
                  }
                                                      
               $editCorrect=$userModel-> adminEditUser($_POST["nif"], $_POST["nombre"], $_POST["apellidos"], $_POST["email"], $_POST["passwordMod"], $_POST["telefono"], $_POST["direccion"],$_POST["estado"], $fileName,$_POST["rol"], $_GET["id"]);
               
               $params=[
                  "id"=>$_GET["id"],
                  "success"=> true
               ];

               $this->redirect("adminUser","editUser",$params);
            }
         }else{
            //Si no se ha pulsado el botón
            $user=$userModel->getById($_GET['id']);

            $params=[
               "user"=>$user
            ];

            $this->authView("adminEditUser","AdminUser","index",$params);
         }

      } else { //Si no recibimos el valor del parámetro $id generamos el mensaje indicativo:
         $params=[
            "type"=>"editSelfAdmin" //Error que indica que no hemos podido acceder al id.
         ];

         $this->redirect("error","index",$params);
      }
      
      //$this->listUser();
   }


   /**
    * Crea al usuario desde la opción "Nuevo usuario".
    * Solo podrá realizarlo el administrador.
    * La contraseña del nuevo usuario será su NIF.
    *
    * @return void
    */
   public function createUser()
   {
      require_once 'ValidationFormController.php';
      
      if(isset($_POST["submit"])){
            //Asociamos una variable de error por si no se validan los campos, que aparezcan en esa variable.
         $errors=validate();

         if(count($errors) != 0){
            //Si hay errores, se muestran.
            $params=[
               "errors"=>$errors
            ];
            //y cargamos la vista con los aprámetros de los errores, que serán los mensajes.
            $this->view->show("adminEditUser",$params);
         }else{
            //Si no hay errores, se meten los datos en la bd.
            $userModel=new UserModel();

            $archivo = (isset($_FILES['imagen'])) ? $_FILES['imagen'] : null;
               if ($archivo) {
                  $fileName=uniqid("avatar",true);
                  $fileName=$fileName.".".pathinfo($archivo['name'],PATHINFO_EXTENSION);
                  $ruta_destino_archivo = "assets/img/avatarsUsers/{$fileName}";
                  $archivo_ok = move_uploaded_file($archivo['tmp_name'], $ruta_destino_archivo);
               }
             
            //Recuerdo que la contraseña será el nif del usuario.
            $createCorrect=$userModel-> adminCreateUser($_POST["nif"], $_POST["nombre"], $_POST["apellidos"], $_POST["email"], $_POST["nif"],  $_POST["telefono"],$_POST["direccion"],$_POST["estado"], $fileName,$_POST["rol"]);

            if($createCorrect["correct"]){
               //Si el registro es correcto, volvemos a mandar a "nuevo usuario" por si quiere crear otro.
               $params=[
                  "message"=>"created",
               ];

               $this->redirect("adminUser", "createUser",$params);
            }else{ 
               //Sino, le mandamos a la misma vista.
               $params=[
                  "errors"=>$createCorrect["errors"],
               ];
               $this->view->adminAuthShow("adminEditUser",$params);
            }
         }
      }else{
         $this->view->adminAuthShow("adminEditUser");
      }  
   }

}
?>