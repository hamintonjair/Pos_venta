<?php 

class CajasModel extends Query{

    private $caja, $id, $estado;
    public function __construct()
    {
        parent::__construct();
    }
  
    //listar caja
    public function getCajas(){

        $sql = "SELECT * FROM caja";
        $data = $this->selectAll($sql);
        return $data;
    }
    //registrar caja
    public function registrarCaja(string $caja){
        $this->caja = $caja; 
       
        $verificar = "SELECT * FROM caja WHERE caja = '$this->caja'";
        $existe = $this->select($verificar);
        if(empty($existe)){
             $sql ="INSERT INTO caja (caja) VALUES (?)";
            $data = array( $this->caja);
            $datos = $this->save($sql, $data);

            if($datos == 1){
                $result = 'ok';
            }else{
                $result = 'error';
            }
        }else{

            $result ="existe";
        }   
        return $result;
    }
    //editar caja
    public function editarCaja(int $id){

        $sql = "SELECT * FROM caja WHERE id = $id";
        $data = $this->select($sql);
        return $data;

    }
    //update caja
    public function updateCaja(string $caja, int $id){
        $this->caja = $caja;       
        $this->id = $id;    
       
        $sql ="UPDATE caja SET caja = ? WHERE id = ? ";
        $data = array( $this->caja,$this->id);
        $datos = $this->save($sql, $data);

            if($datos == 1){
                $result = 'modificado';
            }else{
                $result = 'error';
            }       
        return $result;
    }
     //eliminar caja
    public function accionCaja(int $estado, int $id){

        $this->id = $id;
        $this->estado = $estado;
        $sql = "UPDATE caja SET estado = ? WHERE id = ?";
        $datos = array($this->estado, $this->id);
        $data = $this->save($sql, $datos);       
        return $data;

    }
}

?>