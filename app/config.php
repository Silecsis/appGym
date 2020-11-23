<?php 
/**
 * Parámetros de configuración globales
 * Definidos como constantes define.
 * 
 * Y parámetros de configuración de la base de datos.
 */


define('CONTROLLERS_FOLDER', 'controllers/');
define('MODELS_FOLDER', 'models/');
define('VIEWS_FOLDER', 'views/');
define('PHOTOS_FOLDER', 'fotos/');

define('DEFAULT_CONTROLLER', 'index');
define('DEFAULT_ACTION', 'index');

define('DEFAULT_LOGGED_CONTROLLER', 'home');
define('DEFAULT_LOGGED_ACTION', 'index');


//------------Parámetros base de datos:----------------

define('DBDRIVER', 'mysql');
define('DBHOST', 'localhost');
define('DBNAME', 'bdusuarios');
define('DBUSER', 'admin');
define('DBPASS', 'admin');

?>