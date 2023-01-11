<?php 

class CategoriasModel extends Query{

    private $categoria, $id, $estado;
    public function __construct()
    {
        parent::__construct();
    }
  
    //listar categoria
    public function getCategorias(){

        $sql = "SELECT * FROM categorias";
        $data = $this->selectAll($sql);
        return $data;
    }
    //registrar categoria
    public function registrarCategoria(string $categoria){
        $this->categoria = $categoria; 
       
        $verificar = "SELECT * FROM categorias WHERE nombre = '$this->categoria'";
        $existe = $this->select($verificar);
        if(empty($existe)){
             $sql ="INSERT INTO categorias (nombre) VALUES (?)";
            $data = array( $this->categoria);
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
    //editar categoria
    public function editarCategoria(int $id){

        $sql = "SELECT * FROM categorias WHERE id = $id";
        $data = $this->select($sql);
        return $data;

    }
    //update categoria
    public function updateCategoria(string $categoria, int $id){
        $this->categoria = $categoria;       
        $this->id = $id;    
       
        $sql ="UPDATE categorias SET nombre = ? WHERE id = ? ";
        $data = array( $this->categoria,$this->id);
        $datos = $this->save($sql, $data);

            if($datos == 1){
                $result = 'modificado';
            }else{
                $result = 'error';
            }       
        return $result;
    }
     //eliminar categoria
    public function accionCategoria(int $estado, int $id){

        $this->id = $id;
        $this->estado = $estado;
        $sql = "UPDATE categorias SET estado = ? WHERE id = ?";
        $datos = array($this->estado, $this->id);
        $data = $this->save($sql, $datos);       
        return $data;

    }
}

?>