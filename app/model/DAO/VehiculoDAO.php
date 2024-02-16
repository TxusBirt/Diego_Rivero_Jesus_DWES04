<?php
/*
    Autor:Jesus Diego Rivero
    Fecha: 15/02/2024
    Modulo: DWES
    UD: 04
    Clase VehiculoDAO 
    Es una clase que maneja los datos de la BBDD (CRUD)
*/ 
require_once '../core/DatabaseSingleton.php';
require __DIR__.'/../DTO/VehiculoDTO.php';
require __DIR__.'/../DTO/VehiculoCrearDTO.php';
require __DIR__.'/../DTO/PrestadoDTO.php';
class VehiculoDAO{
    // Establezco una propiedad privada
    private $db;

    public function __construct() {
        // asigno a la propiedad un objeto PDO para conectar con la BBDD
        $this->db=DatabaseSingleton::getInstance();
    
    }
    // función que obtiene todos los vehículos
    public function obtenerVehiculos() {
        $connection = $this->db->getConnection();
        // consulta que me une las 4 tablas relacionadas con vehículos
        $query = "SELECT v.*, f.capacidad AS capacidad, tu.electrico 
                  AS electrico, td.cuatro_por_cuatro AS cuatro_por_cuatro 
                  FROM vehiculos v LEFT JOIN  furgonetas f ON v.id = f.vehiculo_id 
                  LEFT JOIN turismos tu ON v.id = tu.vehiculo_id LEFT JOIN  
                  todoterrenos td ON v.id = td.vehiculo_id";
        $statement = $connection->query($query);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $vehiculosDTO =  array();
        for ($i=0;$i<count($result);$i++) {
            if ($result[$i]['clase']=='furgoneta'){
                $vehiculo= new VehiculoDTO($result[$i]['clase'],$result[$i]);
                $vehiculosDTO[]=$vehiculo;  
            } else if($result[$i]['clase']=='turismo'){
                $vehiculo= new VehiculoDTO($result[$i]['clase'],$result[$i]);
                $vehiculosDTO[]=$vehiculo;
            }else if($result[$i]['clase']=='todoterreno'){
                $vehiculo= new VehiculoDTO($result[$i]['clase'],$result[$i]);
                $vehiculosDTO[]=$vehiculo;
            }     
        }
        return $vehiculosDTO;
    }
    // funcion que según le parametro que le pasemos nos devuelve difernetes resultados
    public function obtenerVehiculoPorParam($param) {
        $connection = $this->db->getConnection();
        // si pasamos el parametro "prestado" en la url nos devuelve todos
        // los vehiculos prestados y las personas que los han reservado
        if ($param=='prestado') {
            $query = "SELECT v.marca, v.modelo, v.clase, v.prestado, v.fecha_inicio, v.fecha_fin, 
            u.nombre, u.departamento, f.capacidad, td.cuatro_por_cuatro, tu.electrico 
            FROM vehiculos v LEFT JOIN  furgonetas f ON v.id = f.vehiculo_id 
            LEFT JOIN turismos tu ON v.id = tu.vehiculo_id LEFT JOIN  
            todoterrenos td ON v.id = td.vehiculo_id INNER JOIN usuarios u 
            on v.usuario_id = u.usuario_id WHERE v.prestado = 'si'";
            $statement = $connection->query($query);
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            $vehiculosPrestados = [];
            for ($i=0;$i<count($result);$i++) {
                if ($result[$i]['clase']=='furgoneta'){
                    $prestadoDTO= new PrestadoDTO($result[$i]['clase'], $result[$i]);
                    $vehiculosPrestados[] = $prestadoDTO;  
                } else if($result[$i]['clase']=='turismo'){
                    $prestadoDTO= new PrestadoDTO($result[$i]['clase'], $result[$i]);
                    $vehiculosPrestados[] = $prestadoDTO;  
                }else if($result[$i]['clase']=='todoterreno'){
                    $prestadoDTO= new PrestadoDTO($result[$i]['clase'], $result[$i]);
                    $vehiculosPrestados[] = $prestadoDTO;          
                }  
            }
            return $vehiculosPrestados;
        // si le pasamos otros parametro valido entramos en esta opcion
        } else {
            // establece que el parametro es numerico para devolvernos el vehículo con el 
            // id que coincida con el parametro
            if (is_numeric($param)) {
                $query = "SELECT v.*, f.capacidad AS capacidad, tu.electrico 
                        AS electrico, td.cuatro_por_cuatro AS cuatro_por_cuatro 
                        FROM vehiculos v LEFT JOIN  furgonetas f ON v.id = f.vehiculo_id 
                        LEFT JOIN turismos tu ON v.id = tu.vehiculo_id LEFT JOIN  
                        todoterrenos td ON v.id = td.vehiculo_id WHERE v.id = '$param'";
            } // si le pasamos el nombre de una de las clases (furgoneta, todoterreno o turismo)
              // nos devuelve los vehiculos de esa clase que hay en la BBDD 
              else {
                $query = "SELECT v.*, f.capacidad AS capacidad, tu.electrico 
                    AS electrico, td.cuatro_por_cuatro AS cuatro_por_cuatro 
                    FROM vehiculos v LEFT JOIN  furgonetas f ON v.id = f.vehiculo_id 
                    LEFT JOIN turismos tu ON v.id = tu.vehiculo_id LEFT JOIN  
                    todoterrenos td ON v.id = td.vehiculo_id WHERE v.clase = '$param'";
            }
            $statement = $connection->query($query);
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            $vehiculosTipoDTO = [];
            for ($i=0;$i<count($result);$i++) {
                if ($result[$i]['clase']=='furgoneta'){
                    $vehiculoDTO= new VehiculoDTO($result[$i]['clase'], $result[$i]);
                    $vehiculosTipoDTO[] = $vehiculoDTO;  
                } else if($result[$i]['clase']=='turismo'){
                    $vehiculoDTO= new VehiculoDTO($result[$i]['clase'],$result[$i]);
                    $vehiculosTipoDTO[] = $vehiculoDTO;  
                }else if($result[$i]['clase']=='todoterreno'){
                    $vehiculoDTO= new VehiculoDTO($result[$i]['clase'],$result[$i]);
                    $vehiculosTipoDTO[] = $vehiculoDTO;        
                }  
            }
            return $vehiculosTipoDTO;
        }
    }
    // funcion para cerar vehículos
    public function crearVehiculo($datos) {
        $connection = $this->db->getConnection();
        $connection->beginTransaction();
        $id=$datos['id'];
        $clase = $datos['clase'];
        // creo el objeto DTO correpondiente para encapsular los datos
        $vehiculoCrearDTO=new VehiculoCrearDTO($clase, $datos);
        // establezco la sentencia insert 
        $query = "INSERT INTO vehiculos (marca, modelo, kilometros, year, clase, disponible, prestado, revision, id) 
        VALUES (?, ?, ?, ?, ?, ?, ? ,?, ?)";
        $statementInsert = $connection->prepare($query);
        // necesito saber el ultimo id para que el nuevo registro tenga un id consecutivo y no repetido
        $query="SELECT * from vehiculos order by id desc Limit 1";
        $statement = $connection->query($query);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        // condicion de forma que si el id no es el que sigue al ultimo me da un error
        if ($id == $result[0]['id'] + 1) {
            // ejecuto el insert con los valores que había encapsulado
            $statementInsert->execute([$vehiculoCrearDTO->getMarca(), $vehiculoCrearDTO->getModelo(), $vehiculoCrearDTO->getKilometros(), 
            $vehiculoCrearDTO->getYear(), $vehiculoCrearDTO->getClase(),$vehiculoCrearDTO->getDisponible(), $vehiculoCrearDTO->getPrestado(), 
            $vehiculoCrearDTO->getRevision(), $vehiculoCrearDTO->getId()]); 
            if ($clase == 'furgoneta') {
                $query = "INSERT INTO furgonetas (vehiculo_id, capacidad) VALUES (?,?)";
                $caract=[$id,$vehiculoCrearDTO->getCapacidad()];
            } else if ($clase == 'todoterreno') {
                $query = "INSERT INTO todoterrenos (vehiculo_id, cuatro_por_cuatro) VALUES (?,?)";
                $caract=[$id,$vehiculoCrearDTO->getCuatro_por_cuatro()];
            } else if ($clase == 'turismo') {
                $query = "INSERT INTO turismos (vehiculo_id, electrico) VALUES (?,?)";
                $caract=[$id,$vehiculoCrearDTO->getElectrico()];
            } 
            $statementInsert1 = $connection->prepare($query);
            $statementInsert1->execute($caract); 
            
        } else {
            echo "id incorrecto pruebe con " . $result[0]['id'] + 1;
        }
        $connection->commit();
            
 
    }
  
    // funcion que me eprmite modificar valores de propiedades
    public function modificarVehiculo($id,$datos) {
        $connection = $this->db->getConnection();
        // Construir la parte SET de la consulta dinámicamente
        $modificacion = "";
        foreach ($datos as $dato => $valor) {
            $modificacion .= "$dato = :$dato, ";
        }
        // Eliminar la coma y el espacio extra al final
        $modificacion = rtrim($modificacion, ', ');
        echo $modificacion;
        // Construyo la consulta de actualización
        $query = "UPDATE vehiculos v 
                  LEFT JOIN furgonetas f ON v.id = f.vehiculo_id 
                  LEFT JOIN turismos tu ON v.id = tu.vehiculo_id 
                  LEFT JOIN todoterrenos td ON v.id = td.vehiculo_id 
                  SET $modificacion 
                  WHERE v.id = :id";
    
        $statement = $connection->prepare($query);
    
        // Vinculo los parámetros
        foreach ($datos as $dato => $valor) {
            $statement->bindParam(":$dato", $datos[$dato]);
        }
        $statement->bindParam(':id', $id);
        $statement->execute();
    }
    //funcion para eliminar registros de la BBDD
    public function eliminarVehiculo($id) {
        $connection = $this->db->getConnection();
        $query = "DELETE f, tu, td  FROM vehiculos v 
        LEFT JOIN furgonetas f ON v.id = f.vehiculo_id 
        LEFT JOIN turismos tu ON v.id = tu.vehiculo_id 
        LEFT JOIN todoterrenos td ON v.id = td.vehiculo_id 
        WHERE v.id = :id;
        DELETE  v FROM vehiculos v 
        WHERE v.id = :id";
        $statement = $connection->prepare($query);
        $statement->bindParam(':id', $id);
        $statement->execute();
    }
}
?>