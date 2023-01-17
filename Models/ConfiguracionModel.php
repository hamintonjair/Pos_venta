<?php 

class ConfiguracionModel extends Query{

    private $caja, $id, $estado;
    public function __construct()
    {
        parent::__construct();
    }
  
    //listar caja
    public function getEmpresa(){

        $sql = "SELECT * FROM configuracion";
        $data = $this->select($sql);
        return $data;
    }
    //actualizar
    public function actualizar( string $nit,string $nombre, string $telefono, string $direccion, string $ciudad, string $mensaje, int $id){

        $sql = "UPDATE configuracion SET nit = ?, nombre = ?, telefono = ?, direccion = ?, ciudad = ?, mensaje = ? WHERE id = ?";
        $data = array($nit, $nombre,  $telefono,  $direccion,  $ciudad,  $mensaje,  $id);
        $datos = $this->save($sql, $data);
     
          if($datos == 1){            
            $result = 'ok';
          }else{
            $result = 'error';
          }         
        return $result;
    }
}

?>