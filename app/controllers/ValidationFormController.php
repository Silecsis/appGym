<?php

/**
 * Script que controla la validación de formularios.
 */



/**
 * Función que muestra el mensaje de error bajo el campo que no ha superado 
 * el proceso de validación
 *
 * @param array $errors array que contendrá los errores
 * @param string $campo será el name de la etiqueta del html.
 * @return void devuelve el error.
 */
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
 * @param string $cadena será el nif
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
 * @return array devuelve el array de errores.
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
    $aforo=0;
    $descripcion="";
    $hora_inicio="";
    $hora_fin="";
    $fecha_alta="";
    $fecha_baja="";
    $hoy = getdate();
    $dia="";
    $actividad_id="";



  $errors=[];
  //Cuando se le de a enviar, se verificará cada campo.
    if (isset($_POST["submit"])) {

        if(isset($_POST["nif"])){
          $nif=filtrado($_POST["nif"]);
            if (empty($nif) || (!preg_match("/^[0-9]{8}[TRWAGMYFPDXBNJZSQVHLCKET]{1}$/i",$nif)) || !comprobarNif($nif)) {
              $errors["nif"] = "Nif no válido. Asegúrate de que el nif tiene un tamaño de 9 caracteres siendo los 8 primeros números y el último una letra divisible entre 23.";   
            }
        }


        if(isset($_POST["nombre"])){
          $nombre=filtrado($_POST["nombre"]);
            if (empty($nombre) || (preg_match("/[0-9]/", $nombre)) || (strlen($nombre) > 15)) {
                $errors["nombre"] = "Nombre no válido. Asegúrate de que no tenga números ni una longitud mayor de 15.";
            }
        }
      
        if(isset($_POST["apellidos"])){
          $apellidos=filtrado($_POST["apellidos"]);
          if (empty($apellidos) || (preg_match("/[0-9]/", $apellidos)) || (strlen($apellidos) > 50)) {
            $errors["apellidos"] = "Apellidos no válidos. Asegúrate de que no tenga números ni una longitud mayor de 50.";
          }
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
        }else if(isset($_SESSION["usuario"]["rol_id"]) && $_SESSION["usuario"]["rol_id"]==1 && !isset($_GET["id"]) && $_GET["action"]!="createActivities" && $_GET["action"]!="createTramos"){
            // Si está logueado con el rol de admin, pero en la barra no hay id, no deberá controlar el error de contraseña. 
            if (!isset($_FILES["imagen"]) || $_FILES["imagen"]["error"] != 0) {
              $errors["imagen"] = "Imagen no válida. Asegúrate de no dejar éste campo vacío.";
            }

            if (!empty($_POST["email"])) {
              $email=filtrado($_POST["email"]);
            }else{
              $errors["email"] = "Email no válido. No puede estar el campo vacío, será tu 'login'.";
            }

        }else{

          if(isset($_POST["passwordMod"])){
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
            
        }

        //Valida telefono movil español y telefono fijo español

        if(isset($_POST["telefono"])){
          if ((!empty($_POST["telefono"]) && preg_match("/^(\34|0034|34)?[ -]*(6|7)[ -]*([0-9][ -]*){8}$/", $_POST["telefono"])) 
            || (!empty($_POST["telefono"])) && preg_match("/^(\34|0034|34)?[ -]*(8|9)[ -]*([0-9][ -]*){8}$/", $_POST["telefono"])) {

                  $telefono=filtrado($_POST["telefono"]);
          } else {
            $errors["telefono"] = "Teléfono no válido. Asegúrese de que empiece por '0034' o '34' (estos casos anteriores opcionales, lo siguiente es obligatorio), que luego le siga un '6' o '7' (en caso de ser móvil) o '8' o '9' (en caso de ser fijo) y que el resto de números tengan una longitud de 8 caracteres.";
          }

        }
        

        if (isset($_POST["telefono"]) && empty($_POST["direccion"])) {
          $errors["direccion"] = "Dirección no válida. No puedes dejar este campo vacío.";
        }

        //Actividades dirigidas:
        if (isset($_POST["descripcion"]) && empty($_POST["descripcion"])) {
          $errors["descripcion"] = "Descripción no válida. Asegúrate de no dejar este campo vacío ni que tenga una longitud mayor a 100 caracteres.";
        }

        if (isset($_POST["aforo"]) && (empty($_POST["aforo"]) || $_POST["aforo"] < 1 || $_POST["aforo"] > 50)) {
          $errors["aforo"] = "Aforo no válido. Asegúrate de no dejar este campo vacío y de que el aforo esté entre 1 y 50.";
        }

        //Tramos
        //En las hora valida de 24 horas
        if (isset($_POST["hora_inicio"]) && (empty($_POST["hora_inicio"]) || !preg_match("/^(?:2[0-3]|[01][0-9]):[0-5][0-9](:[0-5][0-9])*$/", $_POST["hora_inicio"]))) {
          $errors["hora_inicio"] = "Hora de inicio no válida. Asegúrate de no dejar este campo y que tenga un formato YYYY-MM-DD.";
        }

        if (isset($_POST["hora_fin"]) && (empty($_POST["hora_fin"]) || !preg_match("/^(?:2[0-3]|[01][0-9]):[0-5][0-9](:[0-5][0-9])*$/", $_POST["hora_fin"]))) {
          $errors["hora_fin"] = "Hora de fin no válida. Asegúrate de no dejar este campo vacío  y que tenga un formato YYYY-MM-DD.";
        }

        if (isset($_POST["fecha_alta"]) && (empty($_POST["fecha_alta"]) || !preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $_POST["fecha_alta"]))) {
          $errors["fecha_alta"] = "Fecha de alta no válida. Asegúrate de no dejar este campo vacío y que tenga un formato HH:MM.";
        }

        if (isset($_POST["fecha_baja"]) && ($_POST["fecha_baja"] !="" && !preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $_POST["fecha_baja"]))) {
          $errors["fecha_baja"] = "Fecha de baja no válida. Asegúrate de la fecha de baja no sea menor que la fecha de alta HH:MM.";
        }

        if (isset($_POST["dia"]) &&  (empty($_POST["dia"]))) {
          $errors["dia"] = "El día no puede estar vacío.";
        }

        if (isset($_POST["actividad_id"]) && (empty($_POST["actividad_id"])) ) {
          $errors["actividad_id"] = "La actividad no puede estar vacío.";
        }

    }
  return $errors;
}


?>