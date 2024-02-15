<?php
require_once '../core/DatabaseSingleton.php';
require __DIR__.'/../DTO/VehiculoDTO.php';
class VehiculoDAO{

    private $db;

    public function __construct() {

            $this->db=DatabaseSingleton::getInstance();
    
    }
    public function obtenerVehiculos() {
        $connection = $this->db->getConnection();
        //var_dump($connection);
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
        //print_r($result);
        return $vehiculosDTO;
    }
    public function obtenerVehiculoPorId($id) {
        $connection = $this->db->getConnection();
        if (is_numeric($id)) {
        //var_dump($connection);
        $query = "SELECT v.*, f.capacidad AS capacidad, tu.electrico 
                  AS electrico, td.cuatro_por_cuatro AS cuatro_por_cuatro 
                  FROM vehiculos v LEFT JOIN  furgonetas f ON v.id = f.vehiculo_id 
                  LEFT JOIN turismos tu ON v.id = tu.vehiculo_id LEFT JOIN  
                  todoterrenos td ON v.id = td.vehiculo_id WHERE v.id = '$id'";
        } else {
            $query = "SELECT v.*, f.capacidad AS capacidad, tu.electrico 
            AS electrico, td.cuatro_por_cuatro AS cuatro_por_cuatro 
            FROM vehiculos v LEFT JOIN  furgonetas f ON v.id = f.vehiculo_id 
            LEFT JOIN turismos tu ON v.id = tu.vehiculo_id LEFT JOIN  
            todoterrenos td ON v.id = td.vehiculo_id WHERE v.clase = '$id'";
        }
        $statement = $connection->query($query);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        print_r($result);
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

    public function crearVehiculo($datos) {
        $connection = $this->db->getConnection();
        $connection->beginTransaction();
        $id=$datos['id'];
        $clase = $datos['clase'];
        $vehiculoCrear=new VehiculoDTO($clase, $datos);
        $query = "INSERT INTO vehiculos (marca, modelo, kilometros, year, clase, disponible, prestado, revision, id) 
                    VALUES (?, ?, ?, ?, ?, ?, ? ,?, ?)";
        $statementInsert = $connection->prepare($query);
        $query="SELECT * from vehiculos order by id desc Limit 1";
        $statement = $connection->query($query);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $vehiculoDatos = $vehiculoCrear->getVehiculo();
        if ($id == $result[0]['id'] + 1) {
            $statementInsert->execute([$vehiculoDatos->getMarca(), $vehiculoDatos->getModelo(), $vehiculoDatos->getKilometros(), 
            $vehiculoDatos->getYear(), $vehiculoDatos->getClase(),$vehiculoDatos->getDisponible(), $vehiculoDatos->getPrestado(), 
            $vehiculoDatos->getRevision(), $vehiculoDatos->getPropiedad_id()]); 
            if ($clase == 'furgoneta') {
                $query = "INSERT INTO furgonetas (vehiculo_id, capacidad) VALUES (?,?)";
                $caract=[$id,$datos['electrico']];
            } else if ($clase == 'todoterreno') {
                $query = "INSERT INTO todoterrenos (vehiculo_id, cuatro_por_cuatro) VALUES (?,?)";
                $caract=[$id,$datos['cuatro_por_cuatro']];
            } else if ($clase == 'turismo') {
                $query = "INSERT INTO turismos (vehiculo_id, electrico) VALUES (?,?)";
                $caract=[$id,$datos['electrico']];
            } 
            $statementInsert1 = $connection->prepare($query);
            $statementInsert1->execute($caract);   
        } else {
            echo "id incorrecto pruebe con " . $result[0]['id'] + 1;
        }
        $connection->commit();
 
    }
  
            /*$query = "INSERT INTO vehiculos (marca, modelo, kilometros, year, clase, disponible, prestado, revision, id) 
                    VALUES (?, ?, ?, ?, ?, ?, ? ,?, ?, ?)";
            
            $statementInsert = $connection->prepare($query);
            $query="SELECT * from vehiculos order by id desc Limit 1";
            $statement = $connection->query($query);
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            
                if ($id == $result[0]['id'] + 1) {
                    $statementInsert->execute([$datos['marca'], $datos['modelo'], $datos['kilometros'], 
                    $datos['year'], $datos['clase'],$datos['disponible'], $datos['prestado'], $datos['revision'], $datos['id']]); 
                    if ($clase == 'furgoneta') {
                        $query = "INSERT INTO furgonetas (vehiculo_id, capacidad) VALUES (?,?)";
                        $caract=[$id,$datos['capacidad']];
                    } else if ($clase == 'todoterreno') {
                        $query = "INSERT INTO todoterrenos (vehiculo_id, cuatro_por_cuatro) VALUES (?,?)";
                        $caract=[$id,$datos['cuatro_por_cuatro']];
                    } else if ($clase == 'turismo') {
                        $query = "INSERT INTO turismos (vehiculo_id, electrico) VALUES (?,?)";
                        $caract=[$id,$datos['electrico']];
                    } 
                    $statementInsert1 = $connection->prepare($query);
                    $statementInsert1->execute($caract);   
                } else {
                    echo "id incorrecto pruebe con " . $result[0]['id'] + 1;
                }
                $connection->commit();
        } else {
            echo "No introduzca los datos de usuario y fechas";
        }
    }*/
    public function modificarVehiculo($id,$datos) {
        $connection = $this->db->getConnection();
        // Construir la parte SET de la consulta dinámicamente
        $modificacion = "";
        foreach ($datos as $dato => $valor) {
            $modificacion .= "$dato = :$dato, ";
        }
        // Eliminar la coma y el espacio extra al final
        $modificacion = rtrim($modificacion, ', ');
    
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
            $statement->bindParam(":$dato", $valor);
        }
        $statement->bindParam(':id', $id);
        $statement->execute();
    }
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