<?php
/**
 * 
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
}

?>