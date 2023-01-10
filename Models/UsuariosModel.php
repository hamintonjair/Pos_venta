<?php 

class UsuariosModel extends Query{
    private $usuario, $nombre, $clave , $id_caja, $id;
    public function __construct()
    {
        parent::__construct();
    }
   // validar usuario
    public function getUsuario(string $usuario, string $clave){

        $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND clave  = '$clave' ";
        $data = $this->select($sql);
        return $data;
    }
    //listar caja 
    public function getCajas(){

        $sql = "SELECT * FROM caja  WHERE estado = 1";
        $data = $this->selectAll($sql);
        return $data;
    }
    //listar usuarios
    public function getUsuarios(){

        $sql = "SELECT u.*, c.id as id_caja, c.caja FROM usuarios u INNER JOIN caja c WHERE u.id_caja = c.id";
        $data = $this->selectAll($sql);
        return $data;
    }
    //registrar usuarios
    public function registrarUsuario(string $usuario, string $nombre, string $clave, int $id_caja){
        $this->usuario = $usuario;
        $this->nombre =$nombre;
        $this->clave = $clave;
        $this->id_caja = $id_caja;
        $verificar = "SELECT * FROM usuarios WHERE usuario = '$this->usuario'";
        $existe = $this->select($verificar);
        if(empty($existe)){
             $sql ="INSERT INTO usuarios(usuario,nombre,clave,id_caja) VALUES (?,?,?,?)";
            $data = array( $this->usuario,$this->nombre, $this->clave,$this->id_caja);
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
    //editar usuario
    public function editarUsuario(int $id){

        $sql = "SELECT * FROM usuarios WHERE id = $id";
        $data = $this->select($sql);
        return $data;

    }
    //update usuario
    public function updateUsuario(string $usuario, string $nombre, int $id_caja, int $id){
        $this->usuario = $usuario;
        $this->nombre =$nombre;
        $this->id = $id;
        $this->id_caja = $id_caja;
    
        $sql ="UPDATE usuarios SET usuario = ?, nombre = ?, id_caja = ? WHERE id = ? ";
        $data = array( $this->usuario,$this->nombre ,$this->id_caja, $this->id);
        $datos = $this->save($sql, $data);

            if($datos == 1){
                $result = 'modificado';
            }else{
                $result = 'error';
            }
       
        return $result;
    }
     //eliminar usuario
     public function eliminarUsuario(int $id){

        $sql = "DELETE * FROM usuarios WHERE id = $id";
        $data = $this->select($sql);
        $datos = $this->delete($sql, $data);
        if(!empty($data)){
            $result = "eliminado";
        }else{
            $result = "error";
        }
        return $result;

    }
    
}

?>