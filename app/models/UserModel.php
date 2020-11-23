<?php

/**
 *   Clase 'UserModel' que implementa el modelo de usuarios de nuestra aplicación en una
 * arquitectura MVC. Se encarga de gestionar el acceso a la tabla usuarios
 */
class UserModel extends BaseModel
{

   public function __construct()
   {
      // Se conecta a la BD
      parent::__construct();
      $this->table = "usuario";  
   }

   /**
    * Devuelve los datos del usuario logado si los datos son correctos con la base de datos.
    *
    * @param [type] $user Usuario de la base de datos.
    * @param [type] $password password del usuario de la base ded atos.
    * @return si el usuario es corecto o, en caso contrario, un error.
    */
   public function getByCredentials($user,$password)
   {
      //PASSWORD CODIFICADO.

      //Guarda si es válido, los datos de la yabla de usuario de base de datos y el mensaje de error en caso de haber.
      $result=[
         "isValid"=> true,
         "data"=> null,
         "error"=>null
      ];

      try {
         $sql="SELECT * FROM $this->table WHERE login = '$user' and password = '$password'";
         
         $query = $this->db->query($sql);
      
         //Obtiene el primer elemento de la consulta.
         //Entra en el if si la consulta al menos devuelve un elemento.
         if($row = $query->fetchObject()) {
             $result["data"]=$row;

         }else{
            //Sino encuentra elementos, el usuario o la contra son incorrectas y devolvemos un error.
            $result["isValid"] = false;
            $result["error"] = "Usuario o contraseña inválidos.";
         }

      }catch (PDOException $ex) {
         $result["error"] = $ex->getMessage();
         $result["isValid"] = false;
      }
      

      return $result;//Devolvemos el resultado sea el error o el registro.
   }
}
