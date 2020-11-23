<?php
/**
 * 
 */
class IndexController extends BaseController{

    //Siempre realizar cuando herede para inicializar el constructor padre.
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Carga el login.
     *
     * @return void
     */
    public function index (){
        
        if(isset( $_SESSION['logueado'])){
            $this->redirect(DEFAULT_LOGGED_CONTROLLER,DEFAULT_LOGGED_ACTION);
        }else{
            $this->view->show("login"); //Carga la variable view de la clase View.
        }
    }

    /**
     * Loguea al usuario.
     *
     * @return void
     */
    public function login(){

        //Los usuarios que valen.
        $usuariook = "MJ";
        $passok = "MJ";

  
        //Cuando pulsamos el botón enviar.
        if(isset($_POST['submit']))
        { // Comprobamos que recibimos los datos y que no están vacíos
            if((isset($_POST['usuario'])&& isset($_POST['password'])) 
                && (!empty($_POST['usuario'])&& !empty($_POST['password'])))
            {
                if ($_POST['usuario'] == $usuariook && $_POST['password'] == $passok) 
                {
                    $_SESSION['logueado']=$_POST['usuario'];
                    $_SESSION['usuario']= $_POST['usuario'];

                    //Creamos un par de cookies para recordar el user/pass. Tcaducidad=15días
                    if(isset($_POST['recordar'])&&($_POST['recordar']=="on")) // Si está seleccioniado el checkbox...
                    { // Creamos las cookies para ambas variables 
                        setcookie ('usuario' ,$_POST['usuario'] ,time() + (15 * 24 * 60 * 60)); 
                        setcookie ('password',$_POST['password'],time() + (15 * 24 * 60 * 60));
                        setcookie ('recordar',$_POST['recordar'],time() + (15 * 24 * 60 * 60));
                    } else {  //Si no está seleccionado el checkbox..
                        // Eliminamos las cookies
                        if(isset($_COOKIE['usuario'])) { 
                        setcookie ('usuario',""); } 
                        if(isset($_COOKIE['password'])) { 
                        setcookie ('password',""); } 
                        if(isset($_COOKIE['recordar'])) { 
                        setcookie ('recordar',""); }    
                    }


                    // Lógica asociada a mantener la sesión mantenerSesion 
                    if(isset($_POST['mantenerSesion'])&&($_POST['mantenerSesion']=="on")) // Si está seleccionado el checkbox...
                    { // Creamos una cookie para la sesión 
                        setcookie ('mantenerSesion' ,$_POST['usuario'],time() + (15 * 24 * 60 * 60)); 
                    } else {  //Si no está seleccionado el checkbox..
                        // Eliminamos la cookie
                        if(isset($_COOKIE['mantenerSesion'])) 
                        { 
                            setcookie ('mantenerSesion',""); 
                        } 
                    }
                    // Redirigimos a la página de inicio de nuestro sitio  
                    parent::redirect("home","index");
                }else{
                    $params=[
                        "userName"=> $_POST['usuario'],
                        "error"=> true
                    ];
                    

                    parent::redirect("index","index",$params);
                }  
            }
        }
    }

    /**
     * Cierra la sesión y elimina la cookie de mantenerSesion.
     * Luego, redirige al index.php
     *
     * @return void
     */
    public function logout(){
        session_start();
        session_unset();
        session_destroy();

        if(isset($_COOKIE['mantenerSesion'])) 
        { 
            setcookie ('mantenerSesion',""); 
        } 

        $this->redirect(DEFAULT_CONTROLLER, DEFAULT_ACTION);
    }
}

?>