<?php 

class ClientesModel extends Query{

    private $dni, $nombre, $telefono, $direccion, $id, $estado;
    public function __construct()
    {
        parent::__construct();
    }
   // validar cliente
    public function getCliente(string $usuario, string $clave){

        $sql = "SELECT * FROM clientes WHERE dni = '$dni'";
        $data = $this->select($sql);
        return $data;
    }
    //listar cliente
    public function getClientes(){

        $sql = "SELECT  *  FROM clientes";
        $data = $this->selectAll($sql);
        return $data;
    }
    //registrar cliente
    public function registrarCliente(string $dni, string $nombre, string $telefono, string $direccion){
        $this->dni = $dni;
        $this->nombre =$nombre;
        $this->telefono = $telefono;
        $this->direccion = $direccion;

        $verificar = "SELECT * FROM clientes WHERE dni = '$this->dni'";
        $existe = $this->select($verificar);
        if(empty($existe)){
             $sql ="INSERT INTO clientes (dni,nombre,telefono,direccion) VALUES (?,?,?,?)";
            $data = array( $this->dni,$this->nombre, $this->telefono,$this->direccion);
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
    //editar cliente
    public function editarCliente(int $id){

        $sql = "SELECT * FROM clientes WHERE id = $id";
        $data = $this->select($sql);
        return $data;

    }
    //update cliente
    public function updateCliente(string $dni, string $nombre, string $telefono, string $direccion, int $id){
        $this->dni = $dni;
        $this->nombre =$nombre;
        $this->telefono = $telefono;
        $this->direccion = $direccion;
        $this->id = $id;    
       
        $sql ="UPDATE clientes SET dni = ?, nombre = ?, telefono = ?, direccion = ? WHERE id = ? ";
        $data = array( $this->dni,$this->nombre ,$this->telefono ,$this->direccion, $this->id);
        $datos = $this->save($sql, $data);

            if($datos == 1){
                $result = 'modificado';
            }else{
                $result = 'error';
            }       
        return $result;
    }
     //eliminar cliente
    public function accionCliente(int $estado, int $id){

        $this->id = $id;
        $this->estado = $estado;
        $sql = "UPDATE clientes SET estado = ? WHERE id = ?";
        $datos = array($this->estado, $this->id);
        $data = $this->save($sql, $datos);       
        return $data;

    }
}

?>