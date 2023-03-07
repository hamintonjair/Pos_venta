<?php

class Errors extends Controller{

    //error
    public function index(){

       $this->views->getView($this, "index");
    }
 //acceso denegado
    public function permisos(){

        $this->views->getView($this, "permisos");
     }
}

?>