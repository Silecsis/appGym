<?php
/**
 * Clase controlador de errores
 */
class ErrorController extends BaseController{

    //Siempre realizar cuando herede para inicializar el constructor padre.
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Muestra la vista de error.
     *
     * @return void
     */
    public function index (){
        $this->view->show("error");
    }
}

?>