<?php 
/*
    Autor:Jesus Diego Rivero
    Fecha: 15/02/2024
    Modulo: DWES
    UD: 04
    Clase controladora de la API
*/  
//require_once __DIR__.'/../model/BbddManage.php';
require_once __DIR__.'/../model/DAO/VehiculoDAO.php';
require_once __DIR__ .'/../utilities/httpCode/ClientErrorCod.php';
require_once __DIR__ .'/../utilities/httpCode/SuccessCod.php';
//clase que controla las acciones de la API
class Vehiculocontroller {

    private $bbddObject;

    function __construct()
    // objeto de la clase BbddManage como atributo
    {
        $this->bbddObject = new VehiculoDAO();
    }
    // metodo para obtener todos los vehiculos de la BBDD
    public function getAllVehiculos() {
        //datos son obejtos VehiculoDAO que están formados por objetos de
        //las clases FurgonetaEntity, TodoterrenoEnttity y TurismoEntity
        $datos = $this->bbddObject->obtenerVehiculos();
   
        //Como son todos objetos con propiedades protegidas o privadas 
        //hay que transformarlos en array para poder convertirlo en json
        $arrayDatos=[];
        foreach($datos as $dato ){
            $arrayDatos[]=($dato->getVehiculo()->toArray());
        }
        $datosJson=json_encode($arrayDatos, JSON_PRETTY_PRINT);
        echo $datosJson;
        SuccessCod::ok(['result' => 'registros recuperados con éxito']);
        return $datosJson;
    }

    // metodo para obtener un  vehiculo de la BBDD
    public function getVehiculoByParam($param) {
        $elementoBuscado = $this->bbddObject->obtenerVehiculoPorParam($param);
        if ($param == 'alquilado'){
            $datosJson = json_encode($elementoBuscado);
            echo $datosJson;
            SuccessCod::ok(['result' => 'vehiculos prestados recuperado con éxito']);
            return $datosJson;
        } else {
        $arrayDatos=[];
        foreach($elementoBuscado as $dato ){
            $arrayDatos[]=($dato->getVehiculo()->toArray());
        }
        $datosJson=json_encode($arrayDatos, JSON_PRETTY_PRINT);
        
        echo $datosJson;
        SuccessCod::ok(['result' => 'registros recuperados con éxito']);
        return $datosJson;
    }
    }
    
    // metodo para crear vehiculos e introducirlos en la BBDD
    public function createVehiculo($data) {
        $this->bbddObject->crearVehiculo($data);
        SuccessCod::created(['result' => 'registro creado con éxito']);
    }
    
    // metodo para actualizar los atributos de los vehiculos
    public function updateVehiculo($id, $data) {
        $this->bbddObject->modificarVehiculo($id, $data);
        SuccessCod::ok(['result' => 'registro actualizado con exito']);

    }
    // metodo para borrar  los vehiculos de la BBDD por id
    public function deleteVehiculo($id) {
        $this->bbddObject->eliminarVehiculo($id);
        SuccessCod::ok(['result' => 'registro eliminado con exito']);
    }

}
