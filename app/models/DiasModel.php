<?php

/**
 *   Clase 'DiasModel' que implementa el modelo de dias de nuestra aplicación en una
 * arquitectura MVC. Se encarga de gestionar el acceso a la tabla dias
 */
class DiasModel extends BaseModel
{
   private $id;
   private $dia;

   public function __construct()
   {
      // Se conecta a la BD
      parent::__construct();
      $this->table = "dias";  
   }
   
   /**
    * Recoge los registros de la tabla dias.
    *
    * @return void
    */
    public function listDias()
    {
        $return = [
            "correct" => FALSE,
            "data" => NULL,
            "error" => NULL
         ];
         //Realizamos la consulta...
         try {  
             //Definimos la instrucción SQL  
            $sql = "SELECT * FROM dias";
            // Hacemos directamente la consulta al no tener parámetros
            $resultsquery = $this->db->query($sql);
            //Supervisamos si la inserción se realizó correctamente... 
            if ($resultsquery) :
               $return["correct"] = TRUE;
               $return["data"] = $resultsquery->fetchAll(PDO::FETCH_ASSOC);
            endif; // o no :(
         } catch (PDOException $ex) {
            $return["error"] = $ex->getMessage();
         }
   
         return $return;
    }
}