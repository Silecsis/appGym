<?php

/**
 * Incluimos los modelos que necesite este controlador
 */
require_once MODELS_FOLDER . "ActivitiesModel.php";

/**
 * Clase controlador que será la encargada de obtener, para cada tarea, los datos
 * necesarios de la base de datos, y posteriormente, tras su proceso de elaboración,
 * enviarlos a la vista para su visualización.
 * 
 * Esta clase contiene las acciones que solo los admin pueden realizar.
 * En todos sus métodos se controla que sea el rol de admin.
 * 
 * Gestiona el CRUD de las actividades dirigidas.
 */
class AdminActivitiesController extends BaseController
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
      $this->modelo = new ActivitiesModel();
      $this->mensajes = [];
   }

   /**
    * Lista las actividades de la base de datos.
    * Las lista también mediante búsqueda.
    *
    * @return void
    */
   public function listActivities()
   {
       $modelo= new ActivitiesModel();

        if(isset($_GET["rxp"])){
            $rxp=$_GET["rxp"];
        }else{
            $rxp=PAGE_SIZE;
        }

        if(isset($_GET["submit"])){
            $activity=$modelo->listActivities($_GET["pagina"],$rxp,$_GET["nombre"],$_GET["descripcion"],$_GET["aforo"]);
            $totalRegistros=$activity["count"];

            $paginas=$totalRegistros/$rxp;
            //Si lo dividimos, es probable que de un número decimal, en cuyo caso daría el total de páginas de la parte entera, no de la decimal.
            //Por ello, hacemos lo siguiente para que redondee el número hacia arriba.
            $paginas=ceil($paginas);
            $url="&nombre={$_GET["nombre"]}&descripcion={$_GET["descripcion"]}&aforo={$_GET["aforo"]}&submit=Buscar";
            
        }else if(!isset($_GET["submit"]) && $_SESSION["usuario"]["rol_id"]!=1){
            $params=[
                "type"=>"noAdmin"
            ];
            $this->redirect("error","index",$params);

        }else{
            $activity=$modelo->listActivities($_GET["pagina"],$rxp); 
            $totalRegistros=$modelo->countTotalTable();

            $paginas=$totalRegistros/$rxp;
            $paginas=ceil($paginas);
            $url="";
        }

        if($activity["correct"]){
            $params=[
                "data"=>$activity,
                "paginas"=>$paginas, //Para que lleve el num de páginas a la vista
                "url"=>$url
            ];
        }else{
            $params=[
                "type"=>"unexpected"
            ];
            $this->redirect("error","index",$params);
        }

        $this->view->adminAuthShow("listActivities",$params);
        
   }


   /**
    * Elimina la actividad de base de datos.
    *
    * @return void
    */
   public function deleteActivities()
   {
        //Verificamos que hemos recibido los parámetros desde la vista de listUserView, que no podemos eliminarnos a nosotros mismos
        //y que tengamos el rol de admin (por si nos roban la URL).
        if (isset($_GET['id']) && (is_numeric($_GET['id'])) && $_SESSION["usuario"]["rol_id"]==1) {
            $id = $_GET["id"];

            $modelo= new ActivitiesModel();

            //Realizamos la operación de suprimir la actividad con el id.
            $resultModelo = $modelo->deleteActivities($id);

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
            
        } else if($_SESSION["usuario"]["rol_id"]!=1){
            $params=[
                "type"=>"noAdmin"
            ];
            $this->redirect("error","index",$params);

        }else{ //Si no recibimos el valor del parámetro $id generamos el mensaje indicativo:
            $params=[
                "type"=> "unexpected"
            ];
            $this->redirect("error","index",$params);
        }
        //Realizamos el listado de los usuarios
        $this->listActivities();
   }



   /**
    * Edita la actividad en la base de datos
    *
    * @return void
    */
   public function editActivities()
   {
        require_once 'ValidationFormController.php';

        //Verificamos que hemos recibido los parámetros desde la vista de listactivitiesView 
        if (isset($_GET['id']) && (is_numeric($_GET['id']))  && $_SESSION["usuario"]["rol_id"]==1) {
            $id = $_GET["id"];

            $modelo= new ActivitiesModel();

            if(isset($_POST["submit"])){
                $errors=validate();

                if(count($errors) != 0){
                    $params=[
                        "errors"=>$errors
                    ];
                    //Cargamos la vista con los aprámetros de los errores, que serán los mensajes.
                    $this->authView("editActivities","AdminActivities","index",$params);
                }else{
                    //Sino hay errores, modificamos los datos de la actividad en la bd.
                    $editCorrect=$modelo-> editActivities($_POST["nombre"],$_POST["descripcion"], $_POST["aforo"], $_GET["id"]);
                    
                    $params=[
                        "id"=>$_GET["id"],
                        "success"=> true
                    ];

                    $this->redirect("adminActivities","editActivities",$params);
                }
            }else{
                //Si no se ha pulsado el botón
                $activity=$modelo->getById($_GET['id']);

                $params=[
                    "activity"=>$activity
                ];

                $this->authView("editActivities","AdminActivities","index",$params);
            }

        } else if($_SESSION["usuario"]["rol_id"]!=1){
            $params=[
                "type"=>"noAdmin"
            ];
            $this->redirect("error","index",$params);

        }else{ //Si no recibimos el valor del parámetro $id generamos el mensaje indicativo:
            $params=[
                "type"=>"unexpected" //Error que indica que no hemos podido acceder al id.
            ];

            $this->redirect("error","index",$params);
        }
      
   }


   /**
    * Crea una nueva actividad
    *
    * @return void
    */
   public function createActivities()
   {
        require_once 'ValidationFormController.php';

        $modelo= new ActivitiesModel();
        
        if(isset($_POST["submit"]) && $_SESSION["usuario"]["rol_id"]==1){
            //Asociamos una variable de error por si no se validan los campos, que aparezcan en esa variable.
            $errors=validate();

            if(count($errors) != 0){
                $params=[
                    "errors"=>$errors
                ];
                //Cargamos la vista con los aprámetros de los errores, que serán los mensajes.
                $this->authView("editActivities","AdminActivities","index",$params);
            }else{
                //Sino hay errores, creamos la nueva actividad en la bd.
                $createCorrect=$modelo-> createActivities($_POST["nombre"],$_POST["descripcion"], $_POST["aforo"]);

                if($createCorrect["correct"]){
                    //Si el registro es correcto, volvemos a mandar a "nuevo usuario" por si quiere crear otro.
                    $params=[
                        "message"=>"created",
                    ];

                    $this->redirect("adminActivities", "createActivities",$params);
                }else{ 
                    //Sino, le mandamos a la misma vista.
                    $params=[
                        "errors"=>$createCorrect["errors"],
                    ];
                    $this->view->adminAuthShow("editActivities",$params);
                }
            }
        }else if(!isset($_POST["submit"]) && $_SESSION["usuario"]["rol_id"]!=1){
            $params=[
                "type"=>"noAdmin"
            ];
            $this->redirect("error","index",$params);

        }else{
            $this->view->adminAuthShow("editActivities");
        }  
   }



}
?>