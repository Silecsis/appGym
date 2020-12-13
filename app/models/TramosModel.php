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


   //Setter:
 
}