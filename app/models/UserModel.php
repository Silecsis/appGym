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
   private $apellido1;
   private $apellido2;
   private $imagen;
   private $login;
   private $password;
   private $email;
   private $telefono;
   private $direccion;
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

   public function getApellido1()
   {
      return $this->apellido1;
   }

   public function getApellido2()
   {
      return $this->apellido2;
   }

   public function getImagen()
   {
      return $this->imagen;
   }

   public function getLogin()
   {
      return $this->login;
   }

   public function getPassword()
   {
      return $this->password;
   }

   public function getEmail()
   {
      return $this->email;
   }

   public function getTelefono()
   {
      return $this->telefono;
   }

   public function getDireccion()
   {
      return $this->direccion;
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

   public function setApellido1($apellido1)
   {
      $this->apellido1 = $apellido1;
   }

   public function setApellido2($apellido2)
   {
      $this->apellido2 = $apellido2;
   }

   public function setImagen($imagen)
   {
      $this->imagen = $imagen;
   }

   public function setLogin($login)
   {
      $this->login = $login;
   }

   public function setPassword($password)
   {
      $this->password = $password;
   }

   public function setEmail($email)
   {
      $this->email = $email;
   }

   public function setTelefono($telefono)
   {
      $this->telefono = $telefono;
   }

   public function setDireccion($direccion)
   {
      $this->direccion = $direccion;
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
    public function getByCredentials($user,$password)
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
          $sql="SELECT * FROM $this->table WHERE login = '$user' and password = MD5('$password')";
          
          $query = $this->db->query($sql);
       
          //Obtiene el primer elemento de la consulta.
          //Entra en el if si la consulta al menos devuelve un elemento.
          if($row = $query->fetchObject()) {
              $result["data"]=$row;
 
          }else{
             //Sino encuentra elementos, el usuario o la contra son incorrectas, devolvemos un error.
             $result["isValid"] = false;
             $result["mensaje"] = "Usuario o contraseña inválidos.";
          }
 
       }catch (PDOException $ex) {
          $result["mensaje"] = $ex->getMessage();
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
    public function editUser($nif, $nombre, $apellido1, $apellido2, $imagen, $password, $email, $telefono, $direccion, $rol_id, $id)
    {
        //Guarda si es válido, los datos de la tabla de usuario de base de datos y el mensaje de error en caso de haber.
        $return = [
         "correcto" => FALSE,
         "error" => NULL
         ];

      try {
         $sql="UPDATE usuario SET 
            nif = '$nif', nombre = '$nombre', apellido1 = '$apellido1', 
            apellido2 = '$apellido2',
             email = '$email', telefono = '$telefono', 
            direccion = '$direccion', rol_id = '$rol_id'" ;

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
     * Encuentra al user mediante el login y el email si ambos son correctos y del mismo user.
     *
     * @param [type] $login
     * @param [type] $email
     * @return void
     */
    public function getByLoginAndEmail($login,$email)
    {
      $result=[
         "correct"=> true,
         "error"=>null,
         "mensaje"=>null,
      ];
      try {
         $sql="SELECT * FROM $this->table WHERE login = '$login' and email = '$email'";
         
         $query = $this->db->query($sql);
      
         //Obtiene el primer elemento de la consulta.
         //Entra en el if si la consulta al menos devuelve un elemento.
         if($query) {
             $result["correct"]=true;

         }else{
            //Sino encuentra elementos, el usuario o la contra son incorrectas, devolvemos un error.
            $result["correct"] = false;
            $result["error"] = "campo";
         }

      }catch (PDOException $ex) {
         $result["mensaje"] = $ex->getMessage();
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
    public function createUser($nif, $nombre, $apellido1, $apellido2, $imagen,$login, $password, $email, $telefono, $direccion)
    {
        //Guarda si es válido, los datos de la tabla de usuario de base de datos y el mensaje de error en caso de haber.
        $return = [
         "correct" => FALSE,
         "errors" => []
         ];

      try {
         $userList= $this->getBy("login", $login);

         if(count($userList) != 0){
            //["login"] para que se meta en la parte de errores de login.
            $return["errors"]["login"] = "Login no disponible.";
         }else{
            $sql="INSERT INTO usuario 
               (nif, nombre, apellido1, apellido2, imagen, login, password, email, telefono, direccion, rol_id) 
                  VALUES 
                  ('$nif', '$nombre', '$apellido1', '$apellido2',  '$imagen','$login', MD5('$password'), '$email', '$telefono', '$direccion', '2')" ;

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


    public function changePassword($login,$password)
    {
         //Guarda si es válido, los datos de la tabla de usuario de base de datos y el mensaje de error en caso de haber.
        $return = [
         "correct" => FALSE,
         "error" => NULL
         ];

         try {
            $sql="UPDATE usuario SET 
                password = MD5('$password') 
                  WHERE login = '$login'" ; 
            
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
