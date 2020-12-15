<?php

require_once MODELS_FOLDER . "DiasModel.php";
/**
 *   Clase 'TramosModel' que implementa el modelo de tramos de nuestra aplicación en una
 * arquitectura MVC. Se encarga de gestionar el acceso a la tabla tramos
 */
class TramoModel extends BaseModel
{
   private $id;
   private $dia;
   private $hora_inicio;
   private $hora_fin;
   private $actividad_id;
   private $fecha_alta;
   private $fecha_fin;

   public function __construct()
   {
      // Se conecta a la BD
      parent::__construct();
      $this->table = "tramos";
   }


   //Getters.


   //Setter:



   /**
    * Recoge todos los datos de la tabla tramos y las lista.
    *
    * @param integer $page
    * @param integer $rxp
    * @param string $dia
    * @param string $hora_inicio
    * @param string $hora_fin
    * @param string $actividad_id
    * @param string $fecha_alta
    * @param string $fecha_fin
    * @return void
    */
    public function listTramos($page=1,$rxp=10,$dia="",$hora_inicio="",$hora_fin="",$actividad_id="")
    {
        $diasModel= new DiasModel();
        $dias=$diasModel-> listDias();
        $diaActual=getdate();

            // Si hoy es lunes, nos daría el lunes pasado.
            if (date("D")=="Mon"){
                $week_start = date("Y-m-d");
            } else {
                $week_start = date("Y-m-d", strtotime('last Monday', time()));
            }

            //Lo mismo para domingo, pero el próximo domingo
            if (date("D")=="Sun"){
                $week_end = date("Y-m-d");
            } else {
                $week_end = date("Y-m-d", strtotime('next Sunday', time()));
            }

            $page=$page-1;
            $return = [
                "correct" => FALSE,
                "tramos" => [],
                "error" => NULL
            ];
        
        try {
            $sql="SELECT * FROM tramos" ; 

            $sql_count="SELECT count(id) as count FROM tramos" ;

            if($dia!="" || $hora_inicio!="" || $hora_fin!="" || $actividad_id!=""){
                $sql=$sql." WHERE ";
                $sql_count=$sql_count." WHERE ";//Para contar elementos que hay sin paginacion

                $conditions=[];

                if($dia!=""){
                    array_push($conditions,"t.dia like '%".$dia."%'");
                }

                if($hora_inicio!=""){
                    array_push($conditions,"t.hora_inicio = '".$hora_inicio."'");
                }

                if($hora_fin!=""){
                    array_push($conditions,"t.hora_fin = '".$hora_fin."'");
                }

                if($actividad_id!=""){
                    array_push($conditions,"a.nombre like '%".$actividad_id."%'");
                 }


                $sql=$sql.join(" and ",$conditions);
                $sql_count=$sql_count.join(" and ",$conditions);//Para contar elementos que hay sin paginacion
            }

            $query_count=$this->db->query($sql_count);//Para contar elementos que hay sin paginacion

            //Supervisamos que la consulta se realizó correctamente... 
            if ($query_count) {
                $count=$query_count->fetchObject()->count;

                //Para paginación:
                if($page>0 && $page * $rxp >= $count){

                    if($count%$rxp==0){
                        $page= ($count/$rxp) - 1;
                    }else{
                        $page= floor($count/$rxp);
                    }
                }

                $sql=$sql." LIMIT ".$rxp." OFFSET ".($rxp * $page);//* page para que se salte los elementos
                $query = $this->db->query($sql);

                $row = $query;
                $return["correct"] = TRUE;

                foreach ($row as $r) {
                    $return["tramos"] []= $r;
                }
                
                $return["count"]=$count;
            } 
        } catch (PDOException $ex) {
            $return["error"] = $ex->getMessage();
        } 
        return $return;
    }


    /**
     * Elimina la actividad de la base de datos.
     *
     * @param integer $id
     * @return void Un boolean que indica si ha sido correcta la eliminación o no.
     */
    public function deleteTramos($id)
    {
        
    }

    /**
     * Edita una actividad de la base de datos desde la lista de actividades
     *
     * @param string $nombre
     * @param string $descripcion
     * @param integer $aforo
     * @param integer $id
     * @return void Un boolean que indica si ha sido correcta la eliminación o no.
     */
    public function editTramos($nombre, $descripcion, $aforo, $id)
    {
         
    }


    /**
     * Crea una nueva actividad en la base de datos
     *
     * @param string $nombre
     * @param string $descripcion
     * @param integer $aforo
     * @return void
     */
    public function createTramos($nombre, $descripcion, $aforo)
    {
        $return = [
            "correct" => FALSE,
            "errors" => []
        ];

        try {
           
            $sql="INSERT INTO actividades 
                (nombre, descripcion, aforo) 
                    VALUES 
                    ('$nombre', '$descripcion','$aforo')" ;

            //Inicializamos la transacción
            $this->db->beginTransaction();
            $query = $this->db->query($sql);

            
            //Supervisamos si la inserción se realizó correctamente... 
            if ($query) {
                $this->db->commit();
                $return["correct"] = TRUE;
            } 
            
        }catch (PDOException $ex) {
            $this->db->rollback();
            $return["errors"]["generic"] = $ex->getMessage();
        }

        return $return;
    }

    /**
     * Lista el horario. Coge los tramos y los agrupa
     *
     * @param integer $page
     * @param integer $rxp
     * @param string $dia
     * @param string $hora_inicio
     * @param string $hora_fin
     * @param string $actividad_id
     * @return void
     */
    public function listHorario($page=1,$rxp=10,$dia="",$hora_inicio="",$hora_fin="",$actividad_id="")
    {
        $diasModel= new DiasModel();
        $dias=$diasModel-> listDias();
        $diaActual=getdate();

            // Si hoy es lunes, nos daría el lunes pasado.
            if (date("D")=="Mon"){
                $week_start = date("Y-m-d");
            } else {
                $week_start = date("Y-m-d", strtotime('last Monday', time()));
            }

            //Lo mismo para domingo, pero el próximo domingo
            if (date("D")=="Sun"){
                $week_end = date("Y-m-d");
            } else {
                $week_end = date("Y-m-d", strtotime('next Sunday', time()));
            }

         $page=$page-1;
             $return = [
             "correct" => FALSE,
             "tramos" => [],
             "error" => NULL
             ];

         try {
             //Uno ambas tablas para buscar por nombre de actividad en vez de por id.
             $sql="SELECT DISTINCT t.hora_inicio, t.hora_fin FROM tramos as t join actividades as a on (t.actividad_id=a.id) " ;

             $sql_count="SELECT count(DISTINCT t.hora_inicio, t.hora_fin) as count FROM tramos as t join actividades as a on (t.actividad_id=a.id)" ;

             if($dia!="" || $hora_inicio!="" || $hora_fin!="" || $actividad_id!=""){
                 $sql=$sql." WHERE ";
                 $sql_count=$sql_count." WHERE ";//Para contar elementos que hay sin paginacion

                 $conditions=[];

                 if($dia!=""){
                     array_push($conditions,"t.dia like '%".$dia."%'");
                 }

                 if($hora_inicio!=""){
                     array_push($conditions,"t.hora_inicio = '".$hora_inicio."'");
                 }

                 if($hora_fin!=""){
                     array_push($conditions,"t.hora_fin = '".$hora_fin."'");
                 }

                 if($actividad_id!=""){
                     array_push($conditions,"a.nombre like '%".$actividad_id."%'");
                  }


                 $sql=$sql.join(" and ",$conditions);
                 $sql_count=$sql_count.join(" and ",$conditions);//Para contar elementos que hay sin paginacion
             }
             //Para ordenar el horario.
             $sql=$sql." ORDER BY t.hora_inicio, t.hora_fin";
             
             $queryAllTramosCount = $this->db->query($sql_count);

             if ($queryAllTramosCount && $dias["correct"]) {
                $count=$queryAllTramosCount->fetchObject()->count;

                //Para paginación:
                if($page>0 && $page * $rxp >= $count){

                     if($count%$rxp==0){
                         $page= ($count/$rxp) - 1;
                     }else{
                         $page= floor($count/$rxp);
                     }
                }

                $sql=$sql." LIMIT ".$rxp." OFFSET ".($rxp * $page);//* page para que se salte los elementos
             
                $queryAllTramos = $this->db->query($sql);

                if($queryAllTramos){
                    $row = $queryAllTramos;
                    $listNuevosTramos=[];

                    foreach ($row as $r) {
                        $return["tramos"] []= $r;
                        $nuevoTramo=[
                            "hora_inicio"=> $r["hora_inicio"],
                            "hora_fin"=>$r["hora_fin"]
                        ];
                        foreach ($dias["data"] as $d){
                            $sqlTramoDia="SELECT * FROM tramos WHERE hora_inicio = '".$r["hora_inicio"]."' and hora_fin = '".$r["hora_fin"]."' and dia=".$d["id"];
                            $queryTramoDia= $this->db->query($sqlTramoDia);

                            if($queryTramoDia){
                                $dataTramoDia=$queryTramoDia->fetchObject();
                                if($dataTramoDia){
                                    $nuevoTramo[$d["id"]]=[
                                        "id"=>$dataTramoDia->id,
                                        "actividad_id"=>$dataTramoDia->actividad_id
                                    ];
                                }else{
                                    $nuevoTramo[$d["id"]]=false;
                                }
                            }
                        }

                        array_push($listNuevosTramos,$nuevoTramo);
                    }

                    $return["correct"] = TRUE;
                    $return["tramos"]=$listNuevosTramos;
                    $return["count"]=$count;
                }
             }
         } catch (PDOException $ex) {
             $return["error"] = $ex->getMessage();
         }
         return $return;
    }
}