<?php
/**
 * 
 */
//Para que cargue la clase del modelo:
 require_once MODELS_FOLDER."UserModel.php";


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
        
        if(isset($_SESSION['logueado'])){
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
        //Los usuarios que valen serán de la bd.

        //Cuando pulsamos el botón enviar.
        if(isset($_POST['submit']))
        { // Comprobamos que recibimos los datos y que no están vacíos
            if((isset($_POST['usuario'])&& isset($_POST['password'])) 
                && (!empty($_POST['usuario'])&& !empty($_POST['password'])))
            {
                $userModel=new UserModel();

                $user=$userModel->getByCredentials($_POST['usuario'],$_POST['password']);

                //Si la BBDD indica que el usuario y la contraseña coinciden...
                if ($user["isValid"]) 
                {
                    $_SESSION['logueado']=true;

                    //Guardamos el nombre del user y el rol del user en la variable de sesión.
                    $_SESSION['usuario']= [
                        "login"=>$user["data"]->login,
                        "rol_id"=>$user["data"]->rol_id,
                        "id"=>$user["data"]->id,
                        "password"=>$user["data"]->password,
                        "nombre"=> $user["data"]->nombre,
                        "img"=>$user["data"]->imagen,
                        "hora_login"=> date('H:i:s')
                    ];

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
                    { // Creamos las cookies de la sesion que incluye el nombre de user y su rol.

                //-----------------------MODIFICAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAR.
                        //(El rol se borrará de las cookies porque pasará a leerse a bd.)
                        setcookie ('mantenerSesion' , 'on',time() + (15 * 24 * 60 * 60)); 
                        setcookie ('mantenerSesion_login' ,  $_SESSION['usuario']["login"],time() + (15 * 24 * 60 * 60));
                        setcookie ('mantenerSesion_rol' ,  $_SESSION['usuario']["rol_id"],time() + (15 * 24 * 60 * 60));
                        setcookie ('mantenerSesion_nombre' ,  $_SESSION['usuario']["nombre"],time() + (15 * 24 * 60 * 60));
                        setcookie ('mantenerSesion_img' ,  $_SESSION['usuario']["img"],time() + (15 * 24 * 60 * 60));
                        setcookie ('mantenerSesion_hora' ,  $_SESSION['usuario']["hora_login"],time() + (15 * 24 * 60 * 60));
                    } else {  //Si no está seleccionado el checkbox..
                        // Eliminamos la cookie
                        if(isset($_COOKIE['mantenerSesion'])) 
                        { 
                            //Limpiamos todas las cookies.
                            setcookie ('mantenerSesion',""); 
                            setcookie ('mantenerSesion_login',"");
                            setcookie ('mantenerSesion_rol',"");
                            setcookie ('mantenerSesion_img' ,"");
                            setcookie ('mantenerSesion_nombre',"");
                            setcookie ('mantenerSesion_hora',"");
                        } 
                    }
                    // Redirigimos a la página de inicio de nuestro sitio  
                    parent::redirect("home","index");
                }else{
                    $params=[
                        "userName"=> $_POST['usuario'],
                        "error"=> "notFound"
                    ];
                    parent::redirect("index","index",$params);
                }  
            }else{
                $params=[
                    "userName"=> $_POST['usuario'],
                    "error"=>"empty"
                ];

                parent::redirect("index","index",$params);
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
        session_unset();
        session_destroy();

        if(isset($_COOKIE['mantenerSesion'])) 
        { 
            setcookie ('mantenerSesion',""); 
            setcookie ('mantenerSesion_login',"");
            setcookie ('mantenerSesion_rol',"");
            setcookie ('mantenerSesion_nombre',"");
            setcookie ('mantenerSesion_hora',"");
        } 

        $this->redirect(DEFAULT_CONTROLLER, DEFAULT_ACTION);
    }
}

?>