<?php
require_once("config.php");
class usuario
{
    public $id_usuario;
    public $nom_usuario;
    public $ape_usuario;
    public $ced_usuario;
    public $correo_usuario;
    public $dire_usuario;
    public $cel_usuario;
    public $ocupa_usuario;
    public $usu_usuario;
    public $clave_usuario;

    public function __construct()
        {
            $this->id_usuario = "";
            $this->nom_usuario = "";
            $this->ape_usuario = "";
            $this->ced_usuario = "";
            $this->correo_usuario = "";
            $this->dire_usuario = "";
            $this->cel_usuario = "";
            $this->ocupa_usuario = "";
            $this->usu_usuario = "";
            $this->clave_usuario = "";
        }

        public function ConsultarDato($id_usuario) {
            $conex = new DBConexion();
            $conex = $conex->Conectar();
            $sentencia = sprintf(
                "SELECT * FROM usuarios WHERE id_usuario = '%s' AND rol_id_re = 2",
                $conex->real_escape_string($id_usuario)
            );
            
            $result = mysqli_query($conex, $sentencia);
            
            if (!$result) {
                printf("Error: %s\n", mysqli_error($conex));
                return false;
            }
            
            $row = mysqli_fetch_array($result);
            return $row;
        }

        public function ConsultarDatoNotario($id_usuario) {
            $conex = new DBConexion();
            $conex = $conex->Conectar();
            $sentencia = sprintf(
                "SELECT * FROM usuarios WHERE id_usuario = '%s' AND rol_id_re = 3",
                $conex->real_escape_string($id_usuario)
            );
            
            $result = mysqli_query($conex, $sentencia);
            
            if (!$result) {
                printf("Error: %s\n", mysqli_error($conex));
                return false;
            }
            
            $row = mysqli_fetch_array($result);
            return $row;
        }
        
        public function vcedulausu($ced_usuario) {
            $conex = new DBConexion();
            $conex = $conex->Conectar();
            $sentencia = sprintf("SELECT ced_usuario FROM usuarios WHERE ced_usuario='%s'", $conex->real_escape_string($ced_usuario));
            $result = mysqli_query($conex, $sentencia);
            $row = mysqli_fetch_array($result);
            return $row; 
        }

        public function actualizarCredenciales($usu_usuario, $clave_usuario, $id_usuario) {
            $conex = new DBConexion();
            $conex = $conex->Conectar();
            $sentencia = sprintf("UPDATE usuarios SET usu_usuario='%s', clave_usuario='%s' WHERE id_usuario='%s' AND rol_id_re = 2",
                $conex->real_escape_string($usu_usuario),
                $conex->real_escape_string($clave_usuario),
                $conex->real_escape_string($id_usuario));
            $result = mysqli_query($conex, $sentencia);
            return $result;
        }
        
    public function insertarjurado($nom_usuario, $ape_usuario, $ced_usuario, $correo_usuario, $dire_usuario, $cel_usuario, $ocupa_usuario, $usu_usuario, $clave_usuario, $rol_id_re)
    {
        $conex = new DBConexion();
        $conex = $conex->Conectar();
        $sentencia=sprintf("INSERT INTO usuarios (nom_usuario, ape_usuario, ced_usuario, correo_usuario, dire_usuario, cel_usuario, ocupa_usuario, usu_usuario, clave_usuario, rol_id_re) values ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')"
        ,$conex->real_escape_string($nom_usuario),
        $conex->real_escape_string($ape_usuario),
        $conex->real_escape_string($ced_usuario),
        $conex->real_escape_string($correo_usuario),
        $conex->real_escape_string($dire_usuario),
        $conex->real_escape_string($cel_usuario),
        $conex->real_escape_string($ocupa_usuario),
        $conex->real_escape_string($usu_usuario),
        $conex->real_escape_string($clave_usuario),
        $conex->real_escape_string($rol_id_re));
    
        $result=mysqli_query($conex, $sentencia);
        return $result;
    }




    public function insertarnotario($nom_usuario, $ape_usuario, $ced_usuario, $correo_usuario, $dire_usuario, $cel_usuario, $ocupa_usuario, $usu_usuario, $clave_usuario, $rol_id_re)
    {
        $conex = new DBConexion();
        $conex = $conex->Conectar();
        $sentencia=sprintf("INSERT INTO usuarios (nom_usuario, ape_usuario, ced_usuario, correo_usuario, dire_usuario, cel_usuario, ocupa_usuario, usu_usuario, clave_usuario, rol_id_re) values ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')"
        ,$conex->real_escape_string($nom_usuario),
        $conex->real_escape_string($ape_usuario),
        $conex->real_escape_string($ced_usuario),
        $conex->real_escape_string($correo_usuario),
        $conex->real_escape_string($dire_usuario),
        $conex->real_escape_string($cel_usuario),
        $conex->real_escape_string($ocupa_usuario),
        $conex->real_escape_string($usu_usuario),
        $conex->real_escape_string($clave_usuario),
        $conex->real_escape_string($rol_id_re));
    
        $result=mysqli_query($conex, $sentencia);
        return $result;
    }
    public function buscar_jurados($apellido)
    {
        $conex = new DBConexion();
        $conex = $conex->Conectar();
        if($apellido == '')
        {
            $sentencia = sprintf("SELECT * FROM usuarios WHERE rol_id_re = 2");
        }
        else
        {
            $sentencia = sprintf("SELECT * FROM usuarios WHERE rol_id_re = 2 AND ape_usuario LIKE '%s'", "%".$apellido."%");
        }
        $result = mysqli_query($conex, $sentencia);
        return $result;
    }

    public function eliminarjurado($id_usuario) 
    {
        $conex = new DBConexion();
        $conex = $conex->Conectar();
        $sentencia=sprintf("DELETE FROM usuarios WHERE id_usuario='%s'", $conex->real_escape_string($id_usuario)); //NUNCA OLVIDARSE DEL WHERE NI EN EL EDITAR NI ELIMINAR
        $result=mysqli_query($conex, $sentencia);
        return $result;
    }


    public function eliminarnotario($id_usuario) 
    {
        $conex = new DBConexion();
        $conex = $conex->Conectar();
        $sentencia=sprintf("DELETE FROM usuarios WHERE id_usuario='%s'", $conex->real_escape_string($id_usuario)); 
        $result=mysqli_query($conex, $sentencia);
        return $result;
    }


    //////////// EDITAR JURADO
    public function actualizarjurado($nom_usuario,$ape_usuario,$ced_usuario,$correo_usuario,$dire_usuario,$cel_usuario,$ocupa_usuario, $usu_usuario,$clave_usuario,$id_usuario ) 
    {
        $conex = new DBConexion();
        $conex = $conex->Conectar();
        $sentencia=sprintf("UPDATE usuarios SET nom_usuario='%s', ape_usuario='%s', ced_usuario='%s', correo_usuario='%s', dire_usuario='%s', cel_usuario='%s', ocupa_usuario='%s', usu_usuario='%s', clave_usuario='%s' WHERE id_usuario='%s'" 
        ,$conex->real_escape_string($nom_usuario), 
        $conex->real_escape_string($ape_usuario), 
        $conex->real_escape_string($ced_usuario), 
        $conex->real_escape_string($correo_usuario), 
        $conex->real_escape_string($dire_usuario), 
        $conex->real_escape_string($cel_usuario), 
        $conex->real_escape_string($ocupa_usuario), 
        $conex->real_escape_string($usu_usuario), 
        $conex->real_escape_string($clave_usuario), 
        $conex->real_escape_string($id_usuario)); 
        $result=mysqli_query($conex, $sentencia);
        return $result;
    }


        //////////// EDITAR Notario
        public function actualizarnotario($nom_usuario,$ape_usuario,$ced_usuario,$correo_usuario,$dire_usuario,$cel_usuario,$ocupa_usuario, $usu_usuario,$clave_usuario,$id_usuario ) 
        {
            $conex = new DBConexion();
            $conex = $conex->Conectar();
            $sentencia=sprintf("UPDATE usuarios SET nom_usuario='%s', ape_usuario='%s', ced_usuario='%s', correo_usuario='%s', dire_usuario='%s', cel_usuario='%s', ocupa_usuario='%s', usu_usuario='%s', clave_usuario='%s' WHERE id_usuario='%s'" 
            ,$conex->real_escape_string($nom_usuario), 
            $conex->real_escape_string($ape_usuario), 
            $conex->real_escape_string($ced_usuario), 
            $conex->real_escape_string($correo_usuario), 
            $conex->real_escape_string($dire_usuario), 
            $conex->real_escape_string($cel_usuario), 
            $conex->real_escape_string($ocupa_usuario), 
            $conex->real_escape_string($usu_usuario), 
            $conex->real_escape_string($clave_usuario), 
            $conex->real_escape_string($id_usuario)); 
            $result=mysqli_query($conex, $sentencia);
            return $result;
        }

 
    public function buscar_notarios($apellido)
    {
        $conex = new DBConexion();
        $conex = $conex->Conectar();
        if($apellido == '')
        {
            $sentencia = sprintf("SELECT * FROM usuarios WHERE rol_id_re = 3");
        }
        else
        {
            $sentencia = sprintf("SELECT * FROM usuarios WHERE rol_id_re = 3 AND ape_usuario LIKE '%s'", "%".$apellido."%");
        }
        $result = mysqli_query($conex, $sentencia);
        return $result;
    }

}



    class candidatas
    {
        public $id_candidata;
        public $nom_candidata;
        public $ape_candidata;
        public $ced_candidata;
        public $correo_candidata;
        public $cel_candidata;
        public $dir_candidata;
        public $repre_candidata;
        public $img_candidata;
    
        public function __construct()
        {
            $this->id_candidata = "";
            $this->nom_candidata = "";
            $this->ape_candidata = "";
            $this->ced_candidata = "";
            $this->correo_candidata = "";
            $this->cel_candidata = "";
            $this->dir_candidata = "";
            $this->repre_candidata = "";
            $this->img_candidata = "";
        }
    
        public function insertarcandidata($nom_candidata, $ape_candidata, $ced_candidata, $correo_candidata, $cel_candidata, $dir_candidata, $repre_candidata, $img_candidata)
        {
            $conex = new DBConexion();
            $conex = $conex->Conectar();
            $sentencia = sprintf(
                "INSERT INTO candidata (nom_candidata, ape_candidata, ced_candidata, correo_candidata, cel_candidata, dir_candidata, repre_candidata, img_candidata) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
                $conex->real_escape_string($nom_candidata),
                $conex->real_escape_string($ape_candidata),
                $conex->real_escape_string($ced_candidata),
                $conex->real_escape_string($correo_candidata),
                $conex->real_escape_string($cel_candidata),
                $conex->real_escape_string($dir_candidata),
                $conex->real_escape_string($repre_candidata),
                $conex->real_escape_string($img_candidata)
            );
        
            $result = mysqli_query($conex, $sentencia);
            return $result;
        }
        
        public function vcedula($ced_candidata) {
            $conex = new DBConexion();
            $conex = $conex->Conectar();
            $sentencia = sprintf("SELECT ced_candidata FROM candidata WHERE ced_candidata='%s'", $conex->real_escape_string($ced_candidata));
            $result = mysqli_query($conex, $sentencia);
            $row = mysqli_fetch_array($result);
            return $row; 
        }
        
        
        public function buscar_candidatas($apellido)
        {
            $conex = new DBConexion();
            $conex = $conex->Conectar();
            if ($apellido == '') {
                $sentencia = "SELECT * FROM candidata";
            } else {
                $sentencia = sprintf("SELECT * FROM candidata WHERE ape_candidata LIKE '%s'", "%" . $apellido . "%");
            }
            $result = mysqli_query($conex, $sentencia);
            return $result;
        }
        

        public function ConsultarDato($id_candidata)
        {
            $conex = new DBConexion();
            $conex = $conex -> Conectar();
            $sentencia = sprintf ("select * FROM candidata WHERE id_candidata = '%s'",$conex->real_escape_string($id_candidata));
            $result = mysqli_query($conex, $sentencia);
            $row = mysqli_fetch_array($result);
            return $row;
        }



        
        public function actualizarcandidata($id_candidata, $nom_candidata, $ape_candidata, $ced_candidata, $correo_candidata, $cel_candidata, $dir_candidata, $repre_candidata, $img_candidata)
        {
            $conex = new DBConexion();
            $conex = $conex->Conectar();
            $sentencia = sprintf("UPDATE candidata SET nom_candidata='%s', ape_candidata='%s', ced_candidata='%s', correo_candidata='%s', cel_candidata='%s', dir_candidata='%s', repre_candidata='%s', img_candidata='%s' WHERE id_candidata=%d",
                $conex->real_escape_string($nom_candidata),
                $conex->real_escape_string($ape_candidata),
                $conex->real_escape_string($ced_candidata),
                $conex->real_escape_string($correo_candidata),
                $conex->real_escape_string($cel_candidata),
                $conex->real_escape_string($dir_candidata),
                $conex->real_escape_string($repre_candidata),
                $conex->real_escape_string($img_candidata),
                $id_candidata
            );
        
            $result = mysqli_query($conex, $sentencia);
            return $result;
        }
        
            public function buscar_candidata_por_id($id_candidata)
        {
            $conex = new DBConexion();
            $conex = $conex->Conectar();
            $sentencia = sprintf("SELECT * FROM candidata WHERE id_candidata = %d", $id_candidata);
            $result = mysqli_query($conex, $sentencia);
            if ($result) {
                return mysqli_fetch_assoc($result);
            } else {
                return null;
            }
        }
        
        public function eliminar($id_candidata) 
            {
                $conex = new DBConexion();
                $conex = $conex->Conectar();
                $sentencia=sprintf("DELETE FROM candidata WHERE id_candidata='%s'", $conex->real_escape_string($id_candidata)); 
                $result=mysqli_query($conex, $sentencia);
                return $result;
            }
    }

    class roles
{
    public $id_rol;
    public $nom_rol;
    public $descri_rol;

    public function __construct()
    {
        $this->id_rol = "";
        $this->nom_rol = "";
        $this->descri_rol = "";
    }
    }

    
    
    
    class calificacion
    {
        public $id_calificacion;
        public $id_candidata_re;
        public $id_parametro_re;
        public $id_usuario_re;
        public $calificacion;

    
        public function __construct()
        {
            $this->id_calificacion = "";
            $this->id_candidata_re = "";
            $this->id_parametro_re = "";
            $this->id_usuario_re = "";
            $this->calificacion = "";

        }

        public function obtener_calificaciones_completas($id_candidata) {
            $conex = new DBConexion();
            $conex = $conex->Conectar();
            $sentencia = sprintf(
                "SELECT id_parametro_re FROM calificacion 
                WHERE id_candidata_re = '%s' AND id_parametro_re NOT IN (
                    SELECT id_parametros FROM parametros WHERE nom_parametro LIKE '%%Pregunta extra%%'
                )",
                $conex->real_escape_string($id_candidata)
            );
            $result = mysqli_query($conex, $sentencia);
        
            // Verificar si el número de parámetros calificados es igual al número total de parámetros, excluyendo la pregunta extra
            $totalParametros = mysqli_num_rows(mysqli_query($conex, "SELECT id_parametros FROM parametros WHERE nom_parametro NOT LIKE '%%Pregunta extra%%'"));
            return (mysqli_num_rows($result) == $totalParametros);
        }
        

        public function obtener_calificaciones($id_usuario, $id_candidata) {
            $conex = new DBConexion();
            $conex = $conex->Conectar();
            $sentencia = sprintf("SELECT * FROM calificacion WHERE id_usuario_re = '%s' AND id_candidata_re = '%s'", $conex->real_escape_string($id_usuario), $conex->real_escape_string($id_candidata));
            $result = mysqli_query($conex, $sentencia);
            return $result;
        }

        
        public function obtener_todas_calificaciones() {
            $conex = new DBConexion();
            $conex = $conex->Conectar();
            $sentencia = "
                SELECT 
                    c.id_candidata, 
                    c.nom_candidata, 
                    c.ape_candidata, 
                    u.nom_usuario, 
                    u.ape_usuario, 
                    cat.nom_categoria, 
                    p.nom_parametro, 
                    cal.calificacion
                FROM 
                    calificacion cal
                JOIN 
                    candidata c ON cal.id_candidata_re = c.id_candidata
                JOIN 
                    usuarios u ON cal.id_usuario_re = u.id_usuario
                JOIN 
                    parametros p ON cal.id_parametro_re = p.id_parametros
                JOIN 
                    categoria cat ON p.id_categoria_re = cat.id_categoria
                    WHERE 
                u.rol_id_re = 2
            ";
            $result = mysqli_query($conex, $sentencia);
            return $result;
        }
        
        }


    class categoria
        {
            public $id_categoria;
            public $nom_categoria;

            public function __construct()
            {
                $this->id_categoria = "";
                $this->nom_categoria = "";
            }
        }


        class configuraciones
        {
            public $id;
            public $nombre;
            public $valor;


            public function __construct()
            {
                $this->id = "";
                $this->nombre = "";
                $this->valor = "";
            }

            public function obtenerConfiguracion($nombre) {
                $conex = new DBConexion();
                $conex = $conex->Conectar();
                $sentencia = sprintf("SELECT valor FROM configuraciones WHERE nombre='%s'", $conex->real_escape_string($nombre));
                $result = mysqli_query($conex, $sentencia);
                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    return $row['valor'];
                } else {
                    return null;
                }
            }
            
            public function actualizarConfiguracion($nombre, $valor) {
                $conex = new DBConexion();
                $conex = $conex->Conectar();
                $sentencia = sprintf("UPDATE configuraciones SET valor='%s' WHERE nombre='%s'", 
                    $conex->real_escape_string($valor), 
                    $conex->real_escape_string($nombre));
                $result = mysqli_query($conex, $sentencia);
                return $result;
            }
            
        }
        

    class parametros
    {
        public $id_parametros;
        public $nom_parametro;
        public $id_categoria_re;

        public function __construct()
        {
            $this->id_parametros = "";
            $this->nom_parametro = "";
            $this->id_categoria_re = "";

        }

        public function buscar_parametros($parametros) {
            $conex = new DBConexion();
            $conex = $conex->Conectar();
            if ($parametros == '') {
                $sentencia = "SELECT id_parametros, nom_parametro, id_categoria_re FROM parametros";
            } else {
                $sentencia = sprintf("SELECT id_parametros, nom_parametro, id_categoria_re FROM parametros WHERE nom_parametro LIKE '%s'", "%" . $parametros . "%");
            }
            $result = mysqli_query($conex, $sentencia);
            return $result;
        }
        
        


}        



?>


