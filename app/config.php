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
define('DEFAULT_EMAIL_ADMIN','anissa.jenkins@ethereal.email');
define('DEFAULT_PASSWORD_ADMIN','uUTxyuGQJuMkpJQGU5');


//------------Parámetros base de datos:----------------

define('DBDRIVER', 'mysql');
define('DBHOST', 'localhost');
define('DBNAME', 'appgym');
define('DBUSER', 'root');
define('DBPASS', '');
define('PAGE_SIZE',10);//Paginación (max de cada pagina)

?>