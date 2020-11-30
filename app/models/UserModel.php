<?php

/**
 *   Clase 'UserModel' que implementa el modelo de usuarios de nuestra aplicación en una
 * arquitectura MVC. Se encarga de gestionar el acceso a la tabla usuarios
 */
class UserModel extends BaseModel
{
   private $id;
   private $nif;
   private $nombre;
   private $apellidos;
   private $email;
   private $password;
   private $telefono;
   private $direccion;
   private $estado;
   private $imagen;
   private $rol_id;
   
   public function __construct()
   {
      // Se conecta a la BD
      parent::__construct();
      $this->table = "usuario";  
   }


   //Getters.
   public function getId()
   {
      return $this->id;
   }

   public function getNif()
   {
      return $this->nif;
   }

   public function getNombre()
   {
      return $this->nombre;
   } 

   public function getApellidos()
   {
      return $this->apellidos;
   }

    public function getEmail()
   {
      return $this->email;
   }

    public function getPassword()
   {
      return $this->password;
   }

    public function getTelefono()
   {
      return $this->telefono;
   }

   public function getDireccion()
   {
      return $this->direccion;
   }

   public function getEstado()
   {
      return $this->estado;
   }

   public function getImagen()
   {
      return $this->imagen;
   }

   public function getRol()
   {
      return $this->rol_id;
   }



   //Setter:
   public function setId($id)
   {
      $this->id = $id;
   }

   public function setNif($nif)
   {
      $this->nif = $nif;
   }

   public function setNombre($nombre)
   {
      $this->nombre = $nombre;
   }

   public function setApellidos($apellidos)
   {
      $this->apellidos = $apellidos;
   }

   public function setEmail($email)
   {
      $this->email = $email;
   }

   public function setPassword($password)
   {
      $this->password = $password;
   }

   public function setTelefono($telefono)
   {
      $this->telefono = $telefono;
   }

   public function setDireccion($direccion)
   {
      $this->direccion = $direccion;
   }

   public function setEstado($estado)
   {
      $this->estado = $estado;
   }

   public function setImagen($imagen)
   {
      $this->imagen = $imagen;
   }

   public function setRol($rol_id)
   {
      $this->rol_id = $rol_id;
   }


  /**
   * Para logar al usuario mediante la base de datos.
    * Devuelve los datos del usuario logado si los datos son correctos con la base de datos.
    *
    * @param [type] $user Usuario de la base de datos.
    * @param [type] $password password del usuario de la base ded atos.
    * @return si el usuario es corecto o, en caso contrario, un error.
    */
    public function getByCredentials($email,$password)
    {
       //PASSWORD CODIFICADO.
 
       //Guarda si es válido, los datos de la tabla de usuario de base de datos y el mensaje de error en caso de haber.
       $result=[
          "isValid"=> true,
          "data"=> null,
          "error"=>null,
          "mensaje"=>""
       ];
 
       try {
          //MD5() es una función que encripta las contraseñas.
          $sql="SELECT * FROM $this->table WHERE email = '$email' and password = MD5('$password')";
          
          $query = $this->db->query($sql);
       
          //Obtiene el primer elemento de la consulta.
          //Entra en el if si la consulta al menos devuelve un elemento.
          if($row = $query->fetchObject()) {
             if($row->estado==1){
               $result["data"]=$row;
             }else{
               $result["isValid"] = false;
               $result["error"] = "deactivated";
             }
              
 
          }else{
             //Sino encuentra elementos, el usuario o la contra son incorrectas, devolvemos un error.
             $result["isValid"] = false;
             $result["error"] = "notFound";
          }
 
       }catch (PDOException $ex) {
          $result["error"] = $ex->getMessage();
          $result["isValid"] = false;
       }
       
 
       return $result;//Devolvemos el resultado sea el error o el registro.
    }



    /**
     * Actualiza al usuario en la base de datos.
     *
     * @param [type] $nif
     * @param [type] $nombre
     * @param [type] $apellido1
     * @param [type] $apellido2
     * @param [type] $imagen
     * @param [type] $login
     * @param [type] $password
     * @param [type] $email
     * @param [type] $telefono
     * @param [type] $direccion
     * @param [type] $rol_id
     * @param [type] $id no se modifica, solo servirá para identificar al usuario.
     * @return void
     */
    public function editUser($nif, $nombre, $apellidos, $password, $telefono, $direccion, $imagen, $id)
    {
        //Guarda si es válido, los datos de la tabla de usuario de base de datos y el mensaje de error en caso de haber.
        $return = [
         "correcto" => FALSE,
         "error" => NULL
         ];

      try {
         $sql="UPDATE usuario SET 
            nif = '$nif', nombre = '$nombre', apellidos = '$apellidos', telefono = '$telefono', 
            direccion = '$direccion'" ;

         if (isset($password) && $password != ""){
            $sql=$sql . ", password = MD5('$password')";
         } 

         if (isset($imagen) && $imagen != ""){
            $sql=$sql . ", imagen = '$imagen'";
         }

         $sql=$sql . " WHERE id = '$id'";
         
         $query = $this->db->query($sql);
      
         //Supervisamos si la inserción se realizó correctamente... 
         if ($query) {
            $_SESSION["usuario"]["password"]=MD5($password);
            $return["correcto"] = TRUE;
         } 

      }catch (PDOException $ex) {
         $return["error"] = $ex->getMessage();
      }
      

      return $return;
    }



    /**
     * Encuentra al user mediante el el email si es correcto.
     *
     * @param [type] $login
     * @param [type] $email
     * @return void
     */
    public function getByEmail($email)
    {
      $result=[
         "correct"=> true,
         "error"=>null,
         "mensaje"=>null,
      ];
      try {
         $query = $this->getBy('email',$email);
      
         //Obtiene el primer elemento de la consulta.
         //Entra en el if si la consulta al menos devuelve un elemento.
         if(count($query) ==1) {
             $result["correct"]=true;

         }else{
            //Sino encuentra elementos, el usuario o la contra son incorrectas, devolvemos un error.
            $result["correct"] = false;
            $result["error"] = "campo";
         }

      }catch (PDOException $ex) {
         $result["error"] = $ex->getMessage();
         $result["correct"] = false;
      }
      return $result;//Devolvemos el resultado sea el error o el registro.
    }

    /**
     * Crea el user
     *
     * @param [type] $nif
     * @param [type] $nombre
     * @param [type] $apellido1
     * @param [type] $apellido2
     * @param [type] $imagen
     * @param [type] $login
     * @param [type] $password
     * @param [type] $email
     * @param [type] $telefono
     * @param [type] $direccion
     * @return void
     */
    public function createUser($nif, $nombre, $apellidos, $email,$password,$telefono, $direccion, $imagen)
    {
        //Guarda si es válido, los datos de la tabla de usuario de base de datos y el mensaje de error en caso de haber.
        $return = [
         "correct" => FALSE,
         "errors" => []
         ];

      try {
         $userList= $this->getBy("email",$email);

         if(count($userList) != 0){
            //["login"] para que se meta en la parte de errores de login.
            $return["errors"]["email"] = "Email no disponible.";
         }else{
            $sql="INSERT INTO usuario 
               (nif, nombre, apellidos,  email, password,telefono, direccion, estado, imagen, rol_id) 
                  VALUES 
                  ('$nif', '$nombre', '$apellidos','$email',  MD5('$password'),  '$telefono', '$direccion','0','$imagen', '2')" ;

            $query = $this->db->query($sql);

         
            //Supervisamos si la inserción se realizó correctamente... 
            if ($query) {
               $return["correct"] = TRUE;
            } 
         }
      }catch (PDOException $ex) {
         $return["errors"]["generic"] = $ex->getMessage();
      }

      return $return;
    }


    public function changePassword($email,$password)
    {
         //Guarda si es válido, los datos de la tabla de usuario de base de datos y el mensaje de error en caso de haber.
        $return = [
         "correct" => FALSE,
         "error" => NULL
         ];

         try {
            $sql="UPDATE usuario SET 
                password = MD5('$password') 
                  WHERE email = '$email'" ; 
            
            $query = $this->db->query($sql);
         
            //Supervisamos si la inserción se realizó correctamente... 
            if ($query) {
               $return["correct"] = TRUE;
            } 

         }catch (PDOException $ex) {
            $return["error"] = $ex->getMessage();
         }
         return $return; 
   }
}
