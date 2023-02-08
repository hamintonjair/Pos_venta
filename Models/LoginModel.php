<?php 

class LoginModel extends Query{
    private $usuario, $nombre, $clave , $id_caja, $id, $estado;

    public function __construct()
    {
        parent::__construct();
    }
       // validar usuario
    public function getUsuario(string $usuario, string $clave){

        $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND clave = '$clave'  AND estado != 0 ";
        $data = $this->select($sql);

        return $data;
        
    }
}

?>