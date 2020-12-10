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
 * Inicialmente generará los cambios del usuario.
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
     * Registrar el usuario desde el login.
     */
    public function registrer()
    {
      //Llamamos al controlador del formulario.
      require_once 'ValidationFormController.php';

      if(isset($_POST["submit"])){
      //-----Para el captcha:
         require_once "views/includes/captcha.php";
         //Clave sitio Web: 6LcX4QAaAAAAAM-lRaaF4x_Ge_fZLm8YBiYgClAZ 
         //Clave secreta: 6LcX4QAaAAAAAPZkd9Y5wFdawtW8P-OGh2C4Lh5g  

         $secret = "6LcX4QAaAAAAAPZkd9Y5wFdawtW8P-OGh2C4Lh5g";
         $response = null;
         // comprueba la clave secreta
         $reCaptcha = new ReCaptcha($secret);
      
         if ($_POST["g-recaptcha-response"]) {
            $response = $reCaptcha->verifyResponse(
            $_SERVER["REMOTE_ADDR"],
            $_POST["g-recaptcha-response"]
            );
         }

         if ($response != null && $response->success) {
            // Si el captcha es correcto, seguimos procesando el formulario como siempre
            //Asociamos una variable de error por si no se validan los campos, que aparezcan en esa variable.
            $errors=validate();

            if(count($errors) != 0){
               //Si hay errores, se muestran.
               $params=[
                  "errors"=>$errors
               ];
               //y cargamos la vista con los aprámetros de los errores, que serán los mensajes.
               $this->view->show("editUser",$params);
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
                                                            
               $registrerCorrect=$userModel-> createUser($_POST["nif"], $_POST["nombre"], $_POST["apellidos"], $_POST["email"], $_POST["passwordMod"],  $_POST["telefono"],$_POST["direccion"], $fileName);

               if($registrerCorrect["correct"]){
                  //Si el registro es correcto, le mandamos al index para que se loguee.
                  $params=[
                     "message"=>"registrer",
                  ];
                  
                  $this->redirect(DEFAULT_CONTROLLER, DEFAULT_ACTION,$params);
               }else{ 
                  //Sino, le mandamos a la misma vista.
                  $params=[
                     "errors"=>$registrerCorrect["errors"],
                  ];
                  $this->view->show("editUser",$params);
               }
            }

         } else {
            // Si el captcha no es válido, lanzamos mensaje de error al usuario
            $params=[
               "error"=>"captcha"
            ];
            $this->view->show("editUser",$params);
         }
         
      }else{
          $this->view->show("editUser");
      } 
     
    }



   /**
    * Edita el perfil del usuario (desde el mismo usuario).
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
                                                   
            $editCorrect=$userModel-> editUser($_POST["nif"], $_POST["nombre"], $_POST["apellidos"],  $_POST["passwordMod"], $_POST["telefono"], $_POST["direccion"], $fileName, $_SESSION['usuario']["id"]);
               
            if(isset($fileName) && $fileName!=""){
               $_SESSION["usuario"]["img"]=$fileName;
            }
            
            //Cargamos la vista con los aprámetros de los errores en caso de que hallan.
            $this->authView("editUser","user","index",$editCorrect);
         }
      }else{
         //Si no se ha pulsado el boton de enviar, significará que el usuario ha abierto la vista,
         //por lo que se mostrarán sus datos en las casillas para que pueda modificar/editar
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