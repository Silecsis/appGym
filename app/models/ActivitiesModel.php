<?php

/**
 *   Clase 'ActivitiesModel' que implementa el modelo de actividades de nuestra aplicación en una
 * arquitectura MVC. Se encarga de gestionar el acceso a la tabla actividades
 */
class ActivitiesModel extends BaseModel
{
   private $id;
   private $nombre;
   private $descripcion;
   private $aforo;

   public function __construct()
   {
      // Se conecta a la BD
      parent::__construct();
      $this->table = "actividades";  
   }


   //Getters.
   public function getId()
   {
      return $this->id;
   }

   public function getNombre()
   {
      return $this->nombre;
   }

   public function getDescription()
   {
      return $this->description;
   }

   public function getAforo()
   {
      return $this->aforo;
   }


   //Setter:
   public function setId($id)
   {
      $this->id = $id;
   }

   public function setNombre($nombre)
   {
      $this->nombre = $nombre;
   }

   public function setDescripcion($descripcion)
   {
      $this->descripcion = $descripcion;
   }

   public function setAforo($aforo)
   {
      $this->aforo = $aforo;
   }


   /**
    * Recoge todos los datos de la tabla actividades y las lista.
    *
    * @param integer $page
    * @param string $nombre
    * @param string $descripcion
    * @param string $aforo
    * @return void
    */
   public function listActivities($page=1,$rxp=10,$nombre="", $descripcion="",$aforo="")
   {
        $page=$page-1;
            $return = [
            "correct" => FALSE,
            "activities" => [],
            "error" => NULL
            ];
        
        try {
            $sql="SELECT * FROM actividades" ; 

            $sql_count="SELECT count(id) as count FROM actividades" ;

            if($nombre!="" || $descripcion !="" || $aforo !=""){
                $sql=$sql." WHERE ";
                $sql_count=$sql_count." WHERE ";//Para contar elementos que hay sin paginacion

                $conditions=[];

                if($nombre!=""){
                    array_push($conditions,"nombre like '%".$nombre."%'");
                }

                if($descripcion!=""){
                    array_push($conditions,"descripcion like '%".$descripcion."%'");
                }

                if($aforo!=""){
                    array_push($aforo,"aforo = '".$aforo."'");
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
                    $return["activities"] []= $r;
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
   public function deleteActivities($id)
   {
        $return = [
            "correct" => FALSE,
            "error" => NULL
        ];

        //Si hemos recibido el id y es un número realizamos el borrado...
        if ($id && is_numeric($id)) {
            try {

            $sql = "DELETE FROM actividades WHERE id = ".$id;

            //Inicializamos la transacción
            $this->db->beginTransaction();
            $query = $this->db->query($sql);

            //Supervisamos si la eliminación se realizó correctamente... 
            if ($query) {
                $this->db->commit();
                $return["correct"] = TRUE;
                
            } 

            } catch (PDOException $ex) {
                $this->db->rollback();
                $return["error"] = $ex->getMessage();
            }
        } else {
            $return["correct"] = FALSE;
        }

        return $return;
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
   public function editActivities($nombre, $descripcion, $aforo, $id)
   {
        $return = [
            "correct" => FALSE,
            "errors" => []
        ];

        try {
            //sentencia sql que edita la actividad.
            $sql="UPDATE actividades SET 
             nombre = '$nombre', descripcion = '$descripcion', aforo = '$aforo' WHERE id = '$id'" ;
            
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
            $return["errors"]["db"] = $ex->getMessage();
        }
        return $return;
   }


   /**
    * Crea una nueva actividad en la base de datos
    *
    * @param string $nombre
    * @param string $descripcion
    * @param integer $aforo
    * @return void
    */
   public function createActivities($nombre, $descripcion, $aforo)
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
 
}