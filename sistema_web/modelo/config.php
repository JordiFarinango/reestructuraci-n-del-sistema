<?php
class DBConexion
{
    public $conexion;
    protected $db;
    private $host;
    private $usuario;
    private $clave;
    private $base;
    
    public function __construct()
    {
        $this-> conexion="";
        $this-> db="sistema_web_3";
        $this-> host="localhost";
        $this-> usuario="root";
        $this-> clave="";
    }
    public function Conectar()
    {
        $this->conexion = mysqli_connect($this->host, $this->usuario, $this->clave, $this->db);
        if($this->conexion === false) {
            die("Error con la conexión de mysql: " . mysqli_connect_error());
        }
        return $this->conexion;
    }

}
?>
