<?php

/**
 * Incluimos los modelos que necesite este controlador
 */
require_once MODELS_FOLDER . 'UserModel.php';
//Cargamos los ficheros necesarios
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


/**
 * Es el controler de la vista PasswordView.php (la de "olvidé mi contraseña")
 */
class PasswordController extends BaseController{

    //Siempre realizar cuando herede para inicializar el constructor padre.
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Carga la vista de olvide mi contraseña (passwordView).
     *
     * @return void
     */
    public function forgoted (){
        $this->view->show("password");
    }

    /**
     * Recuperará la contraseña mediante el email.
     * Utilización de phpmailer.
     * 
     * NOTA: Para no colocar mi correo y contraseña reales, se ha utilizado un servicio falso de email.
     * Se puede ver si se ha enviado correctamente accediendo a la bandeja de mensajes enviados del enlace 
     *  · https://ethereal.email/create 
     * 
     * con el usuario: anissa.jenkins@ethereal.email
     * y contraseña: uUTxyuGQJuMkpJQGU5.
     *
     * @return void
     */
    public function recuperate()
    {
        //Cargamos los ficheros.
        require_once 'phpmailer/Exception.php';
        require_once 'phpmailer/PHPMailer.php';
        require_once 'phpmailer/SMTP.php';

        if(isset($_POST['submit'])){
            //Si hemos pulsado el botón de enviar:

            $params=[
                "error"=>"",
                "sendMail" => false
            ];

            $userModel=new UserModel();

            //Buscamos el email.
            $user=$userModel->getByEmail($_POST["emailUser"]);

            if($user["correct"]){
                try {
                    //Si el user está en la bd, se genera una contraseña nueva aleatoria.
                    $passwordNew=uniqid("",true); 

                    //Luego se cambia esta contraseña en la bd.
                    $changePassword = $userModel -> changePassword($_POST["emailUser"],$passwordNew );  


                    //Servicio falso de email: https://ethereal.email/create

                    //Ahora configuramos el $mail con los siguientes datos:

                    $mail = new PHPMailer(true);
                    $mail->isSMTP();
                    $mail->Host = 'smtp.ethereal.email'; //Se deberá modificar según la extensión del Username (ejemplo: para gmail: smtp.gmail.com)
                    $mail->SMTPAuth = true;
                    $mail->Username = 'anissa.jenkins@ethereal.email';//Se deberá modificar por el email del cual se quiera enviar los correos.
                    $mail->Password = 'uUTxyuGQJuMkpJQGU5'; //Se deberá modificar por la contraseña del email del cual se quiera enviar los correos.
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;

                    //Recipients
                    $mail->setFrom('anissa.jenkins@ethereal.email', 'APPGYM');//Se deberá modificar por el email del cual se quiera enviar los correos.
                    $mail->addAddress($_POST["emailUser"]); 

                    // Content
                    $mail->isHTML(false);                                  
                    $mail->Subject = 'APPGYM: Recuperar clave de seguridad';
                    $mail->Body    = 'Tu passsword es: '.$passwordNew;
                    $mail->send();

                    
                    if($changePassword["correct"]){
                        //Si el cambio es correcto, le pasamos la contra nueva al usuario.
                        $params=[
                            "sendMail" => true
                        ];
                    }else{
                        //Si no, se le avisa mediante error.
                        $params=[
                            "error"=>"unexpected"
                        ];
                    }

                } catch (Exception $e) {
                   //Si no, se le avisa mediante error.
                   $params=[
                        "error"=>"unexpected"
                    ];
                }  

            }else{
                //Si el user no es correcto, se manda un error.
                $params=[
                    "error"=>$user["error"]
                ];
            }
            //En cualquier caso, se le enviará a la vista de "Olvidé mi contraseña"
            parent::redirect("password","forgoted",$params);
        }
    }
}

?>