<?php

/**
 * Incluimos los modelos que necesite este controlador
 */
require_once MODELS_FOLDER . 'UserModel.php';
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;
// use PHPMailer\PHPMailer\Exception;


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
     * CORREGIR: ENVIAR MENSAJE A SU EMAIL EN VEZ DE QUE APAREZCA EN PANTALLA.
     *
     * @return void
     */
    public function recuperate()
    {
        // require_once 'phpmailer/Exception.php';
        // require_once 'phpmailer/PHPMailer.php';
        // require_once 'phpmailer/SMTP.php';

        if(isset($_POST['submit'])){

            $userModel=new UserModel();
            $user=$userModel->getByEmail($_POST["emailUser"]);

            if($user["correct"]){
                // $mail = new PHPMailer(true);

                // try {
                //     //Server settings
                //     $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                //     $mail->isSMTP();                                            // Send using SMTP
                //     $mail->Host       = 'mail.smtpbucket.com';                    // Set the SMTP server to send through
                //     $mail->SMTPAuth   = false;                                   // Enable SMTP authentication
                //     //$mail->Username   = 'user@example.com';                     // SMTP username
                //     //$mail->Password   = 'secret';                               // SMTP password
                //     $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                //     $mail->Port       = 8025;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                //     //Recipients
                //     $mail->setFrom('appgym@gmail.com', 'APPGYM');
                //     $mail->addAddress($_POST["emailUser"]);     // Add a recipient
                //     //$mail->addReplyTo('info@example.com', 'Information');
                //     //$mail->addCC('cc@example.com');
                //     //$mail->addBCC('bcc@example.com');

                    

                //     // Content
                //     $mail->isHTML(false);                                  // Set email format to HTML
                //     $mail->Subject = 'APPGYM: Recuperar contraseña';
                //     $mail->Body    = 'Tu passsword es: ';
                //     //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                //     $mail->send();
                //     echo 'Message has been sent';
                // } catch (Exception $e) {
                //     echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                // }


                // $params=[
                //     "sendPassword"=> true,
                //     "error"=>false
                // ];

                //Si el user está en la bd, se genera una contraseña nueva aleatoria.
                 $passwordNew=uniqid("",true); //Para contra aleatoria.
                 //Luego se cambia esta contraseña en la bd.
                 $changePassword = $userModel -> changePassword($_POST["emailUser"],$passwordNew );  
                if($changePassword["correct"]){
                    //Si el cambio es correcto, le pasamos la contra nueva al usuario.
                    $params=[
                        "password" => $passwordNew
                    ];
                }else{
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