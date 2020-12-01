<?php

/**
 * Script que muestra en una tabla los valores enviados por el usuario a través 
 * del formulario utilizando el método POST
 */



// Función que muestra el mensaje de error bajo el campo que no ha superado
// el proceso de validación
function mostrar_error(&$errors, $campo) {
  $alert = "";
  
  if (isset($errors) && isset($errors[$campo]) && (!empty($campo))) {
    $alert = '<div class="alert alert-danger" style="margin-top:5px;">' . $errors[$campo] . '</div>';
  }
  return $alert;
}

/**
 * Comprueba que el nif sea correcto.
 *
 * @param [type] $cadena será el nif
 * @return void
 */
function comprobarNif($cadena)
{
  $letras = ['T', 'R', 'W', 'A', 'G', 'M', 'Y', 'F', 'P', 'D', 'X', 'B', 'N', 'J', 'Z', 'S', 'Q', 'V', 'H', 'L', 'C', 'K', 'E', 'T'];

    $numero= substr($cadena, 0, -1);
    $letra = substr($cadena, -1);
    $letra = strtoupper($letra);

  //1. Comprobacion de menor que 0 y mayor que 99999999.
  if ($numero < 0 || $numero > 99999999){
     return false;
  }else{
      //2. Calculamos la posicion de la letra.
          $posicionLetra = $numero%23;

      //3.Se compara con la letra indicada por el user.
      //Si no coinciden:
      if(($letras[ $posicionLetra]) != $letra) {
        return false;
      }else { //Si coincide;
          return true;
      }
  }
}


/**
 * Filtra el dato.
 *
 * @param [type] $datos será el campo a filtrar.
 * @return void
 */
function filtrado($datos){
  $datos = trim($datos); //Elimina espacios antes y después de los datos
  $datos = stripslashes($datos); //Elimina backslashes\
  $datos = htmlspecialchars($datos); //Traduce caracteres especiales en entidades HTML
  return $datos;
}


 
/**
 * Verificamos si todos los campos han sido validados
 *
 * @return void
 */
function validate() {

  // Definimos e inicializamos el array de errores y las variables asociadas a cada campo
    $nif="";
    $nombre = "";
    $apellidos = "";
    $email = "";
    $password = "";
    $passwordMod="";
    $telefono = "";
    $direccion = "";
    $imagen = "";
    $login = "";



  $errors=[];
  //Cuando se le de a enviar, se verificará cada campo.
    if (isset($_POST["submit"])) {

        $nif=filtrado($_POST["nif"]);

        if (empty($nif) || (!preg_match("/^[0-9]{8}[TRWAGMYFPDXBNJZSQVHLCKET]{1}$/i",$nif)) || !comprobarNif($nif)) {
          $errors["nif"] = "Nif no válido. Asegúrate de que el nif tiene un tamaño de 9 caracteres siendo los 8 primeros números y el último una letra divisible entre 23.";   
        } 
      
        $nombre=filtrado($_POST["nombre"]);
        if (empty($nombre) || (preg_match("/[0-9]/", $nombre)) || (strlen($nombre) > 15)) {
           $errors["nombre"] = "Nombre no válido. Asegúrate de que no tenga números ni una longitud mayor de 15.";
        } 

        $apellidos=filtrado($_POST["apellidos"]);
        if (empty($apellidos) || (preg_match("/[0-9]/", $apellidos)) || (strlen($apellidos) > 50)) {
          $errors["apellidos"] = "Apellidos no válidos. Asegúrate de que no tenga números ni una longitud mayor de 50.";
        }
      
        //Si no está logado. Control contras, imagen y login
        if(!isset($_SESSION["usuario"])){
            if (!isset($_FILES["imagen"]) || $_FILES["imagen"]["error"] != 0) {
              $errors["imagen"] = "Imagen no válida. Asegúrate de no dejar éste campo vacío.";
            }

            if (!empty($_POST["email"])) {
              $email=filtrado($_POST["email"]);
            }else{
              $errors["email"] = "Email no válido. No puede estar el campo vacío, será tu 'login'.";
            }

            if (empty($_POST["passwordMod"])||(!preg_match("/^(?=.{8,}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$/i", $_POST["passwordMod"]))) {
              $errors["passwordMod"] = "Contraseña no válida.  Asegúrese de que tenga tener una longitud mínima de 8 caracteres y contener letras mayúsculas, minúsculas, números y caracteres especiales.";
            }
        }else{
            //Para modificar contra. (passwordMod)
            $passwordAct=$_SESSION["usuario"]["password"]; //La contra actual.
            $passwordMod=filtrado($_POST["passwordMod"]); //La contra nueva.
            $password=filtrado($_POST["password"]); //La contra que introduce el user como actual.
            //Si la contra introducida por el user no es igual a la que hay en base de datos, se informa.
            if(!empty($password) && MD5($password) !== $passwordAct){
              $_POST["passwordMod"]="";
              $errors["password"] = "La contraseña que ha introducido no es la que figura en nuestra base de datos.";
            }else if (!empty($password) && MD5($password) === $passwordAct){
              if (empty($_POST["passwordMod"])||(!preg_match("/^(?=.{8,}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$/i", $_POST["passwordMod"]))) {
                
                $errors["passwordMod"] = "Contraseña no válida.  Asegúrese de que tenga tener una longitud mínima de 8 caracteres y contener letras mayúsculas, minúsculas, números y caracteres especiales.";
              }
            }
        }

        //Valida telefono movil español y telefono fijo español
        
        if ((!empty($_POST["telefono"]) && preg_match("/^(\34|0034|34)?[ -]*(6|7)[ -]*([0-9][ -]*){8}$/", $_POST["telefono"])) 
            || (!empty($_POST["telefono"])) && preg_match("/^(\34|0034|34)?[ -]*(8|9)[ -]*([0-9][ -]*){8}$/", $_POST["telefono"])) {
               $telefono=filtrado($_POST["telefono"]);
        } else {
          $errors["telefono"] = "Teléfono no válido. Asegúrese de que empiece por '0034' o '34' (estos casos anteriores opcionales, lo siguiente es obligatorio), que luego le siga un '6' o '7' (en caso de ser móvil) o '8' o '9' (en caso de ser fijo) y que el resto de números tengan una longitud de 8 caracteres.";
        }
        

        if (empty($_POST["direccion"])) {
          $errors["direccion"] = "Dirección no válida. No puedes dejar este campo vacío.";
        }
    }
  return $errors;
}


?>