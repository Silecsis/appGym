<?php

/**
 * Script que muestra en una tabla los valores enviados por el usuario a través 
 * del formulario utilizando el método POST
 */
// Definimos e inicializamos el array de errores y las variables asociadas a cada campo
$errors = [];
$nif="";
$nombre = "";
$apellido1 = "";
$apellido2 = "";
$imagen = "";
$login = "";
$password = "";
$email = "";
$telefono = "";
$direccion = "";
$rol    = "2";//Por defecto el rol siempre es de usuario.

// Función que muestra el mensaje de error bajo el campo que no ha superado
// el proceso de validación
function mostrar_error($errors, $campo) {
  $alert = "";
  if (isset($errors[$campo]) && (!empty($campo))) {
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


// Verificamos si todos los campos han sido validados
function validez($errors) {
  if (isset($_POST["submit"]) && (count($errors) == 0)) {
    return '<div class="alert alert-success" style="margin-top:5px;"> Formulario validado correctamente!! :)</div>';
  }
}

if (isset($_POST["submit"])) {
  if (!empty($_POST["nif"]) && (preg_match("/^[0-9]{8}[TRWAGMYFPDXBNJZSQVHLCKET]{1}$/i", $_POST["nif"])) && comprobarNif($_POST["nif"])) {
    $nif = trim($_POST["nif"]);
    $nif = filter_var($nif, FILTER_SANITIZE_STRING);
  } else {
    $errors["nif"] = "Nif no válido. Asegúsrese de que el nif tiene un tamaño de 9 caracteres siendo los 8 primeros números y el último una letra divisible entre 23.";
  }

  if (!empty($_POST["nombre"]) && (!preg_match("/[0-9]/", $_POST["nombre"])) && (strlen($_POST["nombre"]) < 15)) {
    $nombre = trim($_POST["nombre"]);
    $nombre = filter_var($nombre, FILTER_SANITIZE_STRING);
  } else {
    $errors["nombre"] = "Nombre no válido. Asegúrate de que no tenga números ni una longitud mayor de 15.";
  }

  if (!empty($_POST["apellido1"]) && (!preg_match("/[0-9]/", $_POST["apellido1"])) && (strlen($_POST["apellido1"]) < 20)) {
    $apellido1 = trim($_POST["apellido1"]);
    $apellido1 = filter_var($apellido1, FILTER_SANITIZE_STRING);
  } else {
    $errors["apellido1"] = "Apellido (primero) no válido. Asegúrate de que no tenga números ni una longitud mayor de 20.";
  }

  if (!empty($_POST["apellido2"]) && (!preg_match("/[0-9]/", $_POST["apellido2"])) && (strlen($_POST["apellido2"]) < 20)) {
    $apellido2 = trim($_POST["apellido2"]);
    $apellido2 = filter_var($apellido2, FILTER_SANITIZE_STRING);
  } else {
    $errors["apellido2"] = "Apellido (segundo) no válido. Asegúrate de que no tenga números ni una longitud mayor de 20.";
  }

  if (!isset($_FILES["imagen"]) || empty($_FILES["imagen"]["tmp_name"])) {
    $errors["imagen"] = "Imagen no válida. Vacio";
  }

  if (!empty($_POST["login"]) && (strlen($_POST["login"]) < 15)) {
    $login = trim($_POST["login"]);
    $login = filter_var($login, FILTER_SANITIZE_STRING);
  } else {
    $errors["login"] = "Login no válido. Asegúrate de que no tenga una longitud mayor de 15. EXISTENCIA";
  }

  if (empty($_POST["login"])||(!preg_match("/^(?=.{8,}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$/i", $_POST["password"]))) {
    $errors["password"] = "Contraseña no válida.  Asegúrese de que tenga tener una longitud mínima de 8 caracteres y contener letras mayúsculas, minúsculas, números y caracteres especiales.";
   
  } else {
    $password = sha1($_POST["password"]);
  }

  if (!empty($_POST["email"])) {
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors["email"] = "Email no válido. Asegúrese de que esté bien escrito.";
    }
  }else{
    $errors["email"] = "Email no válido. No puede estar el campo vacío.";
  }

  //Valida telefono movil español y telefono fijo español
  if ((!empty($_POST["telefono"]) && (preg_match("/^(\+34|0034|34)?[ -]*(6|7)[ -]*([0-9][ -]*){8}$/", $_POST["telefono"]))) 
      ||(!empty($_POST["telefono"]) && (preg_match("/^(\+34|0034|34)?[ -]*(8|9)[ -]*([0-9][ -]*){8}$/", $_POST["telefono"])))) {
    $telefono = trim($_POST["telefono"]);
    $telefono = filter_var($telefono, FILTER_SANITIZE_STRING);
  } else {
    $errors["telefono"] = "Teléfono no válido. Asegúrese de que empiece por '+34', '0034' o '34' (estos casos anteriores opcionales, lo siguiente es obligatorio), que luego le siga un '6' o '7' (en caso de ser móvil) o '8' o '9' (en caso de ser fijo) y que el resto de números tengan una longitud de 8 caracteres.";
  }
  
  if (!empty($_POST["direccion"]) ) {
    $direccion = trim($_POST["direccion"]);
    $direccion = filter_var($direccion, FILTER_SANITIZE_STRING);
  } else {
    $errors["direccion"] = "Dirección no válida. Vacio.";
  }

  
}
?>