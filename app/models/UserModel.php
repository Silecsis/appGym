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
    * @param string $email Usuario de la base de datos mediante el email.
    * @param string $password password del usuario de la base ded atos.
    * @return array si el usuario es corecto o, en caso contrario, un error.
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
          //Buscamos al usuario en la bd mediante su email y contraseña.
          //MD5() es una función que encripta las contraseñas.
          $sql="SELECT * FROM $this->table WHERE email = '$email' and password = MD5('$password')";
          
          $query = $this->db->query($sql);
       
          //Obtiene el primer elemento de la consulta.
          //Entra en el if si la consulta al menos devuelve un elemento.
          if($row = $query->fetchObject()) {
             if($row->estado==1){
                //Si está activo el usuario, se devuelven los datos de la bs.
               $result["data"]=$row;
             }else{
                //Sino, se enviará un error.
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
     * Actualiza al usuario de la bd desde el perfil del usuario.
     * Para socios y admin.
     *
     * @param string $nif
     * @param string $nombre
     * @param string $apellidos
     * @param string $password
     * @param integer $telefono
     * @param string $direccion
     * @param string $imagen
     * @param integer $id
     * @return array devuelve el resultado de la operación
     */
    public function editUser($nif, $nombre, $apellidos, $password, $telefono, $direccion, $imagen, $id)
    {
        //Guarda si es válido, los datos de la tabla de usuario de base de datos y el mensaje de error en caso de haber.
        $return = [
         "correct" => FALSE,
         "error" => NULL
         ];

      try {
         //sentencia sql que edita al usuario.
         $sql="UPDATE usuario SET 
            nif = '$nif', nombre = '$nombre', apellidos = '$apellidos', telefono = '$telefono', 
            direccion = '$direccion'" ;

         if (isset($password) && $password != ""){
            //Si cambia la contraseña, se incluye en el sql.
            $sql=$sql . ", password = MD5('$password')";
         } 

         if (isset($imagen) && $imagen != ""){
            //Si cambia la imagen, se incluye en el sql
            $sql=$sql . ", imagen = '$imagen'";
         }

         //Por ultimo, insertamos el dato único que será el id para más seguridad que el email.
         $sql=$sql . " WHERE id = '$id'";
         
         $query = $this->db->query($sql);
      
         //Supervisamos si la inserción se realizó correctamente... 
         if ($query) {
            $_SESSION["usuario"]["password"]=MD5($password);
            $return["correct"] = TRUE;
         } 

      }catch (PDOException $ex) {
         $return["error"] = $ex->getMessage();
      }
      return $return;
    }

    /**
     * Encuentra al user mediante el email si es correcto.
     *
     * @param string $email
     * @return array devuelve el resultado de la operación
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
            //Sino encuentra elementos, devolvemos un error.
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
     * Crea el user.
     *
     * @param string $nif
     * @param string $nombre
     * @param string $apellidos
     * @param string $email
     * @param string $password
     * @param integer $telefono
     * @param string $direccion
     * @param string $imagen
     * @return array devuelve el resultado de la operación
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
            //["email"] para que se meta en la parte de errores de email.
            //Se realizará cuando incluya un email que ya existe en la bd
            $return["errors"]["email"] = "Email no disponible.";
         }else{
            //Sino, creamos el user y lo incluimos en la bd.
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


    /**
     * Cambiará la contraseña en la bd.
     *
     * @param string $email
     * @param string $password
     * @return array devuelve el resultado de la operación
     */
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

    //----------------------------------Acciones de Admin-----------------------------------

    /**
     * Lista los usuarios.
     * Acción para administrador.
     *
     * @param string $nif
     * @param string $nombre
     * @param string $apellidos
     * @param string $email
     * @param string $telefono
     * @param string $direccion
     * @param string $estado
     * @param string $rol
     * @param integer $page
     * @return void Devuelve una serie de parametros que será los usurios, si es correcto y si tiene errores.
     */
    public function listUserDatas($page=1,$rxp=10,$nif="",$nombre="",$apellidos="",$email="", $telefono="", $direccion="", $estado="",$rol="")
    {
      $page=$page-1;
      $return = [
         "correct" => FALSE,
         "users" => [],
         "error" => NULL
      ];
      
      try {
         $sql="SELECT * FROM usuario" ; 

         $sql_count="SELECT count(id) as count FROM usuario" ;

         if($nif!="" || $nombre!="" || $apellidos!="" || $email!="" || $telefono!="" || $direccion!="" || $estado!="" || $rol!=""){
            $sql=$sql." WHERE ";
            $sql_count=$sql_count." WHERE ";//Para contar elementos que hay sin paginacion

            $conditions=[];

            if($nif!=""){
               array_push($conditions,"nif like '%".$nif."%'");
            }

            if($nombre!=""){
               array_push($conditions,"nombre like '%".$nombre."%'");
            }

            if($apellidos!=""){
               array_push($conditions,"apellidos like '%".$apellidos."%'");
            }

            if($email!=""){
               array_push($conditions,"email like '%".$email."%'");
            }

            if($telefono!=""){
               array_push($conditions,"telefono = '".$telefono."'");
            }

            if($direccion!=""){
               array_push($conditions,"direccion like '%".$direccion."%'");
            }

            if($estado!=""){
               array_push($conditions,"estado = '".$estado."'");
            }

            if($rol!=""){
               array_push($conditions,"rol_id = '".$rol."'");
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
               $return["users"] []= $r;
            }
            
            $return["count"]=$count;
         } 
      } catch (PDOException $ex) {
         $return["error"] = $ex->getMessage();
      } 

      return $return;
    }


    /**
     * Elimina al usuario de la bd mediante ID.
     * Acción para administrador.
     *
     * @param integer $id
     * @return void Un boolean que indica si ha sido correcta la eliminación o no.
     */
    public function deleteUser($id)
    {
      $return = [
         "correct" => FALSE,
         "error" => NULL
      ];

      //Si hemos recibido el id y es un número realizamos el borrado...
      if ($id && is_numeric($id)) {
         try {

            $sql = "DELETE FROM usuario WHERE id = ".$id;
            $query = $this->db->query($sql);

            //Supervisamos si la eliminación se realizó correctamente... 
            if ($query) {
               $return["correct"] = TRUE;
               
            } 

         } catch (PDOException $ex) {
            $return["error"] = $ex->getMessage();
         }
      } else {
         $return["correct"] = FALSE;
      }

      return $return;
    }

    /**
     * Edita el usuario desde la lista de usuarios.
     * Solo podrá editarlo el admin.
     *
     * @param string $nif
     * @param string $nombre
     * @param string $apellidos
     * @param string $email
     * @param string $password
     * @param integer $telefono
     * @param string $direccion
     * @param integer $estado
     * @param string $imagen
     * @param integer $rol_id
     * @param integer $id
     * @return array devuelve el resultado de la operación
     */
    public function adminEditUser($nif, $nombre, $apellidos, $email, $telefono, $direccion, $estado, $imagen,$rol_id, $id)
    {
       //Guarda si es válido, los datos de la tabla de usuario de base de datos y el mensaje de error en caso de haber.
       $return = [
         "correct" => FALSE,
         "errors" => []
         ];

      try {
         //sentencia sql que edita al usuario.
         $sql="UPDATE usuario SET 
            nif = '$nif', nombre = '$nombre', apellidos = '$apellidos', telefono = '$telefono', 
            direccion = '$direccion', estado = '$estado', rol_id = '$rol_id'" ;


         if (isset($imagen) && $imagen != ""){
            //Si cambia la imagen, se incluye en el sql
            $sql=$sql . ", imagen = '$imagen'";
         }

         if(isset($email)){
            $userList= $this->getBy("email",$email);

            if(count($userList) != 0 && $email !== $userList[0]->email){
               //["email"] para que se meta en la parte de errores de email.
               //Se realizará cuando incluya un email que ya existe en la bd
               $return["errors"]["email"] = "Email no disponible.";
            }else{
               $sql=$sql . ", email = '$email'";
            }
         }


         //Por ultimo, insertamos el dato único que será el id para más seguridad que el email.
         $sql=$sql . " WHERE id = '$id'";
         
         $query = $this->db->query($sql);
      
         //Supervisamos si la inserción se realizó correctamente... 
         if ($query) {
            $return["correct"] = TRUE;
         } 

      }catch (PDOException $ex) {
         $return["errors"]["db"] = $ex->getMessage();
      }
      return $return;
    }

    /**
     * Crea un usuario. 
     * Operación que solo puede realizar un admin.
     * Añade los valores "estado" y "rol_id"
     *
     * @param string $nif
     * @param string $nombre
     * @param string $apellidos
     * @param string $email
     * @param string $password
     * @param integer $telefono
     * @param string $direccion
     * @param integer $estado
     * @param string $imagen
     * @param integer $rol_id
     * @return array devuelve el resultado de la operación
     */
    public function adminCreateUser($nif, $nombre, $apellidos, $email,$password,$telefono, $direccion,$estado, $imagen,$rol_id)
    {
       //Guarda si es válido, los datos de la tabla de usuario de base de datos y el mensaje de error en caso de haber.
       $return = [
         "correct" => FALSE,
         "errors" => []
         ];

      try {
         $userList= $this->getBy("email",$email);

         if(isset($userList) && count($userList) != 0){
            //["email"] para que se meta en la parte de errores de email.
            //Se realizará cuando incluya un email que ya existe en la bd
            $return["errors"]["email"] = "Email no disponible.";
         }else{
            //Sino, creamos el user y lo incluimos en la bd.
            $sql="INSERT INTO usuario 
               (nif, nombre, apellidos, email, password,telefono, direccion, estado, imagen, rol_id) 
                  VALUES 
                  ('$nif', '$nombre', '$apellidos','$email',  MD5('$password'),  '$telefono', '$direccion','$estado','$imagen', '$rol_id')" ;

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

    /**
     * Cambia el estado del usuario en la base de datos.
     * Solo lo realiza los administradores.
     *
     * @param integer $id
     * @param integer $estado
     * @return void
     */
    public function changeStatus($estado, $id)
    {
       //Guarda si es válido, los datos de la tabla de usuario de base de datos y el mensaje de error en caso de haber.
       $return = [
         "correct" => FALSE,
         "error" => NULL
         ];

         try {
            $sql="UPDATE usuario SET 
                estado = '$estado' 
                  WHERE id = '$id'" ; 
            
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
