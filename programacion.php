<?PHP

use LDAP\Result;

class Conexion
{
    private $servidor="localhost";
    private $user="root";
    private $password="";
    private $db="registro_alumnos";
    private $con;

    public function __construct()
    {
        try 
        {
            $this->con= new PDO("mysql:host=$this->servidor;dbname=$this->db",$this->user,$this->password);
            $this->con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }
         catch (PDOException $e) 
        {
            return "falla de coneccion".$e;
        }
    }

    public function ejecutar($sql){ //delete-update-insert
        $this->con->exec($sql);
        return $this->con->lastInsertId();
    }

    public function consultar($sql){
        $sentencia=$this->con->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll();
    }
    public function consultarid($sql){
        $sentencia=$this->con->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_LAZY);
    }

    public function consultarcount(){
        $sql="SELECT * FROM t_estudiantes where status=1";
        $sentencia=$this->con->prepare($sql);
        $sentencia->execute();
        $sentencia->fetchAll();
        $result=$sentencia->rowCount();
        return $result;
    }

    public function paginacion($n1,$n2){
        $sql="SELECT * FROM t_estudiantes where status=1 limit $n1,$n2 ";
        $sentencia=$this->con->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll();
    }

     public function consultarprueba(){
        
        $sql="SELECT * FROM t_estudiantes";
        $sentencia=$this->con->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll();
     }
     public function consultarcarreras(){
        $sql="SELECT * FROM c_carrera where activo=1";
        $sentencia=$this->con->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll();
     }

     public function buscarmatricula($matricula){
        $sql="SELECT * FROM t_estudiantes where matricula LIKE '%$matricula%' ";
        $sentencia=$this->con->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll();
     }
}

?>