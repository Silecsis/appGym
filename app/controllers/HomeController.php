<?php
/**
 * Clase controlador de la vista homeView.php.
 */
class HomeController extends BaseController{

    //Siempre realizar cuando herede para inicializar el constructor padre.
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Carga la vista home.
     *
     * @return void
     */
    public function index (){
        $this->authView("home","home","index"); 
    }
}

?>