<?php

/**
 * Incluimos los modelos que necesite este controlador
 */
require_once MODELS_FOLDER . "TramoModel.php";
require_once MODELS_FOLDER . "DiasModel.php";
require_once MODELS_FOLDER . "ActivitiesModel.php";
use Spipu\Html2Pdf\Html2Pdf;

/**
 * Clase controlador que será la encargada de obtener, para cada tarea, los datos
 * necesarios de la base de datos, y posteriormente, tras su proceso de elaboración,
 * enviarlos a la vista para su visualización.
 * 
 * Esta clase contiene las acciones que socios y admin pueden realizar.
 * Se controla que sea el rol de admin para modificar, dar de alta y de baja.
 * 
 * Gestiona el CRUD de los tramos de las actividades.
 */
class AdminTramosController extends BaseController
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
      $this->modelo = new TramoModel();
      $this->mensajes = [];
   }

   /**
    * Lista los tramos de la base de datos.
    * Los lista también mediante búsqueda.
    *
    * @return void
    */
   public function listTramos()
   {
        $diasModel= new DiasModel();
        $dias=$diasModel->listDias();

        $actividadesModel= new ActivitiesModel();
        $actividades=$actividadesModel->getAllActivities();

        if(isset($_GET["rxp"])){
            $rxp=$_GET["rxp"];
        }else{
            $rxp=PAGE_SIZE;
        }

        if(isset($_GET["submit"])){
            $tramos=$this->modelo->listTramos($_GET["pagina"],$rxp,$_GET["dia"],$_GET["hora_inicio"],$_GET["hora_fin"],$_GET["actividad_id"]);
            $totalRegistros=$tramos["count"];

            $paginas=$totalRegistros/$rxp;
            //Si lo dividimos, es probable que de un número decimal, en cuyo caso daría el total de páginas de la parte entera, no de la decimal.
            //Por ello, hacemos lo siguiente para que redondee el número hacia arriba.
            $paginas=ceil($paginas);
            $url="&dia={$_GET["dia"]}&hora_inicio={$_GET["hora_inicio"]}&hora_fin={$_GET["hora_fin"]}&actividad_id={$_GET["actividad_id"]}&submit=Buscar";
            
        }else{
            $tramos=$this->modelo->listTramos($_GET["pagina"],$rxp); 
            $totalRegistros=$this->modelo->countTotalTable();

            $paginas=$totalRegistros/$rxp;
            $paginas=ceil($paginas);
            $url="";
        }

        if($tramos["correct"] && $dias["correct"] && $actividades["correct"]){

            $params=[
                "data"=>$tramos,
                "paginas"=>$paginas, //Para que lleve el num de páginas a la vista
                "url"=>$url,
                "days"=>$dias["data"],
                "activities"=>$actividades["data"]
            ];
        }else if(!isset($_GET["submit"]) && $_SESSION["usuario"]["rol_id"]!=1){
            $params=[
                "type"=>"noAdmin"
            ];
            $this->redirect("error","index",$params);

        }else{
            $params=[
                "type"=>"unexpected"
            ];
            $this->redirect("error","index",$params);
        }

        $this->authView("listTramos","adminController","listTramos",$params);
        
   }

    /**
    * Elimina el tramo de base de datos.
    *
    * @return void
    */
    public function deleteTramos()
    {
         //Verificamos que hemos recibido los parámetros desde la vista de listUserView, que no podemos eliminarnos a nosotros mismos
         //y que tengamos el rol de admin (por si nos roban la URL).
         if (isset($_GET['id']) && (is_numeric($_GET['id'])) && $_SESSION["usuario"]["rol_id"]==1) {
             $id = $_GET["id"];
 
             //Realizamos la operación de suprimir la actividad con el id.
             $resultModelo = $this->modelo->deleteTramos($id);
 
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
         $this->listTramos();
    }

    /**
    * Edita el tramo en la base de datos
    *
    * @return void
    */
   public function editTramos()
   {
        $diasModel= new DiasModel();
        $dias=$diasModel->listDias();

        $actividadesModel= new ActivitiesModel();
        $actividades=$actividadesModel->getAllActivities();

        require_once 'ValidationFormController.php';

        //Verificamos que hemos recibido los parámetros desde la vista de listactivitiesView 
        if (isset($_GET['id']) && (is_numeric($_GET['id']))  && $_SESSION["usuario"]["rol_id"]==1) {
            $id = $_GET["id"];

            if(isset($_POST["submit"])){
                $errors=validate();

                if(count($errors) != 0){
                    $params=[
                        "errors"=>$errors
                    ];
                    //Cargamos la vista con los aprámetros de los errores, que serán los mensajes.
                    $this->authView("editTramos","AdminTramos","index",$params);
                }else{
                    //Sino hay errores, modificamos los datos de la actividad en la bd.
                    $editCorrect=$this->modelo-> editTramos($_POST["dia"],$_POST["hora_inicio"], $_POST["hora_fin"],$_POST["actividad_id"],$_POST["fecha_alta"],$_POST["fecha_baja"], $_GET["id"]);
                    
                    $params=[
                        "id"=>$_GET["id"],
                        "success"=> true,
                        "days"=>$dias["data"],
                        "activities"=>$actividades["data"]
                    ];

                    $this->redirect("AdminTramos","editTramos",$params);
                }
            }else{
                //Si no se ha pulsado el botón
                $tramo=$this->modelo->getById($_GET['id']);

                $params=[
                    "tramo"=>$tramo,
                    "days"=>$dias["data"],
                    "activities"=>$actividades["data"]
                ];

                $this->authView("editTramos","AdminTramos","index",$params);
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
    * Crea un nuevo tramo
    *
    * @return void
    */
    public function createTramos()
    {
        $diasModel= new DiasModel();
        $dias=$diasModel->listDias();

        $actividadesModel= new ActivitiesModel();
        $actividades=$actividadesModel->getAllActivities();
        
         require_once 'ValidationFormController.php';
         
         if(isset($_POST["submit"]) && $_SESSION["usuario"]["rol_id"]==1){
             //Asociamos una variable de error por si no se validan los campos, que aparezcan en esa variable.
             $errors=validate();
 
             if(count($errors) != 0){
                 $params=[
                     "errors"=>$errors,
                     "days"=>$dias["data"],
                     "activities"=>$actividades["data"]
                 ];
                 //Cargamos la vista con los aprámetros de los errores, que serán los mensajes.
                 $this->authView("editTramos","AdminTramos","index",$params);
             }else{
                 //Sino hay errores, creamos la nueva actividad en la bd.
                 $createCorrect=$this->modelo-> createTramos($_POST["dia"],$_POST["hora_inicio"], $_POST["hora_fin"],$_POST["actividad_id"],$_POST["fecha_alta"],$_POST["fecha_baja"]);
 
                 if($createCorrect["correct"]){
                     //Si el registro es correcto, volvemos a mandar a "nuevo usuario" por si quiere crear otro.
                     $params=[
                         "message"=>"created",
                     ];
 
                     $this->redirect("adminTramos", "createTramos",$params);
                 }else{ 
                     //Sino, le mandamos a la misma vista.
                     $params=[
                         "errors"=>$createCorrect["errors"],
                     ];
                     $this->adminView("editTramos","adminTramos","createTramos",$params);
                 }
             }
         }else if(!isset($_POST["submit"]) && $_SESSION["usuario"]["rol_id"]!=1){
             $params=[
                 "type"=>"noAdmin"
             ];
             $this->redirect("error","index",$params);
 
         }else{
             $params=[
                "days"=>$dias["data"],
                "activities"=>$actividades["data"]
             ];
            $this->adminView("editTramos","adminTramos","createTramos",$params);
         }  
    }



//----------------------------------------------------------Horario------------------------------------------
   /**
    * Muestra el horario agrupado por hora de inicio y hora de fin del tramo.
    * Lo muestra también por búsqueda
    *
    * @return void
    */
   public function listHorario()
   {
    $diasModel= new DiasModel();
    $dias=$diasModel->listDias();

    $actividadesModel= new ActivitiesModel();
    $actividades=$actividadesModel->getAllActivities();

    if(isset($_GET["rxp"])){
        $rxp=$_GET["rxp"];
    }else{
        $rxp=PAGE_SIZE;
    }

    if(isset($_GET["submit"])){
        $tramos=$this->modelo->listHorario($_GET["pagina"],$rxp,$_GET["dia"],$_GET["hora_inicio"],$_GET["hora_fin"],$_GET["actividad_id"]);
        $totalRegistros=$tramos["count"];

        $paginas=$totalRegistros/$rxp;
        //Si lo dividimos, es probable que de un número decimal, en cuyo caso daría el total de páginas de la parte entera, no de la decimal.
        //Por ello, hacemos lo siguiente para que redondee el número hacia arriba.
        $paginas=ceil($paginas);
        $url="&dia={$_GET["dia"]}&hora_inicio={$_GET["hora_inicio"]}&hora_fin={$_GET["hora_fin"]}&actividad_id={$_GET["actividad_id"]}&submit=Buscar";
        
    }else{
        $tramos=$this->modelo->listHorario($_GET["pagina"],$rxp); 
        $totalRegistros=$this->modelo->countTotalTable();

        $paginas=$totalRegistros/$rxp;
        $paginas=ceil($paginas);
        $url="";
    }

    if($tramos["correct"] && $dias["correct"] && $actividades["correct"]){

        $params=[
            "data"=>$tramos,
            "paginas"=>$paginas, //Para que lleve el num de páginas a la vista
            "url"=>$url,
            "days"=>$dias["data"],
            "activities"=>$actividades["data"]
        ];
    }else{
        $params=[
            "type"=>"unexpected"
        ];
        $this->redirect("error","index",$params);
    }

    $this->authView("listHorario","adminController","listTramos",$params);
   }


   

    /**
     * Imprime el horario en pdf. Imprime la vista impriHorarioView.php
     *
     * @return void
     */
    public function imprimirHorario()
   {
        //Deberemos llamar a los otros modelos para que nos cargue los dias y actividadees por nombre en vez de por id.
        $diasModel= new DiasModel();
        $dias=$diasModel->listDias();

        $actividadesModel= new ActivitiesModel();
        $actividades=$actividadesModel->getAllActivities();

        $tramos=$this->modelo->listHorario(); 
        $totalRegistros=$this->modelo->countTotalTable();

        if($tramos["correct"] && $dias["correct"] && $actividades["correct"]){
            //Si todo es correcto, imprimimos.

            require 'vendor/autoload.php';
   
            $parametros = [
               "horario" => $tramos
            ];
   
            $params=[
               "data"=>$tramos,
               "days"=>$dias["data"],
               "activities"=>$actividades["data"]
           ];
            ob_start();
            $this->view->showBody("impriHorario", $params);
            $html = ob_get_clean();
            $html2pdf = new Html2Pdf('P', 'A4', 'es', 'true', 'UTF-8');
            $html2pdf->writeHTML($html);
            $html2pdf->output("horario_gimnasio_lavanda.pdf"); // Como parámetro opcional nombre de fichero a descargar
            ob_end_clean();
        }else{
            //Sino, manda a un lugar de error
            $params=[
                "type"=>"unexpected"
            ];
            $this->redirect("error","index",$params);
        }
        


   }
}