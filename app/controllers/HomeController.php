<?php
/**
 * 
 */
class HomeController extends BaseController{

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
        $this->authView("home","home","index"); //Carga la variable view de la clase View.
    }

    

    /**
     * Redirige a messagesView.
     *
     * @return void
     */
    public function messages(){
        $this->authView("messages","messages","index"); 
    }
}

?>