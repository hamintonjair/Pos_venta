<?php

class Errors extends CI_Controller{

    //error
    public function error(){
       $this->load->view('layouts/Errors/index');

    }

 //acceso denegado
    public function permisos(){

      $this->load->view('layouts/Errors/permisos');

     }
}

?>