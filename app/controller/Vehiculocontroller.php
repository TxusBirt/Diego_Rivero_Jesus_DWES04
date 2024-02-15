<?php 
/*
    Autor:Jesus Diego Rivero
    Fecha: 21/12/2023
    Modulo: DWES
    UD: 03
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
        //$datosJson = json_encode($datos);
        
        SuccessCod::ok(['result' => 'registros recuperados con éxito']);
        //Como son todos objetos con propiedades protegidas o privadas 
        //hay que transformarlos en array para poder convertirlo en json
        $arrayDatos=[];
        foreach($datos as $dato ){
            $arrayDatos[]=($dato->getVehiculo()->toArray());
        }
        $datosJson=json_encode($arrayDatos, JSON_PRETTY_PRINT);
        echo $datosJson;
    
        return $datosJson;
    }

    // metodo para obtener un  vehiculo de la BBDD
    public function getVehiculoById($id) {
        $elementoBuscado = $this->bbddObject->obtenerVehiculoPorId($id);
        $elementoBuscadoArray = $elementoBuscado->getVehiculo()->toArray();
        $elementoBuscadoJson = json_encode($elementoBuscadoArray, JSON_PRETTY_PRINT);
        SuccessCod::ok(['result' => 'registro recuperado con éxito']);
        echo $elementoBuscadoJson;
        return $elementoBuscadoJson;
    }
    
    // metodo para crear vehiculos e introducirlos en la BBDD
    public function createVehiculo($data) {
        $this->bbddObject->crearVehiculo($data);
        //$ultimoId = end($bbddArray)->getPropiedad_id(); 
      /*  if (!isset($data['id'])) {
            $data['id'] = $ultimoId + 1;
            $bbddArray[] = $data;
        } else {
            if ($data['id'] <= $ultimoId || $data['id'] > $ultimoId + 1 ){
                return ClientErrorCod::badRequest(['error' => "imposible establecer ese id pruebe de nuevo con ". (count($bbddArray) + 1).""]);
            } else {
                $bbddArray[]=$data;
            }
        }
        $this->bbddObject->enviarJsonBbdd($bbddArray);*/
        SuccessCod::ok(['result' => 'registro creado con éxito']);
    }
    
    // metodo para actualizar los atributos de los vehiculos
    public function updateVehiculo($id, $data) {
        $this->bbddObject->modificarVehiculo($id, $data);
        SuccessCod::ok(['result' => 'registro actualizado con exito']);
        /*
        // obtengo el id del elemento a actualizar
        if ($data===null) {
            return ClientErrorCod::badRequest(['error' => 'Parámetros inválidos. No hay informacion a actualizar']);
        // atributos que no se pueden modificar por ser fijos
        }  elseif (array_key_exists('marca', $data) || array_key_exists('modelo', $data) 
                  || array_key_exists('year', $data) || array_key_exists('clase', $data)
                  || array_key_exists('id', $data)) {
                return ClientErrorCod::badRequest(['error' => 
                'Los parametros marca, modelo, year, clase e id son parámetros fijos y no se pueden modificar']);
        } else {
            $elemMod = $this->bbddObject->getVehiculoId($id);
            //actualizo sus propiedades 
            $elemMod->setPropiedades($data);
            //obtengo el array con todos los vehiculos 
            $bbddArray = $this->bbddObject->vehiculosConDatos();
            //$idElemMod = $elemMod->getPropiedad_id();
            //sustituyo el antiguo elemento por el actualizado en el array global
            $bbddArray[$id-1]=$elemMod;
            //envio el json
            $this->bbddObject->enviarJsonBbdd($bbddArray);
            SuccessCod::ok(['result' => 'registro actualizado con exito']);
        }*/
    }
    // metodo para borrar  los vehiculos de la BBDD por id
    public function deleteVehiculo($id) {
        $this->bbddObject->eliminarVehiculo($id);
        SuccessCod::ok(['result' => 'registro eliminado con exito']);
    }

}
